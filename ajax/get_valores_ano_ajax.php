<?php
  require_once('dbconn.php');

   $ano  = trim($_GET["ano"]);

  // Soma os valores separando por mês a partir da categoria RECEITA (tipo=1)
    $stmt = $dbconn->prepare("SELECT categoria,
        SUM(CASE WHEN MONTH(data_recebimento)= 1 THEN valor END)AS jan,
        SUM(CASE WHEN MONTH(data_recebimento)= 2 THEN valor END)AS fev,
        SUM(CASE WHEN MONTH(data_recebimento)= 3 THEN valor END)AS mar,
        SUM(CASE WHEN MONTH(data_recebimento)= 4 THEN valor END)AS abr,
        SUM(CASE WHEN MONTH(data_recebimento)= 5 THEN valor END)AS mai,
        SUM(CASE WHEN MONTH(data_recebimento)= 6 THEN valor END)AS jun,
        SUM(CASE WHEN MONTH(data_recebimento)= 7 THEN valor END)AS jul,
        SUM(CASE WHEN MONTH(data_recebimento)= 8 THEN valor END)AS ago,
        SUM(CASE WHEN MONTH(data_recebimento)= 9 THEN valor END)AS 'set',
        SUM(CASE WHEN MONTH(data_recebimento)= 10 THEN valor END)AS 'out',
        SUM(CASE WHEN MONTH(data_recebimento)= 11 THEN valor END)AS nov,
        SUM(CASE WHEN MONTH(data_recebimento)= 12 THEN valor END)AS dez
        FROM financeiro_movimentos
        WHERE YEAR(data_recebimento)=:ano AND tipo=1
        GROUP BY categoria");
    $stmt->bindParam(':ano', $ano);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo '<table class="table-striped table-bordered" width="100%">';
        echo  '<thead>';
        echo  '    <tr>';
        echo  '      <th width="16%"></th>';
        echo  '      <th style="text-align:center;font-size: small;">Janeiro</th>';
        echo  '      <th style="text-align:center;font-size: small;">Fevereiro</th>';
        echo  '      <th style="text-align:center;font-size: small;">Março</th>';
        echo  '      <th style="text-align:center;font-size: small;">Abril</th>';
        echo  '      <th style="text-align:center;font-size: small;">Maio</th>';
        echo  '      <th style="text-align:center;font-size: small;">Junho</th>';
        echo  '      <th style="text-align:center;font-size: small;">Julho</th>';
        echo  '      <th style="text-align:center;font-size: small;">Agosto</th>';
        echo  '      <th style="text-align:center;font-size: small;">Setembro</th>';
        echo  '      <th style="text-align:center;font-size: small;">Outubro</th>';
        echo  '      <th style="text-align:center;font-size: small;">Novembro</th>';
        echo  '      <th style="text-align:center;font-size: small;">Dezembro</th>';
        echo  '    </tr>';
        echo  '  </thead>';
        echo  '  <tbody>';

    $stmt2 = $dbconn->prepare("SELECT categoria,
        SUM(CASE WHEN MONTH(data_recebimento)= 1 THEN valor END)AS jan,
        SUM(CASE WHEN MONTH(data_recebimento)= 2 THEN valor END)AS fev,
        SUM(CASE WHEN MONTH(data_recebimento)= 3 THEN valor END)AS mar,
        SUM(CASE WHEN MONTH(data_recebimento)= 4 THEN valor END)AS abr,
        SUM(CASE WHEN MONTH(data_recebimento)= 5 THEN valor END)AS mai,
        SUM(CASE WHEN MONTH(data_recebimento)= 6 THEN valor END)AS jun,
        SUM(CASE WHEN MONTH(data_recebimento)= 7 THEN valor END)AS jul,
        SUM(CASE WHEN MONTH(data_recebimento)= 8 THEN valor END)AS ago,
        SUM(CASE WHEN MONTH(data_recebimento)= 9 THEN valor END)AS 'set',
        SUM(CASE WHEN MONTH(data_recebimento)= 10 THEN valor END)AS 'out',
        SUM(CASE WHEN MONTH(data_recebimento)= 11 THEN valor END)AS nov,
        SUM(CASE WHEN MONTH(data_recebimento)= 12 THEN valor END)AS dez
        FROM financeiro_movimentos
        WHERE YEAR(data_recebimento)=:ano AND tipo=1");
    $stmt2->bindParam(':ano', $ano);
    $stmt2->execute();
    $data2 = $stmt2->fetch(PDO::FETCH_ASSOC);


        for($x=0;$x<count($data);$x++){
            $stmt3 = $dbconn->prepare("SELECT nome FROM financeiro_cats WHERE id=:cat");
            $stmt3->bindParam(':cat', $data[$x]['categoria']);
            $stmt3->execute();
            $convenio = $stmt3->fetch(PDO::FETCH_ASSOC);

            echo '<tr><td style="font-size: small;"><b>'.$convenio['nome'].'</b></td>';
            echo '<td style="text-align: right;font-size: small;">'.number_format($data[$x]['jan'], 2, ',', '.').'</td>';
            echo '<td style="text-align: right;font-size: small;">'.number_format($data[$x]['fev'], 2, ',', '.').'</td>';
            echo '<td style="text-align: right;font-size: small;">'.number_format($data[$x]['mar'], 2, ',', '.').'</td>';
            echo '<td style="text-align: right;font-size: small;">'.number_format($data[$x]['abr'], 2, ',', '.').'</td>';
            echo '<td style="text-align: right;font-size: small;">'.number_format($data[$x]['mai'], 2, ',', '.').'</td>';
            echo '<td style="text-align: right;font-size: small;">'.number_format($data[$x]['jun'], 2, ',', '.').'</td>';
            echo '<td style="text-align: right;font-size: small;">'.number_format($data[$x]['jul'], 2, ',', '.').'</td>';
            echo '<td style="text-align: right;font-size: small;">'.number_format($data[$x]['ago'], 2, ',', '.').'</td>';
            echo '<td style="text-align: right;font-size: small;">'.number_format($data[$x]['set'], 2, ',', '.').'</td>';
            echo '<td style="text-align: right;font-size: small;">'.number_format($data[$x]['out'], 2, ',', '.').'</td>';
            echo '<td style="text-align: right;font-size: small;">'.number_format($data[$x]['nov'], 2, ',', '.').'</td>';
            echo '<td style="text-align: right;font-size: small;">'.number_format($data[$x]['dez'], 2, ',', '.').'</td>';
            echo '</tr>';
        }

        echo '<tr><td style="text-align: right;font-size: small;">TOTAL &rarr;</td>';
        echo '<td style="text-align: right;font-size: small;"><b>'.number_format($data2['jan'], 2, ',', '.').'</b></td>';
        echo '<td style="text-align: right;font-size: small;"><b>'.number_format($data2['fev'], 2, ',', '.').'</b></td>';
        echo '<td style="text-align: right;font-size: small;"><b>'.number_format($data2['mar'], 2, ',', '.').'</b></td>';
        echo '<td style="text-align: right;font-size: small;"><b>'.number_format($data2['abr'], 2, ',', '.').'</b></td>';
        echo '<td style="text-align: right;font-size: small;"><b>'.number_format($data2['mai'], 2, ',', '.').'</b></td>';
        echo '<td style="text-align: right;font-size: small;"><b>'.number_format($data2['jun'], 2, ',', '.').'</b></td>';
        echo '<td style="text-align: right;font-size: small;"><b>'.number_format($data2['jul'], 2, ',', '.').'</b></td>';
        echo '<td style="text-align: right;font-size: small;"><b>'.number_format($data2['ago'], 2, ',', '.').'</b></td>';
        echo '<td style="text-align: right;font-size: small;"><b>'.number_format($data2['set'], 2, ',', '.').'</b></td>';
        echo '<td style="text-align: right;font-size: small;"><b>'.number_format($data2['out'], 2, ',', '.').'</b></td>';
        echo '<td style="text-align: right;font-size: small;"><b>'.number_format($data2['nov'], 2, ',', '.').'</b></td>';
        echo '<td style="text-align: right;font-size: small;"><b>'.number_format($data2['dez'], 2, ',', '.').'</b></td>';

        echo '  </tbody>';
        echo '</table>';

    $dbconn = null;

