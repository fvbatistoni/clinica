<?php

  require_once('dbconn.php');



if(isset($_POST['search'])){

    $search = $_POST['search'];



    $stmt = $dbconn->prepare("SELECT pagador, cpf

        FROM recibos

        WHERE pagador like'%".$search."%' GROUP BY pagador");

    $stmt->execute();

    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    

	foreach ($data as $linha) {

	   $response[] = array("label"=>$linha['pagador'],
        "cpf"=>$linha['cpf']);

	}    



    echo json_encode($response);

}



exit;





