<?php
$postData = $aniversarianteData = array();

// Get session data
$sessData = !empty($_SESSION['sessData']) ? $_SESSION['sessData'] : '';

// Get status message from session
if (!empty($sessData['status']['msg'])) {
    $statusMsg = $sessData['status']['msg'];
    $statusMsgType = $sessData['status']['type'];
    unset($_SESSION['sessData']['status']);
}

// Get posted data from session
if (!empty($sessData['postData'])) {
    $postData = $sessData['postData'];
    unset($_SESSION['sessData']['postData']);
}

// Get user data
if (!empty($_GET['id'])) {
    include 'DB.class.php';
    $db = new DB();
    $conditions['where'] = array(
        'id' => $_GET['id'],
    );
    $conditions['return_type'] = 'single';
    $aniversarianteData = $db->getRows('aniversariantes', $conditions);
}

// Pre-filled data
$aniversarianteData = !empty($postData) ? $postData : $aniversarianteData;

// Define action
$actionLabel = !empty($_GET['id']) ? 'Editar' : 'Adicionar';

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
            <h1 class="m-0 text-dark">Adicionar/Editar Aniversariante</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Aniversariantes</li>
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
      <?php if (!empty($statusMsg) && ($statusMsgType == 'success')) { ?>
      <div class="callout callout-success"><?php echo $statusMsg; ?></div>
      <?php } elseif (!empty($statusMsg) && ($statusMsgType == 'error')) { ?>
      <div class="callout callout-danger"><?php echo $statusMsg; ?></div>
      <?php } ?>
      
      <!-- Add/Edit form -->
      <div class="panel panel-default">
        <div class="panel-body">
          <form method="post" action="aniversarianteAction.php" class="form">
            <div class="form-group">
              <label>Nome</label>
              <input type="text" class="form-control" id="name" name="name" value="<?php echo !empty($aniversarianteData['name']) ? $aniversarianteData['name'] : ''; ?>">
            </div>
            <div class="form-group">
              <label>Data de Nascimento</label>
              <input type="date" class="form-control" id="aniversario" name="aniversario" value="<?php echo !empty($aniversarianteData['aniversario']) ? $aniversarianteData['aniversario'] : ''; ?>">
            </div>
            <div class="form-group">
              <label>Telefone 1</label>
              <input type="text" class="form-control" id="phone1" name="phone1" value="<?php echo !empty($aniversarianteData['phone1']) ? $aniversarianteData['phone1'] : ''; ?>" maxlength="20" placeholder="(19) 9XXXX-XXXX">
            </div>
            <div class="form-group">
              <label>Telefone 2</label>
              <input type="text" class="form-control" id="phone2" name="phone2" value="<?php echo !empty($aniversarianteData['phone2']) ? $aniversarianteData['phone2'] : ''; ?>" maxlength="20" placeholder="(19) 9XXXX-XXXX">
            </div>
            <input type="hidden" name="created" id="created" value="<?php echo !empty($aniversarianteData['created']) ? date('Y-m-d', strtotime($aniversarianteData['created'])) : date('Y-m-d'); ?>">
            <input type="hidden" id="id" name="id" value="<?php echo !empty($aniversarianteData['id']) ? $aniversarianteData['id'] : ''; ?>">
            <button type="submit" id= "aniversarianteSubmit" name="aniversarianteSubmit" class="btn btn-success" /><i class="fad fa-save"></i> Salvar</button>
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
<script type="text/javascript">
// === Máscaras ===
$('#phone1').mask('(00) 00000-0000');
$('#phone2').mask('(00) 00000-0000');
</script>