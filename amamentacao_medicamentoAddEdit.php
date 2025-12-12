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
  $userData = $db->getRows('amamentacao_medicamentos', $conditions);
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
            <h1 class="m-0 text-dark">Medicamentos</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Amamentação</li>
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
        <div class="panel-heading"><a href="amamentacao_medicamentoIndex.php" class="float-right"><i class="fad fa-backward"></i> Voltar</a></div>
        <div class="panel-body">
          <form method="post" action="amamentacao_medicamentoAction.php" class="form">
            <div class="form-group">
              <label>Nome</label>
              <input type="text" class="form-control" name="nome" value="<?php echo !empty($userData['nome'])?$userData['nome']:''; ?>">
            </div>
            <div class="form-group">
              <label>Status</label>
              <input type="text" class="form-control" name="stat" value="<?php echo !empty($userData['stat'])?$userData['stat']:''; ?>">
            </div>
            <div class="form-group">
              <label>Info</label>
              <textarea class="textarea" name="info"><?php echo !empty($userData['info'])?$userData['info']:''; ?></textarea>
            </div>
            <div class="form-group">
              <label>Sub1</label>
              <input type="text" class="form-control" name="sub1" value="<?php echo !empty($userData['sub1'])?$userData['sub1']:''; ?>">
            </div>
            <div class="form-group">
              <label>Sub2</label>
              <input type="text" class="form-control" name="sub2" value="<?php echo !empty($userData['sub2'])?$userData['sub2']:''; ?>">
            </div>
            <div class="form-group">
              <label>Sub3</label>
              <input type="text" class="form-control" name="sub3" value="<?php echo !empty($userData['sub3'])?$userData['sub3']:''; ?>">
            </div>
            <div class="form-group">
              <label>Sub4</label>
              <input type="text" class="form-control" name="sub4" value="<?php echo !empty($userData['sub4'])?$userData['sub4']:''; ?>">
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