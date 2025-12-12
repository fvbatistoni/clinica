<!-- Adicionando CSS -->
<style>
    #searchIcon {
        cursor: pointer; /* Muda o cursor para o "dedinho" */
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
$perPageLimit = 20;
$offset = !empty($_GET['page'])?(($_GET['page']-1)*$perPageLimit):0;

// Get search keyword
$searchKeyword = !empty($_GET['sq'])?$_GET['sq']:''; 
$searchStr = !empty($searchKeyword)?'?sq='.$searchKeyword:'';

// Search DB query
if(!empty($searchKeyword)){
  $searchArr = array(
    'tipo' => $searchKeyword,
    'categoria' => $searchKeyword,
    'descricao' => $searchKeyword,
    'detalhes' => $searchKeyword,
    'valor' => $searchKeyword
  );
}

// Get count of the users
$con = array(
  'like_or' => $searchArr,
  'return_type' => 'count'
);
$rowCount = $db->getRows('financeiro_movimentos', $con);

// Initialize pagination class
$pagConfig = array(
  'baseURL' => 'financeiro_movimentoIndex.php'.$searchStr,
  'totalRows' => $rowCount,
  'perPage' => $perPageLimit
);
$pagination = new Pagination($pagConfig);

// Get users from database
$con = array(
  'like_or' => $searchArr,
  'start' => $offset,
  'limit' => $perPageLimit,
  'order_by' => 'data_recebimento DESC',
);
$financeiro_movimentos = $db->getRows('financeiro_movimentos', $con);

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
            <h1 class="m-0 text-dark">Painel de Controle</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Livro Caixa</li>
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
        <p style="font-size: small; color: grey;"><b>Alíquotas efetivas das Notas Fiscais da FS SERVIÇOS:</b> PIS: 0,6500% / COFINS: 3,0000% / IR: 1,5000% / CSLL: 1,0000% / ISSQN: 5,00% <br><b>Total de Tributos:</b> 11,15% do valor bruto da nota.</p>
        <div class="row mb-4">
          <div class="col-md-10">
            <!-- Add link -->
            <span class="float-right">
              <a href="financeiro_movimentoAddEdit.php" class="btn btn-primary" role="button" aria-pressed="true"><i class="fad fa-plus"></i> Nova Movimentação</a>
            </span>          
          </div>
          <div class="col-md-2 search-panel">
            <!-- Search form -->
            <form class="form-inline float-right" id="searchForm">
            <div class="input-group">
              <input type="text" name="sq" class="form-control" placeholder="Busca palavra-chave..." value="<?php echo $searchKeyword; ?>">
                      <span class="input-group-append">
                          <div class="input-group-text bg-transparent" id="searchIcon">
                              <i class="fa fa-search"></i>
                          </div>
                      </span>
            </div>
            </form>
          </div>
        </div>        
        <div class="card">
          <div class="card-header">
            <h3 class="card-title" style="font-size: x-large;">Resumo Financeiro</h3>
              <div class="card-tools">                  
                <div class="btn-group">
                <select class="form-control-sm" id="ano">
                  <option value='<?= date("Y") ?>'><?= date("Y") ?></option>
                  <option value='<?= date("Y",strtotime('-1year')) ?>'><?= date("Y",strtotime('-1year')) ?></option>
                  <option value='<?= date("Y",strtotime('-2year')) ?>'><?= date("Y",strtotime('-2year')) ?></option>
                  <option value='<?= date("Y",strtotime('-3year')) ?>'><?= date("Y",strtotime('-3year')) ?></option>
                  <option value='<?= date("Y",strtotime('-4year')) ?>'><?= date("Y",strtotime('-4year')) ?></option>
                  <option value='<?= date("Y",strtotime('-5year')) ?>'><?= date("Y",strtotime('-5year')) ?></option>
                </select>
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fad fa-minus"></i>
                </button>
                </div>
              </div>
            <!-- /.card-tools -->
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div id="tabela_financeira_anual"></div>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->

        <!-- Data list table --> 
        <table class="table table-striped table-bordered" width="100%">
          <thead>
            <tr>
              <th width="5%">ID</th>
              <th width="10%">Tipo</th>
              <th width="10%">Data Recebimento</th> <!-- Alterado para Data Recebimento -->
              <th width="">Categoria</th>
              <th width="15%">Valor</th>
              <th>Status</th>
              <th width="10%" colspan="2" style="text-align: center;">Ações</th>
            </tr>
          </thead>
          <tbody>
            <?php
            if(!empty($financeiro_movimentos)){ $count = 0; 
              foreach($financeiro_movimentos as $financeiro_movimento){ $count++;
            ?>
            <tr>
              <td><?php echo $financeiro_movimento['id']; ?></td>
              <td class="text-center"><?php echo $financeiro_movimento['tipo'] == 0?'<span class="text-danger"><i class="fad fa-minus"></i> Débito</div>':'<span class="text-success"><i class="fad fa-plus"></i> Crédito</div>'; ?></td>
              <td class="text-center"><?php echo date("d/m/Y", strtotime($financeiro_movimento['data_recebimento'])); ?></td> <!-- Alterado para data_recebimento -->
              <td>
                <?php 
                  $financeiro_categoria = $db->getfinanceiroCat($financeiro_movimento['categoria']);
                  echo $financeiro_categoria['nome'];
                  echo !empty($financeiro_movimento['descricao'])?'<br><small><i class="fa fa-share"></i> '.$financeiro_movimento['descricao'].'</small>':''; 
                  echo !empty($financeiro_movimento['cpf_cnpj']) && strlen($financeiro_movimento['cpf_cnpj']) == 14?' - <small class="text-muted"><strong>CPF:</strong> '.$financeiro_movimento['cpf_cnpj'].'</small>':''; 
                  echo !empty($financeiro_movimento['cpf_cnpj']) && strlen($financeiro_movimento['cpf_cnpj']) == 18?'- <small class="text-muted"><strong>CNPJ:</strong> '.$financeiro_movimento['cpf_cnpj'].'</small>':''; 
                  echo !empty($financeiro_movimento['detalhes'])?'<br><small class="text-muted">'.$financeiro_movimento['detalhes'].'</small>':''; 
                  echo !empty($financeiro_movimento['codigo_ReceitaFederal'])?'<br><small class="text-muted"><strong>Código da Receita:</strong> '.$financeiro_movimento['codigo_ReceitaFederal'].'</small>':''; 
                  echo !empty($financeiro_movimento['cod_LivroCaixa'])?'<br><small class="text-muted"><strong>Livro Caixa:</strong> '.$financeiro_movimento['cod_LivroCaixa'].'</small>':'';                                   
                ?>
              </td>
              <td style="text-align: right;font-weight: bold;">R$ <?php echo number_format($financeiro_movimento['valor'], 2, ',', '.'); ?></td>
              <td>
                <input type="checkbox" class="toggle-status" data-id="<?= $financeiro_movimento['id'] ?>" data-toggle="toggle" data-on="Pago" data-off="Não pago" data-onstyle="success" data-offstyle="danger" data-size="sm" <?= ($financeiro_movimento['status'] == 1) ? 'checked' : '' ?>>
              </td>
              <td style="text-align: center;">
                <a href="financeiro_movimentoAddEdit.php?id=<?php echo $financeiro_movimento['id']; ?>" class="fad fa-edit"></a>
              </td>
              <td style="text-align: center;">
                <a href="financeiro_movimentoAction.php?action_type=delete&id=<?php echo $financeiro_movimento['id']; ?>" class="fad fa-trash-alt" onclick="return confirm('Tem certeza que deseja apagar?')"></a>            
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

      <div class="modal fade" id="financeiro_movimentoAddEdit">
        <div class="modal-dialog modal-md">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Adicionar/Editar</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              pensar no formulário
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->
<script>
    document.getElementById('searchIcon').addEventListener('click', function() {
        document.getElementById('searchForm').submit();
    });
</script>
<?php
  include 'footer.php'; // Fecha a div wrapper
?>