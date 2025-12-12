<?php
$postData = $userData = array();

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

// Get user data if an ID is provided
if (!empty($_GET['id'])) {
    include 'DB.class.php';
    $db = new DB();
    $conditions['where'] = array(
        'id' => $_GET['id'],
    );
    $conditions['return_type'] = 'single';
    $userData = $db->getRows('tuss', $conditions);
}

// Pre-filled data
$userData = !empty($postData) ? $postData : $userData;

// Define action label (Add or Edit)
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
            <h1 class="m-0 text-dark">Adicionar/Editar Procedimento</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">TUSS</li>
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
      <?php if (!empty($statusMsg) && ($statusMsgType == 'success')) { ?>
      <div class="callout callout-success"><?php echo $statusMsg; ?></div>
      <?php } elseif (!empty($statusMsg) && ($statusMsgType == 'error')) { ?>
      <div class="callout callout-danger"><?php echo $statusMsg; ?></div>
      <?php } ?>
      
      <!-- Add/Edit form -->
      <div class="panel panel-default">
        <div class="panel-heading"><a href="tusIndex.php" class="float-right"><i class="fad fa-backward"></i> Voltar</a></div>
        <div class="panel-body">
          <form method="post" action="tusAction.php" class="form">
            <div class="form-group">
              <label>Código</label>
              <input type="text" class="form-control" name="codProcedimento" value="<?php echo !empty($userData['codProcedimento']) ? $userData['codProcedimento'] : ''; ?>" required>
            </div>
            <div class="form-group">
              <label>Descrição</label>
              <input type="text" class="form-control" name="descricao" value="<?php echo !empty($userData['descricao']) ? $userData['descricao'] : ''; ?>" required>
            </div>
            <div class="form-group">
              <label>Versão (AAAA/MM)</label>
              <input 
                type="text" 
                class="form-control" 
                id="versao" 
                name="versao" 
                maxlength="7"
                value="<?php echo !empty($userData['versao']) ? substr($userData['versao'], 0, 4) . '/' . substr($userData['versao'], 4, 2) : ''; ?>"
                placeholder="____/__"
                required
              >
            </div>
            <div class="form-group">
              <label>Status</label>
               <select class="form-control" name="status" required>
                 <option value="1" <?php echo (isset($userData['status']) && $userData['status'] == 1) ? 'selected' : ''; ?>>Ativo</option>
                  <option value="0" <?php echo (isset($userData['status']) && $userData['status'] === '0' || $userData['status'] == 0) ? 'selected' : ''; ?>>Inativo</option>
               </select>
            </div>
            <input type="hidden" name="id" value="<?php echo !empty($userData['id']) ? $userData['id'] : ''; ?>">
            <button type="submit" name="userSubmit" class="btn btn-success"><i class="fad fa-save"></i> Salvar</button>
          </form>
        </div>
      </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<script>
document.addEventListener('DOMContentLoaded', function () {
  const versaoInput = document.getElementById('versao');

  versaoInput.addEventListener('input', function (e) {
    let val = versaoInput.value.replace(/\D/g, ''); // apenas números
    if (val.length > 6) val = val.slice(0,6);        // limite 6 dígitos

    if (val.length > 4) {
      versaoInput.value = val.slice(0,4) + '/' + val.slice(4);
    } else {
      versaoInput.value = val;
    }
  });

  // Antes de enviar o form, remove a barra
  document.querySelector('form').addEventListener('submit', function () {
    versaoInput.value = versaoInput.value.replace('/', '');
  });
});
</script>
<?php include 'footer.php'; ?>
