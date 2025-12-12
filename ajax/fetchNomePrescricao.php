<?php
  require_once('dbconn.php');

if(isset($_POST['search'])){
    $search = $_POST['search'];

    $stmt = $dbconn->prepare("SELECT nome
        FROM prescricaos
        WHERE nome like'%".$search."%' GROUP BY nome");
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
	foreach ($data as $linha) {
	   $response[] = array("label"=>$linha['nome']);
	}    

    echo json_encode($response);
}

exit;


