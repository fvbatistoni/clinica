<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Hematologia</title>

</head>
<body>
<?php
require_once('header.php');?>
<div id="description">
  <h2>Hematologia</h2>
  <form action="hemato.php" method="GET">
			<table width="100%">
				<tr>
					<td>
						<input type="radio" name="sexo" value="1" <?php echo isset($_GET[ 'sexo']) && $_GET[ 'sexo']==1 ? "checked" : "" ?>> Masculino
						<input type="radio" name="sexo" value="2" <?php echo isset($_GET[ 'sexo']) && $_GET[ 'sexo']==2 ? "checked" : "" ?>> Feminino</td>
					<td><strong>Anos:</strong>
						<select name="years">
							<option value="0">0</option>
							<option value="1" <?php echo isset($_GET[ 'years']) && $_GET[ 'years']==1 ? "selected" : "" ?> >1</option>
							<option value="2" <?php echo isset($_GET[ 'years']) && $_GET[ 'years']==2 ? "selected" : "" ?> >2</option>
							<option value="3" <?php echo isset($_GET[ 'years']) && $_GET[ 'years']==3 ? "selected" : "" ?> >3</option>
							<option value="4" <?php echo isset($_GET[ 'years']) && $_GET[ 'years']==4 ? "selected" : "" ?> >4</option>
							<option value="5" <?php echo isset($_GET[ 'years']) && $_GET[ 'years']==5 ? "selected" : "" ?> >5</option>
							<option value="6" <?php echo isset($_GET[ 'years']) && $_GET[ 'years']==6 ? "selected" : "" ?> >6</option>
							<option value="7" <?php echo isset($_GET[ 'years']) && $_GET[ 'years']==7 ? "selected" : "" ?> >7</option>
							<option value="8" <?php echo isset($_GET[ 'years']) && $_GET[ 'years']==8 ? "selected" : "" ?> >8</option>
							<option value="9" <?php echo isset($_GET[ 'years']) && $_GET[ 'years']==9 ? "selected" : "" ?> >9</option>
							<option value="10" <?php echo isset($_GET[ 'years']) && $_GET[ 'years']==10 ? "selected" : "" ?> >10</option>
							<option value="11" <?php echo isset($_GET[ 'years']) && $_GET[ 'years']==11 ? "selected" : "" ?> >11</option>
							<option value="12" <?php echo isset($_GET[ 'years']) && $_GET[ 'years']==12 ? "selected" : "" ?> >12</option>
							<option value="13" <?php echo isset($_GET[ 'years']) && $_GET[ 'years']==13 ? "selected" : "" ?> >13</option>
							<option value="14" <?php echo isset($_GET[ 'years']) && $_GET[ 'years']==14 ? "selected" : "" ?> >14</option>
							<option value="15" <?php echo isset($_GET[ 'years']) && $_GET[ 'years']==15 ? "selected" : "" ?> >15</option>
							<option value="16" <?php echo isset($_GET[ 'years']) && $_GET[ 'years']==16 ? "selected" : "" ?> >16</option>
							<option value="17" <?php echo isset($_GET[ 'years']) && $_GET[ 'years']==17 ? "selected" : "" ?> >17</option>
						</select>
					</td>
					<td><strong>Meses:</strong>
						<select name="months">
							<option value="0" <?php echo isset($_GET[ 'months']) && $_GET[ 'months']==0 ? "selected" : "" ?> >0</option>
							<option value="1" <?php echo isset($_GET[ 'months']) && $_GET[ 'months']==1 ? "selected" : "" ?> >1</option>
							<option value="2" <?php echo isset($_GET[ 'months']) && $_GET[ 'months']==2 ? "selected" : "" ?> >2</option>
							<option value="3" <?php echo isset($_GET[ 'months']) && $_GET[ 'months']==3 ? "selected" : "" ?> >3</option>
							<option value="4" <?php echo isset($_GET[ 'months']) && $_GET[ 'months']==4 ? "selected" : "" ?> >4</option>
							<option value="5" <?php echo isset($_GET[ 'months']) && $_GET[ 'months']==5 ? "selected" : "" ?> >5</option>
							<option value="6" <?php echo isset($_GET[ 'months']) && $_GET[ 'months']==6 ? "selected" : "" ?> >6</option>
							<option value="7" <?php echo isset($_GET[ 'months']) && $_GET[ 'months']==7 ? "selected" : "" ?> >7</option>
							<option value="8" <?php echo isset($_GET[ 'months']) && $_GET[ 'months']==8 ? "selected" : "" ?> >8</option>
							<option value="9" <?php echo isset($_GET[ 'months']) && $_GET[ 'months']==9 ? "selected" : "" ?> >9</option>
							<option value="10" <?php echo isset($_GET[ 'months']) && $_GET[ 'months']==10 ? "selected" : "" ?> >10</option>
							<option value="11" <?php echo isset($_GET[ 'months']) && $_GET[ 'months']==11 ? "selected" : "" ?> >11</option>
							<option value="12" <?php echo isset($_GET[ 'months']) && $_GET[ 'months']==12 ? "selected" : "" ?> >12</option>
						</select>
					</td>
					<td> <input type="submit"/>
					</td>
				</tr>
			</table>

  </form>
  <?php
	 
	$sexo = isset( $_GET['sexo'] ) ? $_GET['sexo'] : "1";
	$years = isset( $_GET['years'] ) ? $_GET['years'] : "1";
	$months = isset( $_GET['months'] ) ? $_GET['months'] : "1";
	
	require_once '../ee-config.php';
	$servername = DB_HOST;
	$username = DB_USER;
	$password = DB_PASSWORD;
	$dbname = DB_NAME;

	// Create connection
	$conn = mysqli_connect($servername, $username, $password, $dbname);
	// Check connection
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}

	$sql = "SELECT * FROM chapter_6 WHERE sexo=$sexo AND years=$years AND months=$months";
	$result = mysqli_query($conn, $sql);

	if (mysqli_num_rows($result) > 0) {
		// output data of each row
		while($row = mysqli_fetch_assoc($result)) {
	?>
  <h2>SÉRIE VERMELHA (médias)</h2>
<div class="label">Hgb:</div>
  <div class="value"><?php echo $row['data_1'];?>-<?php echo $row['data_2'];?> <strong>g/dL</strong> | <font size="-1"><?php echo $row['data_3'];?>-<?php echo $row['data_4'];?> <strong>mmol/L</strong></font></div>
  <div class="label">Htc:</div>
  <div class="value"><?php echo $row['data_5'];?>&nbsp;&#8209;&nbsp;<?php echo $row['data_6'];?> <strong>&percnt;</strong></div>
  <div class="label">Contagem de Eritrócitos:</div>
  <div class="value"><?php echo $row['data_7'];?>&nbsp;&#8209;&nbsp;<?php echo $row['data_8'];?> <strong>10<sup>6</sup> cells/&micro;L</strong></div>
  <div class="label">VCM:</div>
  <div class="value"><?php echo $row['data_9'];?>&nbsp;&#8209;&nbsp;<?php echo $row['data_10'];?></div>
  <div class="label">HCM:</div>
  <div class="value"><?php echo $row['data_11'];?>&nbsp;&#8209;&nbsp;<?php echo $row['data_12'];?> <strong>fL</strong></div>
  <div class="label">CHCM:</div>
  <div class="value"><?php echo $row['data_13'];?>-<?php echo $row['data_14'];?> <strong>&percnt;Hb/cél</strong> | <font size="-1"><?php echo $row['data_15'];?>-<?php echo $row['data_16'];?> <strong>mmol Hb/L</strong></font></div>
  <h2>LEUCOMETRIA</h2>
  <div class="label">Leucometria:</div>
  <div class="value"><?php echo $row['data_17'];?>&nbsp;&#8209;&nbsp;<?php echo $row['data_18'];?> <strong>&micro;L</strong></div>
  <h2>CONTAGEM DE PLAQUETAS</h2>
  <div class="label">Plaquetometria:</div>
  <div class="value">84&nbsp;-&nbsp;478 <strong>x1000/mm<sup>3</sup></strong></div>
  <h2>FERRO (médias)</h2>
  <div class="label">Ferro Sérico (&micro;g/dL | &micro;mol/L):</div>
  <div class="value"><?php echo $row['data_19'];?>-<?php echo $row['data_20'];?> | <?php echo $row['data_21'];?>-<?php echo $row['data_22'];?></div>
  <div class="label">Capacidade Total de Ligação de Ferro ( | ):</div>
  <div class="value"><?php echo $row['data_23'];?>-<?php echo $row['data_24'];?> <strong>&micro;g/dL</strong> | <font size="-1"><?php echo $row['data_25'];?>-<?php echo $row['data_26'];?> <strong>&micro;mol/L</strong></font></div>
  <div class="label">Saturação de Transferrina (%):</div>
  <div class="value"><?php echo $row['data_27'];?>&nbsp;&#8209;&nbsp;<?php echo $row['data_28'];?></div>
  <div class="label">Ferritina (ng/mL | &micro;g/L):</div>
  <div class="value"><?php echo $row['data_29'];?>&nbsp;&#8209;&nbsp;<?php echo $row['data_30'];?></div> 
  <div class="reference">
    <p>Soldin, SJ, Brugnara, C, Wong, EC <a href="http://www.amazon.com/gp/product/1594250677"> Pediatric Reference Intervals, 6th Edition</a> AACC Press Washington D.C. 2007.</p>
    <div class="reference-header">RED CELL INDICES and LEUKOCYTE COUNT</div>
    <p>Soldin provides three different reference ranges for all the red cell indices. We chose the data gathered from Children&apos;s National outpatient clinics and ER, reference 3. They excluded hematology/oncology patients and then went through two methods of excluding outliers (Chauvenet&apos;s criteria and Hoffman&apos;s method) to come to these ranges. Further details are in his book.</p>
    <p>Note: Lab values can vary depending on the assay technique or equipment used to make the measurement. It also can vary with differing populations. Local normal values should be used whenever possible.</p>
    <div class="reference-header">IRON STUDIES</div>
    <p>Soldin OP, Bierbower LH, Choi JJ, et al.<a href="http://www.ncbi.nlm.nih.gov/pubmed/15026283">Clin Chim Acta 2004; 342: 211-7</a>.</p>
  </div>
  <?php
	 }		
	} else {
		echo "0 results";
	}

	mysqli_close($conn);
	?>
</div>
<!-- fim do conteúdo -->
<?php
require_once('footer.php');?>
</body>
</html>