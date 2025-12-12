<?php
$postData = $userData = array();

// Get session data
$sessData = !empty($_SESSION['sessData'])?$_SESSION['sessData']:'';

// Get status message from session
if(!empty($sessData['status']['msg'])){
    $statusMsg = $sessData['status']['msg'];
    $statusMsgType = $sessData['status']['type'];
    unset($_SESSION['sessData']['status']);
}

// Get posted data from session
if(!empty($sessData['postData'])){
    $postData = $sessData['postData'];
    unset($_SESSION['sessData']['postData']);
}

// Get user data
if(!empty($_GET['id'])){
  include 'DB.class.php';
  $db = new DB();
  $conditions['where'] = array(
    'id' => $_GET['id'],
  );
  $conditions['return_type'] = 'single';
  $userData = $db->getRows('sadts', $conditions);
}

// Pre-filled data
$userData = !empty($postData)?$postData:$userData;

// Define action
$actionLabel = !empty($_GET['id'])?'Editar':'Adicionar';

include 'header.php';
?>
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
            <h1 class="m-0 text-dark">Adicionar/Editar SADT</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">SADT</li>
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
  <div class="col-md-12">
    <!-- Display status message -->
    <?php if(!empty($statusMsg) && ($statusMsgType == 'success')){ ?>
      <div class="callout callout-success"><?php echo $statusMsg; ?></div>
    <?php }elseif(!empty($statusMsg) && ($statusMsgType == 'error')){ ?>
      <div class="callout callout-danger"><?php echo $statusMsg; ?></div>
    <?php } ?>


<!-- Resultados Modal -->
<div class="modal fade" id="dutModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Diretriz de Utilização (DUT) - <span id="dut-id"></span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h6><div id="dut-titulo"></div></h6>
        <div id="dut-descricao"></div>
      </div>
      <div class="modal-footer">
        <div id="dut-biblio"></div>
      </div>
    </div>
  </div>
</div>
    <!-- Add/Edit form -->
    <div class="panel panel-default">
      <div class="panel-body">
        <form method="post" action="sadtAction.php" class="form">
          <div class="row">
            <fieldset class="col-lg-10">
              <div class="form-group">
                <label>Nome</label>
                <input type="text" class="form-control" id="nome_sadt" name="nome_paciente" value="<?php echo !empty($userData['nome_paciente'])?$userData['nome_paciente']:''; ?>">
              </div>
            </fieldset>
            <fieldset class="col-lg-2">
              <div class="form-group">
                <label>Diretriz de Utilização - DUT (ANS)</label>
                <div class="input-group mb-2">
                  <input type="number" class="form-control" id="search_dut" name="search_dut" aria-describedby="inputGroupFileAddon04" placeholder="Número">
                  <div class="input-group-append" id="dut_search">
                    <div class="input-group-text">Consultar</div>
                  </div>
                </div>
              </div>
            </fieldset>
          </div>

          <div class="row">
            <fieldset class="col-lg-6">
              <div class="form-group">
                <label>CID</label>
                <input type="text" class="form-control" name="cid" value="<?php echo !empty($userData['cid'])?$userData['cid']:'Z00.1 // Z76.3'; ?>">
              </div>
            </fieldset>
            <div class="col-lg-6">
              <fieldset>
                <div class="form-group">
                  <label>Conv&ecirc;nio</label>
                  <select class="form-control" name="plano">
                    <?php 
                    if (!class_exists('DB')) {
                      include 'DB.class.php';
                    }
                    $consulta = new DB();             
                    $convenios = $consulta->getConvenios();

                    for($x=0;$x<count($convenios);$x++){
                      echo '<option value="'. $convenios[$x]['id'].'"';
                      echo !empty($userData['plano']) && $userData['plano']==$convenios[$x]['id']?'selected':'';
                      echo '>'.$convenios[$x]['nome'].'</option>';
                    }
                    ?>              
                  </select>
                </div>
              </fieldset>
            </div><!-- fim .col-lg-6 -->
          </div><!-- fim .row -->           


          <div class="row">
            <div class="col-12 col-sm-12">
              <div class="card card-info card-tabs">
                <div class="card-header p-0 pt-1">
                  <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true"><i class="fa fa-search"></i> Buscar</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false"><i class="fa fa-star"></i> Favoritos</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="custom-tabs-one-messages-tab" data-toggle="pill" href="#custom-tabs-one-messages" role="tab" aria-controls="custom-tabs-one-messages" aria-selected="false"><i class="fas fa-comment-medical"></i> Especialidades</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="custom-tabs-one-settings-tab" data-toggle="pill" href="#custom-tabs-one-settings" role="tab" aria-controls="custom-tabs-one-settings" aria-selected="false"><i class="fas fa-x-ray"></i> Imagem</a>
                    </li>
                  </ul>
                </div>
                <div class="card-body">
                  <div class="tab-content" id="custom-tabs-one-tabContent">
                    <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                      <table border="0" width="100%">

                        <?php

                        if(!empty($userData['exames'])){
                          $exames=json_decode($userData['exames']);
                        } else {
                          $exames='';
                        }

                        if(!empty($userData['exames'])&&count(json_decode($userData['exames']))==1){
                          echo '<tr class="linhas">';
                          echo  '<td>';
                          echo    '<input type="text" class="form-control" id="exame" name="exames[]" value="'.$exames[0]->procedimento.'">';
                          echo  '</td>';
                          echo    '<td><a href="#" class="removerCampo" title="Remover linha"><span class="fas fa-minus"></span></td>';
                          echo '</tr>';
                        } elseif (!empty($userData['exames'])&&count(json_decode($userData['exames']))>1){
                          for($i=0;$i<count(json_decode($userData['exames']));$i++){
                            echo '<tr class="linhas">';
                            echo  '<td>';
                            echo    '<input type="text" class="form-control" id="exame" name="exames[]" value="'.$exames[$i]->procedimento.'">';
                            echo  '</td>';
                            echo    '<td><a href="#" class="removerCampo" title="Remover linha"><span class="fas fa-minus"></span></td>';
                            echo '</tr>';   
                          }
                        } elseif (empty($userData['exames'])){
                          echo '<tr class="linhas">';
                          echo  '<td>';
                          echo    '<input type="text" class="form-control" name="exames[]"  id="exame" value="">';
                          echo  '</td>';
                          echo    '<td><a href="#" class="removerCampo" title="Remover linha"><span class="fas fa-minus"></span></td>';
                          echo '</tr>'; 
                        } 
                        ?>

                        <tr> 
                          <td>&nbsp;</td>
                          <td width="5%"><a href="#" class="adicionarCampo" title="Adicionar item"><span class="fas fa-plus"></span></a></td>
                        </tr>
                      </table> 
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
                      <div class="row">
                        <fieldset class="col-lg-4">
                          <div class="form-group">
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" name="exames[]" value="40304361 - Hemograma Completo">
                              <label class="form-check-label">Hemograma Completo</label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" name="exames[]" value="40316270 - Ferritina">
                              <label class="form-check-label">Ferritina</label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" name="exames[]" value="40302040 - Glicemia">
                              <label class="form-check-label">Glicemia</label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" name="exames[]" value="40316521 - TSH">
                              <label class="form-check-label">TSH</label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" name="exames[]" value="40302830 - 25DIHIDROXI (Vitamina D3)">
                              <label class="form-check-label">25-DIHIDROXI (Vitamina D3)</label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" name="exames[]" value="40305015 - 1,25-DIHIDROXI (Vitamina D3)">
                              <label class="form-check-label">1,25-DIHIDROXI (Vitamina D3)</label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" name="exames[]" value="40311210 - Urina I (EAS)">
                              <label class="form-check-label">Urina I (EAS)</label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" name="exames[]" value="40310213 - Urocultura">
                              <label class="form-check-label">Urocultura</label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" name="exames[]" value="40303110 - Parasitol&oacute;gico nas fezes (3 amostras)">
                              <label class="form-check-label">PPF (3 amostras)</label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" name="exames[]" value="40306798 - Dengue (IgG e IgM)">
                              <label class="form-check-label">Dengue (IgG e IgM)</label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" name="exames[]" value="40302318 - Pot&aacute;ssio">
                              <label class="form-check-label">Pot&aacute;ssio</label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" name="exames[]" value="40302423 - S&oacute;dio">
                              <label class="form-check-label">S&oacute;dio</label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" name="exames[]" value="40301885 - Fosfatase alcalina">
                              <label class="form-check-label">Fosfatase alcalina</label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" name="exames[]" value="40503062 - Painel de 5 muta&ccedil;&otilde;es G6PD:Pesquisa muta&ccedil;&otilde;es G202A, C563T, A376G, G1376T/C e G1388A no gene G6PD.">
                              <label class="form-check-label">Painel de 5 muta&ccedil;&otilde;es G6PD</label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" name="exames[]" value="40304922 - Coagulograma">
                              <label class="form-check-label">Coagulograma</label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" name="exames[]" value="28059999 - MEGATESTE (DOSAGEM FSH,LH,TSH,PRL,HG,CORTISOL,T4 LIVRE E GLICOSE)">
                              <label class="form-check-label">MEGATESTE (*)</label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" name="exames[]" value="40316289 - Fol&iacute;culo estimulante, horm&ocirc;nio (FSH)">
                              <label class="form-check-label">FSH</label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" name="exames[]" value="40316246 - Estradiol">
                              <label class="form-check-label">Estradiol</label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" name="exames[]" value="40316335 - Horm&ocirc;nio luteinizante (LH)">
                              <label class="form-check-label">Horm&ocirc;nio luteinizante (LH)</label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" name="exames[]" value="40322483 - Relação proteina/creatinina Urinária">
                              <label class="form-check-label">Relação proteina/creatinina Urinária</label>
                            </div>


                            <label>LIPIDOGRAMA</label>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" name="exames[]" value="40302750 - Perfil lip&iacute;dico / lipidograma (colesterol (total e HDL), triglicer&iacute;dios)">
                              <label class="form-check-label">Perfil lip&iacute;dico</label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" name="exames[]" value="40316360 - Insulina">
                              <label class="form-check-label">Insulina</label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" name="exames[]" value="40302075 - Hemoglobina A1c">
                              <label class="form-check-label">Hemoglobina A1c</label>
                            </div>

                            <label>AVALIA&Ccedil;&Atilde;O DE CRESCIMENTO</label>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" name="exames[]" value="40316203 - Horm&ocirc;nio de Crescimento (HGH)">
                              <label class="form-check-label">Horm&ocirc;nio de Crescimento (HGH)</label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" name="exames[]" value="40316440 - Somatomedina C (IGF1)">
                              <label class="form-check-label">Somatomedina C (IGF1)</label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" name="exames[]" value="40305406 - IGF-BP3">
                              <label class="form-check-label">IGF-BP3</label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" name="exames[]" value="40316041 - ACTH">
                              <label class="form-check-label">ACTH</label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" name="exames[]" value="40316416 - Prolactina">
                              <label class="form-check-label">Prolactina</label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" name="exames[]" value="40316190 - Cortisol livre">
                              <label class="form-check-label">Cortisol livre</label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" name="exames[]" value="40305465 - Paratorm&ocirc;nio-PTH">
                              <label class="form-check-label">Paratorm&ocirc;nio-PTH</label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" name="exames[]" value="40301931 - F&oacute;sforo">
                              <label class="form-check-label">F&oacute;sforo</label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" name="exames[]" value="40302237 - Magn&eacute;sio">
                              <label class="form-check-label">Magn&eacute;sio</label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" name="exames[]" value="40301400 - C&aacute;lcio">
                              <label class="form-check-label">C&aacute;lcio</label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" name="exames[]" value="40301419 - C&aacute;lcio i&ocirc;nico">
                              <label class="form-check-label">C&aacute;lcio i&ocirc;nico</label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" name="exames[]" value="40803139 - Rx-M&atilde;os e punhos para idade &oacute;ssea">
                              <label class="form-check-label">Rx-M&atilde;os e punhos para idade &oacute;ssea</label>
                            </div>
                          </fieldset>
                          <div class="col-lg-4">
                            <fieldset>
                              <label>INVESTIGA&Ccedil;&Atilde;O DE TIREÓIDE</label>
                              <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="exames[]" value="40316084 - Anticorpos Anti-receptores de TSH (tamb&eacute;m chamado TRAb)">
                                <label class="form-check-label">Anticorpos Anti-receptores de TSH (TRAb)</label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="exames[]" value="40316157 - Anticorpos Anti-tireoperoxidase (anticorpo anti-TPO)">
                                <label class="form-check-label">Anticorpos Anti-tireoperoxidase (anti-TPO)</label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="exames[]" value="40316106 - Anticorpos Anti-tireoglobulina (Anti-Tg)">
                                <label class="form-check-label">Anticorpos Anti-tireoglobulina</label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="exames[]" value="40316530 - Tireoglobulina">
                                <label class="form-check-label">Tireoglobulina</label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="exames[]" value="40316483 - T3 Reverso">
                                <label class="form-check-label">T3 Reverso</label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="exames[]" value="40703037 - Cintilografia da Tireoide Tecn&eacute;cio(99MTc)">
                                <label class="form-check-label">Cintilografia da Tire&oacute;ide</label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="exames[]" value="40316521 - Tireoestimulante (TSH)">
                                <label class="form-check-label">TSH</label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="exames[]" value="40316491 - T4 Livre">
                                <label class="form-check-label">T4 Livre</label>
                              </div>

                              <label>DOEN&Ccedil;A REUM&Aacute;TICA</label>
                              <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="exames[]" value="40306860 - Fator reumat&oacute;ide, quantitativo">
                                <label class="form-check-label">Fator Reumat&oacute;ide</label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="exames[]" value="40312127 - Perfil reumatol&oacute;gico (&aacute;cido úrico, eletroforese de prote&iacute;nas, FAN, VHS, Prova do l&aacute;tex P/F. R, W. Rose)">
                                <label class="form-check-label">Perfil Reumatol&oacute;gico</label>
                              </div>

                              <small id="passwordHelpBlock" class="form-text text-muted">Posteriormente, se positivos... prosseguir com:</small>
                              <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="exames[]" value="40804054 - RAIO X-JOELHO (bilateral)">
                                <label class="form-check-label">Rx joelho (bilateral)</label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="exames[]" value="40804070 - RAIO X-PRE TIBIAL (bilateral)">
                                <label class="form-check-label">Rx pr&eacute;-tibial (bilateral)</label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="exames[]" value="40304370 - HEMOSSEDIMENTACAO, (VHS)">
                                <label class="form-check-label">VHS</label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="exames[]" value="40308391 - PROTEINA C REATIVA">
                                <label class="form-check-label">Prote&iacute;na C Reativa</label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="exames[]" value="40306127 - ANTI-SM">
                                <label class="form-check-label">Anti-SM</label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="exames[]" value="40306747 - COMPLEMENTO CH-50">
                                <label class="form-check-label">CH50</label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="exames[]" value="40306704 - COMPLEMENTO C3">
                                <label class="form-check-label">Complemento C3</label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="exames[]" value="40306712 - COMPLEMENTO C4">
                                <label class="form-check-label">Complemento C4</label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="exames[]" value="40304108 - COOMBS DIRETO">
                                <label class="form-check-label">Coombs direto</label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="exames[]" value="40306143 - ANTICARDIOLIPINA - IGG">
                                <label class="form-check-label">Anticardiolipina - IgG</label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="exames[]" value="40306151 - ANTICARDIOLIPINA - IGM">
                                <label class="form-check-label">Anticardiolipina - IgM</label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="exames[]" value="40304019 - ANTICOAGULANTE LUPICO">
                                <label class="form-check-label">Anticoagulante Lúpico</label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="exames[]" value="40301729 - DESIDROGENASE LACTICA">
                                <label class="form-check-label">LDH</label>
                              </div>
                            </fieldset>
                          </div><!-- fim .col-lg-6 -->
                          <div class="col-lg-4">
                            <fieldset>
                              <label>INVESTIGA&Ccedil;&Atilde;O AL&Eacute;RGICA</label>
                              <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="exames[]" value="40307271 - IgE total">
                                <label class="form-check-label">IgE total</label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="exames[]" value="40307255 - IgE, grupo espec&iacute;fico, (MX1, HX2, EX1, GX2)">
                                <label class="form-check-label">IgE, grupo espec&iacute;fico, (MX1, HX2, EX1, GX2)</label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="exames[]" value="40307263 - IgE, por al&eacute;rgeno (F76, F77, F78, F79, F232)">
                                <label class="form-check-label">IgE, por al&eacute;rgeno (F76, F77, F78, F79, F232)</label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="exames[]" value="40302164 - Lactose, teste de toler&acirc;ncia">
                                <label class="form-check-label">Lactose, teste de toler&acirc;ncia</label>
                              </div>

                              <label>G6PD</label>
                              <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="exames[]" value="40304817 - Enzimas eritrocit&aacute;rias, rastreio para defici&ecirc;ncia (pesquisa da Atividade da G6PD no eritr&oacute;cito)">
                                <label class="form-check-label">Enzimas eritrocit&aacute;rias (Atividade da G6PD no eritr&oacute;cito)</label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="exames[]" value="40302059 - Glicose-6-fosfato deidrogenase (G6FD) - pesquisa e/ou dosagem">
                                <label class="form-check-label">Glicose-6-fosfato deidrogenase (G6FD)</label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="exames[]" value="40301648 - Creatino fosfoquinase total (CK) - pesquisa e/ou dosagem">
                                <label class="form-check-label">Creatino fosfoquinase total (CK)</label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="exames[]" value="40503216 - S&iacute;ndromes de defici&ecirc;ncia intelectual associada à anomalia cong&ecirc;nita n&atilde;o reconhecida clinicamente">
                                <label class="form-check-label">S&iacute;ndromes de defici&ecirc;ncia intelectual associada à anomalia cong&ecirc;nita n&atilde;o reconhecida clinicamente</label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="exames[]" value="40501051 - Cari&oacute;tipo com banda G">
                                <label class="form-check-label">Cari&oacute;tipo com banda G</label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="exames[]" value="40314235 - X-fr&aacute;gil, S&iacute;ndrome de ataxia, Fal&ecirc;ncia ovariana - gene FMR1">
                                <label class="form-check-label">X-fr&aacute;gil, S&iacute;ndrome de ataxia, Fal&ecirc;ncia ovariana - gene FMR1</label>
                              </div>
                              <label>COPROLÓGICO</label>
                              <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="exames[]" value="40303012 - Alfa-1-antitripsina, (fezes)">
                                <label class="form-check-label">Alfa-1-antitripsina, (fezes)</label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="exames[]" value="40303039 - COPROLOGICO FUNCIONAL (caracteres, pH, digestibilidade, am&ocirc;nia, &aacute;c org&acirc;nicos e interpreta&ccedil;&atilde;o)">
                                <label class="form-check-label">COPROLOGICO FUNCIONAL</label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="exames[]" value="40303136 - Sangue Oculto nas Fezes">
                                <label class="form-check-label">Sangue Oculto nas Fezes</label>
                              </div>

                              <label>FUN&Ccedil;&Atilde;O HEP&Aacute;TICA</label>
                              <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="exames[]" value="40312151 - Fun&ccedil;&atilde;o hep&aacute;tica (bilirrubinas, eletrof. de prote&iacute;nas, FA, TGO, TGP e GGT)">
                                <label class="form-check-label">Fun&ccedil;&atilde;o hep&aacute;tica (bilirrubinas, eletrof. de prote&iacute;nas, FA, TGO, TGP e GGT)</label>
                              </div>            
                            </fieldset>
                          </div>
                        </div>
                        <div class="row">
                          <fieldset>
                            <label>DOEN&Ccedil;A CELÍACA</label>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" name="exames[]" value="40308553 - ANTI-Transglutaminase Tecidual (TG2)- IGA">
                              <label class="form-check-label">ANTI-Transglutaminase Tecidual (TG2)- IGA</label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" name="exames[]" value="40306259 - Anticorpos antiendomisio - IgG, IgM, IgA">
                              <label class="form-check-label">Anticorpos antiendomisio - IgG, IgM, IgA (cada)</label><small id="passwordHelpBlock" class="form-text text-muted">Solicitar se o TG2 for (+)</small>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" name="exames[]" value="40306305 - Antigliadina (glúten) - IgA">
                              <label class="form-check-label">Antigliadina (glúten) - IgA</label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" name="exames[]" value="40306313 - Antigliadina (glúten) - IgG">
                              <label class="form-check-label">Antigliadina (glúten) - IgG</label>
                            </div>
                            <small id="passwordHelpBlock" class="form-text text-muted"><b>PUBERDADE PRECOCE</b><br>
                              A administra&ccedil;&atilde;o intravenosa de horm&ocirc;nio liberador de gonadotropinas (teste de est&iacute;mulo com GnRH) ou um agonista de GnRH (teste de est&iacute;mulo com leuprolida) &eacute; uma ferramenta diagn&oacute;stica útil, particularmente para meninos, nos quais uma resposta “púbere” de LH (pico de LH > 5 unidades internacionais/litro) com predomin&acirc;ncia de LH sobre o horm&ocirc;nio fol&iacute;culo-estimulante (FSH) tende a ocorrer precocemente durante o curso da puberdade precoce. Em meninas com precocidade sexual, entretanto, a secre&ccedil;&atilde;o noturna de LH e a resposta do LH ao GnRH ou ao agonista de GnRH pode ser bastante baixa nos est&aacute;gios mam&aacute;rios iniciais II a III (pico de LH imunom&eacute;trico < 5 unidades internacionais/litro), e a rela&ccedil;&atilde;o LH:FSH pode permanecer baixa at&eacute; o meio da puberdade. Nestas meninas com “baixa” resposta do LH, a natureza central da precocidade sexual pode ser comprovada pela detec&ccedil;&atilde;o de n&iacute;veis púberes de estradiol (> 50 pg/mL), 20 a 24 horas ap&oacute;s o est&iacute;mulo com leuprolida.</small>
                              <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="exames[]" value="28059913 - TESTE DE ESTIMULO DO HORMONIO DO CRESCIMENTO (GH) APOS CLONIDINA OU ATESINA">
                                <label class="form-check-label">TESTE DE ESTIMULO DO HORMONIO DO CRESCIMENTO (GH) APOS CLONIDINA OU ATESINA</label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="exames[]" value="28059930 - TESTE DE ESTIMULO DE TSH APOS TRH">
                                <label class="form-check-label">TESTE DE ESTIMULO DE TSH APOS TRH</label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="exames[]" value="28059948 - TESTE DE ESTIMULO DE PROLACTINA APOS TRH">
                                <label class="form-check-label">TESTE DE ESTIMULO DE PROLACTINA APOS TRH</label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="exames[]" value="28059956 - TESTE DE ESTIMULO DE FSH E LH APOS LHRH">
                                <label class="form-check-label">TESTE DE ESTIMULO DE FSH E LH APOS LHRH</label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="exames[]" value="28059972 - TESTE DE SUPRESSAO DO HORMONIO DO CRESCIMENTO (GH) APOS GLICOSE">
                                <label class="form-check-label">TESTE DE SUPRESSAO DO HORMONIO DO CRESCIMENTO (GH) APOS GLICOSE</label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="exames[]" value="28059980 - TESTE DE ESTIMULO DO HORMONIO DO CRESCIMENTO (GH) APOS INSULINA">
                                <label class="form-check-label">TESTE DE ESTIMULO DO HORMONIO DO CRESCIMENTO (GH) APOS INSULINA</label>
                              </div>
                              <small id="passwordHelpBlock" class="form-text text-muted">A observa&ccedil;&atilde;o de que as c&eacute;lulas gonadotr&oacute;picas hipofis&aacute;rias necessitam de estimula&ccedil;&atilde;o puls&aacute;til em vez de cont&iacute;nua pelo GnRH para manter a libera&ccedil;&atilde;o cont&iacute;nua de gonadotropinas fornece a raz&atilde;o para a utiliza&ccedil;&atilde;o de agonistas de GnRH para o tratamento de puberdade precoce central. Em virtude de serem mais potentes e com maior dura&ccedil;&atilde;o de a&ccedil;&atilde;o do que o GnRH nativo, estes agonistas de GnRH (ap&oacute;s um breve per&iacute;odo de estimula&ccedil;&atilde;o) “dessensibilizam” as c&eacute;lulas gonadotr&oacute;picas da hip&oacute;fise contra o efeito estimulat&oacute;rio do GnRH end&oacute;geno e interrompem efetivamente a progress&atilde;o da precocidade sexual central.
                              </small> 
                            </fieldset>   
                          </div><!-- fim .row -->
                        </div>
                        <div class="tab-pane fade" id="custom-tabs-one-messages" role="tabpanel" aria-labelledby="custom-tabs-one-messages-tab">
                          <div class="row">
                            <fieldset class="col-lg-6">
                              <label>AUXÍLIO T&Eacute;CNICO</label>
                              <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="exames[]" value="50000616 - SESSAO INDIVIDUAL AMBULATORIAL DE FONOAUDIOLOGIA">
                                <label class="form-check-label">SESSAO INDIVIDUAL AMBULATORIAL DE FONOAUDIOLOGIA</label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="exames[]" value="50000560 - CONSULTA AMBULATORIAL POR NUTRICIONISTA-DUT 103">
                                <label class="form-check-label">CONSULTA AMBULATORIAL POR NUTRICIONISTA</label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="exames[]" value="50000470 - SESSAO DE PSICOTERAPIA INDIVIDUAL POR PSICOLOGO-DUT 108">
                                <label class="form-check-label">SESSAO DE PSICOTERAPIA INDIVIDUAL POR PSICOLOGO</label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="exames[]" value="90000034 - Avalia&ccedil;&atilde;o Psicopedag&oacute;gica">
                                <label class="form-check-label">Avalia&ccedil;&atilde;o Psicopedag&oacute;gica</label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="exames[]" value="50000080 - SESSAO INDIVIDUAL AMBULATORIAL EM TERAPIA OCUPACIONAL-DUT 107">
                                <label class="form-check-label">SESSAO INDIVIDUAL AMBULATORIAL EM TERAPIA OCUPACIONAL</label>
                              </div>

                              <label>FISIOTERAPIA</label>
                              <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="exames[]" value="20103310 - Les&atilde;o nervosa perif&eacute;rica afetando mais de um nervo com altera&ccedil;&otilde;es sensitivas e/ou motoras">
                                <label class="form-check-label">Les&atilde;o nervosa perif&eacute;rica afetando mais de um nervo com altera&ccedil;&otilde;es sensitivas e/ou motoras</label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="exames[]" value="20103182 - Desvios posturais da coluna vertebral">
                                <label class="form-check-label">Desvios posturais da coluna vertebral</label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="exames[]" value="20103220 - Doen&ccedil;as pulmonares atendidas em ambulat&oacute;rio">
                                <label class="form-check-label">Doen&ccedil;as pulmonares atendidas em ambulat&oacute;rio</label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="exames[]" value="20103255 - Exerc&iacute;cios para reabilita&ccedil;&atilde;o do asm&aacute;tico (ERAI) - por sess&atilde;o individual">
                                <label class="form-check-label">Exerc&iacute;cios para reabilita&ccedil;&atilde;o do asm&aacute;tico (ERAI)(sess&atilde;o)</label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="exames[]" value="20103301 - Infiltra&ccedil;&atilde;o de ponto gatilho (por músculo) ou agulhamento seco (por músculo)">
                                <label class="form-check-label">Infiltra&ccedil;&atilde;o de ponto gatilho (por músculo) ou agulhamento seco</label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="exames[]" value="20103425 - Paralisia cerebral">
                                <label class="form-check-label">Paralisia cerebral</label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="exames[]" value="20103433 - Paralisia cerebral com distúrbio de comunica&ccedil;&atilde;o">
                                <label class="form-check-label">Paralisia cerebral com distúrbio de comunica&ccedil;&atilde;o</label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="exames[]" value="20103476 - Patologia neurol&oacute;gica com depend&ecirc;ncia de atividades da vida di&aacute;ria">
                                <label class="form-check-label">Patologia neurol&oacute;gica com depend&ecirc;ncia de atividades da vida di&aacute;ria</label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="exames[]" value="20103484 - Patologia osteomioarticular em um membro">
                                <label class="form-check-label">Patologia osteomioarticular em um membro</label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="exames[]" value="20103611 - Queimados - seguimento ambulatorial para preven&ccedil;&atilde;o de seqüelas (por segmento)">
                                <label class="form-check-label">Queimados - preven&ccedil;&atilde;o de seqüelas</label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="exames[]" value="20103654 - Recupera&ccedil;&atilde;o funcional de distúrbios cr&acirc;nio-faciais">
                                <label class="form-check-label">Recupera&ccedil;&atilde;o funcional de distúrbios cr&acirc;nio-faciais</label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="exames[]" value="20103689 - Atraso do desenvolvimento psicomotor">
                                <label class="form-check-label">Atraso do desenvolvimento psicomotor</label>
                              </div>
                            </fieldset>
                            <div class="col-lg-6">
                              <fieldset>

                                <label>TESTE DA ORELHINHA</label>
                                <div class="form-check">
                                  <input class="form-check-input" type="checkbox" name="exames[]" value="40103463 - Otoemiss&otilde;es evocadas transientes">
                                  <label class="form-check-label">Otoemiss&otilde;es evocadas transientes</label>
                                </div>
                                <div class="form-check">
                                  <input class="form-check-input" type="checkbox" name="exames[]" value="40103064 - Audiometria de tronco cerebral (PEA) BERA">
                                  <label class="form-check-label">Audiometria de tronco cerebral (PEA) BERA</label>
                                </div>
                                <div class="form-check">
                                  <input class="form-check-input" type="checkbox" name="exames[]" value="40103080 - Audiometria tonal limiar infantil condicionada (qualquer t&eacute;cnica) - Peep-show at&eacute; 3anos">
                                  <label class="form-check-label">Audiometria tonal limiar infantil condicionada - Peep-show at&eacute; 3anos</label>
                                </div>
                                <div class="form-check">
                                  <input class="form-check-input" type="checkbox" name="exames[]" value="40103072 - Audiometria tonal limiar com testes de discrimina&ccedil;&atilde;o">
                                  <label class="form-check-label">Audiometria tonal (limiar de discrimina&ccedil;&atilde;o)</label>
                                </div>
                                <div class="form-check">
                                  <input class="form-check-input" type="checkbox" name="exames[]" value="40103099 - Audiometria vocal - pesquisa de limiar de discrimina&ccedil;&atilde;o">
                                  <label class="form-check-label">Audiometria vocal (limiar de discrimina&ccedil;&atilde;o)</label>
                                </div>
                                <div class="form-check">
                                  <input class="form-check-input" type="checkbox" name="exames[]" value="40103102 - Audiometria vocal - pesquisa de limiar de inteligibilidade">
                                  <label class="form-check-label">Audiometria vocal (limiar de inteligibilidad</label>
                                </div>
                                <div class="form-check">
                                  <input class="form-check-input" type="checkbox" name="exames[]" value="40103439 - Impedanciometria">
                                  <label class="form-check-label">Impedanciometria</label>
                                </div>
                                <div class="form-check">
                                  <input class="form-check-input" type="checkbox" name="exames[]" value="40103897 - Processamento auditivo central">
                                  <label class="form-check-label">Processamento auditivo central</label>
                                </div>

                                <label>ECOCARDIOGRAMA:</label>
                                <div class="form-check">
                                  <input class="form-check-input" type="checkbox" name="exames[]" value="40901106 - Ecocardiograma bi-doppler">
                                  <label class="form-check-label">Ecocardiograma bi-doppler</label>
                                </div>
                                <div class="form-check">
                                  <input class="form-check-input" type="checkbox" name="exames[]" value="40101010 - ECG com laudo">
                                  <label class="form-check-label">ECG com laudo</label>
                                </div>
                                <div class="form-check">
                                  <input class="form-check-input" type="checkbox" name="exames[]" value="40103170 - EEG de rotina">
                                  <label class="form-check-label">EEG de rotina</label>
                                </div>
                              </fieldset>
                            </div><!-- fim .col-lg-6 -->
                          </div><!-- fim .row -->
                        </div>
                        <div class="tab-pane fade" id="custom-tabs-one-settings" role="tabpanel" aria-labelledby="custom-tabs-one-settings-tab">
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="exames[]" value="41001010 - TC-CRANIO OU SELA TURCICA OU ORBITAS">
                            <label class="form-check-label">41001010 - TC-CRANIO OU SELA TURCICA OU ORBITAS</label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="exames[]" value="41101014 - RM-CRANIO (ENCEFALO)">
                            <label class="form-check-label">41101014 - RM-CRANIO (ENCEFALO)</label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="exames[]" value="31602282 - Anestesia para exames de ressonância magnética">
                            <label class="form-check-label">31602282 - Anestesia para exames de ressonância magnética</label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="exames[]" value="40805026 - RX-T&oacute;rax(AP e PERFIL)">
                            <label class="form-check-label">RX-T&oacute;rax (2)</label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="exames[]" value="40202038 - Endoscopia digestiva alta com bi&oacute;psia e/ou citologia">
                            <label class="form-check-label">Endoscopia digestiva alta</label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="exames[]" value="40806081 - RX-Enema opaco (duplo contraste)">
                            <label class="form-check-label">Enema opaco</label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="exames[]" value="40801128 - RX de Cavum (boca aberta e fechada)">
                            <label class="form-check-label">RX de Cavum</label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="exames[]" value="40801063 - RX Seios da face (fronto-naso e mento-naso)">
                            <label class="form-check-label">Rx Seios da face</label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="exames[]" value="40901122 - USG Abdome total">
                            <label class="form-check-label">USG Abdome total</label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="exames[]" value="40901181 - USG Pelve feminina">
                            <label class="form-check-label">USG Pelve feminina</label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="exames[]" value="40801071 - RX-Sela túrcica">
                            <label class="form-check-label">RX-Sela túrcica</label>
                          </div>

                          <label>URETROCISTOGRAFIA MICCIONAL</label>
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="exames[]" value="40807061 - RX- Uretrocistografia de crian&ccedil;a">
                            <label class="form-check-label">Uretrocistografia de crian&ccedil;a</label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="exames[]" value="40704017 - Cintilografia renal din&acirc;mica">
                            <label class="form-check-label">Cintilografia renal din&acirc;mica</label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="exames[]" value="40704025 - Cintilografia renal din&acirc;mica com diur&eacute;tico">
                            <label class="form-check-label">Cintilografia renal din&acirc;mica com diur&eacute;tico</label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="exames[]" value="40704033 - Cintilografia renal est&aacute;tica (quantitativa ou qualitativa)">
                            <label class="form-check-label">Cintilografia renal est&aacute;tica</label>
                          </div>

                          <label>US-TRANS-FONTANELA</label>
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="exames[]" value="40901351 - Doppler colorido transfontanela">
                            <label class="form-check-label">US transfontanela</label>
                          </div>

                          <b>PESQUISA DE REFLUXO</b>
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="exames[]" value="40806057 - RX-Es&ocirc;fago-est&ocirc;mago-duodeno contrastado (EED)">
                            <label class="form-check-label">RX-Es&ocirc;fago-est&ocirc;mago-duodeno contrastado (REED)</label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="exames[]" value="40806022 - RX - Videodeglutograma">
                            <label class="form-check-label">RX - Videodeglutograma</label>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- /.card -->
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label>Data</label>
                <input type="date" class="form-control" name="created" value="<?php echo !empty($userData['created'])?date('Y-m-d', strtotime($userData['created'])):date('Y-m-d'); ?>">
              </div>
              <input type="hidden" name="id" value="<?php echo !empty($userData['id'])?$userData['id']:''; ?>">
              <button type="submit" name="userSubmit" class="btn btn-success" /><i class="fad fa-save"></i> Salvar</button>
            </form>
          </div>
        </div>
      </div>
    </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?php
	include 'footer.php'; // Fecha a div wrapper
?>