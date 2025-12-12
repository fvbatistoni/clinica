<?php
  require_once('dbconn.php');

   $ano  = trim($_GET["ano"]);
   $mes  = trim($_GET["mes"]);

  // Paciente VAGAS PREENCHIDAS sobre VAGAS TOTAIS
    $stmt = $dbconn->prepare("SELECT FORMAT(((select count(id) from agendas where year(data)=:ano and month(data)=:mes and nome_paciente is not null and hora_consulta is not null and hora_atendimento is NULL)/((select count(id) from agendas where year(data)=:ano and month(data)=:mes and nome_paciente is not null and hora_consulta is not null and hora_atendimento is NULL)+(select count(id) from agendas where year(data)=:ano and month(data)=:mes and nome_paciente is not null and hora_consulta is not null and hora_atendimento is not NULL))*100),1,'pt_BR') AS taxa;");
    $stmt->bindParam(':ano', $ano);
    $stmt->bindParam(':mes', $mes);
    $stmt->execute();
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    echo json_encode($data);
    $dbconn = null;
