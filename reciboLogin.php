<?php
session_start();

if(empty($_POST['usuario']) || empty($_POST['senha'])) {
	header('Location: reciboIndex.php');
	exit();
}

$user = 'ecocenter';
$pass = '#admin37058800';

if($_POST['usuario'] == $user && $_POST['senha'] == $pass) {
	$_SESSION['usuario'] = 'Recepção';
	header('Location: reciboPainel.php');
	exit();
} else {
	$_SESSION['nao_autenticado'] = true;
	header('Location: reciboIndex.php');
	exit();
}