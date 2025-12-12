<?php
$postData = $pedidoData = array();

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

// Get pedido data
if(!empty($_GET['id'])){
  include 'DB.class.php';
  $db = new DB();
  $conditions['where'] = array(
    'id' => $_GET['id'],
  );
  $conditions['return_type'] = 'single';
  $pedidoData = $db->getRows('pedidos', $conditions);
}

// Pre-filled data
$pedidoData = !empty($postData)?$postData:$pedidoData;

// Define action
$actionLabel = !empty($_GET['id'])?'Editar':'Adicionar';

require_once __DIR__ . '/vendor/autoload.php';

$mpdf = new \Mpdf\Mpdf([
    'format' => 'A4',
    'margin_left' => 15,
    'margin_right' => 15,
    'margin_top' => 15,
    'margin_bottom' => 15,
    'default_font' => 'Arial',
]);


$destinatario = (!empty($pedidoData['nome']) ? strtoupper($pedidoData['nome']) : '');
$enderecoDest  = (!empty($pedidoData['endereco']) ? $pedidoData['endereco'] : '');
$enderecoDest .= (!empty($pedidoData['end_numero']) ? ', '.$pedidoData['end_numero'] : '');
$enderecoDest .= (!empty($pedidoData['end_complemento']) ? ', '.$pedidoData['end_complemento'] : '');
$enderecoDest .= (!empty($pedidoData['cidade']) ? ', '.$pedidoData['cidade'] : '');
$enderecoDest .= (!empty($pedidoData['cep']) ? ' - <strong>CEP</strong> '.$pedidoData['cep'] : '');

$html = <<<HTML
<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <title></title>
    <style>
      /* ===== CONFIGURAÇÃO GLOBAL ===== */
      body {
        font-family: Arial, sans-serif;
        font-size: 16px;
        line-height: 1.4;
        margin: 40px;
      }

      /* ===== TABELA ===== */
      table {
        border-collapse: collapse;
        margin: 0 auto;
        width: 450px; /* largura padrão da etiqueta */
      }

      td {
        border: 2px solid #000;
        padding: 8px 10px;
        vertical-align: top;
      }

      /* ===== CABEÇALHO ===== */
      tr:first-child td {
        border-bottom: none;
        text-align: center;
        font-size: 24px;
        font-weight: bold;
        line-height: 1.2;
      }

      tr:nth-child(2) td {
        border-top: none;
        border-bottom: 1px solid #000;
        text-align: center;
        font-size: 18px;
        font-weight: bold;
      }

      /* ===== SEÇÕES INTERMEDIÁRIAS ===== */
      tr:nth-child(3) td,
      tr:nth-child(4) td,
      tr:nth-child(5) td {
        border-top: none;
        border-bottom: 1px solid #000;
      }

      /* ===== ÚLTIMA LINHA ===== */
      tr:last-child td {
        border-top: none;
        font-weight: bold;
      }

      /* ===== TEXTO ===== */
      p {
        margin: 6px 0;
      }

      b, strong {
        font-weight: bold;
      }

      .center {
        text-align: center;
      }
    </style>
  </head>

  <body>
    <table>
      <tr>
        <td colspan="2" style="border-bottom: none;text-align: center;font-size: 24px;font-weight: bold;line-height: 1.2;">
          <p><strong>IMPRESSO</strong></p>
          <p><strong>REGISTRO MÓDICO</strong></p>
        </td>
      </tr>
      <tr>
        <td colspan="2" style="border-top: none;border-bottom: 1px solid #000;text-align: center;font-size: 18px;font-weight: bold;">
        <p style=""><strong>FECHAMENTO AUTORIZADO PELA ECT</strong></p>
        </td>
      </tr>
      <tr>
        <td colspan="2">
          <p><strong>REMETENTE:</strong> FABRÍCIO VALADÃO BATISTONI</p>
          <p><strong>ENDEREÇO:</strong> Rua Maria Monteiro, 1016 – Cambuí, Campinas/SP - <strong>CEP</strong> 13025-151</p>
        </td>
      </tr>
      <tr>
        <td colspan="2" style="margin:0;padding: 0;text-align: center;">
        &#9617;&#9617;&#9617;&#9617;&#9617;&#9617;&#9617;&#9617;&#9617;&#9617;&#9617;&#9617;&#9617;&#9617;&#9617;&#9617;&#9617;&#9617;&#9617;&#9617;&#9617;&#9617;&#9617;&#9617;&#9617;&#9617;&#9617;&#9617;&#9617;&#9617;&#9617;&#9617;&#9617;&#9617;&#9617;&#9617;&#9617;&#9617;&#9617;&#9617;
        </td>
      </tr>
      <tr>
        <td colspan="2">
          <p><strong>DESTINATÁRIO:</strong> {$destinatario}</p>
          <p><strong>ENDEREÇO:</strong> {$enderecoDest} </p>
        </td>
      </tr>
      <tr>
        <td style="border-right:0;">
          <p><strong>DECLARAÇÃO DE CONTEÚDO:</strong></p>
          <p><strong>LIVRO:</strong> <em>NADA ME FALTARÁ:<br>Um Encontro com a Plenitude</em></p>
        </td>
        <td style="margin: 0;padding: 0;border-left:0;width:150px;"><img src="./images/codigo-de-barra.png"></td>        
      </tr>
      <tr>
        <td colspan="2" style="height: 100px;"><p><strong>PARA USO DO CORREIO:</strong></p></td>
      </tr>
    </table>
  </body>
</html>
HTML;

preg_match('/<style.*?>(.*?)<\/style>/is', $html, $cssMatch);
$css = $cssMatch[1] ?? '';
$htmlBody = preg_replace('/<style.*?<\/style>/is', '', $html);

$mpdf->WriteHTML($css, 1);
$mpdf->WriteHTML($htmlBody, 2);

$mpdf->Output('Etiqueta.pdf', 'I');
