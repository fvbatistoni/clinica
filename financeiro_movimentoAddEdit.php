<?php
$postData = $userData = array();

// Get session data
$sessData = !empty($_SESSION['sessData']) ? $_SESSION['sessData'] : '';

// Get status message from session
if (!empty($sessData['status']['msg'])) {
    $statusMsg = $sessData['status']['msg'];
    $statusMsgType = $sessData['status']['type'];
    unset($_SESSION['sessData']['status']);
}

// Get posted data from session
if (!empty($sessData['postData'])) {
    $postData = $sessData['postData'];
    unset($_SESSION['sessData']['postData']);
}

// Get user data
if (!empty($_GET['id'])) {
  include 'DB.class.php';
  $db = new DB();
  $conditions['where'] = array(
    'id' => $_GET['id'],
  );
  $conditions['return_type'] = 'single';
  $userData = $db->getRows('financeiro_movimentos', $conditions);
}

// Pre-filled data
$userData = !empty($postData) ? $postData : $userData;


// Define action
$actionLabel = !empty($_GET['id']) ? 'Editar' : 'Adicionar';

include 'header.php';
?>
<style>
  small {
    font-size: x-small !important;
    font-style: italic !important;
    color: grey;
  }
</style>
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
            <h1 class="m-0 text-dark">Movimentações Financeiras</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Livro-Caixa</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <!-- Display status message -->
            <?php if (!empty($statusMsg) && ($statusMsgType == 'success')) { ?>
            <div class="callout callout-success"><?php echo $statusMsg; ?></div>
            <?php } elseif (!empty($statusMsg) && ($statusMsgType == 'error')) { ?>
            <div class="callout callout-danger"><?php echo $statusMsg; ?></div>
            <?php } ?>
            
            <!-- Add/Edit form -->
            <div class="panel panel-default">
              <div class="panel-body">
                <form method="post" action="financeiro_movimentoAction.php" class="form">
                  <div class="row">
                    <div class="col-md-11">
                      <div class="form-group">
                        <label>Categoria</label>
                        <small>Receita / Despesa</small>
                        <select class="form-control" name="categoria">
                          <?php                     
                            if (!class_exists('DB')) {
                               include 'DB.class.php';
                            }
                            $consulta = new DB();             
                            $movimentos_cats = $consulta->getAllFinanceiroCats();
                            
                            echo '<option>Escolha</option>';
                            
                            for ($x = 0; $x < count($movimentos_cats); $x++) {
                                echo '<option value="' . $movimentos_cats[$x]['id'] . '"';
                                echo (isset($userData['categoria']) && $userData['categoria'] == $movimentos_cats[$x]['id']) ? ' selected' : '';
                                echo '>' . $movimentos_cats[$x]['nome'] . '</option>';
                            }                     
                          ?>
                        </select>             
                      </div>                      
                    </div>
                    <div class="col-md-1">
                      <label>Status</label>
                      <div class="form-group">                        
                        <input type="checkbox" name="status" value="1" data-toggle="toggle" data-on="Pago" data-off="Não pago" data-onstyle="success" data-offstyle="danger" <?= (!empty($userData['status']) && $userData['status'] == 1) ? 'checked' : '' ?>>
                      </div>
                    </div>
                </div>
                  </div>          
                  <div class="row">
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>Valor</label>
                        <small>Líquido</small>                  
                        <input class="form-control" name="valor" type="text" value="<?php echo isset($userData['valor']) ? $userData['valor'] : ''; ?>">
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>Código Receita</label>
                        <small>Para DARF</small>
                        <input type="text" class="form-control" name="codigo_ReceitaFederal" value="<?php echo isset($userData['codigo_ReceitaFederal']) ? $userData['codigo_ReceitaFederal'] : ''; ?>">
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>CPF/CNPJ</label>
                        <small>Definir o Beneficiário</small>
                        <input type="text" class="form-control" id="cpf_movimentacao" name="cpf_cnpj" value="<?php echo isset($userData['cpf_cnpj']) ? $userData['cpf_cnpj'] : ''; ?>">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>Descrição</label>
                        <small>Descrição sucinta para facilitar agrupamentos.</small>
                        <input type="text" class="form-control" name="descricao" value="<?php echo isset($userData['descricao']) ? $userData['descricao'] : ''; ?>">
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>Detalhes</label>
                        <small>Quando for preciso inserir nome da criança, beneficiário ou descrever procedimento.</small>
                        <input type="text" class="form-control" id="nome_movimentacao" name="detalhes" value="<?php echo isset($userData['detalhes']) ? $userData['detalhes'] : ''; ?>">
                      </div>
                    </div> 
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>Data</label>
                        <input type="date" class="form-control" name="data_recebimento" value="<?php echo isset($userData['data_recebimento']) ? date('Y-m-d', strtotime($userData['data_recebimento'])) : date('Y-m-d'); ?>">
                      </div>
                    </div>                            
                  </div>
                  <input type="hidden" name="id" value="<?php echo isset($userData['id']) ? $userData['id'] : ''; ?>">
                  <button type="submit" name="userSubmit" class="btn btn-success" /><i class="fad fa-save"></i> Salvar</button>
                </form>
              </div>
            </div>
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
