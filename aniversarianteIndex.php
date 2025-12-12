<style>
  .input-group-text {
    cursor: pointer;
  }
</style>
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
    'name' => $searchKeyword
  );
}

// Get count of the users
$con = array(
  'like_or' => $searchArr,
  'return_type' => 'count'
);
$rowCount = $db->getRows('aniversariantes', $con);

// Initialize pagination class
$pagConfig = array(
  'baseURL' => 'aniversarianteIndex.php'.$searchStr,
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
$aniversariantes = $db->getRows('aniversariantes', $con);

date_default_timezone_set('America/Sao_Paulo');
function calcularIdadeDetalhada($aniversario) {
    // Converte a string de data em objeto DateTime
    $dataNasc = new DateTime($aniversario);
    $hoje = new DateTime();

    // Calcula a diferença
    $diff = $hoje->diff($dataNasc);

    $anos  = $diff->y;
    $meses = $diff->m;
    $dias  = $diff->d;

    $partes = [];

    if ($anos > 0) {
        $partes[] = $anos . ' ' . ($anos == 1 ? 'ano' : 'anos');
    }
    if ($meses > 0) {
        $partes[] = $meses . ' ' . ($meses == 1 ? 'mês' : 'meses');
    }
    if ($dias > 0) {
        $partes[] = $dias . ' ' . ($dias == 1 ? 'dia' : 'dias');
    }

    // Se todas as partes forem zero (ex: nasceu hoje)
    if (empty($partes)) {
        return '0 dia';
    }

    // Junta as partes com vírgulas
    return implode(', ', $partes);
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
            <h1 class="m-0 text-dark">Aniversariantes</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Histórico de Aniversariantes</li>
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
              <div class="input-group pointer">
                <input type="text" name="sq" class="form-control" placeholder="Busca palavra-chave..." value="<?php echo $searchKeyword; ?>">
               <span class="input-group-append">
                <button type="submit" class="input-group-text bg-transparent" style="border: none; background: transparent;">
                  <i class="fa fa-search"></i>
                </button>
              </span>
              </div>
            </form>
          </div>
          <!-- Add link -->
          <span class="pull-right">
            <a href="aniversarianteAddEdit.php" class="btn btn-primary" role="button" aria-pressed="true"><i class="fad fa-plus"></i> Novo</a>
          </span>
        <hr>
        <!-- Data list table --> 
        <table class="table table-striped table-bordered" width="100%">
          <thead>
            <tr>
              <th width="5%">ID</th>
              <th width="30%">Nome</th>
              <th>Aniversário</th>
              <th>Idade</th>
              <th>Telefone 1</th>
              <th>Telefone 2</th>
              <th width="15%" colspan="2" style="text-align: center;">Ações</th>
            </tr>
          </thead>
          <tbody>
            <?php
            if(!empty($aniversariantes)){ $count = 0; 
              foreach($aniversariantes as $aniversariante){ $count++;
            ?>
            <tr>
              <td><?php echo strtoupper($aniversariante['id']); ?></td>
              <td><?php echo strtoupper($aniversariante['name']); ?></td>
              <td><?php echo date("d/m/Y",strtotime($aniversariante['aniversario'])); ?></td>
              <td><?php
                  echo calcularIdadeDetalhada($aniversariante['aniversario']);
                  ?>
              </td>
              <td><?php echo $aniversariante['phone1'] ?? ''; ?></td>
              <td><?php echo $aniversariante['phone2'] ?? ''; ?></td>
              <td style="text-align: center;">
                <a href="aniversarianteAddEdit.php?id=<?php echo $aniversariante['id']; ?>" class="fad fa-edit"></a>
              </td>
              <td style="text-align: center;">
                <a href="aniversarianteAction.php?action_type=delete&id=<?php echo $aniversariante['id']; ?>" class="fad fa-trash-alt" onclick="return confirm('Tem certeza que deseja apagar?')"></a>
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