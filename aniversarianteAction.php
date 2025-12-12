<?php
// Start session
session_start();

// Load and initialize database class
require_once 'DB.class.php';

$db = new DB();

$tblName = 'aniversariantes';

// Set default redirect url
$redirectURL = 'aniversarianteIndex.php';

function sanitizarData($dataBruta) {
    // Remove espaços extras e tags maliciosas
    $dataBruta = trim(strip_tags($dataBruta));

    // Detecta se está no formato DD/MM/YYYY
    if (preg_match('/^(\d{2})\/(\d{2})\/(\d{4})$/', $dataBruta, $m)) {
        $dataFormatada = "{$m[3]}-{$m[2]}-{$m[1]}"; // YYYY-MM-DD
    } 
    // Detecta se já está no formato YYYY-MM-DD
    elseif (preg_match('/^(\d{4})-(\d{2})-(\d{2})$/', $dataBruta, $m)) {
        $dataFormatada = $dataBruta;
    } 
    else {
        return null; // formato inválido
    }

    // Valida se a data realmente existe
    $partes = explode('-', $dataFormatada);
    if (!checkdate($partes[1], $partes[2], $partes[0])) {
        return null; // data inválida (ex: 31/02/2024)
    }

    return $dataFormatada;
}

function sanitizarTelefone($telefoneBruto) {
    // Remove tudo que não for número
    $telefone = preg_replace('/\D/', '', $telefoneBruto);

    // Garante que não seja nulo
    if (empty($telefone)) {
        return null;
    }

    // Se já começa com 55 e tem tamanho válido (12 ou 13 dígitos), retorna como está
    // 55 + DDD + número => 12 dígitos (fixo) ou 13 dígitos (celular)
    if (strpos($telefone, '55') === 0 && (strlen($telefone) === 12 || strlen($telefone) === 13)) {
        return $telefone;
    }

    // Se o número começa com 0 (ex: 0XX...), remove o zero inicial
    $telefone = ltrim($telefone, '0');

    // Se tiver 11 dígitos → celular (DDD + 9 + número)
    if (strlen($telefone) === 11) {
        return '55' . $telefone;
    }

    // Se tiver 10 dígitos → fixo (DDD + número)
    if (strlen($telefone) === 10) {
        return '55' . $telefone;
    }

    // Qualquer outro tamanho é considerado inválido
    return null;
}


function sanitizarNome($nomeBruto) {
    // Remove tags HTML e espaços extras
    $nome = trim(strip_tags($nomeBruto));

    // Remove múltiplos espaços internos
    $nome = preg_replace('/\s+/', ' ', $nome);

    // Converte para maiúsculas (opcional)
    $nome = strtoupper($nome);

    return $nome;
}

if(isset($_POST['aniversarianteSubmit'])){
	// Get submitted data
	$name 	= sanitizarNome($_POST['name'] ?? '');
	$phone1 	= sanitizarTelefone($_POST['$phone1'] ?? '');
	$phone2 	= sanitizarTelefone($_POST['$phone2'] ?? '');
	$aniversario 	= sanitizarData($_POST['aniversario'] ?? '');
	$created 	= sanitizarData($_POST['created'] ?? '');
	$id 	=  intval($_POST['id']);
	
	// Submitted user data
	$aniversarianteData = array(
		'name' 	=> $name,
		'phone1' => $phone1,
		'phone2' => $phone2,
		'aniversario' => $aniversario,
		'created' => $created
	);
	
	// Store submitted data into session
	$sessData['postData'] = $aniversarianteData;
	$sessData['postData']['id'] = $id;
	
	// ID query string
	$idStr = !empty($id)?'?id='.$id:'';
	
	// If the data is not empty
			if(!empty($id)){
				// Update data
				$condition = array('id' => $id);
				$update = $db->update($tblName, $aniversarianteData, $condition);
				
				if($update){
					$sessData['postData'] = '';
					$sessData['status']['type'] = 'success';
					$sessData['status']['msg'] 	= 'Atualizada com sucesso.';
				}else{
					$sessData['status']['type'] = 'error';
					$sessData['status']['msg'] 	= 'Ocorreu um problema. Tente novamente.';
					
					// Set redirect url
					$redirectURL = 'aniversarianteIndex.php'.$idStr;
				}
			}else{
				// Insert data
				$insert = $db->insert($tblName, $aniversarianteData);
				
				if($insert){
					$sessData['postData'] = '';
					$sessData['status']['type'] = 'success';
					$sessData['status']['msg'] = 'Adicionada com sucesso.';
				}else{
					$sessData['status']['type'] = 'error';
					$sessData['status']['msg'] = 'Ocorreu um problema. Tente novamente.';
					
					// Set redirect url
					$redirectURL = 'aniversarianteIndex.php';
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
