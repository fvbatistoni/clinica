<?php
include 'header.php';
?>
<style>
td {
    font-size: small;
    border-bottom: thin;
    border-bottom-style: dotted;
    padding: 4px;
}
.alinha_a_direita {
    text-align: right;
}
.ajuda {
    display: inline;
    font-size: x-small;
    font-color: grey;
    font-style: italic;
    color: #999;
    line-height: normal;
}
.ajuda1 {
    display: inline;
    font-size: x-small;
    font-style: italic;
    line-height: normal;
}
hr.style-six {
    padding: 0;
    border: none;
    height: 1px;
    background-image: -webkit-linear-gradient(left, rgba(0,0,0,0), rgba(0,0,0,0.20), rgba(0,0,0,0));
    background-image: -moz-linear-gradient(left, rgba(0,0,0,0), rgba(0,0,0,0.20), rgba(0,0,0,0));
    background-image: -ms-linear-gradient(left, rgba(0,0,0,0), rgba(0,0,0,0.20), rgba(0,0,0,0));
    background-image: -o-linear-gradient(left, rgba(0,0,0,0), rgba(0,0,0,0.20), rgba(0,0,0,0));
    color: #999;
    text-align: center;
}
</style>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
<?php
  include 'navbar.php';
  include 'menu.php';
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper"> 
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Painel de Controle</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard v1</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
  <div class="row">    
    <div class="col-md-8">
      <div class="row">
        <?php
        if ( isset( $_SESSION[ 'message' ] ) ) {
            echo '<div class="callout callout-info">' . $_SESSION[ 'message' ] . '</div>';
            unset( $_SESSION[ 'message' ] );
        }
        ?>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div id="card_cardapio" class="card card-primary">
            <div class="card-header">
              <h3 class="card-title"><i class='fas fa-hamburger'></i> Meu Cardápio</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i> </button>
              </div>
              <!-- /.card-tools --> 
            </div>
            <!-- /.card-header -->
            <div class="card-body" style="padding:7px;">
              <form method="post" action="alimentacaoSaveCart.php">
                <table class="table table-bordered table-striped" width="100%" style="font-size: small">
                  <thead>
                  <th width="5%"></th>
                    <th width="40%">Descrição</th>
                    <th width="13%">Porções</th>
                    <th style="text-align:center">C</th>
                    <th style="text-align:center">L</th>
                    <th style="text-align:center">P</th>
                    <th style="text-align:center">F</th>
                    </thead>
                  <tbody>
                    <?php
                    if ( !empty( $_SESSION[ 'cart' ] ) ) {

                        if ( !class_exists( 'DB' ) ) {
                            include 'DB.class.php';
                        }
                        $db = new DB();

                        $total_geral = 1;
                        $total_c = 1;
                        $total_p = 1;
                        $total_l = 1;
                        $total_f = 1;

                        /* $consulta
                        [0]id,
                        [1]descricao
                        [2]porcao_g
                        [3]porcao_unidade
                        [4]energia_kcal
                        [5]carbohidrato_g
                        [6]lipideos_g
                        [7]proteina_g
                        [8]fibra_g */


                        if ( !isset( $_SESSION[ 'qty_array' ] ) ) {
                            $_SESSION[ 'qty_array' ] = array_fill( 0, count( $_SESSION[ 'cart' ] ), 1 );
                        }

                        $consulta = $db->getFichaAlimento( implode( ',', $_SESSION[ 'cart' ] ) );

                        $index = 0;

                        while($index < count($consulta)){
                          echo '<tr><td><a href="alimentacaoCartDeleteItem.php?id=' . $consulta[ $index ][ 0 ] . '&index=' . $index . '"><i class="ion ion-trash-a"></i></a></td>';
                          echo '<td>' . $consulta[ $index ][ 1 ] . '<br><small>Porção: ' . $consulta[ $index ][ 2 ] . ' ' . $consulta[ $index ][ 3 ] . ' - ' . number_format( $consulta[ $index ][ 4 ], 1, ',', '.' ) . ' kcal</small></td>';
                          echo '<td><input type="hidden" name="indexes[]" value="' . $index . '">';
                          echo '<input type="number" class="form-control" value="' . $_SESSION[ 'qty_array' ][ $index ] . '" name="qty_' . $index . '"></td>';
                          echo '<td style="text-align:right">' . number_format( $consulta[ $index ][ 5 ] * $_SESSION[ 'qty_array' ][ $index ], 1, ',', '.' ) . ' g</td>';
                          echo '<td style="text-align:right">' . number_format( $consulta[ $index ][ 6 ] * $_SESSION[ 'qty_array' ][ $index ], 1, ',', '.' ) . ' g</td>';
                          echo '<td style="text-align:right">' . number_format( $consulta[ $index ][ 7 ] * $_SESSION[ 'qty_array' ][ $index ], 1, ',', '.' ) . ' g</td>';
                          echo '<td style="text-align:right">' . number_format( $consulta[ $index ][ 8 ] * $_SESSION[ 'qty_array' ][ $index ], 1, ',', '.' ) . ' g</td></tr>';

                            $total_geral += $_SESSION[ 'qty_array' ][ $index ] * $consulta[ $index ][ 4 ];
                            $total_c += $_SESSION[ 'qty_array' ][ $index ] * $consulta[ $index ][ 5 ];
                            $total_l += $_SESSION[ 'qty_array' ][ $index ] * $consulta[ $index ][ 6 ];
                            $total_p += $_SESSION[ 'qty_array' ][ $index ] * $consulta[ $index ][ 7 ];
                            $total_f += $_SESSION[ 'qty_array' ][ $index ] * $consulta[ $index ][ 8 ];

                          $index ++;
                        } // fim do WHILE

                    } // fim do IF

                    ?>
                    <tr>
                      <td colspan="2" align="right"><b>Total:</b></td>
                      <td style="text-align:right"><b><?php echo number_format($total_geral); ?></b> kcal</td>
                      <td style="text-align:right"><b><?php echo number_format($total_c, 1, ",", "."); ?></b> g</td>
                      <td style="text-align:right"><b><?php echo number_format($total_l, 1, ",", "."); ?></b> g</td>
                      <td style="text-align:right"><b><?php echo number_format($total_p, 1, ",", "."); ?></b> g</td>
                      <td style="text-align:right"><b><?php echo number_format($total_f, 1, ",", "."); ?></b> g</td>
                    </tr>
                  </tbody>
                </table>
                <a href="alimentacaoIndex.php" class="btn btn-primary"><i class="ion ion-reply"></i> Voltar</a>
                <button type="submit" class="btn btn-success" name="save"><i class="ion ion-loop"></i> Atualizar</button>
                <a href="alimentacaoClearCart.php" class="btn btn-danger"><i class="ion ion-trash-a"></i> Limpar</a>
              </form>
            </div>
            <!-- /.card-body --> 
          </div>
          <!-- /.card --> 
        </div>
        <!-- /.col --> 
      </div>
      <div class="row">
        <div class="col-md-12">
          <div id="card_analise" class="card card-secondary collapsed-card">
            <div class="card-header">
              <h3 class="card-title"><i class='far fa-bell'></i> Resultados</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i> </button>
              </div>
              <!-- /.card-tools --> 
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div id="analise"></div>
            </div>
            <!-- /.row --> 
            <!-- /.card-body --> 
          </div>
          <!-- /.card --> 
        </div>
        <!-- /.col --> 
      </div>
    </div>
    <div class="col-md-4">
      <div class="card card-info">
        <div class="card-header">
          <h3 class="card-title"><i class='fas fa-calculator'></i> Calculadora</h3>
          <?php

          if ( !isset( $_POST[ 'birthdate' ] ) ) {
              $birthdate = '';
          } else {
              $birthdate = $_POST[ 'birthdate' ];
          }

          if ( !isset( $_POST[ 'weight' ] ) ) {
              $weight = '';
          } else {
              $weight = $_POST[ 'weight' ];
          }

          if ( !isset( $_POST[ 'height' ] ) ) {
              $height = '';
          } else {
              $height = $_POST[ 'height' ];
          }

          if ( !isset( $_POST[ 'gender' ] ) ) {
              $gender = '';
          } else {
              $gender = intval( $_POST[ 'gender' ] );
          }

          if ( !isset( $_POST[ 'sobrepeso' ] ) ) {
              $sobrepeso = '';
          } else {
              $sobrepeso = $_POST[ 'sobrepeso' ];
          }

          if ( !isset( $_POST[ 'atividade' ] ) ) {
              $atividade = '';
          } else {
              $atividade = $_POST[ 'atividade' ];
          }

          if ( !isset( $_POST[ 'emagrece' ] ) ) {
              $emagrece = 0;
          } else {
              $emagrece = $_POST[ 'emagrece' ];
          }

          if ( !isset( $_POST[ 'engorda' ] ) ) {
              $engorda = 0;
          } else {
              $engorda = $_POST[ 'engorda' ];
          }

          ?>
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i> </button>
          </div>
          <!-- /.card-tools --> 
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <form class="form" id="calculadora_calorias" action="" method="post">
            <div class="row">
              <div id="identificacao"></div> <!-- Resumo gerado -->
            </div>
            <div class="row" style="margin-top:5px; margin-bottom: -20px">
              <div class="col-md-8">
                <div class="form-group small">
                  <label><i class="fa fa-birthday-cake" aria-hidden="true"></i> Data de nascimento:</label>
                  <!-- Os campos hidden vieram do ZMI index -->
                  
                  <input type="hidden" name="type" class="type" id="adolescentType" value="adolescent" checked="true">
                  </input>
                  <input type="date" data-val="true" data-val-date="Data inválida" data-val-required="Campo obrigatório." id="birthdate" name="birthdate" class="form-control form-control-sm" required/>
                  <span class="field-validation-valid" data-valmsg-for="birthdate" data-valmsg-replace="true"></span>
                  <input type="hidden" data-val="true" data-val-date="Data inválida" data-val-required="Appointment date is required." id="appointment" name="appointment" value="<?php echo date('Y-m-d'); ?>" />
                  <span class="field-validation-valid" data-valmsg-for="appointment" data-valmsg-replace="true"></span> 
        </div>
              </div>
              <div class="col-md-4">
                <div class="form-group small">
                  <label><i class="fa fa-venus-mars"></i> Sexo:</label><br>
                    <input type="radio" name="gender" value=1 <?php echo $gender==1?'checked':''; ?>> Masculino
                    <br>
                    <input type="radio" name="gender" value=2 <?php echo $gender==2?'checked':''; ?>> Feminino
                </div>
              </div>
            </div>
            <hr class="style-six">
            <div class="row" style="margin-top:5px; margin-bottom: -10px">
              <div class="col-md-3">
                <label>Peso:</label>                
                <!-- Os inputs hidden vieram do ZMI index -->
                <input type="number" data-val="true" data-val-number="O peso precisa ser um número." data-val-required="Campo obrigatório." id="weight" name="weight" placeholder="kg" class="form-control"/>
                <input type="hidden" name="weightUnit" checked="true" value="kg">
                </input>
                <span class="field-validation-valid" data-valmsg-for="weight" data-valmsg-replace="true"></span> </div>
              <div class="col-md-3">
                <label>Estatura:</label>
                <!-- Os inputs hidden vieram do ZMI index -->
                <input type="number" data-val="true" data-val-number="A estatura precisa ser um número." data-val-required="Campo obrigatório." id="height" name="height" placeholder="cm" class="form-control"/>
                <input type="hidden" name="heightUnit" checked="true" value="cm">
                </input>
                <span class="field-validation-valid" data-valmsg-for="height" data-valmsg-replace="true"></span> </div>
              <div class="col-md-6" style="background-color: #E8E8E8;">
                <div class="row" style="margin-bottom: 5px;margin-bottom: -5px;">
                  <div class="col" style="text-align: center">
                    <div class="form-group small">
                      <!-- Este campo veio do VZI -->
                      <div id="result" style="text-align:center;font-size:small;color:red;font-style:italic">automático</div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col" style="text-align: center; margin-bottom: 5px;margin-bottom: -10px;">
                    <div class="form-group small">
                    <label><i class="fas fa-exclamation-triangle" style="color:orange"></i> Sobrepeso?</label>
                    <br>
                      <input type="radio" name="sobrepeso" value="1" disabled> Sim
                      <input type="radio" name="sobrepeso" value="2" disabled> Não
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <hr class="style-six">
            <div class="row">
            <div class="col-md-6">
              <label><i class="fas fa-fire"></i> Nível de Atividade:</label>
              <div class="form-check small">
                <input class="form-check-input" type="radio" name="atividade" id="Radio1" value="1" <?php echo $atividade=='1'?'checked':''; ?>>
                <label class="form-check-label" for="Radio1"> Sedentário </label>
              </div>
              <div class="form-check small">
                <input class="form-check-input" type="radio" name="atividade" id="Radio2" value="2" <?php echo $atividade=='2'?'checked':''; ?>>
                <label class="form-check-label" for="Radio2"> Pouco Ativo </label>
                <small>(1-3 d/sem)</small> </div>
              <div class="form-check small">
                <input class="form-check-input" type="radio" name="atividade" id="Radio3" value="3" <?php echo $atividade=='3'?'checked':''; ?>>
                <label class="form-check-label" for="Radio3"> Ativo </label>
                <small>(3-5 d/sem)</small> </div>
              <div class="form-check small">
                <input class="form-check-input" type="radio" name="atividade" id="Radio4" value="4" <?php echo $atividade=='4'?'checked':''; ?>>
                <label class="form-check-label" for="Radio4"> Muito Ativo </label>
                <small>(6-7 d/sem)</small> </div>
            </div>
            <div class="col-md-6">
              <div class="row-form">
                <label class="control-label"><i class="fa fa-caret-down" aria-hidden="true"></i> Para perder</label>
                <input type="number" data-val="true" data-val-number="0" data-val-required="Preencha corretamente" id="emagrece" name="emagrece" placeholder="kg" class="form-control form-control-sm"/>
                <span class="field-validation-valid" data-valmsg-for="emagrece" data-valmsg-replace="true"></span> 
              </div>
              <div class="row-form">
                <label class="control-label"><i class="fa fa-caret-up" aria-hidden="true"></i> Para ganhar</label>
                <input type="number" data-val="true" data-val-number="0" data-val-required="Preencha corretamente" id="engorda" name="engorda" placeholder="kg" class="form-control form-control-sm"/>
                <span class="field-validation-valid" data-valmsg-for="engorda" data-valmsg-replace="true"></span> 
              </div>
              <span class="ajuda">(por semana)</span>
                <input type="hidden" id="total_c" name="total_c" value="<?php echo !empty($total_c)?$total_c:1; ?>">
                <input type="hidden" id="total_p" name="total_p" value="<?php echo !empty($total_p)?$total_p:1; ?>">
                <input type="hidden" id="total_l" name="total_l" value="<?php echo !empty($total_l)?$total_l:1; ?>">
            </div>
      </div>
            <div class="row">
              <div class="col-md-12">
                <button type="submit" class="btn btn-primary float-right"><i class="ion ion-ios-gear-outline"></i> Calcular</button>
              </div>
            </div>
          </form>
        </div>
      </div>
      <!-- /.card-body --> 
    </div>
    <!-- /.card --> 
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?php
  include 'footer.php'; // Fecha a div wrapper
?>