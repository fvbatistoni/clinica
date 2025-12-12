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
	$userData = $db->getRows('atestados', $conditions);
}

// Pre-filled data
$userData = !empty($postData)?$postData:$userData;

// Define action
$actionLabel = !empty($_GET['id'])?'Editar':'Adicionar';

ob_start();
?>
<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <title><?= !empty($userData['nome_paciente']) ? $userData['nome_paciente'] : 'Atestado'; ?></title>

    <style>
        .soft-break {
            margin-left: 0 !important;
            margin-right: 50% !important;
            margin-top: 0 !important;
            margin-bottom: 0 !important;
            padding: 0 !important;
            display: inline !important;
            line-height: 16px !important;
        }
        .text-pequeno {
            font-size: 10px !important;
        }
    </style>
</head>

<body>

    <p align="center">
        <img src="images/image1.png" align="center" width="645">
    </p><br>

    <h1>ATESTADO MÉDICO</h1>

    <p class="nome">O(A) SR.(A):
        <strong><?= !empty($userData['nome_paciente']) ? $userData['nome_paciente'] : ''; ?></strong>
    </p><br>

    <p>COMPARECEU A ESTA CLÍNICA PARA:</p>

    <p>
        <?= $userData['beneficiario'] == 1 ? '<img src="images/mini-checked.png">' : '<img src="images/mini-unchecked.png">'; ?>
        <label>CONSULTA</label>
        <br>
        <?= $userData['beneficiario'] == 2 ? '<img src="images/mini-checked.png">' : '<img src="images/mini-unchecked.png">'; ?>
        <label>ACOMPANHAR FAMILIAR: <?= !empty($userData['beneficiario_complemento']) ? $userData['beneficiario_complemento'] : ''; ?></label>
    </p>

    <br>

    <p><strong>PORTANTO, COMUNICAMOS QUE:</strong></p>

    <table width="100%" cellpadding="1" cellspacing="1">
        <tr>
            <td valign="top" width="70%">

                <div>
                    <?= $userData['motivo'] == 1 ? '<img src="images/mini-checked.png">' : '<img src="images/mini-unchecked.png">'; ?>
                    <label>Nada apresenta que o impossibilite o retorno <strong><?= ($userData['motivo'] == 1 && !empty($userData['motivo_complemento'])) ? $userData['motivo_complemento'] : ''; ?></strong></label>
                </div>

                <div>
                    <?= $userData['motivo'] == 2 ? '<img src="images/mini-checked.png">' : '<img src="images/mini-unchecked.png">'; ?>
                    <label>Deverá permanecer em repouso no horário: <strong><?= ($userData['motivo'] == 2 && !empty($userData['motivo_complemento'])) ? $userData['motivo_complemento'] : ''; ?></strong></label>
                </div>

                <div>
                    <?= $userData['motivo'] == 3 ? '<img src="images/mini-checked.png">' : '<img src="images/mini-unchecked.png">'; ?>
                    <label>Deverá permanecer em repouso no período da <b>MANHÃ</b></label>
                </div>

                <div>
                    <?= $userData['motivo'] == 4 ? '<img src="images/mini-checked.png">' : '<img src="images/mini-unchecked.png">'; ?>
                    <label>Deverá permanecer em repouso no período da <b>TARDE</b></label>
                </div>

                <div>
                    <?= $userData['motivo'] == 5 ? '<img src="images/mini-checked.png">' : '<img src="images/mini-unchecked.png">'; ?>
                    <label>Deverá permanecer em repouso no dia de hoje</label>
                </div>

                <div>
                    <?= $userData['motivo'] == 6 ? '<img src="images/mini-checked.png">' : '<img src="images/mini-unchecked.png">'; ?>
                    <label>Deverá permanecer em repouso no período de <strong><?= ($userData['motivo'] == 6 && !empty($userData['motivo_complemento'])) ? $userData['motivo_complemento'] : ''; ?></strong></label>
                </div>

                <hr>

                AUTORIZO O MÉDICO A REGISTRAR O CID NESTE RELATÓRIO<br><br>
                Assinatura: __________________________________________<br><br>

                CID: <strong><?= !empty($userData['cid']) ? $userData['cid'] : ''; ?></strong>

            </td>

            <td valign="top">
                <table class="tabela2" width="200">
                    <tr>
                        <td valign="bottom" height="150" align="center">
                            <font class="rodape">CARIMBO MÉDICO COM CRM</font>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <?php if (!empty($userData['observacoes'])): ?>
        <p>&nbsp;</p>
        <p class="soft-break text-pequeno">
            <strong>OBSERVAÇÕES: </strong><?= $userData['observacoes']; ?>
        </p>
    <?php endif; ?>

    <p align="right">
        <strong>Campinas</strong>, <?= date("d/m/Y", strtotime($userData['created'])); ?>
    </p>

    <hr>

    <p>
        <font class="rodape">
            <b>LOCAL DO ATENDIMENTO:</b><br>
            <strong>Clínica ECOCENTER:</strong>
            Rua Maria Monteiro, 1016 - Cambuí, Campinas (SP),
            <!-- Seus SVGs continuam iguais -->
            ...  
            <i>www.ecocenter.med.br</i>
        </font>
    </p>

</body>
</html>

<?php
//==============================================================
// FINALIZA O HTML PARA O MPDF
//==============================================================
$html = ob_get_contents();
ob_end_clean();

$path = getenv('MPDF_ROOT') ? getenv('MPDF_ROOT') : __DIR__;
require_once $path . '/vendor/autoload.php';

$mpdf = new \Mpdf\Mpdf([
    'mode'                 => 'utf-8',
    'format'               => 'A4',
    'useInlineStyles'      => true,
    'use_kwt'              => false,
]);

$mpdf->SetDisplayMode('fullpage');

// CSS externo (opcional)
$stylesheet = file_get_contents(__DIR__ . '/assets/css/atestado.css');
$mpdf->WriteHTML($stylesheet, \Mpdf\HTMLParserMode::HEADER_CSS);

// HTML final
$mpdf->WriteHTML($html, \Mpdf\HTMLParserMode::HTML_BODY);

$mpdf->Output('atestado.pdf', 'I');
exit;
?>