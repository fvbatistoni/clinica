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
$perPageLimit = 10;
$offset = !empty($_GET['page'])?(($_GET['page']-1)*$perPageLimit):0;

// Get search keyword
$searchKeyword = !empty($_GET['sq'])?$_GET['sq']:'';
$searchStr = !empty($searchKeyword)?'?sq='.$searchKeyword:'';

// Search DB query
if(!empty($searchKeyword)){
  $searchArr = array(
    'sub1' => $searchKeyword,
    'sub2' => $searchKeyword,
    'farmaco' => $searchKeyword,
    'farmaco_info' => $searchKeyword,
    'nome_comercial' => $searchKeyword,
    'dose' => $searchKeyword,
    'colaterais' => $searchKeyword,
    'extra_info' => $searchKeyword
  );
}

// Get count of the users
$con = array(
  'like_or' => $searchArr,
  'return_type' => 'count'
);
$rowCount = $db->getRows('black_medicamentos', $con);

// Initialize pagination class
$pagConfig = array(
  'baseURL' => 'black_medicamentoIndex.php'.$searchStr,
  'totalRows' => $rowCount,
  'perPage' => $perPageLimit
);
$pagination = new Pagination($pagConfig);

// Get users from database
$con = array(
  'like_or' => $searchArr,
  'start' => $offset,
  'limit' => $perPageLimit,
  'order_by' => 'id DESC',
);
$black_medicamentos = $db->getRows('black_medicamentos', $con);

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
            <h1 class="m-0 text-dark">Black Book</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Medicamentos</li>
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

        <div class="col-md-12 search-panel">
          <!-- Search form -->
          <form class="form-inline float-right">
          <div class="input-group">
            <input type="text" name="sq" class="form-control" placeholder="Busca palavra-chave..." value="<?php echo $searchKeyword; ?>">
                    <span class="input-group-append">
                        <div class="input-group-text bg-transparent"><i class="fa fa-search"></i></div>
                    </span>
          </div>
          </form>
        </div>
          <!-- Add link -->
          <span class="pull-right">
            <a href="black_medicamentoAddEdit.php" class="btn btn-primary" role="button" aria-pressed="true"><i class="fad fa-plus"></i> Novo</a>
          </span>
        <hr>

        <!-- Data list table --> 
        <table class="table table-striped table-bordered" width="100%">
          <thead>
            <tr>
              <th>ID</th>
              <th>Capítulo</th>
              <th>Fármaco</th>
              <th>Nome Comercial</th>
              <th width="10%" colspan="2" style="text-align: center;">Ações</th>
            </tr>
          </thead>
          <tbody>
            <?php
            if(!empty($black_medicamentos)){ $count = 0; 
              foreach($black_medicamentos as $black_medicamento){ $count++;
            ?>
            <tr>
              <td><?php echo $black_medicamento['id']; ?></td>
              <td><ion-icon name="return-down-forward-outline"></ion-icon>
                <?php 
                  $getBlackSub1 = $db->getBlackSub1($black_medicamento['sub1']);
                  echo '<strong>'.$getBlackSub1['nome'].'</strong>';

                  $getBlackSub2 = $db->getBlackSub2($black_medicamento['sub1'],$black_medicamento['sub2']);
                  if(!empty($getBlackSub2)){
                    echo '<br>&nbsp;&nbsp;&nbsp;&nbsp;<i class="fad fa-level-up-alt fa-rotate-90"></i>&nbsp;&nbsp;';
                    echo '<small>'.$getBlackSub2['nome'].'</small>';
                  } else {
                    echo '';
                  }
                  
                ?>            
              </td>
              <td><?php echo $black_medicamento['farmaco']; ?></td>
              <td><?php echo $black_medicamento['nome_comercial']; ?></td>
              <td>
                <a href="black_modal_view.php?id=<?php echo $black_medicamento['id']; ?>" data-toggle='modal' data-target='#black_modal_view'><i class='fas fa-laptop-medical'></i></a>
                <a href="black_medicamentoAddEdit.php?id=<?php echo $black_medicamento['id']; ?>" class="fad fa-edit"></a>
              </td>
            </tr>
            <?php } }else{ ?>
            <tr><td colspan="5">Expressão não encontrada...</td></tr>
            <?php } ?>
          </tbody>
        </table>
        
        <!-- Display pagination links -->
        <?php echo $pagination->createLinks(); ?>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?php
	include 'footer.php'; // Fecha a div wrapper
?>