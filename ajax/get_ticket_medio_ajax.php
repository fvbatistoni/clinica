<?php
  require_once('dbconn.php');

   $ano  = trim($_GET["ano"]);

  // prepare sql and bind parameters
    $stmt = $dbconn->prepare("SELECT select1.credito,
            select2.debito,
            select3.atendimentos,
            format(((select1.credito - select2.debito)/select3.atendimentos),2,'pt_BR') AS ticket_medio
             
            FROM
            (select sum(valor) as credito
            from
            financeiro_movimentos where tipo = '1' and year(created)=:ano) select1,
            (select sum(valor) as debito
            from
            financeiro_movimentos where tipo = '0' and year(created)=:ano) select2,
            (select count(id) as atendimentos
            from
            agendas where nome_paciente is not null and hora_atendimento is not null and id_convenio is not null and year(data)=:ano) select3");
    $stmt->bindParam(':ano', $ano);
    // insert a row
    $stmt->execute();
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    echo json_encode($data);
    $dbconn = null;
