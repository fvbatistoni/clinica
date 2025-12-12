<?php
// Inicia a sessão
session_start();

include 'DB.class.php';
$db = new DB();

// Verifique se a ação é de exclusão
if (isset($_GET['action_type']) && $_GET['action_type'] == 'delete') {
    $id = $_GET['id'];

    // Verifique se o ID é válido
    if (!empty($id)) {
        // Deletando o registro
        $delete = $db->delete('tuss', array('id' => $id));
        
        // Verifique se a exclusão foi bem-sucedida
        if ($delete) {
            $_SESSION['sessData']['status']['msg'] = 'Registro deletado com sucesso!';
            $_SESSION['sessData']['status']['type'] = 'success';
        } else {
            $_SESSION['sessData']['status']['msg'] = 'Erro ao deletar o registro! Tente novamente.';
            $_SESSION['sessData']['status']['type'] = 'error';
        }
    } else {
        $_SESSION['sessData']['status']['msg'] = 'ID inválido para exclusão.';
        $_SESSION['sessData']['status']['type'] = 'error';
    }

    // Redirecionar para a página de listagem após deletar
    header("Location: tusIndex.php");
    exit;
}

// Verifique se o formulário foi submetido para adição ou edição
if (isset($_POST['userSubmit'])) {
    // Capture os dados do formulário
    $userData = array(
        'codProcedimento' => $_POST['codProcedimento'],
        'descricao' => $_POST['descricao'],
        'versao' => $_POST['versao'],
        'status' => $_POST['status'],
    );

    // Verifique se é uma adição ou edição
    if (!empty($_POST['id'])) {
        // Editando um registro existente
        $where = array('id' => $_POST['id']);
        $update = $db->update('tuss', $userData, $where);

        if ($update) {
            $_SESSION['sessData']['status']['msg'] = 'Registro atualizado com sucesso!';
            $_SESSION['sessData']['status']['type'] = 'success';
        } else {
            $_SESSION['sessData']['status']['msg'] = 'Erro ao atualizar o registro!';
            $_SESSION['sessData']['status']['type'] = 'error';
        }
    } else {
        // Adicionando um novo registro
        $insert = $db->insert('tuss', $userData);

        if ($insert) {
            $_SESSION['sessData']['status']['msg'] = 'Registro adicionado com sucesso!';
            $_SESSION['sessData']['status']['type'] = 'success';
        } else {
            $_SESSION['sessData']['status']['msg'] = 'Erro ao adicionar o registro!';
            $_SESSION['sessData']['status']['type'] = 'error';
        }
    }

    // Redirecionar para a página de listagem após salvar
    header("Location: tusIndex.php");
    exit;
}
?>
