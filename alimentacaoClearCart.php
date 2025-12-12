<?php
	session_start();
	unset($_SESSION['cart']);
	$_SESSION['message'] = 'Cardápio vazio';
	header('location: alimentacaoIndex.php');
?>