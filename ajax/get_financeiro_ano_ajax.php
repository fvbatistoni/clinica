<?php
  require_once('dbconn.php');

   $ano  = trim($_GET["ano"]);

  // Soma os valores separando por mês a partir da categoria RECEITA (tipo=1)
    $stmt = $dbconn->prepare("SELECT categoria,
        SUM(CASE WHEN MONTH(created)= 1 THEN valor END)AS jan,
        SUM(CASE WHEN MONTH(created)= 2 THEN valor END)AS fev,
        SUM(CASE WHEN MONTH(created)= 3 THEN valor END)AS mar,
        SUM(CASE WHEN MONTH(created)= 4 THEN valor END)AS abr,
        SUM(CASE WHEN MONTH(created)= 5 THEN valor END)AS mai,
        SUM(CASE WHEN MONTH(created)= 6 THEN valor END)AS jun,
        SUM(CASE WHEN MONTH(created)= 7 THEN valor END)AS jul,
        SUM(CASE WHEN MONTH(created)= 8 THEN valor END)AS ago,
        SUM(CASE WHEN MONTH(created)= 9 THEN valor END)AS 'set',
        SUM(CASE WHEN MONTH(created)= 10 THEN valor END)AS 'out',
        SUM(CASE WHEN MONTH(created)= 11 THEN valor END)AS nov,
        SUM(CASE WHEN MONTH(created)= 12 THEN valor END)AS dez
        FROM financeiro_movimentos
        WHERE YEAR(created)=:ano
        GROUP BY categoria");
    $stmt->bindParam(':ano', $ano);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($data);
    $dbconn = null;