<?php
// Get session data
$sessData = !empty($_SESSION['sessData'])?$_SESSION['sessData']:'';

// Get status message from session
if(!empty($sessData['status']['msg'])){
    $statusMsg = $sessData['status']['msg'];
    $statusMsgType = $sessData['status']['type'];
    unset($_SESSION['sessData']['status']);
}

// Get status message
if(!empty($_GET['status'])){
    switch($_GET['status']){
        case 'success':
            $statusType = 'alert-success';
            $statusMsg = 'Agenda importada com sucesso.';
            break;
        case 'error':
            $statusType = 'alert-danger';
            $statusMsg = 'Agenda já existe ou arquivo inválido.';
            break;
        case 'invalid_file':
            $statusType = 'alert-danger';
            $statusMsg = 'CSV inválido.';
            break;
        default:
            $statusType = '';
            $statusMsg = '';
    }
}

$searchArr = '';

// Load pagination class
require_once 'Pagination.class.php';

// Load and initialize database class
require_once 'DB.class.php';
$db = new DB();

// Page offset and limit
$perPageLimit = 34;
$offset = !empty($_GET['page'])?(($_GET['page']-1)*$perPageLimit):0;

// Get search keyword
$searchKeyword = !empty($_GET['sq'])?$_GET['sq']:'';
$searchStr = !empty($searchKeyword)?'?sq='.$searchKeyword:'';

// Search DB query
if(!empty($searchKeyword)){
  $searchArr = array(
    'nome_paciente' => $searchKeyword,
    'local_atendimento' => $searchKeyword,
    'data' => $searchKeyword
  );
}

// Get count of the users
$con = array(
  'like_or' => $searchArr,
  'return_type' => 'count'
);
$rowCount = $db->getRows('agendas', $con);

// Initialize pagination class
$pagConfig = array(
  'baseURL' => 'agendaIndex.php'.$searchStr,
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
$agendas = $db->getRows('agendas', $con);

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
            <h1 class="m-0 text-dark">Dump de Agendas</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Agendas</li>
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
            <div class="alert <?php echo $statusType; ?>"><?php echo $statusMsg; ?></div>
        </div>
        <?php } ?>

        <div class="row">
            <div class="col-md-5">
              <div class="card card-outline card-info">
                <div class="card-header">
                  <h3 class="card-title">
                    <i class="fad fa-upload mr-1"></i>
                    Enviar Agenda
                  </h3>
                  <!-- tools box -->
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool btn-sm" data-card-widget="collapse" data-toggle="tooltip"
                            title="Collapse">
                      <i class="fad fa-minus"></i></button>
                  </div>
                  <!-- /. tools -->
                </div>
                <!-- /.card-header -->
                <div class="card-body pad">
                  <div class="mb-3">
                    <form method="POST" enctype="multipart/form-data" action="recebe_agenda_do_dia.php" class="form">
                    <div class="form-group">
                      <label>Data:</label>
                      <input type="date" class="form-control" name="data" value="<?php echo date('Y-m-d'); ?>"/>
                    </div>
                    <div class="form-group">
                      <label>Arquivo:</label>
                      <input type="file" name="file" />
                    </div>
                      </div>
                      <p class="text-sm mb-0">
                      <button type="submit" name="importSubmit" class="btn btn-success float-right"><i class="fad fa-upload"></i> Enviar</button>
                    </form>
                  </p>
                </div>
              </div>
            </div>
            <!-- /.col-->
        <div class="col">
                <!-- Previsões de Repasses -->
                <div class="card card-outline card-primary collapsed-card">
                  <div class="card-header">
                    <h3 class="card-title">
                      <i class="fad fa-money-check mr-1"></i>
                      Repasses Clínica Campinas
                    </h3>
                    <div class="card-tools">
                      <div class="input-group input-group-sm">
                        <input type="text" class="form-control" id="monthpicker1" value="<?php echo date('m/Y'); ?>"/>
                        <div class="input-group-append">
                          <span class="input-group-text"><i class="fad fa-calendar"></i></span>
                        </div>
                        <button type="button" class="btn btn-tool btn-sm" data-card-widget="collapse">
                        <i class="fad fa-plus"></i>
                      </button>
                      </div>
                    </div>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body table-responsive p-0">
                    <div id="analiticos"></div>
                  </div>
                  <!-- /.card-body -->
                </div>
                <!-- /.card --> 
        </div>
          </div>
          <!-- ./row -->

        
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
            <a href="agendaAddEdit.php" class="btn btn-primary" role="button" aria-pressed="true"><i class="fad fa-plus"></i> Novo</a>
          </span>
        <hr>
        <!-- Data list table --> 
        <table class="table table-striped table-bordered" width="100%">
          <thead>
            <tr>
              <th>ID</th>
              <th width="20%">Nome</th>
              <th>Loc.</th>
              <th>Data</th>
              <th>Ret.</th>
              <th>Plano</th>
              <th>Agend.</th>
              <th>Atend.</th>
              <th>Pont.</th>
              <th width="10%" colspan="2" style="text-align: center;">Ações</th>
            </tr>
          </thead>
          <tbody>
            <?php
            if(!empty($agendas)){ $count = 0; 
              foreach($agendas as $agenda){ $count++;
            ?>
            <tr>
              <td><?php echo $agenda['id']; ?></td>
              <td><?php echo $agenda['nome_paciente']; ?></td>
              <td><?php echo $agenda['local_atendimento']; ?></td>
              <td><?php echo date("d/m/Y",strtotime($agenda['data'])); ?></td>
              <td><?php echo $agenda['tipo']; ?></td>
              <td><?php echo $agenda['id_convenio']; ?></td>
              <td><?php echo $agenda['hora_consulta']; ?></td>
              <td><?php echo $agenda['hora_atendimento']; ?></td>
              <td><?php echo $agenda['pontualidade']; ?></td>
              <td style="text-align: center;">
                <a href="agendaAddEdit.php?id=<?php echo $agenda['id']; ?>" class="fad fa-edit"></a>                
              </td>
              <td style="text-align: center;">
                <a href="agendaAction.php?action_type=delete&id=<?php echo $agenda['id']; ?>" class="fad fa-trash-alt" onclick="return confirm('Tem certeza que deseja apagar?')"></a>
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