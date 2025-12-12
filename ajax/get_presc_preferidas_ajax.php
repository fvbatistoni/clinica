<?php
  require_once('dbconn.php');

  // Soma os valores separando por mês a partir da categoria RECEITA (tipo=1)
    $stmt = $dbconn->prepare("SELECT id,name,titulo,descricao
        FROM presc_preferidas");
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    for($x = 0; $x < count($data); $x++){
        $presc_preferidas[]= array(
            'id'=>$data[$x]['id'],
            'name'=>$data[$x]['name'],
            'title'=>$data[$x]['titulo'],
            'description'=>$data[$x]['descricao']
        );        
    }

    print json_encode($data, JSON_HEX_QUOT | JSON_HEX_TAG);
    $dbconn = null;

