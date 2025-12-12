<?php
  require_once('dbconn.php');

if(isset($_POST['search'])){
    $search = $_POST['search'];

    $stmt = $dbconn->prepare("SELECT nome_paciente
        FROM atestados
        WHERE nome_paciente like'%".$search."%' GROUP BY nome_paciente");
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
	foreach ($data as $linha) {
	   $response[] = array("label"=>$linha['nome_paciente']);
	}    

    echo json_encode($response);
}

exit;


