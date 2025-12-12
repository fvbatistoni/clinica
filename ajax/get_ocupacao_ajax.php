<?php
  require_once('dbconn.php');

    // Esta programação não vai gerar um jSON para o charts... vai gerar uma <table>
    // Se quiser gerar o jSON vai precisar terminar diferente ou fazer outra requisição

   $ano  = trim($_GET["ano"]);

  // Paciente AGENDOU (ocupação)
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
                            WHERE YEAR(data)=:ano AND nome_paciente is not null");
    $stmt->bindParam(':ano', $ano);
    $stmt->execute();
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

  // Paciente não AGENDOU (não-ocupação)
    $stmt2 = $dbconn->prepare("SELECT
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
    $stmt2->bindParam(':ano', $ano);
    $stmt2->execute();
    $data2 = $stmt2->fetch(PDO::FETCH_ASSOC);


echo '<table style="padding: .25rem;" class="table-striped table-bordered" width="100%">';
echo  '<thead>';
echo  '    <tr>';
echo  '      <th width="7%" style="text-align: center;">Jan</th>';
echo  '      <th width="7%" style="text-align: center;">Fev</th>';
echo  '      <th width="7%" style="text-align: center;">Mar</th>';
echo  '      <th width="7%" style="text-align: center;">Abr</th>';
echo  '      <th width="7%" style="text-align: center;">Mai</th>';
echo  '      <th width="7%" style="text-align: center;">Jun</th>';
echo  '      <th width="7%" style="text-align: center;">Jul</th>';
echo  '      <th width="7%" style="text-align: center;">Ago</th>';
echo  '      <th width="7%" style="text-align: center;">Set</th>';
echo  '      <th width="7%" style="text-align: center;">Out</th>';
echo  '      <th width="7%" style="text-align: center;">Nov</th>';
echo  '      <th width="7%" style="text-align: center;">Dez</th>';
echo  '    </tr>';
echo  '  </thead>';
echo  '  <tbody>';
echo '<td style="text-align: right;">'.number_format(($data['jan']/(($data['jan']+$data2['jan'])==0?1:($data['jan']+$data2['jan'])))*(100), 2, ',', ' ').'%</td>';
echo '<td style="text-align: right;">'.number_format(($data['fev']/(($data['fev']+$data2['fev'])==0?1:($data['fev']+$data2['fev'])))*(100), 2, ',', ' ').'%</td>';
echo '<td style="text-align: right;">'.number_format(($data['mar']/(($data['mar']+$data2['mar'])==0?1:($data['mar']+$data2['mar'])))*(100), 2, ',', ' ').'%</td>';
echo '<td style="text-align: right;">'.number_format(($data['abr']/(($data['abr']+$data2['abr'])==0?1:($data['abr']+$data2['abr'])))*(100), 2, ',', ' ').'%</td>';
echo '<td style="text-align: right;">'.number_format(($data['mai']/(($data['mai']+$data2['mai'])==0?1:($data['mai']+$data2['mai'])))*(100), 2, ',', ' ').'%</td>';
echo '<td style="text-align: right;">'.number_format(($data['jun']/(($data['jun']+$data2['jun'])==0?1:($data['jun']+$data2['jun'])))*(100), 2, ',', ' ').'%</td>';
echo '<td style="text-align: right;">'.number_format(($data['jul']/(($data['jul']+$data2['jul'])==0?1:($data['jul']+$data2['jul'])))*(100), 2, ',', ' ').'%</td>';
echo '<td style="text-align: right;">'.number_format(($data['ago']/(($data['ago']+$data2['ago'])==0?1:($data['ago']+$data2['ago'])))*(100), 2, ',', ' ').'%</td>';
echo '<td style="text-align: right;">'.number_format(($data['set']/(($data['set']+$data2['set'])==0?1:($data['set']+$data2['set'])))*(100), 2, ',', ' ').'%</td>';
echo '<td style="text-align: right;">'.number_format(($data['out']/(($data['out']+$data2['out'])==0?1:($data['out']+$data2['out'])))*(100), 2, ',', ' ').'%</td>';
echo '<td style="text-align: right;">'.number_format(($data['nov']/(($data['nov']+$data2['nov'])==0?1:($data['nov']+$data2['nov'])))*(100), 2, ',', ' ').'%</td>';
echo '<td style="text-align: right;">'.number_format(($data['dez']/(($data['dez']+$data2['dez'])==0?1:($data['dez']+$data2['dez'])))*(100), 2, ',', ' ').'%</td>';
echo '</tr>';
echo '  </tbody>';
echo '</table>';

    $dbconn = null;
