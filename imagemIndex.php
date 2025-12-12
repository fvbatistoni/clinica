<?php
// Include and initialize DB class
require_once 'imagemDB.class.php';
$db = new imagemDB();

// Fetch the gallery data
$images = $db->getRows();

// Get session data
$sessData = !empty($_SESSION['sessData'])?$_SESSION['sessData']:'';

// Get status message from session
if(!empty($sessData['status']['msg'])){
    $statusMsg = $sessData['status']['msg'];
    $statusMsgType = $sessData['status']['type'];
    unset($_SESSION['sessData']['status']);
}

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
            <h1 class="m-0 text-dark">Adicionar/Editar Álbuns</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Desenhos para Colorir</li>
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
      <?php if(!empty($statusMsg)){ ?>
      <div class="col-xs-12">
          <div class="alert alert-<?php echo $statusMsgType; ?>"><?php echo $statusMsg; ?></div>
      </div>
      <?php } ?>
      
      <div class="row">
          <div class="col-md-12 head">
              <!-- Add link -->
              <div class="float-right">
                <a href="imagemAddEdit.php" class="btn btn-primary" role="button" aria-pressed="true"><i class="fad fa-plus"></i> Nova Galeria</a>
              </div>
          </div>
      </div>
      <div class="row"><hr></div>
      <div class="row">
          <!-- List the images -->
          <table class="table table-striped table-bordered" width="100%">
              <thead class="thead-dark">
                  <tr>
                      <th width="5%">#</th>
                      <th width="20%"></th>
                      <th width="40%">Título</th>
                      <th width="8%">Status</th>
                      <th width="10%" colspan="3" style="text-align: center;">Ações</th>
                  </tr>
              </thead>
              <tbody>
                  <?php
                  if(!empty($images)){ $i=0;
                      foreach($images as $row){ $i++;
                          $link = explode("/", $row['default_image']);
                          $defaultImage = !empty($row['default_image'])?'<img src="uploads/images/'.$link[0].'/thumbs/'.$link[1].'" alt="" />':'';
                          $statusLink = ($row['status'] == 1)?'postAction.php?action_type=block&id='.$row['id']:'postAction.php?action_type=unblock&id='.$row['id'];
                          $statusTooltip = ($row['status'] == 1)?'Clique para Inativar':'Clique para Ativar';
                  ?>
                  <tr>
                      <td><?php echo $i; ?></td>
                      <td><?php echo $defaultImage; ?></td>
                      <td><?php echo $row['title']; ?></td>
                      <td><a href="<?php echo $statusLink; ?>" title="<?php echo $statusTooltip; ?>"><span class="badge <?php echo ($row['status'] == 1)?'badge-success':'badge-danger'; ?>"><?php echo ($row['status'] == 1)?'Ativa':'Inativa'; ?></span></a></td>
                      <td style="text-align: center;">
                          <a href="imagemView.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">View</a>                                                    
                      </td>
                      <td style="text-align: center;">
                        <a href="imagemAddEdit.php?id=<?php echo $row['id']; ?>" class="btn btn-warning">Editar</a>
                      </td>
                      <td style="text-align: center;">
                        <a href="imagemAction.php?action_type=delete&id=<?php echo $row['id']; ?>" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja apagar a informação?')?true:false;">Deletar</a>
                      </td>
                  </tr>
                  <?php } }else{ ?>
                  <tr><td colspan="6">Nenhuma Galeria Encontada...</td></tr>
                  <?php } ?>
              </tbody>
          </table>
      </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?php
	include 'footer.php'; // Fecha a div wrapper
?>