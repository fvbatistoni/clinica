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
  $userData = $db->getRows('financeiro_cats', $conditions);
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
            <h1 class="m-0 text-dark">Rubricas</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Livro Caixa</li>
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
        <div class="panel-heading"><a href="financeiro_catIndex.php" class="float-right"><i class="fad fa-backward"></i> Voltar</a></div>
        <div class="panel-body">
          <form method="post" action="financeiro_catAction.php" class="form">
            <div class="form-group">
              <label>Tipo:&nbsp;&nbsp;</label>
              <div class="form-check form-check-inline">              
                <input class="form-check-input" type="radio" name="tipo" id="tipo" value="0" <?php echo $userData['tipo']==0?'checked':''; ?>>
                <label class="form-check-label" for="inlineRadio1">Débito</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="tipo" id="tipo" value="1" <?php echo $userData['tipo']==1?'checked':''; ?>>
                <label class="form-check-label" for="inlineRadio2">Crédito</label>
              </div>
            </div>
            <div class="form-group">
              <label>Nome: </label>
              <input type="text" class="form-control" name="nome" value="<?php echo !empty($userData['nome'])?$userData['nome']:''; ?>">
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