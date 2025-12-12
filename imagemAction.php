<?php
// Start session

session_start();



// Include and initialize DB class

require_once 'imagemDB.class.php';

$db = new imagemDB();



// File upload path

$uploadDir = "uploads/images/";



// Allow file formats

$allowTypes = array('jpg','png','jpeg','gif');



// Set default redirect url

$redirectURL = 'imagemIndex.php';



$statusMsg = $errorMsg = '';

$sessData = array();

$statusType = 'danger';

if(isset($_POST['imgSubmit'])){

	

	 // Set redirect url

    $redirectURL = 'imagemAddEdit.php';



    // Get submitted data

	$title	= $_POST['title'];

	$id		= $_POST['id'];

    

    // Submitted user data

    $galData = array(

        'title'  => $title

    );

    

    // Store submitted data into session

    $sessData['postData'] = $galData;

    $sessData['postData']['id'] = $id;

    

    // ID query string

    $idStr = !empty($id)?'?id='.$id:'';

    require_once('./php-image-magician/php_image_magician.php');



	if(empty($title)){

		$error = '<br/>Insira um nome para a Galeria.';

	}

	

	if(!empty($error)){

		$statusMsg = 'Preencha todos os campos.'.$error;

	}else{

		if(!empty($id)){

			// Update data

			$condition = array('id' => $id);

			$update = $db->update($galData, $condition);

			$galleryID = $id;

		}else{

			// Insert data

			$insert = $db->insert($galData);

			$galleryID = $insert;

		}

		

		$fileImages = array_filter($_FILES['images']['name']);

		if(!empty($galleryID)){

			if(!empty($fileImages)){

				foreach($fileImages as $key=>$val){

					// File upload path

					// Remove os caracteres especiais e espaços do título da pasta

					$album = str_replace(" ","_",preg_replace("/&([a-z])[a-z]+;/i", "$1", htmlentities(trim($title))));



					$fileName = $galleryID.'_'.basename($fileImages[$key]);

					if(is_dir($uploadDir.strtolower($album))){

						$targetFilePath = $uploadDir.strtolower($album).'/'.$fileName;

					} else {

						mkdir($uploadDir.strtolower($album), 0777, true);

						mkdir($uploadDir.strtolower($album).'/thumb/', 0777, true);

						$targetFilePath = $uploadDir.strtolower($album).'/'. $fileName;

					}



					

					

					// Check whether file type is valid

					$fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);

					if(in_array($fileType, $allowTypes)){

						// Upload file to server

						if(move_uploaded_file($_FILES["images"]["tmp_name"][$key], $targetFilePath)){

							// Image db insert

							$imgData = array(

								'gallery_id' => $galleryID,

								'file_name' => $album.'/'.$fileName

							);

							$insert = $db->insertImage($imgData);



							// Converte o Thumbnail

				            $magicianObj = new imageLib($targetFilePath);

				            $magicianObj->resizeImage(157, 220);

				            $magicianObj->saveImage($uploadDir .strtolower($album). '/thumb/' . $fileName, 100);

						}else{

							$errorUpload .= $fileImages[$key].' | ';

						}

					}else{

						$errorUploadType .= $fileImages[$key].' | ';

					}

				}

			

				$errorUpload = !empty($errorUpload)?'Upload Error: '.trim($errorUpload, ' | '):'';

				$errorUploadType = !empty($errorUploadType)?'File Type Error: '.trim($errorUploadType, ' | '):'';

				$errorMsg = !empty($errorUpload)?'<br/>'.$errorUpload.'<br/>'.$errorUploadType:'<br/>'.$errorUploadType;

			}

			

			$statusType = 'success';

			$statusMsg = 'Imagens enviadas com sucesso.'.$errorMsg;

			$sessData['postData'] = '';

			

			$redirectURL = 'imagemIndex.php';

		}else{

			$statusMsg = 'Ocorreu um problema, tente novamente.';

			// Set redirect url

			$redirectURL .= $idStr;	

		}

	}

	

	// Status message

	$sessData['status']['type'] = $statusType;

    $sessData['status']['msg']  = $statusMsg;

}elseif(($_REQUEST['action_type'] == 'block') && !empty($_GET['id'])){

    // Update data

	$galData = array('status' => 0);

    $condition = array('id' => $_GET['id']);

    $update = $db->update($galData, $condition);

    if($update){

        $statusType = 'success';

        $statusMsg  = 'Dados bloqueados com sucesso.';

    }else{

        $statusMsg  = 'Ocorreu um problema, tente novamente.';

    }

	

	// Status message

	$sessData['status']['type'] = $statusType;

    $sessData['status']['msg']  = $statusMsg;

}elseif(($_REQUEST['action_type'] == 'unblock') && !empty($_GET['id'])){

    // Update data

	$galData = array('status' => 1);

    $condition = array('id' => $_GET['id']);

    $update = $db->update($galData, $condition);

    if($update){

        $statusType = 'success';

        $statusMsg  = 'Dados ativados com sucesso.';

    }else{

        $statusMsg  = 'Ocorreu um problema, tente novamente.';

    }

	

	// Status message

	$sessData['status']['type'] = $statusType;

    $sessData['status']['msg']  = $statusMsg;

}elseif(($_REQUEST['action_type'] == 'delete') && !empty($_GET['id'])){

	// Previous image files

	$conditions['where'] = array(

		'id' => $_GET['id'],

	);

	$conditions['return_type'] = 'single';

	$prevData = $db->getRows($conditions);

				

    // Delete gallery data

    $condition = array('id' => $_GET['id']);

    $delete = $db->delete($condition);

    if($delete){

		// Delete images data

		$condition = array('gallery_id' => $_GET['id']);

		$delete = $db->deleteImage($condition);

		

		// Remove files from server

		if(!empty($prevData['images'])){

			foreach($prevData['images'] as $img){

				@unlink($uploadDir.$img['file_name']);

			}

		}

		

        $statusType = 'success';

        $statusMsg  = 'Galeria deletada com sucesso.';

    }else{

        $statusMsg  = 'Ocorreu um problema, tente novamente.';

    }

	

	// Status message

	$sessData['status']['type'] = $statusType;

    $sessData['status']['msg']  = $statusMsg;

}elseif(($_POST['action_type'] == 'img_delete') && !empty($_POST['id'])){

	// Previous image data

	$prevData = $db->getImgRow($_POST['id']);

				

    // Delete gallery data

    $condition = array('id' => $_POST['id']);

    $delete = $db->deleteImage($condition);

    if($delete){

		@unlink($uploadDir.$prevData['file_name']);

		$status = 'ok';

    }else{

        $status  = 'err';

    }

	echo $status;die;

}



// Store status into the session

$_SESSION['sessData'] = $sessData;

	

// Redirect the user

header("Location: ".$redirectURL);

exit();

?>