<?php

// Start session
session_start();

// Load and initialize database class
require_once 'DB.class.php';
$db = new DB();

$tblName = 'agendas';

// Set default redirect url
$redirectURL = 'agendaIndex.php';

if(isset($_POST['userSubmit'])){
	// Get submitted data
	$nome_paciente 	= $_POST['nome_paciente'];
	$local_atendimento 	= $_POST['local_atendimento'];
	$data 	= $_POST['data'];
	$id_paciente 	= $_POST['id_paciente'];
	$tipo 	= $_POST['tipo'];
	$id_convenio 	= $_POST['id_convenio'];
	$hora_consulta 	= $_POST['hora_consulta'];
	$hora_atendimento 	= $_POST['hora_atendimento'];
	$pontualidade 	= $_POST['pontualidade'];
	$valor_pago 	= $_POST['valor_pago'];
	$desconto 	= $_POST['desconto'];
	$data_pagamento 	= $_POST['data_pagamento'];
	$id 	= $_POST['id'];


	// Submitted user data
	$userData = array(
		'nome_paciente' 	=> $nome_paciente,
		'local_atendimento' => $local_atendimento,
		'data' => $data,
		'id_paciente' => $id_paciente,
		'tipo' => $tipo,
		'id_convenio' => $id_convenio,
		'hora_consulta' => $hora_consulta,
		'hora_atendimento' => $hora_atendimento,
		'pontualidade' => $pontualidade,
		'valor_pago' => $valor_pago,
		'desconto' => $desconto,
		'data_pagamento' => $data_pagamento
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
					$redirectURL = 'addEdit.php'.$idStr;
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
					$redirectURL = 'addEdit.php';
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
