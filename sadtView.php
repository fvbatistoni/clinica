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
	$userData = $db->getRows('sadts', $conditions);

    // Busca na tabela 'convenios' os dados a partir da informação da tabela 'sadts'
    $convenioData = $db->getConvenioData($userData['plano']);
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
  <title><?php echo !empty($userData['nome_paciente'])?$userData['nome_paciente']:'Guia SADT'; ?></title>
</head>
<!-- preciso transformar a variável $userData['plano']
também preciso buscar os CSS do SADTprint velhos, renomear e usa-los aqui -->
<body lang=PT-BR>
    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td class="top">
                <table width="100%">
                    <tr>
                        <td width="20%">&nbsp;&nbsp;<img src="<?php echo $convenioData['logo']; ?>" width="180px">
                        </td>
                        <td align="center">
                            <p><span style='font-family:Arial;font-size: 12pt;'><b>GUIA SOLICITAÇÃO DE SERVIÇO PROFISSIONAL
 / <br>SERVIÇO AUXILIAR DE DIAGNÓSTICO E TERAPIA - SP/SADT</b></span>
                        </td>
                        <td width="20%" valign=top>
                            <p><span style='font-family:Arial;font-size:7.0pt;color:black'>2. Nº Guia no Prestador</span>
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td class="laterais" >
                <table width="">
                    <tr>
                        <td class="celulas">
                            <p><span style='font-family:Arial;font-size:7.0pt;color:black'>1. Registro
 ANS</span><br>
                                <span><span lang=EN-US style='font-family:Arial;font-size:14.0pt;font-weight: bold;color:black'><?php echo $convenioData['ans']; ?></span></span>
                            </p>
                        </td>
                        <td class="celulas">
                            <p><span style='font-family:Arial;font-size:7.0pt;color:black'>3 - Número da Guia
 Principal<br></span>
                                <span><span lang=EN-US style='font-family:Arial;font-size:10.0pt;color:#808080'>|__|__|__|__|__|__|__|__|__|__|__|__|__|__|__|__|__|__|__|</span></span>
                            </p>
                        </td>
                        <td class="celulas">
                            <p><span style='font-family:Arial;font-size:7.0pt;color:black'>4. Data da
 Autorização</span><br>
                                <span><span lang=EN-US style='font-family:Arial;font-size:10.0pt;font-weight: bold;color:#808080'>|__|__|/|__|__|/|__|__|__|__|</span></span>
                            </p>
                        </td>
                        <td class="celulas">
                            <p><span style='font-family:Arial;font-size:7.0pt;color:black'>5. Senha</span><br>
                                <span><span lang=EN-US style='font-family:Arial;font-size:10.0pt;font-weight: bold;color:#808080'>|__|__|__|__|__|__|__|__|__|__|__|__|__|__|__|__|__|__|__|__|</span></span>
                            </p>
                        </td>
                        <td class="celulas">
                            <p><span style='font-family:Arial;font-size:7.0pt;color:black'>6. Data
 Validade da Senha</span><br>
                                <span><span lang=EN-US style='font-family:Arial;font-size:10.0pt;color:#808080'>|__|__|/|__|__|/|__|__|__|__|</span></span>
                            </p>
                        </td>
                        <td class="celulas">
                            <p><span style='font-family:Arial;font-size:7.0pt;color:black'>7. Número da Guia Atribuido pela operadora</span><br>
                                <span><span lang=EN-US style='font-family:Arial;font-size:10.0pt;color:#808080'>|__|__|__|__|__|__|__|__|__|__|__|__|__|__|__|__|__|__|__|__|</span></span>
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td bgcolor="#D9D9D9"  class="laterais">
                <p><b><span style='font-family:Arial;font-size:7.0pt;color:black'>Dados do Beneficiário</span></b>
                </p>
            </td>
        </tr>
        <tr>
            <td  class="laterais">
                <table width="100%">
                    <tr>
                        <td class="celulas" width="">
                            <p><span style='font-family:Arial;font-size:7.0pt;color:black'>8. Número da Carteira</span><br>
                                <span><span lang=EN-US style='font-family:Arial;font-size:10.0pt;color:#808080'>|__|__|__|__|__|__|__|__|__|__|__|__|__|__|__|__|__|__|__|__|</span></span>
                            </p>
                        </td>
                        <td class="celulas" width="">
                            <p><span style='font-family:Arial;font-size:7.0pt;color:black'>9. Validade
 da Carteira</span><br>
                                <span><span lang=EN-US style='font-family:Arial;font-size:10.0pt;color:#808080'>|__|__|/|__|__|/|__|__|__|__|</span></span>
                            </p>
                        </td>
                        <td class="celulas">
                            <p><span style='font-family:Arial;font-size:7.0pt;color:black'>10. Nome</span><br>
                                <span><span lang=EN-US style='font-family:Arial;font-size:14.0pt;font-weight: bold;color:black'><?php echo !empty($userData['nome_paciente'])?$userData['nome_paciente']:''; ?></span></span>
                            </p>
                        </td>
                        <td class="celulas" width="">
                            <p><span style='font-family:Arial;font-size:7.0pt;color:black'>11. Cartão Nacional de Saúde</span><br>
                                <span><span lang=EN-US style='font-family:Arial;font-size:10.0pt;color:#808080'>|__|__|__|__|__|__|__|__|__|__|__|__|__|__|__|</span></span>
                            </p>
                        </td>
                        <td class="celulas" width="">
                            <p><span style='font-family:Arial;font-size:7.0pt;color:black'>12. Atendimento a RN</span><br>
                                <span><span lang=EN-US style='font-family:Arial;font-size:10.0pt;color:#808080'>|__|</span></span>
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td bgcolor="#D9D9D9"  class="laterais">
                <p><b><span lang=EN-US style='font-family:Arial;font-size:7.0pt;color:black'>Dados
 do Contratado Solicitante</span></b>
                </p>
            </td>
        </tr>
        <tr>
            <td  class="laterais">
                <table width="100%">
                    <tr>
                        <td class="celulas" width="">
                            <p><span style='font-family:Arial;font-size:7.0pt;color:black'>13. Código na operadora</span><br>
                                <span><span lang=EN-US style='font-family:Arial;font-size:10.0pt;color:#808080'>|__|__|__|__|__|__|__|__|__|__|__|__|__|__|</span></span>
                            </p>
                        </td>
                        <td class="celulas">
                            <p><span style='font-family:Arial;font-size:7.0pt;color:black'>14 - Nome do Contratado</span><br>
                                <span><span lang=EN-US style='font-family:Arial;font-size:10.0pt;font-weight: bold;color:black'>&nbsp;</span></span>
                            </p>
                        </td>
                        <td class="celulas">
                            <p><span style='font-family:Arial;font-size:7.0pt;color:black'>15 - Nome do Profissional Solicitante</span><br>
                                <span lang=EN-US style='font-family:Arial;font-size:10.0pt;font-weight: bold;color:black'>FABRICIO VALADÃO BATISTONI</span>
                            </p>
                        </td>
                        <td class="celulas">
                            <p><span style='font-family:Arial;font-size:7.0pt;color:black'>16 - Conselho Profissional</span><br>
                                <span><span lang=EN-US style='font-family:Arial;font-size:10.0pt;font-weight: bold;color:black'>CRM</span></span>
                            </p>
                        </td>
                        <td class="celulas">
                            <p><span style='font-family:Arial;font-size:7.0pt;color:black'>17 - Número no conselho</span><br>
                                <span><span lang=EN-US style='font-family:Arial;font-size:10.0pt;font-weight: bold;color:black'>122.499</span></span>
                            </p>
                        </td>
                        <td class="celulas">
                            <p><span style='font-family:Arial;font-size:7.0pt;color:black'>18 - UF </span><br>
                                <span><span lang=EN-US style='font-family:Arial;font-size:10.0pt;font-weight: bold;color:black'>SP</span></span>
                            </p>
                        </td>
                        <td class="celulas">
                            <p><span style='font-family:Arial;font-size:7.0pt;color:black'>19 - Código CBO</span><br>
                                <span><span lang=EN-US style='font-family:Arial;font-size:10.0pt;font-weight: bold;color:black'>225124</span></span>
                            </p>
                        </td>
                        <td class="celulas">
                            <p><span style='font-family:Arial;font-size:7.0pt;color:black'>20 - Assinatura do Profissional Solicitante</span><br>
                                <span><span lang=EN-US style='font-family:Arial;font-size:10.0pt;font-weight: bold;color:black'>&nbsp;</span></span>
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr>
            <td bgcolor="#D9D9D9"  class="laterais">
                <p><b><span lang=EN-US style='font-family:Arial;font-size:7.0pt;color:black'>Dados da Solicitação / Procedimentos e Exames Solicitados</span></b>
                </p>
            </td>
        </tr>
        <tr>
            <td  class="laterais">
                <table width="100%">
                    <tr>
                        <td class="celulas">
                            <p><span style='font-family:Arial;font-size:7.0pt;color:black'>21- Caráter do Atendimento </span><br>
                                <span><span lang=EN-US style='font-family:Arial;font-size:7.0pt;color:#808080'>|__|ELETIVO |__|URGENCIA</span></span>
                            </p>
                        </td>
                        <td class="celulas">
                            <p><span style='font-family:Arial;font-size:7.0pt;color:black'>22 - Data da Solicitação </span><br>
                                <span lang=EN-US style='font-family:Arial;font-size:10.0pt;font-weight: bold;color:black'><?php echo !empty($userData['created'])?date("d/m/Y", strtotime($userData['created'])):''; ?></span>
                            </p>
                        </td>
                        <td class="celulas">
                            <p><span style='font-family:Arial;font-size:7.0pt;color:black'>23 - Indicação Clínica </span><br>
                                <span lang=EN-US style='font-family:Arial;font-size:10.0pt;font-weight: bold;color:black'><?php echo !empty($userData['cid'])?$userData['cid']:''; ?></span>
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr>
            <td class="laterais" width="100%" style="padding:2pt;">
                <table width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td bgcolor="#D9D9D9" width="8%" align=center style="border-bottom: 1pt solid #999999;">
                            <span style='font-family:Arial;font-size:7.0pt;color:black'>24 - Tabela 
                            </span>
                        </td>
                        <td bgcolor="#D9D9D9" width="" align=center style="border-bottom: 1pt solid #999999;border-left: 1px solid #ccc;">
                            <span style='font-family:Arial;font-size:7.0pt;color:black'>25 - Código 
                            </span>
                        </td>
                        <td bgcolor="#D9D9D9" width="70%" style="border-bottom: 1pt solid #999999;border-left: 1px solid #ccc;">
                            <span style='font-family:Arial;font-size:7.0pt;color:black'>26 - Descrição 
                            </span>
                            
                        </td>
                        <td bgcolor="#D9D9D9" width="5%" align=center style="border-bottom: 1pt solid #999999;border-left: 1px solid #ccc;">
                            <span style='font-family:Arial;font-size:7.0pt;color:black'>27 - Qtde. Solici. 
                            </span>
                            
                        </td>
                        <td bgcolor="#D9D9D9" width="5%" align=center style="border-bottom: 1pt solid #999999;border-left: 1px solid #ccc;">
                            <span style='font-family:Arial;font-size:7.0pt;color:black'>28 - Qtde. Aut. 
                            </span>
                        </td>
                    </tr>

                    <?php 
                    $exames=json_decode($userData['exames']);
                    for($i=0;$i<count($exames);$i++){

                        $proceder = preg_split('( - )',$exames[$i]->procedimento);

                        echo    '<tr>';
                        echo        '<td align=center bgcolor="#D9D9D9" style="border-bottom: 1pt solid #999999;">';
                        echo            '<span lang=EN-US style=\'font-family:Arial;font-size:10.0pt;color:#808080\'>|__|__|__|__|__|__|
                        </span>';
                        echo        '</td>';
                        echo        '<td align=center bgcolor="#D9D9D9" style="border-bottom: 1pt solid #999999;border-left: 1px solid #ccc;">';
                        echo            '<span style=\'font-family:Arial;font-size:12.0pt;font-weight:bold;color:black;\'>';
                        echo !empty($proceder[0])?$proceder[0]:'';
                        echo        '</span>';
                        echo        '</td>';
                        echo        '<td class="celula_exame" style="padding-left:.5rem;">';
                        echo                '<span style=\'font-family:Arial;font-size:12.0pt;color:black\'>';
                        echo !empty($proceder[1])?$proceder[1]:'';
                        echo                '</span>';
                        echo        '</td>';
                        echo        '<td align=center bgcolor="#D9D9D9" style="border-bottom: 1px solid #ccc;border-left: 1pt solid #999999;">';
                        echo            '<span lang=EN-US style=\'font-family:Arial;font-size:10.0pt;color:#808080\'>|__|__|__|__|
                        </span>';
                        echo        '</td>';
                        echo        '<td align=center bgcolor="#D9D9D9" style="border-bottom: 1px solid #ccc;border-left: 1pt solid #999999;">';
                        echo            '<span lang=EN-US style=\'font-family:Arial;font-size:10.0pt;font-weight: bold;color:#808080\'>|__|__|__|__|</span>';
                        echo        '</td>';
                        echo '</tr>';
                    }
                    ?>
                </table>
            </td>
        </tr>
        <tr>
            <td bgcolor="#D9D9D9"  class="laterais">
                <p><b><span lang=EN-US style='font-family:Arial;font-size:7.0pt;color:black'>Dados do Contratado Executante</span></b>
                </p>
            </td>
        </tr>
        <tr>
            <td  class="laterais">
                <table width="100%">
                    <tr>
                        <td class="celulas">
                            <p><span style='font-family:Arial;font-size:7.0pt;color:black'>29 - Código na Operadora</span><br>
                                <span><span lang=EN-US style='font-family:Arial;font-size:10.0pt;font-weight: bold;color:#808080'>|__|__|__|__|__|__|__|__|</span></span>
                            </p>
                        </td>
                        <td class="celulas" width="70%">
                            <p><span style='font-family:Arial;font-size:7.0pt;color:black'>30 - Nome do Contratado</span>
                            </p>
                        </td>
                        <td class="celulas">
                            <p><span style='font-family:Arial;font-size:7.0pt;color:black'>31 - Código CNES</span><br>
                                <span><span lang=EN-US style='font-family:Arial;font-size:10.0pt;font-weight: bold;color:#808080'>|__|__|__|__|__|__|__|</span></span>
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td bgcolor="#D9D9D9"  class="laterais">
                <p><b><span lang=EN-US style='font-family:Arial;font-size:7.0pt;color:black'>Dados do Atendimento</span></b>
                </p>
            </td>
        </tr>
        <tr>
            <td  class="laterais">
                <table width="100%">
                    <tr>
                        <td class="celulas">
                            <p><span style='font-family:Arial;font-size:7.0pt;color:black'>32 - Tipo de Atendimento </span><br>
                                <span><span lang=EN-US style='font-family:Arial;font-size:10.0pt;font-weight: bold;color:#808080'>|__|__|</span></span>
                            </p>
                        </td>
                        <td class="celulas">
                            <p><span style='font-family:Arial;font-size:7.0pt;color:black'>33 - Indicação de Acidente (acidente ou doença relacionada)</span><br>
                                <span><span lang=EN-US style='font-family:Arial;font-size:10.0pt;font-weight: bold;color:#808080'>|__|</span></span>
                            </p>
                        </td>
                        <td class="celulas">
                            <p><span style='font-family:Arial;font-size:7.0pt;color:black'>34 - Tipo de Consulta</span><br>
                                <span><span lang=EN-US style='font-family:Arial;font-size:10.0pt;font-weight: bold;color:#808080'>|__|</span></span>
                            </p>
                        </td>
                        <td class="celulas">
                            <p><span style='font-family:Arial;font-size:7.0pt;color:black'>35 - Motivo de Encerramento do Atendimento</span><br>
                                <span><span lang=EN-US style='font-family:Arial;font-size:10.0pt;font-weight: bold;color:#808080'>|__|__|</span></span>
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td class="laterais">
                <p><b><span lang=EN-US style='font-family:Arial;font-size:7.0pt;color:black'>Dados da Execução / Procedimentos e Exames Realizados</span></b>
                </p>
            </td>
        </tr>
        <tr>
            <td  class="laterais">
                <table width="100%" class="celulas">
                    <tr>
                        <td>
                            <p><span style='font-family:Arial;font-size:7.0pt;color:black'>36 - Data</span>
                            </p> <span><span style='font-family:Arial;font-size:7.0pt;color:black'><span lang=EN-US style='font-family:Arial;font-size:10.0pt;font-weight: bold;color:#808080'>|__|__|/|__|__|/|__|__|__|__|</span></span>
                        </td>
                        <td>
                            <p><span style='font-family:Arial;font-size:7.0pt;color:black'>37 - Hora Inicial</span>
                            </p> <span><span style='font-family:Arial;font-size:7.0pt;color:black'><span lang=EN-US style='font-family:Arial;font-size:10.0pt;font-weight: bold;color:#808080'>|__|__|:|__|__|</span></span>
                        </td>
                        <td>
                            <p><span style='font-family:Arial;font-size:7.0pt;color:black'>38 - Hora Final</span>
                            </p> <span><span style='font-family:Arial;font-size:7.0pt;color:black'><span lang=EN-US style='font-family:Arial;font-size:10.0pt;font-weight: bold;color:#808080'>|__|__|:|__|__|</span></span>
                        </td>
                        <td>
                            <p><span style='font-family:Arial;font-size:7.0pt;color:black'>39 - Tabela</span>
                            </p> <span><span style='font-family:Arial;font-size:7.0pt;color:black'><span lang=EN-US style='font-family:Arial;font-size:10.0pt;font-weight: bold;color:#808080'>|__|__|</span></span>
                        </td>
                        <td>
                            <p><span style='font-family:Arial;font-size:7.0pt;color:black'>40 - Código de Procedimento </span>
                            </p> <span><span style='font-family:Arial;font-size:7.0pt;color:black'><span lang=EN-US style='font-family:Arial;font-size:10.0pt;font-weight: bold;color:#808080'>|__|__|__|__|__|__|__|__|__|__|</span></span>
                        </td>
                        <td width="100px">
                            <p><span style='font-family:Arial;font-size:7.0pt;color:black'>41 - Descrição </span>
                            </p>
                        </td>
                        <td>
                            <p><span style='font-family:Arial;font-size:7.0pt;color:black'>42 - Qtde. </span>
                            </p> <span><span style='font-family:Arial;font-size:7.0pt;color:black'><span lang=EN-US style='font-family:Arial;font-size:10.0pt;font-weight: bold;color:#808080'>|__|__|__|</span></span>
                        </td>
                        <td>
                            <p><span style='font-family:Arial;font-size:7.0pt;color:black'>43 - Via </span>
                            </p> <span><span style='font-family:Arial;font-size:7.0pt;color:black'><span lang=EN-US style='font-family:Arial;font-size:10.0pt;font-weight: bold;color:#808080'>|__|</span></span>
                        </td>
                        <td>
                            <p><span style='font-family:Arial;font-size:7.0pt;color:black'>44 - Tec. </span>
                            </p> <span><span style='font-family:Arial;font-size:7.0pt;color:black'><span lang=EN-US style='font-family:Arial;font-size:10.0pt;font-weight: bold;color:#808080'>|__|</span></span>
                        </td>
                        <td>
                            <p><span style='font-family:Arial;font-size:7.0pt;color:black'>45 - Fator Red./Acresc.</span>
                            </p> <span><span style='font-family:Arial;font-size:7.0pt;color:black'><span lang=EN-US style='font-family:Arial;font-size:10.0pt;font-weight: bold;color:#808080'>|__|.|__|__|</span></span>
                        </td>
                        <td>
                            <p><span style='font-family:Arial;font-size:7.0pt;color:black'>46 - Valor Unitário (R$) </span>
                            </p> <span><span style='font-family:Arial;font-size:7.0pt;color:black'><span lang=EN-US style='font-family:Arial;font-size:10.0pt;font-weight: bold;color:#808080'>|__|__|__|__|__|__|__|.|__|__|</span></span>
                        </td>
                        <td valign=top>
                            <p><span style='font-family:Arial;font-size:7.0pt;color:black'>47 - Valor Total(R$)</span>
                            </p> <span><span style='font-family:Arial;font-size:7.0pt;color:black'><span lang=EN-US style='font-family:Arial;font-size:10.0pt;font-weight: bold;color:#808080'>|__|__|__|__|__|__|__|.|__|__|</span></span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td bgcolor="#D9D9D9"  class="laterais">
                <p><b><span lang=EN-US style='font-family:Arial;font-size:7.0pt;color:black'>Identificação do(s) Profissional(is) Executante(s)</span></b>
                </p>
            </td>
        </tr>
        <tr>
            <td  class="laterais">
                <table class="celulas" width="100%">
                    <tr>
                        <td width="70px">
                            <p><span style='font-family:Arial;font-size:7.0pt;color:black'>48 - Seq.Ref.</span>
                            </p> <span><span style='font-family:Arial;font-size:7.0pt;color:black'><span lang=EN-US style='font-family:Arial;font-size:10.0pt;font-weight: bold;color:#808080'>|__|__|</span></span>
                        </td>
                        <td width="70px">
                            <p><span style='font-family:Arial;font-size:7.0pt;color:black'>49 - Grau Part.</span>
                            </p> <span><span style='font-family:Arial;font-size:7.0pt;color:black'><span lang=EN-US style='font-family:Arial;font-size:10.0pt;font-weight: bold;color:#808080'>|__|__|</span></span>
                        </td>
                        <td>
                            <p><span style='font-family:Arial;font-size:7.0pt;color:black'>50 - Código na Operadora/CPF</span>
                            </p> <span><span style='font-family:Arial;font-size:7.0pt;color:black'><span lang=EN-US style='font-family:Arial;font-size:10.0pt;font-weight: bold;color:#808080'>|__|__|__|__|__|__|__|__|__|__|__|__|__|__|</span></span>
                        </td>
                        <td class="celula_exame" width="35%">
                            <p><span style='font-family:Arial;font-size:7.0pt;color:black'>51- Nome do Profissional</span>
                            </p> <span><span style='font-family:Arial;font-size:7.0pt;color:black'></span>
                        </td>
                        <td width="150px">
                            <p><span style='font-family:Arial;font-size:7.0pt;color:black'>52 - Conselho Profissional</span>
                            </p> <span><span style='font-family:Arial;font-size:7.0pt;color:black'><span lang=EN-US style='font-family:Arial;font-size:10.0pt;font-weight: bold;color:#808080'>|__|__|</span></span>
                        </td>
                        <td>
                            <p><span style='font-family:Arial;font-size:7.0pt;color:black'>53 - Número no Conselho</span>
                            </p> <span><span style='font-family:Arial;font-size:7.0pt;color:black'><span lang=EN-US style='font-family:Arial;font-size:10.0pt;font-weight: bold;color:#808080'>|__|__|__|__|__|__|__|__|__|__|__|__|__|__|</span></span>
                        </td>
                        <td>
                            <p><span style='font-family:Arial;font-size:7.0pt;color:black'>54 - UF </span>
                            </p> <span><span style='font-family:Arial;font-size:7.0pt;color:black'><span lang=EN-US style='font-family:Arial;font-size:10.0pt;font-weight: bold;color:#808080'>|__|__|</span></span>
                        </td>
                        <td>
                            <p><span style='font-family:Arial;font-size:7.0pt;color:black'>55 - Código CBO</span>
                            </p> <span><span style='font-family:Arial;font-size:7.0pt;color:black'><span lang=EN-US style='font-family:Arial;font-size:10.0pt;font-weight: bold;color:#808080'>|__|__|__|__|__|__|__|</span></span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td class="laterais">
                <table width="100%" class="celulas">
                    <tr>
                        <td valign=top>
                            <p><span style='font-family:Arial;font-size:7.0pt;color:black'>56- data de Realização de Procedimentos em Série // 57- Assinatura do Beneficiário ou Responsável</span>
                            </p> <span><span style='font-family:Arial;font-size:7.0pt;color:black'><span lang=EN-US style='font-family:Arial;font-size:10.0pt;font-weight: bold;color:#808080'>|__|__|/|__|__|/|__|__|__|__| _________</span></span>
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr>
            <td bgcolor="#D9D9D9"  class="laterais">
                <table width="100%">
                    <tr>
                        <td valign=top>
                            <p><span style='font-family:Arial;font-size:7.0pt;color:black'>58 - Observação/Justificativa</span>
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td  class="laterais">
                <table width="100%">
                    <tr>
                        <td class="celulas">
                            <p><span style='font-family:Arial;font-size:7.0pt;color:black'>59 - Total de Procedimentos (R$)</span>
                            </p> <span><span style='font-family:Arial;font-size:7.0pt;color:black'><span lang=EN-US style='font-family:Arial;font-size:10.0pt;font-weight: bold;color:#808080'>|__|__|__|__|__|__|__|__|,|__|__|</span></span>
                        </td>
                        <td class="celulas">
                            <p><span style='font-family:Arial;font-size:7.0pt;color:black'>60 - Total de Taxas e Aluguéis (R$)</span>
                            </p> <span><span style='font-family:Arial;font-size:7.0pt;color:black'><span lang=EN-US style='font-family:Arial;font-size:10.0pt;font-weight: bold;color:#808080'>|__|__|__|__|__|__|__|__|,|__|__|</span></span>
                        </td>
                        <td class="celulas">
                            <p><span style='font-family:Arial;font-size:7.0pt;color:black'>61 - Total de Materiais (R$)</span>
                            </p> <span><span style='font-family:Arial;font-size:7.0pt;color:black'><span lang=EN-US style='font-family:Arial;font-size:10.0pt;font-weight: bold;color:#808080'>|__|__|__|__|__|__|__|__|,|__|__|</span></span>
                        </td>
                        <td class="celulas">
                            <p><span style='font-family:Arial;font-size:7.0pt;color:black'>62 - Total de OPME (R$)</span>
                            </p> <span><span style='font-family:Arial;font-size:7.0pt;color:black'><span lang=EN-US style='font-family:Arial;font-size:10.0pt;font-weight: bold;color:#808080'>|__|__|__|__|__|__|__|__|,|__|__|</span></span>
                        </td>
                        <td class="celulas">
                            <p><span style='font-family:Arial;font-size:7.0pt;color:black'>63 - Total de Medicamentos (R$)</span>
                            </p> <span><span style='font-family:Arial;font-size:7.0pt;color:black'><span lang=EN-US style='font-family:Arial;font-size:10.0pt;font-weight: bold;color:#808080'>|__|__|__|__|__|__|__|__|,|__|__|</span></span>
                        </td>
                        <td class="celulas">
                            <p><span style='font-family:Arial;font-size:7.0pt;color:black'>64 - Total de Gases Medicinais (R$)</span>
                            </p> <span><span style='font-family:Arial;font-size:7.0pt;color:black'><span lang=EN-US style='font-family:Arial;font-size:10.0pt;font-weight: bold;color:#808080'>|__|__|__|__|__|__|__|__|,|__|__|</span></span>
                        </td>
                        <td class="celulas">
                            <p><span style='font-family:Arial;font-size:7.0pt;color:black'>65 - Total Geral (R$)</span>
                            </p> <span><span style='font-family:Arial;font-size:7.0pt;color:black'><span lang=EN-US style='font-family:Arial;font-size:10.0pt;font-weight: bold;color:#808080'>|__|__|__|__|__|__|__|__|,|__|__|</span></span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td  class="embaixo">
                <table width="100%">
                    <tr>
                        <td class="celulas">
                            <p><span style='font-family:Arial;font-size:7.0pt;color:black'>66- Assinatura do Responsável pela Autorização</span>
                                <br>
                            </p>
                            <br>
                        </td>
                        <td class="celulas">
                            <p><span style='font-family:Arial;font-size:7.0pt;color:black'>Assinatura do Beneficiário ou Responsável</span>
                            </p>
                        </td>
                        <td class="celulas">
                            <p><span style='font-family:Arial;font-size:7.0pt;color:black'>Assinatura do Contratado</span>
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
<?php
//==============================================================
//==============================================================
//==============================================================
$html = ob_get_contents();
ob_clean();

$path = getenv('MPDF_ROOT') ? getenv('MPDF_ROOT') : __DIR__;
require_once $path . '/vendor/autoload.php';

// Instância correta (sem barra invertida errada)
$mpdf = new \Mpdf\Mpdf([
    'orientation' => 'L',
    'mode'        => 'utf-8',
    'format'      => 'A4',
]);

// Modo de exibição no viewer do PDF
$mpdf->SetDisplayMode('fullpage');

// Carregar stylesheet corretamente
$stylesheet = file_get_contents(__DIR__ . '/assets/css/guia.css');

// 1º parâmetro: conteúdo CSS
// 2º parâmetro: Mpdf::WRITEHTML_MODE_CSS quer dizer que é CSS
$mpdf->WriteHTML($stylesheet, \Mpdf\HTMLParserMode::HEADER_CSS);

// Agora escreve o HTML do documento
$mpdf->WriteHTML($html, \Mpdf\HTMLParserMode::HTML_BODY);

// Output
$mpdf->Output('documento.pdf', 'I');

exit;
?>    