<?php
session_start();

// Vetor com os caracteres com problemas. 
$vetorStringProblema = [
'Ã€', 'Ã‚', 'Ãƒ', 'Ã„', 'Ã…', 'Ã†', 'Ã‡', 'Ãˆ', 'Ã‰', 'ÃŠ', 'Ã‹', 'ÃŒ', 'Ã ', 'ÃŽ', 'Ã ', 'Ã ', 'Ã‘', 'Ã’', 'Ã“', 'Ã”', 'Ã•', 'Ã–', 'Ã—', 'Ã˜', 'Ã™', 'Ãš', 'Ã›', 'Ãœ', 'Ã ', 'Ãž', 'ÃŸ', 'Ã ', 'Ã¡', 'Ã¢', 'Ã£', 'Ã¤', 'Ã¥', 'Ã¦', 'Ã§', 'Ã¨', 'Ã©', 'Ãª', 'Ã«', 'Ã¬', 'Ã­', 'Ã®', 'Ã¯', 'Ã°', 'Ã±', 'Ã²', 'Ã³', 'Ã´', 'Ãµ', 'Ã¶', 'Ã·', 'Ã¸', 'Ã¹', 'Ãº', 'Ã»', 'Ã¼', 'Ã½', 'Ã¾', 'Ã¿', 'Ã',
];

// Vetor respctico com os caracteres corretos.
$vetorStringCorreta = [
'À', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', '×', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'Þ', 'ß', 'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ð', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', '÷', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'þ', 'ÿ', 'Á',
];


function mascara($valor, $formato) {
    $retorno = '';
    $posicao_valor = 0;
    for($i = 0; $i<=strlen($formato)-1; $i++) {
        if($formato[$i] == '#') {
            if(isset($valor[$posicao_valor])) {
 $retorno .= $valor[$posicao_valor++];
 }
        } else {
            $retorno .= $formato[$i];
        }
    }
    return $retorno;
}

require_once("./assets/clsTexto.php");

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
	$userData = $db->getRows('recibos', $conditions);
}

// Pre-filled data
$userData = !empty($postData)?$postData:$userData;

// Define action
$actionLabel = !empty($_GET['id'])?'Editar':'Adicionar';

ob_start();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo !empty($userData['pagador'])?$userData['pagador']:'Recibo'; ?></title>
</head>
<body>
<p align="center"> <img src="images/image-recibo.png" align="center" width="645"></p>
<br /><br />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td style="padding: 0.5em; border-top: 1px solid; border-left: 1px solid;"><p>Recebi de <strong><?php echo !empty($userData['pagador'])?$userData['pagador']:''; ?></strong>, portador do CPF <strong><?php echo !empty($userData['valor'])?mascara($userData['cpf'], "###.###.###-##"):''; ?></strong> a importância de <i><?php echo ucfirst(clsTexto::valorPorExtenso(str_replace('.', ',', $userData['valor']), true, false)); ?></i> referente à <u>Consulta Médica</u>.</p>
      <?php echo !empty($userData['observacao'])?'<br><p><strong>Obs.:</strong> '.$userData['observacao'].'</p>':''; ?> <br></td>
    <td colspan="6" style="padding:1em; text-align: right; font-size: xx-large; border-top: 1px solid; border-right: 1px solid;" valign="top"><sup>R$</sup> <?php echo !empty($userData['valor'])?'<strong>'.$userData['valor'].'</strong>':''; ?></td>
  </tr>
  <tr>
    <td rowspan="2" valign="top" style="padding-left: 0.5em; padding-top:0.5em; border-left: 1px solid;"><p><strong>Campinas</strong>, <?php echo date("d/m/Y", strtotime($userData['created'])); ?></p>
      <br />
      <p class="breadcrumb" style="color: grey;"><i>O valor recebido refere-se a serviços esporádicos prestados a esta pessoa física na condição de autônomo, sem habitualidade e frequência não caracterizando em hipótese alguma vinculo empregatício. Dou plena e geral quitação pelos serviços que prestei e declaro que nada mais tenho a receber desta empresa seja a qual título for.</i><br />&nbsp;</p></td>
    <td colspan="6" rowspan="2" valign="bottom" style="padding-left:1em; padding-right:1em; padding-bottom:0.5em; text-align: center; border-right: 1px solid;" class="breadcrumb">
      <hr style="border-top: 1px dashed grey;">
      <strong>Dr Fabrício Valadão Batistoni</strong><br />
      CREMESP 122.499<br />
      CPF: 036.007.986-50</td />
  </tr>
  <tr>
    <td  width="27"></td>
  </tr>
  <tr>
    <td colspan="7" style="padding: 0.5em; border-top: 1px solid; border-bottom: 1px solid; border-left: 1px solid; border-right: 1px solid;"><p class="breadcrumb"><strong>LOCAL DO ATENDIMENTO:</strong> Rua Maria Monteiro, 1016 - Cambuí, Campinas - SP - 13025-151 - (19) 3705-8800 || (19) 99649-0008</p></td>
  </tr>
</table>
</body>
</html>


<?php
//==============================================================
//==============================================================
//==============================================================
$html = ob_get_contents();
ob_end_clean();

$path = (getenv('MPDF_ROOT')) ? getenv('MPDF_ROOT') : __DIR__;
require_once $path . '/vendor/autoload.php';

$mpdf = new \Mpdf\Mpdf();

$mpdf->SetDisplayMode('fullpage');

// LOAD a stylesheet
$stylesheet = file_get_contents('assets/css/mpdfstyleA4.css');
$mpdf->WriteHTML($stylesheet,1);	// The parameter 1 tells that this is css/style only and no body/html/text

$mpdf->WriteHTML($html);

$mpdf->Output();

exit;
//==============================================================
//==============================================================
//==============================================================
?>