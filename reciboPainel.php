<?php
require_once '../loader.php';
@session_start();
if (!isset($_SESSION['LOGADO']) || $_SESSION['LOGADO'] == FALSE) {
    @header('location:' . Validacao::getBase() . 'login.php');
    exit;
}
// Vetor com os caracteres com problemas. 
$vetorStringProblema = [
'Ã€', 'Ã‚', 'Ãƒ', 'Ã„', 'Ã…', 'Ã†', 'Ã‡', 'Ãˆ', 'Ã‰', 'ÃŠ', 'Ã‹', 'ÃŒ', 'Ã ', 'ÃŽ', 'Ã ', 'Ã ', 'Ã‘', 'Ã’', 'Ã“', 'Ã”', 'Ã•', 'Ã–', 'Ã—', 'Ã˜', 'Ã™', 'Ãš', 'Ã›', 'Ãœ', 'Ã ', 'Ãž', 'ÃŸ', 'Ã ', 'Ã¡', 'Ã¢', 'Ã£', 'Ã¤', 'Ã¥', 'Ã¦', 'Ã§', 'Ã¨', 'Ã©', 'Ãª', 'Ã«', 'Ã¬', 'Ã­', 'Ã®', 'Ã¯', 'Ã°', 'Ã±', 'Ã²', 'Ã³', 'Ã´', 'Ãµ', 'Ã¶', 'Ã·', 'Ã¸', 'Ã¹', 'Ãº', 'Ã»', 'Ã¼', 'Ã½', 'Ã¾', 'Ã¿', 'Ã',
];

// Vetor respctico com os caracteres corretos.
$vetorStringCorreta = [
'À', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', '×', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'Þ', 'ß', 'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ð', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', '÷', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'þ', 'ÿ', 'Á',
];

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
$perPageLimit = 20;
$offset = !empty($_GET['page'])?(($_GET['page']-1)*$perPageLimit):0;

// Get search keyword
$searchKeyword = !empty($_GET['sq'])?$_GET['sq']:'';
$searchStr = !empty($searchKeyword)?'?sq='.$searchKeyword:'';

// Search DB query
if(!empty($searchKeyword)){
  $searchArr = array(
    'pagador' => $searchKeyword,
    'cpf' => $searchKeyword,
    'valor' => $searchKeyword,
    'observacao' => $searchKeyword,
    'created' => $searchKeyword
  );
}

// Get count of the users
$con = array(
  'like_or' => $searchArr,
  'return_type' => 'count'
);
$rowCount = $db->getRows('recibos', $con);

// Initialize pagination class
$pagConfig = array(
  'baseURL' => 'reciboPainel.php'.$searchStr,
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
$recibos = $db->getRows('recibos', $con);

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Pediatria Simples | RECIBOS</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="plugins/toastr/toastr.min.css">  
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="assets/css/adminlte.min.css">
  <!-- Font Awesome Duotone -->
  <script src="assets/js/duotone.min.js"></script>
  <link rel="stylesheet" href="assets/css/duotone.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <!-- JQuery UI -->
  <link rel="stylesheet" href="assets/css/jquery-ui.css">
  <!-- JQuery UI -->
  <link rel="stylesheet" href="assets/css/paginacao.css">
  <!-- Impressão do desenho -->
  <link rel="stylesheet" href="assets/css/style-desenho.css">
<style type="text/css">
.red {
  color:darkred;
    -webkit-animation: glow .5s infinite alternate;
    overflow-x: hidden; 
    overflow-y: hidden; 
    opacity: 1;
}

@-webkit-keyframes glow {
    to {
        text-shadow: 0 0 7px red;
    }
}
</style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a class="nav-link" href="reciboAddEdit.php"><i class="fad fa-plus"></i> Novo Recibo</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" href="reciboLogout.php"><i class="fas fa-sign-out-alt"></i> Sair do Sistema</a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="reciboIndex.php" class="brand-link">
      <img src="assets/img/kidometer.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="border-radius: 20%;">
      <span class="brand-text font-weight-light">Recibos</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="reciboIndex.php" class="nav-link">
              <i class="nav-icon fad fa-list"></i>
              <p>
                Listar Recibos
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fad fa-file-export"></i>
              <p>
                Exportar XML
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper"> 
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-8">
            <h1 class="m-0 text-dark">Recibo de Consulta Particular</h1>
            <p style="line-height:1.0;"><small><b>Atenção:</b> Os recibos devem ser emitidos no nome do <u>responsável pelo paciente</u>. <br />
              Se o CPF inserido for inválido um alerta vai aparecer nesta página. Corrija antes de Imprimir. <br />
              O valor padrão da Consulta Particular é <b>R$ 300,00</b>. <br />
              Para os clientes <b>BRADESCO</b> e <b>MEDISERVICE</b> o valor da consulta será de <b>R$ 150,00</b> <u>até que o credenciamento com estes convênios esteja habilitado</u>. <br />
              O pagamento pode ser feito em Cartão de Crédito/Débito e Pix.</small></p>
          </div><!-- /.col -->
          <div class="col-sm-2">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Recibos Particulares</li>
            </ol>
          </div>
          <div class="col-sm-2">
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
          <!-- /.col -->
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
          
        <hr>
        <!-- Data list table --> 
        <table class="table table-striped table-bordered">
          <thead>
            <tr>
              <th>ID</th>
              <th>Data</th>
              <th>Nome</th>
              <th>CPF</th>
              <th>Valor</th>
              <th>Observações</th>
              <th width="10%" colspan="3" style="text-align: center;">Ações</th>
            </tr>
          </thead>
          <tbody>
            <?php
            if(!empty($recibos)){ $count = 0; 
              foreach($recibos as $recibo){ $count++;
            ?>
            <tr>
              <td><?php echo $recibo['id']; ?></td>
              <td><?php echo date('d/m/Y', strtotime($recibo['created'])); ?></td>
              <td><?php echo $recibo['pagador']; ?></td>
              <td><?php echo $recibo['cpf']==''?"<span class='red'>⚠️ <em><b>CPF</b> inválido</span><br></em><a href='reciboAddEdit.php?id=".$recibo['id']."'>&raquo; Editar antes de Imprimir</a>":"<span class='cpf'>".$recibo['cpf']."</span>"; ?></td>
              <td style="text-align:right;">R$ <?php echo "<span class='valor'>".$recibo['valor']."</span>"; ?></td>
              <td><?php echo $recibo['observacao']; ?></td>
              <td style="text-align: center;">
                <a href="#" class="fad fa-print" onclick="window.open('reciboView.php?id=<?php echo $recibo['id']; ?>' , 'Visualizar/Imprimir','width=850,height=600,scrollbars=yes,resizable=yes',true);"></a>
              </td>              
              <td style="text-align: center;">
                <a href="reciboAddEdit.php?id=<?php echo $recibo['id']; ?>" class="fas fa-edit"></a>
              </td>
              <td style="text-align: center;">
                <a href="reciboAction.php?action_type=delete&id=<?php echo $recibo['id']; ?>" class="fas fa-trash-alt" onclick="return confirm('Tem certeza que deseja apagar?')"></a>
              </td>
            </tr>
            <?php } }else{ ?>
            <tr><td colspan="7">Expressão não encontrada...</td></tr>
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

  <footer class="main-footer">
    <strong>Copyright &copy; 2020-2021 by <a href="http://pediatriasimples.com">PediatriaSimples</a>.</strong>
    Todos os direitos reservados.
    <div class="float-right d-none d-sm-inline-block">
      <b>Versão</b> 2.1
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<script src="https://igorescobar.github.io/jQuery-Mask-Plugin/js/jquery.mask.min.js"></script>
<!-- Popper -->
<script src="plugins/popper/popper.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- SweetAlert2 -->
<script src="plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="plugins/toastr/toastr.min.js"></script>
<!-- JQVMap -->
<script src="plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="plugins/jquery-knob/jquery.knob.min.js"></script>
    <script type="text/javascript" src="lib/js/jquery.validate.js"></script>
    <script type="text/javascript" src="lib/js/jquery.validate.unobtrusive.js"></script>
<!-- daterangepicker -->
<script src="plugins/moment/moment.min.js"></script>
    <script type="text/javascript" src='app/js/zmi.js'></script>
    <script type="text/javascript" src='app/js/main.js'></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="plugins/summernote/summernote-bs4.min.js"></script>

<script type="text/javascript">
  $(document).ready(function(){
    $(".cpf").mask("999.999.999-99");
    $(".valor").mask('#.##0,00', {reverse: true});
  });
</script>


<script>
// Summernote Editor - lançar o editor e ao mesmo tempo configurar autocomplete
$.summernote.addPlugin({
    name: 'customEnter',
    events: {
        'insertParagraph': function (evt) {
            if (evt.which === 13 || evt.keyCode === 13)
                evt.shiftKey = true;
        }
    }
});    
    $('#editorprescricao').summernote({
        height: 200,
        placeholder: 'digite o atalho começando com [[',
        hint: { // trata-se de um JSON com os atalhos (poderá vir de um ajax... montar AJAX aqui mesmo na função)
            mentions: 'ajax/get_presc_preferidas_ajax.php';,
            match: /\B\[\[(\w*)$/,
            search: function (keyword, callback) {
                callback($.grep(this.mentions, function (item) {
                    return item.name.indexOf(keyword) == 0;
                }));
            },
            template: function (item) {
                return item.name;
            },
            content: function (item) { // Modela o que vai retornar no próprio editor
                return $('<x>'+item.observacao+'</x>')[0];
            }
        }
    });

</script>

<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="assets/js/adminlte.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="assets/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="assets/js/demo.js"></script>

<script src="validaCpfCnpj.js"></script>
</body>
</html>
