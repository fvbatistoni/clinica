<?php
  require_once('dbconn.php');

if(isset($_POST['search'])){
    $search = $_POST['search'];

    $stmt = $dbconn->prepare("SELECT codProcedimento, descricao
        FROM tuss
        WHERE descricao like'%".$search."%'");
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
	foreach ($data as $linha) {
	   $response[] = array("cod"=>$linha['codProcedimento'],"label"=>$linha['descricao']);
	}    

    echo json_encode($response, JSON_HEX_QUOT | JSON_HEX_TAG);
}

exit;


