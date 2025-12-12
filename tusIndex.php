<?php
// Get session data
$sessData = !empty($_SESSION['sessData']) ? $_SESSION['sessData'] : '';

// Get status message from session
if (!empty($sessData['status']['msg'])) {
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
$offset = !empty($_GET['page']) ? (($_GET['page'] - 1) * $perPageLimit) : 0;

// Get search keyword
$searchKeyword = !empty($_GET['sq']) ? $_GET['sq'] : '';
$searchStr = !empty($searchKeyword) ? '?sq=' . $searchKeyword : '';

// Search DB query
if (!empty($searchKeyword)) {
    $searchArr = array(
        'codProcedimento' => $searchKeyword,
        'descricao' => $searchKeyword,
        'versao' => $searchKeyword,
        'status' => $searchKeyword
    );
}

// Get count of the users
$con = array(
    'like_or' => $searchArr,
    'return_type' => 'count'
);
$rowCount = $db->getRows('tuss', $con);

// Initialize pagination class
$pagConfig = array(
    'baseURL' => 'tusIndex.php' . $searchStr,
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
$tuss = $db->getRows('tuss', $con);

include 'header.php';
?>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
<?php
include 'navbar.php';
include 'menu.php';
?>
  <div class="content-wrapper"> 
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">TUSS: Terminologia Unificada da Saúde Suplementar</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Tabela TUSS</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <section class="content">
      <div class="container-fluid">
        <?php if (!empty($statusMsg) && ($statusMsgType == 'success')) { ?>
          <div class="callout callout-success"><?php echo $statusMsg; ?></div>
        <?php } elseif (!empty($statusMsg) && ($statusMsgType == 'error')) { ?>
          <div class="callout callout-danger"><?php echo $statusMsg; ?></div>
        <?php } ?>

        <div class="col-md-12 search-panel">
          <form class="form-inline float-right">
            <div class="input-group">
              <input type="text" name="sq" class="form-control" placeholder="Busca palavra-chave..." value="<?php echo $searchKeyword; ?>">
              <span class="input-group-append">
                <div class="input-group-text bg-transparent"><i class="fa fa-search"></i></div>
              </span>
            </div>
          </form>
        </div>
        <span class="pull-right">
          <a href="tusAddEdit.php" class="btn btn-primary" role="button" aria-pressed="true"><i class="fad fa-plus"></i> Novo</a>
        </span>
        <hr>

        <table class="table table-striped table-bordered" width="100%">
          <thead>
            <tr>
              <th>ID</th>
              <th>Código</th>
              <th>Descrição</th>
              <th>Versão</th>
              <th>Data Criação</th>
              <th>Data Modificação</th>
              <th>Status</th>
              <th width="10%" colspan="2" style="text-align: center;">Ações</th>
            </tr>
          </thead>
          <tbody>
            <?php
            if (!empty($tuss)) {
              foreach ($tuss as $tus) {
            ?>
            <tr>
              <td><?php echo $tus['id']; ?></td>
              <td><?php echo $tus['codProcedimento']; ?></td>
              <td><?php echo $tus['descricao']; ?></td>
              <td><?php echo $tus['versao']; ?></td>
              <td><?php echo date('d/m/Y H:i', strtotime($tus['created'])); ?></td>
              <td><?php echo date('d/m/Y H:i', strtotime($tus['modified'])); ?></td>
              <td><?php echo ($tus['status'] == 1) ? 'Ativo' : 'Inativo'; ?></td>
              <td style="text-align: center;">
                <a href="tusAddEdit.php?id=<?php echo $tus['id']; ?>" class="fad fa-edit"></a>
              </td>
              <td style="text-align: center;">
                <a href="tusAction.php?action_type=delete&id=<?php echo $tus['id']; ?>" class="fad fa-trash-alt" onclick="return confirm('Tem certeza que deseja apagar?')"></a>
              </td>
            </tr>
            <?php }
            } else { ?>
            <tr><td colspan="9">Expressão não encontrada...</td></tr>
            <?php } ?>
          </tbody>
        </table>

        <?php echo $pagination->createLinks(); ?>
      </div>
    </section>
  </div>

<?php
include 'footer.php';
?>
