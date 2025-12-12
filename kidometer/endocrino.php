<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Endocrinologia</title>

</head>

<body>
	<?php
	require_once( 'header.php' );
	?>
	<div id="description">
		<h2>Endocrinologia</h2>
		<form action="endocrino.php" method="GET">
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

		$sexo = isset( $_GET[ 'sexo' ] ) ? $_GET[ 'sexo' ] : "1";
		$years = isset( $_GET[ 'years' ] ) ? $_GET[ 'years' ] : "1";
		$months = isset( $_GET[ 'months' ] ) ? $_GET[ 'months' ] : "1";

		require_once '../../ee-config.php';
		$servername = DB_HOST;
		$username = DB_USER;
		$password = DB_PASSWORD;
		$dbname = DB_NAME;

		// Create connection
		$conn = mysqli_connect( $servername, $username, $password, $dbname );
		// Check connection
		if ( !$conn ) {
			die( "Connection failed: " . mysqli_connect_error() );
		}

		$sql = "SELECT * FROM chapter_4 WHERE sexo=$sexo AND years=$years AND months=$months";
		$result = mysqli_query( $conn, $sql );

		if ( mysqli_num_rows( $result ) > 0 ) {
			// output data of each row
			while ( $row = mysqli_fetch_assoc( $result ) ) {
				?>
		<div class="label">1,25 Dihidroxi Vitamina D (pg/mL | pmol/L):</div>
		<div class="value">(
			<?php echo $row['data_1'];?>-
			<?php echo $row['data_2'];?>) |
			<font size="-1">[
				<?php echo $row['data_3'];?>-
				<?php echo $row['data_4'];?>]</font>
		</div>
		<div class="label">17-Hidroxiprogesterona, plasma (ng/dL):</div>
		<div class="value">(
			<?php echo $row['data_5'];?>) |
			<font size="-1">[
				<?php echo $row['data_6'];?>]</font>
		</div>
		<div class="label">25-hidroxi Vitamina D (ng/mL | nmol/L):</div>
		<div class="value">(
			<?php echo $row['data_7'];?>-
			<?php echo $row['data_8'];?>) |
			<font size="-1">[
				<?php echo $row['data_9'];?>-
				<?php echo $row['data_10'];?>]</font>
		</div>
		<div class="label">ACTH, AM draw (pg/mL | pmol/L):</div>
		<div class="value">
			<?php echo $row['data_11'];?> |
			<font size="-1">[
				<?php echo $row['data_12'];?>]</font>
		</div>
		<div class="label">Aldosterona, em pé (ng/dL | nmol/L):</div>
		<div class="value">(
			<?php echo $row['data_13'];?>) |
			<font size="-1">[
				<?php echo $row['data_14'];?>]</font>
		</div>
		<div class="label">Peptídeo-C, jejum (ng/mL):</div>
		<div class="value">
			<?php echo $row['data_15'];?>-
			<?php echo $row['data_16'];?>
		</div>
		<div class="label">Calcitonina (pg/mL | ng/L):</div>
		<div class="value">(
			<?php echo $row['data_19'];?>-
			<?php echo $row['data_20'];?>) |
			<font size="-1">[
				<?php echo $row['data_21'];?>-
				<?php echo $row['data_22'];?>]</font>
		</div>
		<div class="label">Colesterol Total (mg/dL | mmol/L):</div>
		<div class="value">(
			<?php echo $row['data_23'];?>) |
			<font size="-1">[
				<?php echo $row['data_24'];?>]</font>
		</div>
		<div class="label">Colesterol HDL (mg/dL | mmol/L):</div>
		<div class="value">(
			<?php echo $row['data_25'];?>) |
			<font size="-1">[
				<?php echo $row['data_26'];?>]</font>
		</div>
		<div class="label">Colesterol LDL (mg/dl | mmol/l):</div>
		<div class="value">(
			<?php echo $row['data_27'];?>) |
			<font size="-1">[
				<?php echo $row['data_28'];?>´]</font>
		</div>
		<div class="label">Cortisol total AM (mcg/dL | nmol/L):</div>
		<div class="value">(
			<?php echo $row['data_29'];?>-
			<?php echo $row['data_30'];?>) |
			<font size="-1">[
				<?php echo $row['data_31'];?>-
				<?php echo $row['data_32'];?>]</font>
		</div>
		<div class="label">Cortisol, livre em urina de 24h (mcg/day | nmol/day):</div>
		<div class="value">(
			<?php echo $row['data_33'];?>-
			<?php echo $row['data_34'];?>) |
			<font size="-1">[
				<?php echo $row['data_35'];?>-
				<?php echo $row['data_36'];?>]</font>
		</div>
		<div class="label">Dopamina, urina 24h (mcg/day | nmol/day Creatinina):</div>
		<div class="value">&lt;&nbsp;
			<?php echo $row['data_37'];?> |
			<font size="-1">
				<?php echo $row['data_38'];?>
			</font>
		</div>
		<div class="label">Epinefrina urina 24h (mcg/gCr | &micro;mol/molCr):</div>
		<div class="value">&lt;&nbsp;
			<?php echo $row['data_39'];?> |
			<font size="-1">
				<?php echo $row['data_40'];?>
			</font>
		</div>
		<div class="label">Epinefrina em pé (pg/mL | pmol/L):</div>
		<div class="value">
			<?php echo $row['data_41'];?> |
			<font size="-1">
				<?php echo $row['data_42'];?>
			</font>
		</div>
		<div class="label">Estrona (ng/dL | pmol/L):</div>
		<div class="value">
			<?php echo $row['data_45'];?> |
			<font size="-1">
				<?php echo $row['data_46'];?>
			</font>
		</div>
		<div class="label">Hemoglobina glicada A1c (%):</div>
		<div class="value">3.4 - 6.1</div>
		<div class="label">Ácido homovanílico (HVA) urina 24h (mcg/mgCr | mmol/molCr):</div>
		<div class="value">&lt;&nbsp;
			<?php echo $row['data_47'];?> |
			<font size="-1">
				<?php echo $row['data_48'];?>
			</font>
		</div>
		<div class="label">IGF-1 (ng/mL):</div>
		<div class="value">(
			<?php echo $row['data_49'];?>) |
			<font size="-1">[
				<?php echo $row['data_50'];?>]</font>
		</div>
		<div class="label">Metanephrinas urina 24h (mcg/gCr | &micro;mol/molCr):</div>
		<div class="value">(
			<?php echo $row['data_51'];?>-
			<?php echo $row['data_52'];?>) |
			<font size="-1">[
				<?php echo $row['data_53'];?>-
				<?php echo $row['data_54'];?>]</font>
		</div>
		<div class="label">Norepinephrina urina 24h (mcg/gCr | &micro;mol/mol):</div>
		<div class="value">&lt;&nbsp;
			<?php echo $row['data_55'];?> |
			<font size="-1">
				<?php echo $row['data_56'];?>
			</font>
		</div>
		<div class="label">Osteocalcina (ng/mL | &micro;g/L):</div>
		<div class="value">
			<?php echo $row['data_61'];?>-
			<?php echo $row['data_62'];?>
		</div>
		<div class="label">Prolactina (ng/mL)):</div>
		<div class="value">
			<?php echo $row['data_63'];?>-
			<?php echo $row['data_64'];?>
		</div>
		<div class="label">PTH, intacto (pg/mL | ng/L):</div>
		<div class="value">
			<?php echo $row['data_65'];?> |
			<font size="-1">
				<?php echo $row['data_66'];?>
			</font>
		</div>
		<div class="label">Renina (ng/mL | &micro;g/hr) normal Na intake supine:</div>
		<div class="value">&lt;&nbsp;
			<?php echo $row['data_67'];?>
		</div>
		<div class="label">Globulina de ligação de hormônio sexual (mcg/dL | nmol/L):</div>
		<div class="value">(
			<?php echo $row['data_68'];?>-
			<?php echo $row['data_69'];?>) |
			<font size="-1">[
				<?php echo $row['data_70'];?>-
				<?php echo $row['data_71'];?>]</font>
		</div>
		<div class="label">Testosterona, livre (pg/mL | pmol/L):</div>
		<div class="value">(
			<?php echo $row['data_72'];?>-
			<?php echo $row['data_73'];?>) |
			<font size="-1">[
				<?php echo $row['data_74'];?>-
				<?php echo $row['data_75'];?>]</font>
		</div>
		<div class="label">Testosterona, total (ng/dL):</div>
		<div class="value">
			<?php echo $row['data_76'];?>
		</div>
		<div class="label">Imunoglobulina estimulante de Tireoide:</div>
		<div class="value">menos que 130% do controle</div>
		<div class="label">Tiroxina, T4 total (&micro;g/dL | nmol/L):</div>
		<div class="value">(
			<?php echo $row['data_77'];?>-
			<?php echo $row['data_78'];?>) |
			<font size="-1">[
				<?php echo $row['data_79'];?>-
				<?php echo $row['data_80'];?>]</font>
		</div>
		<div class="label">Tiroxina, T4 livre (ng/dL | pmol/L):</div>
		<div class="value">(
			<?php echo $row['data_81'];?>-
			<?php echo $row['data_82'];?>) |
			<font size="-1">[
				<?php echo $row['data_83'];?>-
				<?php echo $row['data_84'];?>]</font>
		</div>
		<div class="label">Globulina de ligação de Tiroxina (mg/dL| mg/L):</div>
		<div class="value">(
			<?php echo $row['data_85'];?>) |
			<font size="-1">
				<?php echo $row['data_86'];?>
			</font>
		</div>
		<div class="label">Triglicerides (mmol/L | mg/dL) fasting:</div>
		<div class="value">(
			<?php echo $row['data_87'];?>-
			<?php echo $row['data_88'];?>) |
			<font size="-1">[
				<?php echo $row['data_89'];?>-
				<?php echo $row['data_90'];?>]</font>
		</div>
		<div class="label">Triiodotironina, T3, total (ng/dL | nmol/L):</div>
		<div class="value">
			<?php echo $row['data_91'];?>-
			<?php echo $row['data_92'];?> |
			<font size="-1">[
				<?php echo $row['data_93'];?>-
				<?php echo $row['data_94'];?>]</font>
		</div>
		<div class="label">TSH (&micro;IU/L | &micro;U/L):</div>
		<div class="value">
			<?php echo $row['data_95'];?>-
			<?php echo $row['data_96'];?>
		</div>
		<div class="label">Ácido vanilmandélico, VMA urina 24h (mcg/mgCr | mmol/molCr):</div>
		<div class="value">&lt;&nbsp;
			<?php echo $row['data_97'];?> |
			<font size="-1">
				<?php echo $row['data_98'];?>
			</font>
		</div>

		<div class="reference">
			Alan H.B. Wu:<a href="http://www.amazon.com/gp/product/0721679757">Tietz Clinical Guide to Laboratory Tests 4th Edition</a>W.B. Saunders Co. Philadelphia, 2006.
			<p>Soldin, SJ, Brugnara, C, Wong, EC<a href="http://www.amazon.com/gp/product/1594250677">Pediatric Reference Intervals, 6th Edition</a>Note: Values labeled "standing" can be used for ambulatory patients. Patients who have been bed bound for > 10 hours should use supine data.<br>
				<p>Note: Lab values can vary depending on the assay technique or equipment used to make the measurement. It also can vary with differing populations. Local normal values should be used whenever possible.
		</div>
		<?php
		}
		} else {
			echo "0 results";
		}

		mysqli_close( $conn );
		?>
	</div>
	<!-- fim do conteúdo -->
	<?php
	require_once( 'footer.php' );
	?>
</body>
</html>