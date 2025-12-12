<?php
  require_once('dbconn.php');

   $ano  = trim($_GET["ano"]);


  // Paciente AGENDOU, e FALTOU
    $stmt = $dbconn->prepare("SELECT
                            COUNT(CASE WHEN MONTH(data)= 1 THEN id END)AS faltas_jan,
                            COUNT(CASE WHEN MONTH(data)= 2 THEN id END)AS faltas_fev,
                            COUNT(CASE WHEN MONTH(data)= 3 THEN id END)AS faltas_mar,
                            COUNT(CASE WHEN MONTH(data)= 4 THEN id END)AS faltas_abr,
                            COUNT(CASE WHEN MONTH(data)= 5 THEN id END)AS faltas_mai,
                            COUNT(CASE WHEN MONTH(data)= 6 THEN id END)AS faltas_jun,
                            COUNT(CASE WHEN MONTH(data)= 7 THEN id END)AS faltas_jul,
                            COUNT(CASE WHEN MONTH(data)= 8 THEN id END)AS faltas_ago,
                            COUNT(CASE WHEN MONTH(data)= 9 THEN id END)AS faltas_set,
                            COUNT(CASE WHEN MONTH(data)= 10 THEN id END)AS faltas_out,
                            COUNT(CASE WHEN MONTH(data)= 11 THEN id END)AS faltas_nov,
                            COUNT(CASE WHEN MONTH(data)= 12 THEN id END)AS faltas_dez
                            FROM agendas
                            WHERE YEAR(data)=:ano AND nome_paciente is not null AND hora_consulta is not null AND hora_atendimento is null");
    $stmt->bindParam(':ano', $ano);
    $stmt->execute();
    $faltas = $stmt->fetch(PDO::FETCH_ASSOC);

    $stmt2 = $dbconn->prepare("SELECT
                            COUNT(CASE WHEN MONTH(data)= 1 THEN id END)AS ocup_jan,
                            COUNT(CASE WHEN MONTH(data)= 2 THEN id END)AS ocup_fev,
                            COUNT(CASE WHEN MONTH(data)= 3 THEN id END)AS ocup_mar,
                            COUNT(CASE WHEN MONTH(data)= 4 THEN id END)AS ocup_abr,
                            COUNT(CASE WHEN MONTH(data)= 5 THEN id END)AS ocup_mai,
                            COUNT(CASE WHEN MONTH(data)= 6 THEN id END)AS ocup_jun,
                            COUNT(CASE WHEN MONTH(data)= 7 THEN id END)AS ocup_jul,
                            COUNT(CASE WHEN MONTH(data)= 8 THEN id END)AS ocup_ago,
                            COUNT(CASE WHEN MONTH(data)= 9 THEN id END)AS ocup_set,
                            COUNT(CASE WHEN MONTH(data)= 10 THEN id END)AS ocup_out,
                            COUNT(CASE WHEN MONTH(data)= 11 THEN id END)AS ocup_nov,
                            COUNT(CASE WHEN MONTH(data)= 12 THEN id END)AS ocup_dez
                            FROM agendas
                            WHERE YEAR(data)=:ano AND nome_paciente is not null");
    $stmt2->bindParam(':ano', $ano);
    $stmt2->execute();
    $ocupacao = $stmt2->fetch(PDO::FETCH_ASSOC);


    $data = array(
        'jan'=>($ocupacao['ocup_jan'])==0?null:($faltas['faltas_jan']/$ocupacao['ocup_jan'])*100,
        'fev'=>($ocupacao['ocup_fev'])==0?null:($faltas['faltas_fev']/$ocupacao['ocup_fev'])*100,
        'mar'=>($ocupacao['ocup_mar'])==0?null:($faltas['faltas_mar']/$ocupacao['ocup_mar'])*100,
        'abr'=>($ocupacao['ocup_abr'])==0?null:($faltas['faltas_abr']/$ocupacao['ocup_abr'])*100,
        'mai'=>($ocupacao['ocup_mai'])==0?null:($faltas['faltas_mai']/$ocupacao['ocup_mai'])*100,
        'jun'=>($ocupacao['ocup_jun'])==0?null:($faltas['faltas_jun']/$ocupacao['ocup_jun'])*100,
        'jul'=>($ocupacao['ocup_jul'])==0?null:($faltas['faltas_jul']/$ocupacao['ocup_jul'])*100,
        'ago'=>($ocupacao['ocup_ago'])==0?null:($faltas['faltas_ago']/$ocupacao['ocup_ago'])*100,
        'set'=>($ocupacao['ocup_set'])==0?null:($faltas['faltas_set']/$ocupacao['ocup_set'])*100,
        'out'=>($ocupacao['ocup_out'])==0?null:($faltas['faltas_out']/$ocupacao['ocup_out'])*100,
        'nov'=>($ocupacao['ocup_nov'])==0?null:($faltas['faltas_nov']/$ocupacao['ocup_nov'])*100,
        'dez'=>($ocupacao['ocup_dez'])==0?null:($faltas['faltas_dez']/$ocupacao['ocup_dez'])*100
    );


    echo json_encode($data);
    $dbconn = null;
