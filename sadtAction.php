<?php

// Start session
session_start();

// Load and initialize database class
require_once 'DB.class.php';
$db = new DB();

$tblName = 'sadts';

// Set default redirect url
$redirectURL = 'sadtIndex.php';

if(isset($_POST['userSubmit'])){
	// Get submitted data
	$nome_paciente 	= strtoupper(addslashes($_POST['nome_paciente']));
	$cid 	= addslashes($_POST['cid']);
	$plano 	= intval($_POST['plano']);
	$created 	= addslashes($_POST['created']);

	$exames 	= array();
		for($i=0;$i<count($_POST['exames']);$i++){
			if ($_POST['exames'][$i] === "") {
			    // Se o procedimento for vazio não será incluído no array
			} else {
				$exames[]=array(
					'procedimento'=>$_POST['exames'][$i]);				
			}
		}

	$id 	= intval($_POST['id']);

	// Submitted user data
	$userData = array(
		'nome_paciente' 	=> $nome_paciente,
		'cid' => $cid,
		'plano' => $plano,
		'created' => $created,
		'exames' => json_encode($exames, JSON_UNESCAPED_UNICODE)
	);
	
	// Store submitted data into session
	$sessData['postData'] = $userData;
	$sessData['postData']['id'] = $id;
	
	// ID query string
	$idStr = !empty($id)?'?id='.$id:'';
	
	// If the data is not empty
			if(!empty($id)){
				// Update data
				$condition = array('id' => $id);
				$update = $db->update($tblName, $userData, $condition);
				
				if($update){
					$sessData['postData'] = '';
					$sessData['status']['type'] = 'success';
					$sessData['status']['msg'] 	= 'Atualizada com sucesso.';
				}else{
					$sessData['status']['type'] = 'error';
					$sessData['status']['msg'] 	= 'Ocorreu um problema. Tente novamente.';
					
					// Set redirect url
					$redirectURL = 'sadtAddEdit.php'.$idStr;
				}
			}else{
				// Insert data
				$insert = $db->insert($tblName, $userData);
				
				if($insert){
					$sessData['postData'] = '';
					$sessData['status']['type'] = 'success';
					$sessData['status']['msg'] = 'Adicionada com sucesso.';
				}else{
					$sessData['status']['type'] = 'error';
					$sessData['status']['msg'] = 'Ocorreu um problema. Tente novamente.';
					
					// Set redirect url
					$redirectURL = 'sadtAddEdit.php';
				}
			}

	
	// Store status into the session
    $_SESSION['sessData'] = $sessData;
}elseif(($_REQUEST['action_type'] == 'delete') && !empty($_GET['id'])){
    // Delete data
    $condition = array('id' => $_GET['id']);
    $delete = $db->delete($tblName, $condition);
    if($delete){
        $sessData['status']['type'] = 'success';
        $sessData['status']['msg'] = 'Deletado com sucesso.';
    }else{
        $sessData['status']['type'] = 'error';
        $sessData['status']['msg'] = 'Ocorreu um problema. Tente novamente.';
    }
	
	// Store status into the session
    $_SESSION['sessData'] = $sessData;
}

// Redirect the user
header("Location: ".$redirectURL);
exit();
