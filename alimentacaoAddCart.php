<?php
	session_start();

	//check if product is already in the cart
	if(!in_array($_GET['id'], $_SESSION['cart'])){
		array_push($_SESSION['cart'], $_GET['id']);
		$_SESSION['message'] = 'Alimento inserido com sucesso';
	}
	else{
		$_SESSION['message'] = 'Alimento já consta no cardápio';
	}

	header('location: alimentacaoIndex.php');
?>