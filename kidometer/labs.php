<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Laboratório Geral</title>
</head>
<body>
	<?php
	require_once( 'header.php' );
	?>
	<div id="description">
		<h2>Laboratório Geral</h2>
		<form action="labs.php" method="GET">
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

		require_once '../ee-config.php';
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

		$sql = "SELECT * FROM chapter_7 WHERE sexo=$sexo AND years=$years AND months=$months";
		$result = mysqli_query( $conn, $sql );

		if ( mysqli_num_rows( $result ) > 0 ) {
			// output data of each row
			while ( $row = mysqli_fetch_assoc( $result ) ) {
				?>
		<div class="label">ALT (U/L):</div>
		<div class="value">
			<?php echo $row['data_1'];?>-
			<?php echo $row['data_2'];?>
		</div>
		<div class="label">Albumina (g/dL | g/L):</div>
		<div class="value">
			<?php echo $row['data_3'];?>-
			<?php echo $row['data_4'];?> |
			<font size="-1">[
				<?php echo $row['data_5'];?>-
				<?php echo $row['data_6'];?>]</font>
		</div>
		<div class="label">Fosfatase Alcalina (U/L):</div>
		<div class="value">
			<?php echo $row['data_7'];?>-
			<?php echo $row['data_8'];?>
		</div>
		<div class="label">&alpha;1-antitripsina (mg/dL | g/L):</div>
		<div class="value">
			<?php echo $row['data_9'];?>-
			<?php echo $row['data_10'];?> |
			<font size="-1">[
				<?php echo $row['data_11'];?>-
				<?php echo $row['data_12'];?>]</font>
		</div>
		<div class="label">Amônia (mcg NH<sub>3</sub/dL | mmol NH<sub>3</sub>/L):</div>
		<div class="value">
			<?php echo $row['data_13'];?>-
			<?php echo $row['data_14'];?> |
			<font size="-1">[
				<?php echo $row['data_15'];?>-
				<?php echo $row['data_16'];?>]</font>
		</div>
		<div class="label">Amilase (U/L):</div>
		<div class="value">
			<?php echo $row['data_17'];?>-
			<?php echo $row['data_18'];?>
		</div>
		<div class="label"><i>Anion gap</i> (mmol/L):</div>
		<div class="value">
			<?php echo $row['data_19'];?>-
			<?php echo $row['data_20'];?>
		</div>
		<div class="label">Anti-DNAse titulação:</div>
		<div class="value">&le;&nbsp;
			<?php echo $row['data_21'];?>
		</div>
		<div class="label">ASO titulação (IU/mL):</div>
		<div class="value">&le;
			<?php echo $row['data_22'];?>
		</div>
		<div class="label">AST (U/L):</div>
		<div class="value">
			<?php echo $row['data_24'];?>-
			<?php echo $row['data_25'];?>
		</div>
		<div class="label"><i>Base excess</i> (mmol/L):</div>
		<div class="value">
			<?php echo $row['data_26'];?>
		</div>
		<div class="label">Bicarbonato (mmol/L):</div>
		<div class="value">
			<?php echo $row['data_27'];?>-
			<?php echo $row['data_28'];?>
		</div>
		<div class="label">Bilirubina, total (&micro;mol/L):</div>
		<div class="value">
			<?php echo $row['data_29'];?>-
			<?php echo $row['data_30'];?>
		</div>
		<div class="label">Bilirubina, recém-nascido (mg/dL | &micro;mol/L):</div>
		<div class="value">
			<?php echo $row['data_33'];?> |
			<font size="-1">
				<?php echo $row['data_34'];?>
			</font>
		</div>
		<div class="label">Calcio, total (mg/dL | mmol/L):</div>
		<div class="value">
			<?php echo $row['data_35'];?>-
			<?php echo $row['data_36'];?> |
			<font size="-1">[
				<?php echo $row['data_37'];?>-
				<?php echo $row['data_38'];?>]</font>
		</div>
		<div class="label">Cálcio, ionizado (mg/dL | mmol/L):</div>
		<div class="value">
			<?php echo $row['data_39'];?>-
			<?php echo $row['data_40'];?> |
			<font size="-1">[
				<?php echo $row['data_41'];?>-
				<?php echo $row['data_42'];?>]</font>
		</div>
		<div class="label">Ceruloplasmina (mg/dL | mg/L):</div>
		<div class="value">
			<?php echo $row['data_43'];?>-
			<?php echo $row['data_44'];?> |
			<font size="-1">[
				<?php echo $row['data_45'];?>-
				<?php echo $row['data_46'];?>]</font>
		</div>
		<div class="label">Cloreto, sérico (mmol/L):</div>
		<div class="value">
			<?php echo $row['data_47'];?>-
			<?php echo $row['data_48'];?>
		</div>
		<div class="label">Cloreto, suor (mmol/L):</div>
		<div class="value">normal: [5-35]<br/> borderline: [30-70]<br/> fibrose cística: [60-200]</div>
		<div class="label">Cobre (mcg/dL | mol/L):</div>
		<div class="value">(
			<?php echo $row['data_49'];?>-
			<?php echo $row['data_50'];?>) |
			<font size="-1">[
				<?php echo $row['data_51'];?>-
				<?php echo $row['data_52'];?>]</font>
		</div>
		<div class="label">Creatinina (mg/dL | &micro;mol/L):</div>
		<div class="value">(
			<?php echo $row['data_53'];?>-
			<?php echo $row['data_55'];?>) |
			<font size="-1">[
				<?php echo $row['data_54'];?>-
				<?php echo $row['data_56'];?>]</font>
		</div>
		<div class="value">WBC (cells/&micro;L):&nbsp;0 -
			<?php echo $row['data_71'];?>
		</div>
		<div class="label">&gamma;GT (U/L):</div>
		<div class="value">
			<?php echo $row['data_72'];?>-
			<?php echo $row['data_73'];?>
		</div>
		<div class="label">IgA (mg/dL | mg/L):</div>
		<div class="value">
			<?php echo $row['data_74'];?>-
			<?php echo $row['data_76'];?> |
			<font size="-1">[
				<?php echo $row['data_75'];?>-
				<?php echo $row['data_77'];?>]</font>
		</div>
		<div class="label">IgD (mg/dL):</div>
		<div class="value">0 -
			<?php echo $row['data_78'];?>
		</div>
		<div class="label">IgE (mg/dL):</div>
		<div class="value">0 -
			<?php echo $row['data_79'];?>
		</div>
		<div class="label">IgG (mg/dL | g/L):</div>
		<div class="value">total
			<?php echo $row['data_80'];?>-
			<?php echo $row['data_81'];?> |
			<font size="-1">[
				<?php echo $row['data_82'];?>-
				<?php echo $row['data_83'];?>]</font>
		</div>
		<div class="value">IgG subclasse 1:
			<?php echo $row['data_84'];?>-
			<?php echo $row['data_86'];?> |
			<font size="-1">[
				<?php echo $row['data_85'];?>-
				<?php echo $row['data_87'];?>]</font>
		</div>
		<div class="value">IgG subclasse 2:
			<?php echo $row['data_88'];?>-
			<?php echo $row['data_90'];?> |
			<font size="-1">[
				<?php echo $row['data_89'];?>-
				<?php echo $row['data_91'];?>]</font>
		</div>
		<div class="value">IgG subclasse 3:
			<?php echo $row['data_92'];?>-
			<?php echo $row['data_94'];?> |
			<font size="-1">[
				<?php echo $row['data_92'];?>-
				<?php echo $row['data_95'];?>]</font>
		</div>
		<div class="value">IgG subclasse 4:
			<?php echo $row['data_96'];?>-
			<?php echo $row['data_98'];?> |
			<font size="-1">[
				<?php echo $row['data_97'];?>-
				<?php echo $row['data_99'];?>]</font>
		</div>
		<div class="label">IgM (mg/dL| mg/L):</div>
		<div class="value">
			<?php echo $row['data_100'];?>-
			<?php echo $row['data_101'];?> |
			<font size="-1">[
				<?php echo $row['data_102'];?>-
				<?php echo $row['data_103'];?>]</font>
		</div>
		<div class="label">LDH (U/L):</div>
		<div class="value">
			<?php echo $row['data_104'];?>-
			<?php echo $row['data_105'];?>
		</div>
		<div class="label">Lipase (U/L):</div>
		<div class="value">
			<?php echo $row['data_106'];?>-
			<?php echo $row['data_107'];?>
		</div>
		<div class="label">Magnésio (mg/dL | mmol/L):</div>
		<div class="value">
			<?php echo $row['data_108'];?>-
			<?php echo $row['data_109'];?> |
			<font size="-1">[
				<?php echo $row['data_110'];?>-
				<?php echo $row['data_111'];?>]</font>
		</div>
		<div class="label">midi-chlorian count (k/cell):</div>
		<div class="value">2.25 - 2.75</div>
		<div class="label">Fósforo (mg/dL | mmol/L):</div>
		<div class="value">
			<?php echo $row['data_112'];?>-
			<?php echo $row['data_114'];?> |
			<font size="-1">[
				<?php echo $row['data_113'];?>-
				<?php echo $row['data_115'];?>]</font>
		</div>
		<div class="label">Potássio (mmol/L):</div>
		<div class="value">
			<?php echo $row['data_116'];?>-
			<?php echo $row['data_117'];?>
		</div>
		<div class="label">Pre-albumina (mg/dL):</div>
		<div class="value">
			<?php echo $row['data_118'];?>-
			<?php echo $row['data_120'];?> |
			<font size="-1">[
				<?php echo $row['data_119'];?>-
				<?php echo $row['data_121'];?>]</font>
		</div>
		<div class="label">Proteina, total (g/L):</div>
		<div class="value">
			<?php echo $row['data_122'];?>-
			<?php echo $row['data_124'];?> |
			<font size="-1">[
				<?php echo $row['data_123'];?>-
				<?php echo $row['data_125'];?>]</font>
		</div>
		<div class="label">Sódio (mmol/L):</div>
		<div class="value">
			<?php echo $row['data_127'];?>-
			<?php echo $row['data_128'];?>
		</div>
		<div class="label">Ureia Nitrogenada (mg/dL | mmol/L):</div>
		<div class="value">
			<?php echo $row['data_129'];?>-
			<?php echo $row['data_131'];?> |
			<font size="-1">[
				<?php echo $row['data_130'];?>-
				<?php echo $row['data_132'];?>]</font>
		</div>
		<div class="label">Ácido Úrico (mg/dL | &micro;mol/L):</div>
		<div class="value">
			<?php echo $row['data_133'];?>-
			<?php echo $row['data_135'];?> |
			<font size="-1">[
				<?php echo $row['data_134'];?>-
				<?php echo $row['data_136'];?>]</font>
		</div>
		<div class="reference">
			<p>Berhman, R:<a href="http://www.amazon.com/Nelson-Textbook-Pediatrics-Enhanced-Features/dp/1437707556">Nelson Textbook of Pediatrics, 19th Ed.</a>2011.</p>
			Alan H.B. Wu:<a href="http://www.amazon.com/gp/product/0721679757">Tietz Clinical Guide to Laboratory Tests 4th Edition</a>W.B. Saunders Co. Philadelphia, 2006.
			<p>
				<p>Soldin, SJ, Brugnara, C, Wong, EC<a href="http://www.amazon.com/gp/product/1594250677">Pediatric Reference Intervals, 6th Edition</a>AACC Press Washington D.C. 2007.</p>
				<p>Note: Lab values can vary depending on the assay technique or equipment used to make the measurement. It also can vary with differing populations. Local normal values should be used whenever possible.</p>
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