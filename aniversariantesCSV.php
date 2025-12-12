<?php
require_once '../loader.php';
@session_start();

if (!isset($_SESSION['LOGADO']) || $_SESSION['LOGADO'] == FALSE) {
    @header('location:' . Validacao::getBase() . 'login.php');
    exit;
}

include 'DB.class.php';
$db = new DB();

date_default_timezone_set('America/Sao_Paulo');
$now = new DateTime();
$hoje = $now->format('m-d');

// Pega os aniversariantes
$dados_aniversariantes = $db->getAniversariantes($hoje);

$nomes_compostos = array(
    "Ana",
    "Maria",
    "Joao",
    "Jose",
    "Marco",
    "Pedro",
    "Victor",
    "Vitor"
);

// Configura cabeçalhos para download CSV
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=aniversariantes-' . $now->format('Y-m-d') . '.csv');
header('Pragma: no-cache');
header('Expires: 0');

// Abre a saída do PHP para o navegador
$output = fopen('php://output', 'w');

// Escreve as colunas
$cabecalhos = array('NAME','NUMBER');
fputcsv($output, $cabecalhos, ",");

// Escreve cada aniversariante
for ($i = 0; $i < count($dados_aniversariantes); $i++) {
    if(!empty($dados_aniversariantes[$i]['aniversario'])){
        if($db->calcula_idade_anos($dados_aniversariantes[$i]['aniversario'],$now->format('Y-m-d')) <= 18){

            // Se o phone1 estiver prenchido e for celular, cria uma linha com nome + número
            if (!empty($dados_aniversariantes[$i]['phone1']) && strlen($dados_aniversariantes[$i]['phone1']) == 13){                
                // Cuida dos nomes compostos
                $name_pieces = explode(" ", $dados_aniversariantes[$i]['name']);
                if(in_array($name_pieces[0],$nomes_compostos)){
                    $aniversariantes = array(
                        'name' => $name_pieces[0]." ".$name_pieces[1],
                        'number' => '+'.$dados_aniversariantes[$i]['phone1']                        
                    );
                    fputcsv($output, $aniversariantes, ",");
                } else {
                    $aniversariantes = array(
                        'name' => $name_pieces[0],
                        'number' => '+'.$dados_aniversariantes[$i]['phone1']                        
                    );
                    fputcsv($output, $aniversariantes, ",");
                }
            }
        }
    }
}

for ($i = 0; $i < count($dados_aniversariantes); $i++) {
    if(!empty($dados_aniversariantes[$i]['aniversario'])){
        if($db->calcula_idade_anos($dados_aniversariantes[$i]['aniversario'],$now->format('Y-m-d')) <= 18){

            // Se o phone1 estiver prenchido e for celular, cria uma linha com nome + número
            if (!empty($dados_aniversariantes[$i]['phone2']) && strlen($dados_aniversariantes[$i]['phone2']) == 13){                
                // Cuida dos nomes compostos
                $name_pieces = explode(" ", $dados_aniversariantes[$i]['name']);
                if(in_array($name_pieces[0],$nomes_compostos)){
                    $aniversariantes = array(
                        'name' => $name_pieces[0]." ".$name_pieces[1],
                        'number' => '+'.$dados_aniversariantes[$i]['phone2']                        
                    );
                    fputcsv($output, $aniversariantes, ",");
                } else {
                    $aniversariantes = array(
                        'name' => $name_pieces[0],
                        'number' => '+'.$dados_aniversariantes[$i]['phone2']                        
                    );
                    fputcsv($output, $aniversariantes, ",");
                }
            }
        }
    }
}

fclose($output);
exit;
?>
