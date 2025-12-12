<?php



// Start session

session_start();



// Load and initialize database class

require_once 'DB.class.php';

$db = new DB();



$tblName = 'atestados';



// Set default redirect url

$redirectURL = 'atestadoIndex.php';



if(isset($_POST['userSubmit'])){

	// Get submitted data

	$nome 	= strtoupper(addslashes($_POST['nome_paciente']));

	$beneficiario 	= intval(addslashes($_POST['beneficiario']));

	$beneficiario_complemento 	= addslashes($_POST['beneficiario_complemento']);

	$motivo 	= intval(addslashes($_POST['motivo']));

	$motivo_complemento 	= addslashes($_POST['motivo_complemento']);

	$cid 	= addslashes($_POST['cid']);

	$observacoes 	= addslashes($_POST['observacoes']);

	$created 	= addslashes($_POST['created']);

	$id 	= intval(addslashes($_POST['id']));

	

	// Submitted user data

	$userData = array(

		'nome_paciente' 	=> $nome,

		'beneficiario' => $beneficiario,

		'beneficiario_complemento' => $beneficiario_complemento,

		'motivo' => $motivo,

		'motivo_complemento' => $motivo_complemento,

		'cid' => $cid,

		'observacoes' => $observacoes,

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

					$redirectURL = 'atestadoAddEdit.php'.$idStr;

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

					$redirectURL = 'atestadoAddEdit.php';

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

