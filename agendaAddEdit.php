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
  $userData = $db->getRows('agendas', $conditions);
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
            <h1 class="m-0 text-dark">Agendamentos</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Agendamentos</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
      <!-- Display status message -->
      <?php if(!empty($statusMsg) && ($statusMsgType == 'success')){ ?>
      <div class="callout callout-success"><?php echo $statusMsg; ?></div>
      <?php }elseif(!empty($statusMsg) && ($statusMsgType == 'error')){ ?>
      <div class="callout callout-danger"><?php echo $statusMsg; ?></div>
      <?php } ?>
      
      <!-- Add/Edit form -->
      <div class="panel panel-default">
        <div class="panel-heading"><a href="agendaIndex.php" class="float-right"><i class="fad fa-backward"></i> Voltar</a></div>
        <div class="panel-body">
          <form method="post" action="agendaAction.php" class="form">
            <div class="form-group">
              <label>Nome_paciente</label>
              <input type="text" class="form-control" name="nome_paciente" value="<?php echo !empty($userData['nome_paciente'])?$userData['nome_paciente']:''; ?>">
            </div>
            <div class="form-group">
              <label>local_atendimento</label>
              <input type="text" class="form-control" name="local_atendimento" value="<?php echo !empty($userData['local_atendimento'])?$userData['local_atendimento']:''; ?>">
            </div>
            <div class="form-group">
              <label>Data</label>
              <input type="date" class="form-control" name="data" value="<?php echo !empty($userData['data'])?$userData['data']:''; ?>">
            </div>
            <div class="form-group">
              <label>id_paciente</label>
              <input type="text" class="form-control" name="id_paciente" value="<?php echo !empty($userData['id_paciente'])?$userData['id_paciente']:''; ?>">
            </div>
            <div class="form-group">
              <label>tipo (retorno ou não)</label>
              <input type="text" class="form-control" name="tipo" value="<?php echo !empty($userData['tipo'])?$userData['tipo']:'0'; ?>">
            </div>
            <div class="form-group">
              <label>id_convenio</label>
              <input type="text" class="form-control" name="id_convenio" value="<?php echo !empty($userData['id_convenio'])?$userData['id_convenio']:''; ?>">
            </div>
            <div class="form-group">
              <label>hora_consulta</label>
              <input type="text" class="form-control" name="hora_consulta" value="<?php echo !empty($userData['hora_consulta'])?$userData['hora_consulta']:''; ?>">
            </div>
            <div class="form-group">
              <label>Hora_atendimento</label>
              <input type="text" class="form-control" name="hora_atendimento" value="<?php echo !empty($userData['hora_atendimento'])?$userData['hora_atendimento']:$userData['hora_consulta']; ?>">
            </div>
            <div class="form-group">
              <label>pontualidade (s)</label>
              <input type="text" class="form-control" name="pontualidade" value="<?php echo !empty($userData['pontualidade'])?$userData['pontualidade']:(strtotime($userData['hora_atendimento'])-strtotime($userData['hora_consulta'])); ?>">
            </div>
            <div class="form-group">
              <label>valor_pago</label>
              <input type="text" class="form-control" name="valor_pago" value="<?php echo !empty($userData['valor_pago'])?$userData['valor_pago']:''; ?>">
            </div>
            <div class="form-group">
              <label>desconto</label>
              <input type="text" class="form-control" name="desconto" value="<?php echo !empty($userData['desconto'])?$userData['desconto']:''; ?>">
            </div>
            <div class="form-group">
              <label>data_pagamento</label>
              <input type="text" class="form-control" name="data_pagamento" value="<?php echo !empty($userData['data_pagamento'])?$userData['data_pagamento']:''; ?>">
            </div>
            <input type="hidden" name="id" value="<?php echo !empty($userData['id'])?$userData['id']:''; ?>">
            <button type="submit" name="userSubmit" class="btn btn-success" /><i class="fad fa-save"></i> Salvar</button>
          </form>
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