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

// Get user data
if (!empty($_GET['id'])) {
    include 'DB.class.php';
    $db = new DB();
    $conditions['where'] = array(
        'id' => $_GET['id'],
    );
    $conditions['return_type'] = 'single';
    $userData = $db->getRows('prescricaos', $conditions);
}

// Pre-filled data
$userData = !empty($postData) ? $postData : $userData;

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
            <h1 class="m-0 text-dark">Adicionar/Editar Prescrição</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Prescrições</li>
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
          <form method="post" action="prescricaoAction.php" class="form">
            <div class="form-group">
              <label>Nome</label>
              <input type="text" class="form-control" id="nome_prescricao" name="nome" value="<?php echo !empty($userData['nome']) ? $userData['nome'] : ''; ?>">
            </div>
            <div class="form-group">
              <label>Tipo de Receituário </label>
                <?php
                if (empty($userData['rec_especial'])) {
                  echo '<div class="form-check form-check-inline">';
                  echo '  <input class="form-check-input" type="radio" name="rec_especial" id="rec_especial_nao" value="0" checked>';
                  echo '  <label class="form-check-label" for="inlineCheckbox1">Comum</label>';
                  echo '</div>';
                  echo '<div class="form-check form-check-inline">';
                  echo '  <input class="form-check-input" type="radio" name="rec_especial" id="rec_especial_sim" value="1">';
                  echo '  <label class="form-check-label" for="inlineCheckbox2">Especial</label>';
                  echo '</div>';
                } else {
                  switch ($userData['rec_especial']) {
                    case '0':
                      echo '<div class="form-check form-check-inline">';
                      echo '  <input class="form-check-input" type="radio" name="rec_especial" id="rec_especial_nao" value="0" checked>';
                      echo '  <label class="form-check-label" for="inlineCheckbox1">Comum</label>';
                      echo '</div>';
                      echo '<div class="form-check form-check-inline">';
                      echo '  <input class="form-check-input" type="radio" name="rec_especial" id="rec_especial_sim" value="1">';
                      echo '  <label class="form-check-label" for="inlineCheckbox2">Especial</label>';
                      echo '</div>';
                      break;
                    case '1':
                      echo '<div class="form-check form-check-inline">';
                      echo '  <input class="form-check-input" type="radio" name="rec_especial" id="rec_especial_nao" value="0">';
                      echo '  <label class="form-check-label" for="inlineCheckbox1">Comum</label>';
                      echo '</div>';
                      echo '<div class="form-check form-check-inline">';
                      echo '  <input class="form-check-input" type="radio" name="rec_especial" id="rec_especial_sim" value="1" checked>';
                      echo '  <label class="form-check-label" for="inlineCheckbox2">Especial</label>';
                      echo '</div>';
                      break;    
                  }
                }
                ?>
            </div>
            <div class="form-group">
              <label><i class="fad fa-prescription"></i></label>
           <?php 
            $rx = !empty($userData['rx']) ? $userData['rx'] : '';
            $rx = stripslashes($rx); 
            $rx = html_entity_decode($rx, ENT_QUOTES | ENT_HTML5, 'UTF-8');
            ?>

          <textarea id="editorprescricao" name="rx" style="height: 147px;width: 100%;"><?php echo htmlspecialchars($rx, ENT_QUOTES | ENT_HTML5, 'UTF-8'); ?></textarea>

            </div>
            <div class="form-group">
              <label>Data</label>
              <input type="date" class="form-control" name="created" value="<?php echo !empty($userData['created']) ? date('Y-m-d', strtotime($userData['created'])) : date('Y-m-d'); ?>">
            </div>
            <input type="hidden" name="id" value="<?php echo !empty($userData['id']) ? $userData['id'] : ''; ?>">
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