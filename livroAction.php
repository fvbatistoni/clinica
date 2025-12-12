<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start session
session_start();

// ===== UTIL =====
function limpar($s) {
    return htmlspecialchars(strip_tags(trim($s ?? '')), ENT_QUOTES, 'UTF-8');
}

// Load and initialize database class
require_once 'DB.class.php';
$db = new DB();

$tblName = 'pedidos';

// Set default redirect url
$redirectURL = 'livroIndex.php';

if(isset($_POST['pedidoSubmit'])){
	// Get submitted data
	$id =  intval($_POST['id']);
    $nome      = limpar(strtoupper($_POST['nome']));
    $endereco  = limpar($_POST['endereco']);
    $cidade  = limpar(strtoupper(ltrim($_POST['cidade'], "- ")));
    $end_numero = limpar(filter_var($_POST['end_numero'], FILTER_SANITIZE_NUMBER_INT));;
    $end_complemento = limpar($_POST['end_complemento']);
    $cep       = limpar($_POST['cep']);
    $telefone  = limpar(filter_var($_POST['telefone'], FILTER_SANITIZE_NUMBER_INT));
    $telefone = preg_replace('/\D+/', '', $telefone);
    $whatsapp  = limpar(filter_var($_POST['whatsapp'], FILTER_SANITIZE_NUMBER_INT));
    $whatsapp = preg_replace('/\D+/', '', $whatsapp);
    $quantidade  = limpar(filter_var($_POST['quantidade'], FILTER_SANITIZE_NUMBER_INT));
    $email     = limpar(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL));
    $tipo      = limpar($_POST['tipo_entrega']);
    $frete      = limpar($_POST['frete']);
    $valor      = limpar($_POST['valor']);
    $rastreamento = limpar($_POST['rastreamento']);
    $horario      = limpar($_POST['horario']);
    $status      = limpar($_POST['status']);
    	
	// Submitted pedido data
	$pedidoData = array(
		'nome' 	=> $nome,
		'endereco' => $endereco,
		'cidade' => $cidade,
		'end_numero' => $end_numero,
		'end_complemento' => $end_complemento,
		'cep' => $cep,
		'telefone' => $telefone,
		'whatsapp' => $whatsapp,
		'quantidade' => $quantidade,
		'email' => $email,
		'tipo_entrega' => $tipo,
		'frete' => $frete,
		'valor' => $valor,
		'rastreamento' => $rastreamento,
		'horario' => $horario,
		'status' => $status
	);
	
	// Store submitted data into session
	$sessData['postData'] = $pedidoData;
	$sessData['postData']['id'] = $id;
	
	// ID query string
	$idStr = !empty($id)?'?id='.$id:'';
	
	// If the data is not empty
			if(!empty($id)){
				// Update data
				$condition = array('id' => $id);
				$update = $db->update($tblName, $pedidoData, $condition);
				
				if($update){
					$sessData['postData'] = '';
					$sessData['status']['type'] = 'success';
					$sessData['status']['msg'] 	= 'Atualizada com sucesso.';
				}else{
					$sessData['status']['type'] = 'error';
					$sessData['status']['msg'] 	= 'Ocorreu um problema. Tente novamente.';
					
					// Set redirect url
					$redirectURL = 'livroAddEdit.php'.$idStr;
				}
			}else{
				// Insert data
				$insert = $db->insert($tblName, $pedidoData);
				
				if($insert){
					$sessData['postData'] = '';
					$sessData['status']['type'] = 'success';
					$sessData['status']['msg'] = 'Adicionada com sucesso.';
				}else{
					$sessData['status']['type'] = 'error';
					$sessData['status']['msg'] = 'Ocorreu um problema. Tente novamente.';
					
					// Set redirect url
					$redirectURL = 'livroAddEdit.php';
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

// Redirect the pedido
header("Location: ".$redirectURL);
exit();
