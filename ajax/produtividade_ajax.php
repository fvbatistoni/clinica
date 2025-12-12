<?php
  require_once('dbconn.php');

   $ano  = trim($_GET["ano"]);

  // Conta quantas consultas por mês e separa por convênio -- REVISITA ESTA REQUISICAO
    $stmt = $dbconn->prepare("SELECT
                                AVG(CASE WHEN MONTH(data)= 1 THEN (select count(id) as contagem from agendas where year(data)=:ano and month(data)=1 and id_convenio is not null and hora_atendimento is not null and tipo=0)/((select count(distinct day(data)) from agendas where year(data)=:ano and month(data)=1)*8.5) END)AS jan,
                                AVG(CASE WHEN MONTH(data)= 2 THEN (select count(id) as contagem from agendas where year(data)=:ano and month(data)=2 and id_convenio is not null and hora_atendimento is not null and tipo=0)/((select count(distinct day(data)) from agendas where year(data)=:ano and month(data)=2)*8.5) END)AS fev,
                                AVG(CASE WHEN MONTH(data)= 3 THEN (select count(id) as contagem from agendas where year(data)=:ano and month(data)=3 and id_convenio is not null and hora_atendimento is not null and tipo=0)/((select count(distinct day(data)) from agendas where year(data)=:ano and month(data)=3)*8.5) END)AS mar,
                                AVG(CASE WHEN MONTH(data)= 4 THEN (select count(id) as contagem from agendas where year(data)=:ano and month(data)=4 and id_convenio is not null and hora_atendimento is not null and tipo=0)/((select count(distinct day(data)) from agendas where year(data)=:ano and month(data)=4)*8.5) END)AS abr,
                                AVG(CASE WHEN MONTH(data)= 5 THEN (select count(id) as contagem from agendas where year(data)=:ano and month(data)=5 and id_convenio is not null and hora_atendimento is not null and tipo=0)/((select count(distinct day(data)) from agendas where year(data)=:ano and month(data)=5)*8.5) END)AS mai,
                                AVG(CASE WHEN MONTH(data)= 6 THEN (select count(id) as contagem from agendas where year(data)=:ano and month(data)=6 and id_convenio is not null and hora_atendimento is not null and tipo=0)/((select count(distinct day(data)) from agendas where year(data)=:ano and month(data)=6)*8.5) END)AS jun,
                                AVG(CASE WHEN MONTH(data)= 7 THEN (select count(id) as contagem from agendas where year(data)=:ano and month(data)=7 and id_convenio is not null and hora_atendimento is not null and tipo=0)/((select count(distinct day(data)) from agendas where year(data)=:ano and month(data)=7)*8.5) END)AS jul,
                                AVG(CASE WHEN MONTH(data)= 8 THEN (select count(id) as contagem from agendas where year(data)=:ano and month(data)=8 and id_convenio is not null and hora_atendimento is not null and tipo=0)/((select count(distinct day(data)) from agendas where year(data)=:ano and month(data)=8)*8.5) END)AS ago,
                                AVG(CASE WHEN MONTH(data)= 9 THEN (select count(id) as contagem from agendas where year(data)=:ano and month(data)=9 and id_convenio is not null and hora_atendimento is not null and tipo=0)/((select count(distinct day(data)) from agendas where year(data)=:ano and month(data)=9)*8.5) END)AS 'set',
                                AVG(CASE WHEN MONTH(data)= 10 THEN (select count(id) as contagem from agendas where year(data)=:ano and month(data)=10 and id_convenio is not null and hora_atendimento is not null and tipo=0)/((select count(distinct day(data)) from agendas where year(data)=:ano and month(data)=10)*8.5) END)AS 'out',
                                AVG(CASE WHEN MONTH(data)= 11 THEN (select count(id) as contagem from agendas where year(data)=:ano and month(data)=11 and id_convenio is not null and hora_atendimento is not null and tipo=0)/((select count(distinct day(data)) from agendas where year(data)=:ano and month(data)=11)*8.5) END)AS nov,
                                AVG(CASE WHEN MONTH(data)= 12 THEN (select count(id) as contagem from agendas where year(data)=:ano and month(data)=12 and id_convenio is not null and hora_atendimento is not null and tipo=0)/((select count(distinct day(data)) from agendas where year(data)=:ano and month(data)=12)*8.5) END)AS dez
                            FROM agendas;");
    $stmt->bindParam(':ano', $ano);
    $stmt->execute();
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode($data);
    $dbconn = null;
