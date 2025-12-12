<?php
// Get session data
$sessData = !empty($_SESSION['sessData'])?$_SESSION['sessData']:'';

// Get status message from session
if(!empty($sessData['status']['msg'])){
    $statusMsg = $sessData['status']['msg'];
    $statusMsgType = $sessData['status']['type'];
    unset($_SESSION['sessData']['status']);
}

$searchArr = '';

// Load pagination class
require_once 'Pagination.class.php';

// Load and initialize database class
require_once 'DB.class.php';
$db = new DB();

// Page offset and limit
$perPageLimit = 500;
$offset = !empty($_GET['page'])?(($_GET['page']-1)*$perPageLimit):0;

// Get search keyword
$searchKeyword = !empty($_GET['sq'])?$_GET['sq']:'';
$searchStr = !empty($searchKeyword)?'?sq='.$searchKeyword:'';

// Search DB query
if(!empty($searchKeyword)){
  $searchArr = array(
    'title' => $searchKeyword,
    'img_folder' => $searchKeyword,
    'data' => $searchKeyword
  );
}

// Get count of the users
$con = array(
  'like_or' => $searchArr,
  'return_type' => 'count'
);
$rowCount = $db->getRows('gallery', $con);

// Initialize pagination class
$pagConfig = array(
  'baseURL' => 'desenhoIndex.php'.$searchStr,
  'totalRows' => $rowCount,
  'perPage' => $perPageLimit
);
$pagination = new Pagination($pagConfig);

// Get users from database
$con = array(
  'like_or' => $searchArr,
  'start' => $offset,
  'limit' => $perPageLimit,
  'order_by' => 'title ASC',
);
$gallery = $db->getRows('gallery', $con);

include 'header.php';
?>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
<?php
	include 'navbar.php';
	include 'menu.php';
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="background-image: url('uploads/pink-bg.png');"> 
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Galerias</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Desenhos para colorir</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
       <section class="gallery-block cards-gallery">
        <div class="container">
          <div class="row">
            <?php
            if(!empty($gallery)){ $count = 0; 
              foreach($gallery as $galeria){ $count++;
            ?>
              <div class="col-md-4 col-lg-2">
                <div class="card border-0 transform-on-hover">
                  <a href='ajax/gallery_items.php?id=<?php echo $galeria['id']; ?>' class="lightbox" data-toggle='modal' data-target='#gallery_detalhes'><img src="<?php echo $galeria['img_folder']; ?>"></a>
                  <div class="card-body">
                    <h6><?php echo $galeria['title']; ?></h6>
                  </div>
                </div>
              </div>
            <?php } }else{ ?>
            <div>Expressão não encontrada...</div>
            <?php } ?>
          </div>
        </div>
       </section>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

      <!-- modal -->
      <div class="modal fade" id="gallery_detalhes">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title"><i class="fa fa-print"></i> Escolha para Imprimir</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
        <div class="embed-responsive embed-responsive-1by1">
          <iframe id="iframeModal2" class="embed-responsive-item" src=""></iframe>
        </div>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->

<?php
	include 'footer.php'; // Fecha a div wrapper
?>

<script>
  $( document ).on( 'click', 'a[data-toggle]', function ( e ) {
    e.preventDefault();

    //carrega URL do link no IFRAME
    $( "#iframeModo" ).attr( "src", this.href );
    $( "#iframeModal2" ).attr( "src", this.href );
  } );
</script>
