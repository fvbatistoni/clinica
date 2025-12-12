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
    'nome' => $searchKeyword,
    'stat' => $searchKeyword,
    'info' => $searchKeyword,
    'sub1' => $searchKeyword,
    'sub2' => $searchKeyword,
    'sub3' => $searchKeyword,
    'sub4' => $searchKeyword
  );
}

// Get count of the users
$con = array(
  'like_or' => $searchArr,
  'return_type' => 'count'
);
$rowCount = $db->getRows('amamentacao_medicamentos', $con);

// Initialize pagination class
$pagConfig = array(
  'baseURL' => 'amamentacao_medicamentoIndex.php'.$searchStr,
  'totalRows' => $rowCount,
  'perPage' => $perPageLimit
);
$pagination = new Pagination($pagConfig);

// Get users from database
$con = array(
  'like_or' => $searchArr,
  'start' => $offset,
  'limit' => $perPageLimit,
  'order_by' => 'nome ASC',
);
$amamentacao_medicamentos = $db->getRows('amamentacao_medicamentos', $con);

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
            <h1 class="m-0 text-dark">Amamentação e Uso de Medicamentos</h1>
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
              

          <div class="callout callout-info" style="background-image: url('uploads/pink-bg.png');">
            <div class="row">
            <div class="col-md-8">
            <i class="fa fa-circle" style="color:green;"></i> <label>USO COMPATÍVEL COM A AMAMENTAÇÃO</label>
            <h6><small>Fármacos cujo uso é potencialmente seguro durante a lactação, haja vista não haver relatos de efeitos farmacológicos significativos para o lactente.</small></h6>
            <i class="fa fa-circle" style="color:yellow;"></i> <label>USO CRITERIOSO DURANTE A AMAMENTAÇÃO</label>
            <h6><small>Medicamentos cujo uso no período da lactação depende da avaliação do risco/benefício. Quando utilizados, exigem monitorização clínica e/ou laboratorial do lactente, devendo ser utilizados durante o menor tempo e na menor dose possível. Inclui também novos medicamentos cuja segurança durante a amamentação ainda não foi devidamente documentada.</small></h6>
            <i class="fa fa-circle" style="color:red;"></i> <label>USO CONTRAINDICADO DURANTE A AMAMENTAÇÃO</label>
            <h6><small>Drogas que exigem a interrupção da amamentação, pelas evidências ou risco significativo de efeitos colaterais importantes no lactente.</small></h6>
            </div>
            <div class="col-md-4">
              <form class="float-right">
                <div class="input-group">
                  <input type="text" name="sq" class="form-control" placeholder="Busca princípio ativo" value="<?php echo $searchKeyword; ?>">
                          <span class="input-group-append">
                              <div class="input-group-text bg-transparent"><i class="fa fa-search"></i></div>
                          </span>
                </div>
              </form>
            </div>
          </div>
          </div>
        </div>
        
        <!-- Data list table --> 
        <table class="table table-striped table-bordered" width="100%">
          <thead>
            <tr>
              <th>ID</th>
              <th width="25%">Nome</th>
              <th style="text-align: center">Status</th>
              <th>Info</th>
              <th width="10%" colspan="2" style="text-align: center;">Ações</th>
            </tr>
          </thead>
          <tbody>
            <?php
            if(!empty($amamentacao_medicamentos)){ $count = 0; 
              foreach($amamentacao_medicamentos as $amamentacao_medicamento){ $count++;
            ?>
            <tr>
              <td><?php echo $amamentacao_medicamento['id']; ?></td>
              <td><strong><?php echo $amamentacao_medicamento['nome']; ?></strong></td>
              <td style="text-align: center">
                <?php
                switch ($amamentacao_medicamento['stat']) {
                    case 1:
                        echo "<i class=\"fa fa-circle\" style=\"color:green;font-size:26px\"></i>";
                        break;
                    case 2:
                        echo "<i class=\"fa fa-circle\" style=\"color:red;font-size:26px\"></i>";
                        break;
                    case 3:
                        echo "<i class=\"fa fa-circle\" style=\"color:yellow;font-size:26px\"></i>";
                        break;
                }           
              ?>
              </td>
              <td><?php echo $amamentacao_medicamento['info']; ?></td>
              <td style="text-align: center;">
                <a href="amamentacao_medicamentoAddEdit.php?id=<?php echo $amamentacao_medicamento['id']; ?>" class="fad fa-edit"></a>                
              </td>
              <td style="text-align: center;">
                <a href="amamentacao_medicamentoAction.php?action_type=delete&id=<?php echo $amamentacao_medicamento['id']; ?>" class="fad fa-trash-alt" onclick="return confirm('Tem certeza que deseja apagar?')"></a>
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