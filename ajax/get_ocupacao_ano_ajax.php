<?php
  require_once('dbconn.php');

   $ano  = trim($_GET["ano"]);


  // Paciente não AGENDOU
    $stmt = $dbconn->prepare("SELECT
                            COUNT(CASE WHEN MONTH(data)= 01 THEN id END)AS jan,
                            COUNT(CASE WHEN MONTH(data)= 02 THEN id END)AS fev,
                            COUNT(CASE WHEN MONTH(data)= 03 THEN id END)AS mar,
                            COUNT(CASE WHEN MONTH(data)= 04 THEN id END)AS abr,
                            COUNT(CASE WHEN MONTH(data)= 05 THEN id END)AS mai,
                            COUNT(CASE WHEN MONTH(data)= 06 THEN id END)AS jun,
                            COUNT(CASE WHEN MONTH(data)= 07 THEN id END)AS jul,
                            COUNT(CASE WHEN MONTH(data)= 08 THEN id END)AS ago,
                            COUNT(CASE WHEN MONTH(data)= 09 THEN id END)AS 'set',
                            COUNT(CASE WHEN MONTH(data)= 10 THEN id END)AS 'out',
                            COUNT(CASE WHEN MONTH(data)= 11 THEN id END)AS nov,
                            COUNT(CASE WHEN MONTH(data)= 12 THEN id END)AS dez
                            FROM agendas
                            WHERE YEAR(data)=:ano AND nome_paciente is null");
    $stmt->bindParam(':ano', $ano);
    $stmt->execute();
    $nao_ocup = $stmt->fetch(PDO::FETCH_ASSOC);

// Paciente AGENDOU
    $stmt2 = $dbconn->prepare("SELECT
                            COUNT(CASE WHEN MONTH(data)= 1 THEN id END)AS jan,
                            COUNT(CASE WHEN MONTH(data)= 2 THEN id END)AS fev,
                            COUNT(CASE WHEN MONTH(data)= 3 THEN id END)AS mar,
                            COUNT(CASE WHEN MONTH(data)= 4 THEN id END)AS abr,
                            COUNT(CASE WHEN MONTH(data)= 5 THEN id END)AS mai,
                            COUNT(CASE WHEN MONTH(data)= 6 THEN id END)AS jun,
                            COUNT(CASE WHEN MONTH(data)= 7 THEN id END)AS jul,
                            COUNT(CASE WHEN MONTH(data)= 8 THEN id END)AS ago,
                            COUNT(CASE WHEN MONTH(data)= 9 THEN id END)AS 'set',
                            COUNT(CASE WHEN MONTH(data)= 10 THEN id END)AS 'out',
                            COUNT(CASE WHEN MONTH(data)= 11 THEN id END)AS nov,
                            COUNT(CASE WHEN MONTH(data)= 12 THEN id END)AS dez
                            FROM agendas
                            WHERE YEAR(data)=:ano AND nome_paciente is not null");
    $stmt2->bindParam(':ano', $ano);
    $stmt2->execute();
    $ocupacao = $stmt2->fetch(PDO::FETCH_ASSOC);


    $data = array(
        'jan'=>($ocupacao['jan']+$nao_ocup['jan'])==0?null:($ocupacao['jan']/($ocupacao['jan']+$nao_ocup['jan']))*100,
        'fev'=>($ocupacao['fev']+$nao_ocup['fev'])==0?null:($ocupacao['fev']/($ocupacao['fev']+$nao_ocup['fev']))*100,
        'mar'=>($ocupacao['mar']+$nao_ocup['mar'])==0?null:($ocupacao['mar']/($ocupacao['mar']+$nao_ocup['mar']))*100,
        'abr'=>($ocupacao['abr']+$nao_ocup['abr'])==0?null:($ocupacao['abr']/($ocupacao['abr']+$nao_ocup['abr']))*100,
        'mai'=>($ocupacao['mai']+$nao_ocup['mai'])==0?null:($ocupacao['mai']/($ocupacao['mai']+$nao_ocup['mai']))*100,
        'jun'=>($ocupacao['jun']+$nao_ocup['jun'])==0?null:($ocupacao['jun']/($ocupacao['jun']+$nao_ocup['jun']))*100,
        'jul'=>($ocupacao['jul']+$nao_ocup['jul'])==0?null:($ocupacao['jul']/($ocupacao['jul']+$nao_ocup['jul']))*100,
        'ago'=>($ocupacao['ago']+$nao_ocup['ago'])==0?null:($ocupacao['ago']/($ocupacao['ago']+$nao_ocup['ago']))*100,
        'set'=>($ocupacao['set']+$nao_ocup['set'])==0?null:($ocupacao['set']/($ocupacao['set']+$nao_ocup['set']))*100,
        'out'=>($ocupacao['out']+$nao_ocup['out'])==0?null:($ocupacao['out']/($ocupacao['out']+$nao_ocup['out']))*100,
        'nov'=>($ocupacao['nov']+$nao_ocup['nov'])==0?null:($ocupacao['nov']/($ocupacao['nov']+$nao_ocup['nov']))*100,
        'dez'=>($ocupacao['dez']+$nao_ocup['dez'])==0?null:($ocupacao['dez']/($ocupacao['dez']+$nao_ocup['dez']))*100
    );


    echo json_encode($data);
    $dbconn = null;
