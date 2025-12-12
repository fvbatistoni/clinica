<?php
  require_once('dbconn.php');

   $ano  = trim($_GET["ano"]);

  // prepare sql and bind parameters
    $stmt = $dbconn->prepare("SELECT
                            AVG(CASE WHEN MONTH(data)= 1 THEN pontualidade/60 END)AS jan,
                            AVG(CASE WHEN MONTH(data)= 2 THEN pontualidade/60 END)AS fev,
                            AVG(CASE WHEN MONTH(data)= 3 THEN pontualidade/60 END)AS mar,
                            AVG(CASE WHEN MONTH(data)= 4 THEN pontualidade/60 END)AS abr,
                            AVG(CASE WHEN MONTH(data)= 5 THEN pontualidade/60 END)AS mai,
                            AVG(CASE WHEN MONTH(data)= 6 THEN pontualidade/60 END)AS jun,
                            AVG(CASE WHEN MONTH(data)= 7 THEN pontualidade/60 END)AS jul,
                            AVG(CASE WHEN MONTH(data)= 8 THEN pontualidade/60 END)AS ago,
                            AVG(CASE WHEN MONTH(data)= 9 THEN pontualidade/60 END)AS 'set',
                            AVG(CASE WHEN MONTH(data)= 10 THEN pontualidade/60 END)AS 'out',
                            AVG(CASE WHEN MONTH(data)= 11 THEN pontualidade/60 END)AS nov,
                            AVG(CASE WHEN MONTH(data)= 12 THEN pontualidade/60 END)AS dez
                            FROM agendas
                            WHERE YEAR(data)=:ano AND pontualidade is not null");
    $stmt->bindParam(':ano', $ano);
    // insert a row
    $stmt->execute();
    $pontualidade = $stmt->fetch(PDO::FETCH_ASSOC);

    $data = array(
        'jan'=>$pontualidade['jan'] ==null?null:number_format($pontualidade['jan'],2),
        'fev'=>$pontualidade['fev'] ==null?null:number_format($pontualidade['fev'],2),
        'mar'=>$pontualidade['mar'] ==null?null:number_format($pontualidade['mar'],2),
        'abr'=>$pontualidade['abr'] ==null?null:number_format($pontualidade['abr'],2),
        'mai'=>$pontualidade['mai'] ==null?null:number_format($pontualidade['mai'],2),
        'jun'=>$pontualidade['jun'] ==null?null:number_format($pontualidade['jun'],2),
        'jul'=>$pontualidade['jul'] ==null?null:number_format($pontualidade['jul'],2),
        'ago'=>$pontualidade['ago'] ==null?null:number_format($pontualidade['ago'],2),
        'set'=>$pontualidade['set'] ==null?null:number_format($pontualidade['set'],2),
        'out'=>$pontualidade['out'] ==null?null:number_format($pontualidade['out'],2),
        'nov'=>$pontualidade['nov'] ==null?null:number_format($pontualidade['nov'],2),
        'dez'=>$pontualidade['dez'] ==null?null:number_format($pontualidade['dez'],2)
    );
    echo json_encode($data);
    $dbconn = null;
