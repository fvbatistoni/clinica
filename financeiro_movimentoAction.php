<?php
// Start session
session_start();

// Load and initialize database class
require_once 'DB.class.php';
$db = new DB();

$tblName = 'financeiro_movimentos';

// Set default redirect url
$redirectURL = 'financeiro_movimentoIndex.php';

$livro_caixa = array(23, 26, 27, 34, 35, 36, 37, 38, 39, 40, 41, 45, 46, 47, 49, 52);
$atividades_pj = array(32, 42);
$receitas_pf = array(16,17,18,19,20,50,51,24,25,29,53,28,54,57,58,59,60,61);
$despesas_pf = array(21,22,31,43,44,48);

// Atualiza STATUS via AJAX (toggle no Index)
if (isset($_POST['action_type']) && $_POST['action_type'] == 'update_status') {

    $id = intval($_POST['id']);
    $status = isset($_POST['status']) ? intval($_POST['status']) : 0;

    // Atualiza somente o status
    $update = $db->update($tblName, ['status' => $status], ['id' => $id]);

    // Retorna JSON para o AJAX
    echo json_encode([
        'success' => $update ? true : false,
        'id' => $id,
        'status' => $status
    ]);

    exit; // Evita redirecionamento
}

if(isset($_POST['userSubmit'])){
    // Get submitted data    
    $categoria    = !empty($_POST['categoria'])?intval($_POST['categoria']):'';
    $valor        = !empty($_POST['valor'])?floatval($_POST['valor']):'';
    $descricao    = !empty($_POST['descricao'])?addslashes($_POST['descricao']):'';
    $detalhes     = !empty($_POST['detalhes'])?addslashes($_POST['detalhes']):'';
    $cpf_cnpj     = !empty($_POST['cpf_cnpj'])?addslashes($_POST['cpf_cnpj']):'';
    $cod_LivroCaixa = !empty($_POST['cod_LivroCaixa'])?addslashes($_POST['cod_LivroCaixa']):'';
    $codigo_ReceitaFederal = !empty($_POST['codigo_ReceitaFederal'])?addslashes($_POST['codigo_ReceitaFederal']):'';    
    $data_recebimento = !empty($_POST['data_recebimento'])?addslashes($_POST['data_recebimento']):'';
    $status = isset($_POST['status']) ? intval($_POST['status']) : 0;
    $id            = intval($_POST['id']);

    if(in_array($categoria, $livro_caixa)){
        switch ($categoria) {
            case 23:  $tipo = 1; $cod_LivroCaixa = 'R01.001.001'; break;
            case 26:  $tipo = 0; $cod_LivroCaixa = 'P10.01.00002'; break;
            case 27:  $tipo = 0; $cod_LivroCaixa = 'P10.01.00011'; break;
            case 34:  $tipo = 0; $cod_LivroCaixa = 'P10.01.00001'; break;
            case 35:  $tipo = 0; $cod_LivroCaixa = 'P10.01.00003'; break;
            case 36:  $tipo = 0; $cod_LivroCaixa = 'P10.01.00004'; break;
            case 37:  $tipo = 0; $cod_LivroCaixa = 'P10.01.00006'; break;
            case 38:  $tipo = 0; $cod_LivroCaixa = 'P10.01.00007'; break;
            case 39:  $tipo = 0; $cod_LivroCaixa = 'P10.01.00008'; break;
            case 40:  $tipo = 0; $cod_LivroCaixa = 'P10.01.00009'; break;
            case 41:  $tipo = 0; $cod_LivroCaixa = 'P10.01.00010'; break;
            case 45:  $tipo = 0; $cod_LivroCaixa = 'P11.01.00013'; break;
            case 46:  $tipo = 0; $cod_LivroCaixa = 'P11.01.00016'; break;
            case 47:  $tipo = 0; $cod_LivroCaixa = 'P11.01.00017'; break;
            case 49:  $tipo = 0; $cod_LivroCaixa = 'P11.01.00004'; break;
            case 52:  $tipo = 0; $cod_LivroCaixa = 'P11.01.00008'; break;
            default:  $tipo = 0; break;
        }

        $userData = array(
            'tipo' => $tipo,
            'categoria' => $categoria,
            'descricao' => $descricao,
            'detalhes' => $detalhes,
            'cpf_cnpj' => $cpf_cnpj,
            'cod_LivroCaixa' => $cod_LivroCaixa,
            'codigo_ReceitaFederal' => $codigo_ReceitaFederal,
            'valor' => $valor,
            'status' => $status,
            'data_recebimento' => $data_recebimento
        );

    } else if(in_array($categoria, $atividades_pj)){
        $tipo = 0;
        $userData = array(
            'tipo' => $tipo,
            'categoria' => $categoria,
            'descricao' => $descricao,
            'detalhes' => $detalhes,
            'cpf_cnpj' => $cpf_cnpj,
            'cod_LivroCaixa' => $cod_LivroCaixa,
            'codigo_ReceitaFederal' => $codigo_ReceitaFederal,
            'valor' => $valor,
            'status' => $status,
            'data_recebimento' => $data_recebimento
        );

    } else if(in_array($categoria, $receitas_pf)){
        $tipo = 1;
        $userData = array(
            'tipo' => $tipo,
            'categoria' => $categoria,
            'descricao' => $descricao,
            'detalhes' => $detalhes,
            'cpf_cnpj' => $cpf_cnpj,
            'cod_LivroCaixa' => $cod_LivroCaixa,
            'codigo_ReceitaFederal' => $codigo_ReceitaFederal,
            'valor' => $valor,
            'status' => $status,
            'data_recebimento' => $data_recebimento
        );

    } else if(in_array($categoria, $despesas_pf)){
        $tipo = 0;
        $userData = array(
            'tipo' => $tipo,
            'categoria' => $categoria,
            'descricao' => $descricao,
            'detalhes' => $detalhes,
            'cpf_cnpj' => $cpf_cnpj,
            'cod_LivroCaixa' => $cod_LivroCaixa,
            'codigo_ReceitaFederal' => $codigo_ReceitaFederal,
            'valor' => $valor,
            'status' => $status,
            'data_recebimento' => $data_recebimento
        );
    }

    $sessData['postData'] = $userData;
    $sessData['postData']['id'] = $id;
    


    $idStr = !empty($id) ? '?id='.$id : '';

    if(!empty($id)){
        $condition = array('id' => $id);
        $update = $db->update($tblName, $userData, $condition);

        if($update){
            $sessData['postData'] = '';
            $sessData['status']['type'] = 'success';
            $sessData['status']['msg'] = 'Atualizada com sucesso.';
        }else{
            $sessData['status']['type'] = 'error';
            $sessData['status']['msg'] = 'Ocorreu um problema. Tente novamente.';
            $redirectURL = 'financeiro_movimentoAddEdit.php'.$idStr;
        }
    } else {
        $insert = $db->insert($tblName, $userData);

        if($insert){
            $sessData['postData'] = '';
            $sessData['status']['type'] = 'success';
            $sessData['status']['msg'] = 'Adicionada com sucesso.';
        }else{
            $sessData['status']['type'] = 'error';
            $sessData['status']['msg'] = 'Ocorreu um problema. Tente novamente.';
            $redirectURL = 'financeiro_movimentoAddEdit.php';
        }
    }

    $_SESSION['sessData'] = $sessData;

} elseif(($_REQUEST['action_type'] == 'delete') && !empty($_GET['id'])) {
    $condition = array('id' => $_GET['id']);
    $delete = $db->delete($tblName, $condition);

    if($delete){
        $sessData['status']['type'] = 'success';
        $sessData['status']['msg'] = 'Excluída com sucesso.';
    }else{
        $sessData['status']['type'] = 'error';
        $sessData['status']['msg'] = 'Ocorreu um problema. Tente novamente.';
    }
    $_SESSION['sessData'] = $sessData;
    $redirectURL = 'financeiro_movimentoIndex.php';
}

// Redirect to the page
header("Location: ".$redirectURL);
exit();
?>
