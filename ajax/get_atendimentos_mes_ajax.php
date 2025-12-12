<?php
  require_once('dbconn.php');

   $ano  = trim($_GET["ano"]);
   $mes  = trim($_GET["mes"]);

  // Paciente AGENDOU, e FALTOU
    $stmt = $dbconn->prepare("SELECT count(id) as atendimentos 
                            FROM agendas
                            WHERE YEAR(data)=:ano AND MONTH(data)=:mes AND nome_paciente is not null AND hora_consulta is not null AND hora_atendimento is not null");
    $stmt->bindParam(':ano', $ano);
    $stmt->bindParam(':mes', $mes);
    $stmt->execute();
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    echo json_encode($data);
    $dbconn = null;
