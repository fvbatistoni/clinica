<?php
  require_once('dbconn.php');

   $ano  = trim($_GET["ano"]);

  // Conta quantas consultas por mês e separa por convênio -- REVISITA ESTA REQUISICAO
    $stmt = $dbconn->prepare("SELECT id_convenio,
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
                            WHERE YEAR(data)=:ano AND id_convenio is not null AND hora_atendimento is not null AND tipo=0
                            GROUP BY id_convenio");
    $stmt->bindParam(':ano', $ano);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo '<table style="padding: .25rem;" class="table-striped table-bordered" width="100%">';
        echo  '<thead>';
        echo  '    <tr>';
        echo  '      <th width="16%">Convênio</th>';
        echo  '      <th width="7%" style="text-align: right;">Jan</th>';
        echo  '      <th width="7%" style="text-align: right;">Fev</th>';
        echo  '      <th width="7%" style="text-align: right;">Mar</th>';
        echo  '      <th width="7%" style="text-align: right;">Abr</th>';
        echo  '      <th width="7%" style="text-align: right;">Mai</th>';
        echo  '      <th width="7%" style="text-align: right;">Jun</th>';
        echo  '      <th width="7%" style="text-align: right;">Jul</th>';
        echo  '      <th width="7%" style="text-align: right;">Ago</th>';
        echo  '      <th width="7%" style="text-align: right;">Set</th>';
        echo  '      <th width="7%" style="text-align: right;">Out</th>';
        echo  '      <th width="7%" style="text-align: right;">Nov</th>';
        echo  '      <th width="7%" style="text-align: right;">Dez</th>';
        echo  '    </tr>';
        echo  '  </thead>';
        echo  '  <tbody>';

        // Retorna os totais por mês -- PRECISA REVISAR ESTA REQUISIÇÃO
    $stmt2 = $dbconn->prepare("SELECT id_convenio,
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
                            WHERE YEAR(data)=:ano AND hora_atendimento is not null");
    $stmt2->bindParam(':ano', $ano);
    $stmt2->execute();
    $data2 = $stmt2->fetch(PDO::FETCH_ASSOC);        


  // Conta os RETORNOS ATENDIDOS por mês e separa por convênio -- REVISITA ESTA REQUISICAO
    $stmt4 = $dbconn->prepare("SELECT id_convenio,
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
                            WHERE YEAR(data)=:ano AND id_convenio is not null AND hora_atendimento is not null AND tipo=1");
    $stmt4->bindParam(':ano', $ano);
    $stmt4->execute();
    $retornos = $stmt4->fetch(PDO::FETCH_ASSOC);

            for($x=0;$x<count($data);$x++){
            $stmt3 = $dbconn->prepare("SELECT nome FROM convenios WHERE id=:cat");
            $stmt3->bindParam(':cat', $data[$x]['id_convenio']);
            $stmt3->execute();
            $convenio = $stmt3->fetch(PDO::FETCH_ASSOC);

            echo '<tr><td><b>'.$convenio['nome'].'</b></td>';
            echo '<td style="text-align: right;">'.$data[$x]['jan'].'</td>';
            echo '<td style="text-align: right;">'.$data[$x]['fev'].'</td>';
            echo '<td style="text-align: right;">'.$data[$x]['mar'].'</td>';
            echo '<td style="text-align: right;">'.$data[$x]['abr'].'</td>';
            echo '<td style="text-align: right;">'.$data[$x]['mai'].'</td>';
            echo '<td style="text-align: right;">'.$data[$x]['jun'].'</td>';
            echo '<td style="text-align: right;">'.$data[$x]['jul'].'</td>';
            echo '<td style="text-align: right;">'.$data[$x]['ago'].'</td>';
            echo '<td style="text-align: right;">'.$data[$x]['set'].'</td>';
            echo '<td style="text-align: right;">'.$data[$x]['out'].'</td>';
            echo '<td style="text-align: right;">'.$data[$x]['nov'].'</td>';
            echo '<td style="text-align: right;">'.$data[$x]['dez'].'</td>';
            echo '</tr>';
        }

        echo '<tr><td style="text-align: right;"><i>Retornos:</i></td>';
        echo '<td style="text-align: right;"><i>'.$retornos['jan'].'</i></td>';
        echo '<td style="text-align: right;"><i>'.$retornos['fev'].'</i></td>';
        echo '<td style="text-align: right;"><i>'.$retornos['mar'].'</i></td>';
        echo '<td style="text-align: right;"><i>'.$retornos['abr'].'</i></td>';
        echo '<td style="text-align: right;"><i>'.$retornos['mai'].'</i></td>';
        echo '<td style="text-align: right;"><i>'.$retornos['jun'].'</i></td>';
        echo '<td style="text-align: right;"><i>'.$retornos['jul'].'</i></td>';
        echo '<td style="text-align: right;"><i>'.$retornos['ago'].'</i></td>';
        echo '<td style="text-align: right;"><i>'.$retornos['set'].'</i></td>';
        echo '<td style="text-align: right;"><i>'.$retornos['out'].'</i></td>';
        echo '<td style="text-align: right;"><i>'.$retornos['nov'].'</i></td>';
        echo '<td style="text-align: right;"><i>'.$retornos['dez'].'</i></td></tr>';

        echo '<tr><td style="text-align: right;"><b>TOTAL:</b></td>';
        echo '<td style="text-align: right;"><b>'.$data2['jan'].'</b></td>';
        echo '<td style="text-align: right;"><b>'.$data2['fev'].'</b></td>';
        echo '<td style="text-align: right;"><b>'.$data2['mar'].'</b></td>';
        echo '<td style="text-align: right;"><b>'.$data2['abr'].'</b></td>';
        echo '<td style="text-align: right;"><b>'.$data2['mai'].'</b></td>';
        echo '<td style="text-align: right;"><b>'.$data2['jun'].'</b></td>';
        echo '<td style="text-align: right;"><b>'.$data2['jul'].'</b></td>';
        echo '<td style="text-align: right;"><b>'.$data2['ago'].'</b></td>';
        echo '<td style="text-align: right;"><b>'.$data2['set'].'</b></td>';
        echo '<td style="text-align: right;"><b>'.$data2['out'].'</b></td>';
        echo '<td style="text-align: right;"><b>'.$data2['nov'].'</b></td>';
        echo '<td style="text-align: right;"><b>'.$data2['dez'].'</b></td></tr>';

        echo '  </tbody>';
        echo '</table>';

    $dbconn = null;

