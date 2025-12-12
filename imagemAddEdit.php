<?php
$postData = $galData = array();

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

// Get gallery data
if(!empty($_GET['id'])){
  // Include and initialize DB class
    require_once 'imagemDB.class.php';
  $db = new imagemDB();
  
    $conditions['where'] = array(
        'id' => $_GET['id'],
    );
    $conditions['return_type'] = 'single';
    $galData = $db->getRows($conditions);
}

// Pre-filled data
$galData = !empty($postData)?$postData:$galData;

// Define action
$actionLabel = !empty($_GET['id'])?'Editar':'Criar';

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
            <h1 class="m-0 text-dark">Criar Álbum</h1>
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
          <div class="col-md-6">
              <form method="post" action="imagemAction.php" enctype="multipart/form-data">
                  <div class="form-group">
                      <label>Nome da Galeria:</label>
                      <input type="text" name="title" class="form-control" placeholder="Enter title" value="<?php echo !empty($galData['title'])?$galData['title']:''; ?>" >
                  </div>
                  <div class="form-group">
                      <label>Imagens:</label>
                      <input type="file" name="images[]" class="form-control" multiple>
                      <?php if(!empty($galData['images'])){ ?>
                          <div class="gallery-img">
                          <?php foreach($galData['images'] as $imgRow){ ?>
                              <div class="img-box" id="imgb_<?php echo $imgRow['id']; ?>">
                                  <img src="uploads/images/<?php echo $imgRow['file_name']; ?>" width="50%">
                                  <a href="javascript:void(0);" class="badge badge-danger" onclick="deleteImage('<?php echo $imgRow['id']; ?>')"><i class="far fa-trash-alt"></i> Apagar</a>
                              </div>
                          <?php } ?>
                          </div>
                      <?php } ?>
                  </div>
                  <a href="imagemIndex.php" class="btn btn-secondary">Voltar</a>
                  <input type="hidden" name="id" value="<?php echo !empty($galData['id'])?$galData['id']:''; ?>">
                  <input type="submit" name="imgSubmit" class="btn btn-success" value="Enviar">
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
<script>
function deleteImage(id){
  var result = confirm("Tem certeza que deseja apagar?");
  if(result){
    $.post( "imagemAction.php", {action_type:"img_delete",id:id}, function(resp) {
      if(resp == 'ok'){
        $('#imgb_'+id).remove();
        alert('A imagem foi removida da galeria');
      }else{
        alert('Ocorreu um problema, tente novamente.');
      }
    });
  }
}
</script>