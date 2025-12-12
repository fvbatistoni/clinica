<?php

// Start session
session_start();

// Load and initialize database class
require_once 'DB.class.php';
$db = new DB();

$tblName = 'black_medicamentos';

// Set default redirect url
$redirectURL = 'black_medicamentoIndex.php';

if(isset($_POST['userSubmit'])){
	// Get submitted data
	$sub1 	= $_POST['sub1'];
	$sub2 	= $_POST['sub2'];
	$farmaco 	= $_POST['farmaco'];
	$farmaco_info = $_POST['farmaco_info'];
	$nome_comercial = $_POST['nome_comercial'];
	$dose = $_POST['dose'];
	$colaterais = $_POST['colaterais'];
	$extra_info = $_POST['extra_info'];
	$id 	= $_POST['id'];

	// Submitted user data
	$userData = array(
		'sub1' 	=> $sub1,
		'sub2' => $sub2,
		'farmaco' => $farmaco,
		'farmaco_info' => $farmaco_info,
		'nome_comercial' => $nome_comercial,
		'dose' => $dose,
		'colaterais' => $colaterais,
		'extra_info' => $extra_info
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
					$redirectURL = 'black_medicamentoAddEdit.php'.$idStr;
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
					$redirectURL = 'black_medicamentoAddEdit.php';
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
