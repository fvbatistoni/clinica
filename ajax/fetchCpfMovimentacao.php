<?php
  require_once('dbconn.php');

if(isset($_POST['search'])){
    $search = $_POST['search'];

    $stmt = $dbconn->prepare("SELECT cpf_cnpj
        FROM financeiro_movimentos
        WHERE cpf_cnpj like'%".$search."%' GROUP BY cpf_cnpj");
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
	foreach ($data as $linha) {
	   $response[] = array("label"=>$linha['cpf_cnpj']);
	}    

    echo json_encode($response);
}

exit;