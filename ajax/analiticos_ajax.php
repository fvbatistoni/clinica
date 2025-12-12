<?php
  require_once('dbconn.php');

   $ano  = trim($_GET["ano"]);
   $mes  = trim($_GET["mes"]);
   $date = $ano.'-'.$mes.'-01';

  // Conta quantas consultas por mês e separa por convênio -- REVISITA ESTA REQUISICAO
    $stmt = $dbconn->prepare("SELECT id_convenio, count(id) as contagem, sum(valor_pago) as repasse, min(data_atendimento) as min, max(data_atendimento) as max from analiticos WHERE MONTH(data_pagamento)=MONTH(:date) and YEAR(data_pagamento)=YEAR(:date) GROUP BY id_convenio");
    $stmt->bindParam(':date', $date);
    $stmt->execute();
    $alcancado = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt2 = $dbconn->prepare("SELECT 
    	(select count(id) as bradesco1 from agendas where year(data)=YEAR(DATE_SUB(:date,INTERVAL 2 MONTH)) and month(data)=MONTH(DATE_SUB(:date,INTERVAL 2 MONTH)) and day(data)<16 and id_convenio=5 and hora_atendimento is not null and tipo=0)as bra1, 
    	(select count(id) as bradesco2 from agendas where year(data)=YEAR(DATE_SUB(:date,INTERVAL 3 MONTH)) and month(data)=MONTH(DATE_SUB(:date,INTERVAL 3 MONTH)) and day(data)>15 and id_convenio=5 and hora_atendimento is not null and tipo=0)as bra2, 
    	(select count(id) as geap from agendas where year(data)=YEAR(DATE_SUB(:date,INTERVAL 5 MONTH)) and month(data)=MONTH(DATE_SUB(:date,INTERVAL 5 MONTH)) and id_convenio=12 and hora_atendimento is not null and tipo=0)as geap, 
    	(select count(id) as mediservice from agendas where year(data)=YEAR(DATE_SUB(:date,INTERVAL 4 MONTH)) and month(data)=MONTH(DATE_SUB(:date,INTERVAL 4 MONTH)) and id_convenio=17 and hora_atendimento is not null and tipo=0)as mediservice, 
    	(select count(id) as proasa from agendas where year(data)=YEAR(DATE_SUB(:date,INTERVAL 4 MONTH)) and month(data)=MONTH(DATE_SUB(:date,INTERVAL 4 MONTH)) and id_convenio=22 and hora_atendimento is not null and tipo=0)as proasa, 
    	(select count(id) as proasa from agendas where year(data)=YEAR(DATE_SUB(:date,INTERVAL 2 MONTH)) and month(data)=MONTH(DATE_SUB(:date,INTERVAL 2 MONTH)) and id_convenio=14 and hora_atendimento is not null and tipo=0)as green, 
    	(select count(id) as proasa from agendas where year(data)=YEAR(DATE_SUB(:date,INTERVAL 5 MONTH)) and month(data)=MONTH(DATE_SUB(:date,INTERVAL 5 MONTH)) and id_convenio=6 and hora_atendimento is not null and tipo=0)as caixa,
    	(select count(id) as proasa from agendas where year(data)=YEAR(DATE_SUB(:date,INTERVAL 5 MONTH)) and month(data)=MONTH(DATE_SUB(:date,INTERVAL 5 MONTH)) and id_convenio=29 and hora_atendimento is not null and tipo=0)as medisanitas,
    	(select count(id) as proasa from agendas where year(data)=YEAR(DATE_SUB(:date,INTERVAL 5 MONTH)) and month(data)=MONTH(DATE_SUB(:date,INTERVAL 5 MONTH)) and id_convenio=18 and hora_atendimento is not null and tipo=0)as notredame,
    	(select count(id) as proasa from agendas where year(data)=YEAR(DATE_SUB(:date,INTERVAL 5 MONTH)) and month(data)=MONTH(DATE_SUB(:date,INTERVAL 5 MONTH)) and id_convenio=11 and hora_atendimento is not null and tipo=0)as gama");
    $stmt2->bindParam(':date', $date);
    $stmt2->execute();
    $projetado = $stmt2->fetchAll(PDO::FETCH_ASSOC);

    echo '<table class="table table-hover"><thead><tr><th>Convênio</th><th style="text-align:center;">Previsto</th><th style="text-align:center;">Pago</th><th style="text-align:center;">Valor</th><th style="text-align:center;">Período Pago</th></tr></thead><tbody>';
    for($x=0;$x<count($alcancado);$x++){

				switch ($alcancado[$x]['id_convenio']) {
				    case 2:
				        echo '<tr><td>Amil</td>';
				        break;
				    case 5:
				        echo '<tr><td>Bradesco</td>';
				        break;
				    case 6:
				        echo '<tr><td>Saúde Caixa</td>';
				        break;
				    case 8:
				        echo '<tr><td>E & E</td>';
				        break;
				    case 11:
				        echo '<tr><td>Gama</td>';
				        break;
				    case 12:
				        echo '<tr><td>GEAP</td>';
				        break;
				    case 14:
				        echo '<tr><td>Gren Life</td>';
				        break;
				    case 17:
				        echo '<tr><td>Mediservice</td>';
				        break;
				    case 18:
				        echo '<tr><td>Notre Dame</td>';
				        break;
				    case 22:
				        echo '<tr><td>Proasa</td>';
				        break;
				    case 29:
				        echo '<tr><td>Medisanitas</td>';
				        break;
				}

				switch ($alcancado[$x]['id_convenio']) {
				    case 2:
				        echo '<td></td>';
				        break;
				    case 5:
				        echo '<td style="padding:0.3rem"><table class="table table-sm" style="margin-bottom: 0rem;" width="100%"><tr><td>'.$projetado[0]['bra2'].'</td><td>'.$projetado[0]['bra1'].'</td></tr><tr><td style="font-size:x-small">'.date("m/Y", strtotime("-3 months", strtotime($date))).'</td><td style="font-size:x-small">'.date("m/Y", strtotime("-2 months", strtotime($date))).'</td></tr></table></td>';
				        break;
				    case 6:
				        echo '<td style="padding:0.3rem"><table class="table table-sm" style="margin-bottom: 0rem;" width="100%"><tr><td>'.$projetado[0]['caixa'].'</td></tr><tr><td style="font-size:x-small">'.date("m/Y", strtotime("-5 months", strtotime($date))).'</td></tr></table></td>';
				        break;
				    case 11:
				        echo '<td style="padding:0.3rem"><table class="table table-sm" style="margin-bottom: 0rem;" width="100%"><tr><td>'.$projetado[0]['gama'].'</td></tr><tr><td style="font-size:x-small">'.date("m/Y", strtotime("-5 months", strtotime($date))).'</td></tr></table></td>';
				        break;
				    case 12:
				        echo '<td style="padding:0.3rem"><table class="table table-sm" style="margin-bottom: 0rem;" width="100%"><tr><td>'.$projetado[0]['geap'].'</td></tr><tr><td style="font-size:x-small">'.date("m/Y", strtotime("-5 months", strtotime($date))).'</td></tr></table></td>';
				        break;
				    case 14:
				        echo '<td style="padding:0.3rem"><table class="table table-sm" style="margin-bottom: 0rem;" width="100%"><tr><td>'.$projetado[0]['green'].'</td></tr><tr><td style="font-size:x-small">'.date("m/Y", strtotime("-5 months", strtotime($date))).'</td></tr></table></td>';
				        break;
				    case 17:
				        echo '<td style="padding:0.3rem"><table class="table table-sm" style="margin-bottom: 0rem;" width="100%"><tr><td>'.$projetado[0]['mediservice'].'</td></tr><tr><td style="font-size:x-small">'.date("m/Y", strtotime("-4 months", strtotime($date))).'</td></tr></table></td>';
				        break;
				    case 18:
				        echo '<td style="padding:0.3rem"><table class="table table-sm" style="margin-bottom: 0rem;" width="100%"><tr><td>'.$projetado[0]['notredame'].'</td></tr><tr><td style="font-size:x-small">'.date("m/Y", strtotime("-4 months", strtotime($date))).'</td></tr></table></td>';
				        break;
				    case 22:
				        echo '<td style="padding:0.3rem"><table class="table table-sm" style="margin-bottom: 0rem;" width="100%"><tr><td>'.$projetado[0]['proasa'].'</td></tr><tr><td style="font-size:x-small">'.date("m/Y", strtotime("-4 months", strtotime($date))).'</td></tr></table></td>';
				        break;
				    case 29:
				        echo '<td style="padding:0.3rem"><table class="table table-sm" style="margin-bottom: 0rem;" width="100%"><tr><td>'.$projetado[0]['medisanitas'].'</td></tr><tr><td style="font-size:x-small">'.date("m/Y", strtotime("-4 months", strtotime($date))).'</td></tr></table></td>';
				        break;
				}    	

				echo '<td style="text-align:center;">'.$alcancado[$x]['contagem'].'</td><td style="text-align:right; padding-left: .1rem;padding-right: .1rem">R$ '.number_format($alcancado[$x]['repasse'], 2, ',', '.').'</td><td style="text-align:center;font-size:small;">'.date('d/m/Y',strtotime($alcancado[$x]['min'])).' a '.date('d/m/Y',strtotime($alcancado[$x]['max'])).'</td></tr>';



    }
    echo '</tbody></table>';
    
    $dbconn = null;
