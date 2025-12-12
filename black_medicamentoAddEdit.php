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
  $userData = $db->getRows('black_medicamentos', $conditions);
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
            <h1 class="m-0 text-dark">Cadastrar/Editar Medicamento</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Black Book</li>
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
        <div class="panel-heading"><a href="black_medicamentoIndex.php" class="float-right"><i class="fad fa-backward"></i> Voltar</a></div>
        <div class="panel-body">
          <form method="post" action="black_medicamentoAction.php" class="form">
            <div class="form-group">
              <label>Sub1</label>
              <input type="text" class="form-control" name="sub1" value="<?php echo !empty($userData['sub1'])?$userData['sub1']:''; ?>">
            </div>
            <div class="form-group">
              <label>Sub2</label>
              <input type="text" class="form-control" name="sub2" value="<?php echo !empty($userData['sub2'])?$userData['sub2']:''; ?>">
            </div>
            <div class="form-group">
              <label>Farmaco</label>
              <input type="text" class="form-control" name="farmaco" value="<?php echo !empty($userData['farmaco'])?$userData['farmaco']:''; ?>">
            </div>
            <div class="form-group">
              <label>Farmaco_Info</label>
              <textarea class="textarea" name="farmaco_info"><?php echo !empty($userData['farmaco_info'])?$userData['farmaco_info']:''; ?></textarea>
            </div>
            <div class="form-group">
              <label>Nome Comercial</label>
              <textarea class="textarea" name="nome_comercial"><?php echo !empty($userData['nome_comercial'])?$userData['nome_comercial']:''; ?></textarea>
            </div>
            <div class="form-group">
              <label>Dose</label>
              <textarea class="textarea" name="dose"><?php echo !empty($userData['dose'])?$userData['dose']:''; ?></textarea>
            </div>
            <div class="form-group">
              <label>Colaterais</label>
              <textarea class="textarea" name="colaterais"><?php echo !empty($userData['colaterais'])?$userData['colaterais']:''; ?></textarea>
            </div>
            <div class="form-group">
              <label>Extra_info</label>
              <textarea class="textarea" name="extra_info"><?php echo !empty($userData['extra_info'])?$userData['extra_info']:''; ?></textarea>
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