<?php
  require_once('dbconn.php');

if(isset($_POST['search'])){
    $search = $_POST['search'];

    $stmt = $dbconn->prepare("SELECT descricao
        FROM financeiro_movimentos
        WHERE descricao like'%".$search."%' GROUP BY descricao");
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
	foreach ($data as $linha) {
	   $response[] = array("label"=>$linha['descricao']);
	}    

    echo json_encode($response);
}

exit;