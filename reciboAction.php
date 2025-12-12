<?php

function validateCPF($number) {
    $cpf = preg_replace('/[^0-9]/', "", $number);
    if (strlen($cpf) != 11 || preg_match('/([0-9])\1{10}/', $cpf)) {
        return false;
    }
    $number_quantity_to_loop = [9, 10];
    foreach ($number_quantity_to_loop as $item) {
        $sum = 0;
        $number_to_multiplicate = $item + 1;
    
        for ($index = 0; $index < $item; $index++) {
            $sum += $cpf[$index] * ($number_to_multiplicate--);
    
        }
        $result = (($sum * 10) % 11);
        if ($cpf[$item] != $result) {
            return false;
        }
    }
    return true;
}

function limpar_texto($str){ 
  return preg_replace("/[^0-9]/", "", $str); 
}

function limpar_valor($valor){
	$sem_ponto=str_replace(".","",$valor);
	$virgula_ponto=str_replace(",",".",$sem_ponto);
	return addslashes($virgula_ponto);
}

// Start session
// session_start();

// Load and initialize database class
require_once 'DB.class.php';
$db = new DB();

$tblName = 'recibos';

// Set default redirect url
$redirectURL = 'reciboPainel.php';

if(isset($_POST['userSubmit'])){
	// Get submitted data
	$pagador 	= addslashes(strtoupper($_POST['pagador']));
	$cpf = !empty($_POST['cpf'])?limpar_texto($_POST['cpf']):'';
	if(validateCPF($cpf) == true) {
		$cpf_final = $cpf;
	} else {
		$cpf_final = '';
	}
	$valor 	= limpar_valor($_POST['valor']);
	$observacao 	= addslashes($_POST['observacao']);
	$created 	= $_POST['created'];
	$id 	= intval($_POST['id']);
	
	// Submitted user data
	$userData = array(
		'pagador' 	=> $pagador,
		'cpf' => $cpf_final,
		'valor' => $valor,
		'observacao' => $observacao,
		'created' => $created
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
					$redirectURL = 'reciboAddEdit.php'.$idStr;
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
					$redirectURL = 'reciboPainel.php';
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
