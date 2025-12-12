<?php

$postData = $userData = array();

// Get session data
$sessData = !empty($_SESSION['sessData'])?$_SESSION['sessData']:'';

// Get status message from session
if(!empty($sessData['status']['msg'])){
    $statusMsg = $sessData['status']['msg'];
    $statusMsgType = $sessData['status']['type'];
    unset($_SESSION['sessData']['status']);
}

// Get posted data from session
if(!empty($sessData['postData'])){
    $postData = $sessData['postData'];
    unset($_SESSION['sessData']['postData']);
}

// Get user data
if(!empty($_GET['id'])){
	include 'DB.class.php';
	$db = new DB();
	$conditions['where'] = array(
		'id' => $_GET['id'],
	);
	$conditions['return_type'] = 'single';
	$userData = $db->getRows('prescricaos', $conditions);
}

// Pre-filled data
$userData = !empty($postData)?$postData:$userData;

// Define action
$actionLabel = !empty($_GET['id'])?'Editar':'Adicionar';

// Vetor com os caracteres com problemas. 
$vetorStringProblema = [
'Ã€', 'Ã‚', 'Ãƒ', 'Ã„', 'Ã…', 'Ã†', 'Ã‡', 'Ãˆ', 'Ã‰', 'ÃŠ', 'Ã‹', 'ÃŒ', 'Ã ', 'ÃŽ', 'Ã ', 'Ã ', 'Ã‘', 'Ã’', 'Ã“', 'Ã”', 'Ã•', 'Ã–', 'Ã—', 'Ã˜', 'Ã™', 'Ãš', 'Ã›', 'Ãœ', 'Ã ', 'Ãž', 'ÃŸ', 'Ã ', 'Ã¡', 'Ã¢', 'Ã£', 'Ã¤', 'Ã¥', 'Ã¦', 'Ã§', 'Ã¨', 'Ã©', 'Ãª', 'Ã«', 'Ã¬', 'Ã­', 'Ã®', 'Ã¯', 'Ã°', 'Ã±', 'Ã²', 'Ã³', 'Ã´', 'Ãµ', 'Ã¶', 'Ã·', 'Ã¸', 'Ã¹', 'Ãº', 'Ã»', 'Ã¼', 'Ã½', 'Ã¾', 'Ã¿', 'Ã',
];

// Vetor respctico com os caracteres corretos.
$vetorStringCorreta = [
'À', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', '×', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'Þ', 'ß', 'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ð', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', '÷', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'þ', 'ÿ', 'Á',
];

ob_start();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title><?php echo !empty($userData['nome'])?$userData['nome']:'Prescricao'; ?></title>
<style>
  blockquote {
    border-left: 10px solid #ccc;
    margin: 1.5em 10px;
    padding: 0.5em 10px;
    quotes: "\201C""\201D""\2018""\2019";
  }
  blockquote:before {
    color: #ccc;
    content: open-quote;
    font-size: 4em;
    line-height: 0.1em;
    margin-right: 0.25em;
    vertical-align: -0.4em;
  }
  blockquote p {
    display: inline;
  }  
</style>
</head>
<body>
<p align="center">	
<img src="images/image1.png" align="center" width="645"></p>
<br>
<table width="100%">
<tr>
<td align="center"><h1>RECEITUÁRIO
  M&Eacute;DICO</h1></td>
  </tr>
  <tr>
  <td><img src="images/prescription.svg" width="20px" fill="purple"></td>
  </tr>
<tr><td><p class="nome"><b>NOME:</b> 
  <?php echo !empty($userData['nome'])?$userData['nome']:''; ?></p></td></tr>
</table>

<?php if (!empty($_SESSION['message'])) : ?>
	<div class="alert alert-<?php echo $_SESSION['type']; ?>"><?php echo $_SESSION['message']; ?></div>
<?php endif; ?>

	<p>
    <?php // gambiarra para resolver problemas de charset

    $userData['rx'] = html_entity_decode($userData['rx']);   // Etapa 1: Decode entidades
    $userData['rx'] = stripslashes($userData['rx']);    
    $strTratada = str_replace($vetorStringProblema, $vetorStringCorreta, $userData['rx']); 
    $strTratada = str_replace('&quot;', '"', $strTratada);  
    $strTratada = stripslashes($strTratada);
    echo $strTratada;
    ?>
  </p>
<p class="breadcrumb">Campinas, 
	<?php echo date("d/m/Y", strtotime($userData['created'])); ?></p>

</dl>

<hr>
<p><font class="rodape"><b>LOCAL DO ATENDIMENTO:</b><br>
  <strong>Clínica ECOCENTER:</strong> Rua Maria Monteiro, 1016 - Cambuí, Campinas (SP), <svg version="1.1" viewBox="0 0 10 10" xmlns="http://www.w3.org/2000/svg">
<path d="m9.5868 7.4014-0.99848-0.99848a1.4115 1.4115 0 0 0-2.382 0.72201c-1.6465-0.30788-3.2479-1.9027-3.3476-3.3282a1.4018 1.4018 0 0 0 0.73858-0.38842 1.4118 1.4118 0 0 0 0-1.9964l-0.99819-0.99848a1.4118 1.4118 0 0 0-1.9964 0c-2.9949 2.9949 5.9892 11.979 8.984 8.984a1.412 1.412 0 0 0 0-1.9961z" fill="#000000" stroke-width=".28561"/>
</svg> (19) 3705-8800 ou <svg version="1.1" viewBox="0 0 10 10" xmlns="http://www.w3.org/2000/svg">
<path d="m8.5431 1.4531a4.9585 4.9585 0 0 0-3.5221-1.4531c-2.7442 0-4.9781 2.2228-4.9792 4.9554a4.9243 4.9243 0 0 0 0.66473 2.4777l-0.70647 2.567 2.6395-0.68906a4.9917 4.9917 0 0 0 2.3795 0.60268h2e-3c2.744 0 4.9777-2.223 4.979-4.9553a4.9147 4.9147 0 0 0-1.4569-3.5051zm-3.5221 7.6241h-0.0018a4.1462 4.1462 0 0 1-2.1062-0.57411l-0.15112-0.089286-1.5663 0.40893 0.41808-1.5199-0.098437-0.15625a4.0951 4.0951 0 0 1-0.63282-2.1913c0-2.2708 1.8574-4.1183 4.1402-4.1183a4.1295 4.1295 0 0 1 4.1368 4.1214c-9e-4 2.271-1.8574 4.1187-4.1384 4.1187zm2.2699-3.0846c-0.12433-0.062054-0.73661-0.36161-0.85-0.4029-0.11339-0.041295-0.1971-0.062054-0.27991 0.062053-0.082812 0.12411-0.32143 0.40179-0.39397 0.48549-0.072544 0.083706-0.14509 0.092857-0.26942 0.030805-0.12433-0.062054-0.52545-0.19264-1.0007-0.61451-0.36987-0.32835-0.61942-0.7337-0.69196-0.85759-0.072545-0.12388-0.0078125-0.19107 0.054464-0.25268 0.056027-0.05558 0.12433-0.14464 0.18661-0.21696 0.062276-0.072321 0.083036-0.12411 0.12433-0.2067 0.041295-0.082589 0.02076-0.15491-0.010268-0.21674-0.031027-0.06183-0.27991-0.67143-0.38348-0.91942-0.10112-0.24152-0.20357-0.20871-0.27991-0.2125-0.072544-0.0035725-0.15625-0.004465-0.23862-0.004465a0.45826 0.45826 0 0 0-0.3317 0.15491c-0.11406 0.12411-0.43549 0.42411-0.43549 1.033s0.44643 1.1982 0.50804 1.2808c0.061607 0.082589 0.87723 1.3333 2.1252 1.8696a7.2123 7.2123 0 0 0 0.70937 0.26071c0.29799 0.094196 0.5692 0.081026 0.78348 0.049105 0.23906-0.03549 0.73661-0.29955 0.83995-0.58884 0.10335-0.28928 0.10357-0.53705 0.072544-0.58862-0.031025-0.051562-0.11406-0.082812-0.23862-0.14464z" fill="#000000" fill-rule="evenodd" stroke-width=".022321"/>
</svg> (19) 99829-0800 <svg version="1.1" viewBox="0 0 10 10" xmlns="http://www.w3.org/2000/svg">
<path d="m5 0a5 5 0 1 0 0 10 5 5 0 0 0 0-10zm1.9222 6.6389c0 0.81667-0.44444 1.8333-2.2556 2.6111 0.16667-2.3167-1.4-2.05-1.7778-2.7778a1.8056 1.8056 0 0 1 1-1.4167 4.7167 4.7167 0 0 1-2.3222-1.1111c0.027778 0.26111 0.155 0.50222 0.35556 0.67222a2.3222 2.3222 0 0 1-1.0778-0.83333 4.4111 4.4111 0 0 1 4.0278-3.1278c-0.46667 0.76667-0.83333 2.2944 0 3.0944-0.85556 0.13889-1.3944-0.97222-1.8667-0.53333-0.62778 0.58889 0.18333 1.3944 1.9 1.7111 1.8278 0.32778 2.0333 0.87778 2.0167 1.7111zm0.74444-2.2222c-0.17778-0.61667 0.34444-1.2389 0.93889-1.7444a4.0389 4.0389 0 0 1 0.46667 3.7111c-0.42778-1.05-1.2056-1.2889-1.4056-1.9833z" fill="#000000" stroke-width=".55556"/>
</svg>
 <i>www.ecocenter.med.br</i></font></p>
<?php

  switch ($userData['rec_especial']) {
     case 0:
         break;
     case 1:
      echo '<table class="c36" align="center" width="100%">';
      echo '  <tbody>';
      echo '    <tr class="c25">';
      echo '      <td class="c40" colspan="2" rowspan="1"><p class="c5" align="center"><span class="c11 c24 c31">IDENTIFICA&Ccedil;&Atilde;O DO COMPRADOR</span></p></td>';
      echo '      <td class="c20" colspan="1" rowspan="1"><p class="c5" align="center"><span class="c31 c11 c24">IDENTIFICA&Ccedil;&Atilde;O DO FORNECEDOR</span></p></td>';
      echo '    </tr>';
      echo '    <tr class="c25">';
      echo '      <td class="c14" colspan="2" rowspan="1"><p class="c10"><span class="c4">Nome:</span></p></td>';
      echo '      <td class="c15" colspan="1" rowspan="4"><p class="c28"><span class="c4">&nbsp;</span></p>';
      echo '        <p class="c5 c6"><span class="c4"></span></p>';
      echo '        <p class="c5 c6"><span class="c4"></span></p>';
      echo '        <p class="c5 c6"><span class="c4"></span></p>';
      echo '        <p class="c5"><span class="c4"><br><br><br>&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;..</span></p>';
      echo '        <p class="c5"><span class="c4">Assinatura do Farmac&ecirc;utico</span></p>';
      echo '        <p class="c5"><span class="c11 c24">Data:&nbsp;____</span><span class="c11">/ </span><span class="c11 c24">____</span><span class="c11">/ </span><span class="c11 c24">_______</span></p></td>';
      echo '    </tr>';
      echo '    <tr class="c25">';
      echo '      <td class="c14" colspan="2" rowspan="1"><p class="c10"><span class="c4">Identidade: &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &Oacute;rg.Emissor:</span></p></td>';
      echo '    </tr>';
      echo '    <tr class="c29">';
      echo '      <td class="c14" colspan="2" rowspan="1"><p class="c10"><span class="c4">End:</span></p></td>';
      echo '    </tr>';
      echo '    <tr class="c7">';
      echo '      <td class="c19" colspan="2" rowspan="1"><p class="c10"><span class="c4">Cidade: &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; UF: &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Tel:</span></p></td>';
      echo '    </tr>';
      echo '  </tbody>';
      echo '</table>';         
         break;
  }
?>
</body>
</html>


<?php
//==============================================================
//==============================================================
//==============================================================
$html = ob_get_contents();
ob_end_clean();

$path = getenv('MPDF_ROOT') ? getenv('MPDF_ROOT') : __DIR__;
require_once $path . '/vendor/autoload.php';

// Instância com boas práticas (UTF-8 + A4)
$mpdf = new \Mpdf\Mpdf([
    'mode'   => 'utf-8',
    'format' => 'A4',
]);

// Define o modo de exibição no visualizador de PDF
$mpdf->SetDisplayMode('fullpage');

// Carregar stylesheet
$stylesheet = file_get_contents(__DIR__ . '/assets/css/mpdfstyleA4.css');

// 1º parâmetro: CSS
// 2º parâmetro: modo CSS usando a constante moderna
$mpdf->WriteHTML($stylesheet, \Mpdf\HTMLParserMode::HEADER_CSS);

// Agora insere o corpo HTML
$mpdf->WriteHTML($html, \Mpdf\HTMLParserMode::HTML_BODY);

// Gerar PDF
$mpdf->Output('documento.pdf', 'I');

exit;
//==============================================================
//==============================================================
//==============================================================
?>