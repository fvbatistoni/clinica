<?php
require_once '../loader.php';
@session_start();
if (!isset($_SESSION['LOGADO']) || $_SESSION['LOGADO'] == FALSE) {
    @header('location:' . Validacao::getBase() . 'login.php');
    exit;
}
// Vetor com os caracteres com problemas. 
$vetorStringProblema = [
'Ã€', 'Ã‚', 'Ãƒ', 'Ã„', 'Ã…', 'Ã†', 'Ã‡', 'Ãˆ', 'Ã‰', 'ÃŠ', 'Ã‹', 'ÃŒ', 'Ã ', 'ÃŽ', 'Ã ', 'Ã ', 'Ã‘', 'Ã’', 'Ã“', 'Ã”', 'Ã•', 'Ã–', 'Ã—', 'Ã˜', 'Ã™', 'Ãš', 'Ã›', 'Ãœ', 'Ã ', 'Ãž', 'ÃŸ', 'Ã ', 'Ã¡', 'Ã¢', 'â€¢', 'Ã£', 'Ã¤', 'Ã¥', 'Ã¦', 'Ã§', 'Ã¨', 'Ã©', 'Ãª', 'Ã«', 'Ã¬', 'Ã­', 'Ã®', 'Ã¯', 'Ã°', 'Ã±', 'Ã²', 'Ã³', 'Ã´', 'Ãµ', 'Ã¶', 'Ã·', 'Ã¸', 'Ã¹', 'Ãº', 'Ã»', 'Ã¼', 'Ã½', 'Ã¾', 'Ã¿', 'Ã',
];

// Vetor respctico com os caracteres corretos.
$vetorStringCorreta = [
'À', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', '×', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'Þ', 'ß', 'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ð', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', '÷', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'þ', 'ÿ', 'Á',
];
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Pediatria Simples | Consultório</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="plugins/toastr/toastr.min.css">  
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="assets/css/adminlte.min.css">
  <!-- Font Awesome Duotone -->
  <script src="assets/js/duotone.min.js"></script>
  <link rel="stylesheet" href="assets/css/duotone.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <!-- JQuery UI -->
  <link rel="stylesheet" href="assets/css/jquery-ui.css">
  <!-- JQuery UI -->
  <link rel="stylesheet" href="assets/css/paginacao.css">
  <!-- Impressão do desenho -->
  <link rel="stylesheet" href="assets/css/style-desenho.css">
  <!-- Toggle Financeiro -->
  <link href="plugins/bootstrap4-toggle/bootstrap4-toggle.min.css" rel="stylesheet">
</head>