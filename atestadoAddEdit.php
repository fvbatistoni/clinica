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
  $userData = $db->getRows('atestados', $conditions);
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
            <h1 class="m-0 text-dark">Adicionar/Editar Atestado</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Atestados</li>
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

      <!-- Add/Edit form -->
      <div class="panel panel-default">
        <div class="panel-body">
          <form method="post" action="atestadoAction.php" class="form">
            <div class="form-group">
              <label>Nome</label>
              <input type="text" class="form-control" id="nome_atestado" name="nome_paciente" value="<?php echo !empty($userData['nome_paciente'])?$userData['nome_paciente']:''; ?>">
            </div>
            <div class="form-group">
              <label>Compareceu nesta unidade para:</label>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="beneficiario" id="beneficiario1" value=1 <?php echo !empty($userData['beneficiario'])&&$userData['beneficiario']==1?'checked':'';?>>
                <label class="form-check-label" for="beneficiario1">
                  Consultar
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="beneficiario" id="beneficiario2" value=2 <?php echo !empty($userData['beneficiario'])&&$userData['beneficiario']==2?'checked':'';?>>
                <label class="form-check-label" for="beneficiario2">
                  Acompanhar Familiar
                </label>
                <input type="text" name="beneficiario_complemento" value="<?php echo !empty($userData['beneficiario_complemento'])?$userData['beneficiario_complemento']:'Filho menor de idade'; ?>" />
              </div>
            </div>
            <div class="form-group">
              <label>PORTANTO, comunicamos que:</label>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="motivo" id="motivo1" value=1 <?php echo !empty($userData['motivo'])&&$userData['motivo']==1?'checked':'';?>>
                <label class="form-check-label" for="motivo1">
                  Nada apresenta que o impossibilite ao
                </label>
                <input type="text" id="motivo_1" name="motivo_complemento" value="<?php echo !empty($userData['motivo_complemento'])?$userData['motivo_complemento']:''; ?>" placeholder="TRABALHO/ESCOLA">
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="motivo" id="motivo2" value=2 <?php echo !empty($userData['motivo'])&&$userData['motivo']==2?'checked':'';?>>
                <label class="form-check-label" for="motivo2">
                  Deverá permanecer em repouso no horário
                </label>
                <input type="text" id="motivo_2" name="motivo_complemento" value="<?php echo !empty($userData['motivo_complemento'])?$userData['motivo_complemento']:''; ?>" placeholder="00:00 as 00:00">
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="motivo" id="motivo3" value=3 <?php echo !empty($userData['motivo'])&&$userData['motivo']==3?'checked':'';?>>
                <label class="form-check-label" for="motivo3">
                  Deverá permanecer em repouso no período da MANHÃ
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="motivo" id="motivo4" value=4 <?php echo !empty($userData['motivo'])&&$userData['motivo']==4?'checked':'';?>>
                <label class="form-check-label" for="motivo4">
                  Deverá permanecer em repouso no período da TARDE
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="motivo" id="motivo5" value=5 <?php echo !empty($userData['motivo'])&&$userData['motivo']==5?'checked':'';?>>
                <label class="form-check-label" for="motivo5">
                  Deverá permanecer em repouso no dia de hoje
                </label>
              </div>              
              <div class="form-check">
                <input class="form-check-input" type="radio" name="motivo" id="motivo6" value=6 <?php echo !empty($userData['motivo'])&&$userData['motivo']==6?'checked':'';?>>
                <label class="form-check-label" for="motivo6">
                  Deverá permanecer em repouso no período de
                </label>
                <input type="text" id="motivo_6" name="motivo_complemento" value="<?php echo !empty($userData['motivo_complemento'])?$userData['motivo_complemento']:''; ?>" placeholder="-- DIAS">
              </div>
            </div>
              <div class="form-group">
                <label>CID</label>
                <input type="text" class="form-control" name="cid" value="<?php echo !empty($userData['cid'])?$userData['cid']:'Z00.1 // Z76.1'; ?>">
              </div>            
              <div class="form-group">
                <label>Data</label>
                <input type="date" class="form-control" name="created" value="<?php echo !empty($userData['created'])?date('Y-m-d', strtotime($userData['created'])):date('Y-m-d'); ?>">
              </div>
              <div class="form-group">
                <label>Observações</label>
                <input type="text" class="form-control" name="observacoes" value="<?php echo !empty($userData['observacoes'])?$userData['observacoes']:''; ?>">
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