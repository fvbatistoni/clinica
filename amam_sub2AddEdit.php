<?php
$postData = $userData = array();

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

// Get user data
if(!empty($_GET['id'])){
  include 'DB.class.php';
  $db = new DB();
  $conditions['where'] = array(
    'id' => $_GET['id'],
  );
  $conditions['return_type'] = 'single';
  $userData = $db->getRows('amamentacao_sub2', $conditions);
}

// Pre-filled data
$userData = !empty($postData)?$postData:$userData;

// Define action
$actionLabel = !empty($_GET['id'])?'Editar':'Adicionar';

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
            <h1 class="m-0 text-dark">Sessão</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Amamentação</li>
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
      
      <!-- Add/Edit form -->
      <div class="panel panel-default">
        <div class="panel-heading"><a href="amam_sub2Index.php" class="float-right"><i class="fad fa-backward"></i> Voltar</a></div>
        <div class="panel-body">
          <form method="post" action="amam_sub2Action.php" class="form">
            <div class="form-group">
              <label>Nome</label>
              <input type="text" class="form-control" name="nome" value="<?php echo !empty($userData['nome'])?$userData['nome']:''; ?>">
            </div>
            <div class="form-group">
              <label>Capítulo</label>
              <select class="form-control" name="sub1">
                <option value="0" <?php echo !empty($userData['sub1'])&&$userData['sub1']=='0'?'selected="selected"':''; ?>>Apresentação</option>
                <option value="1" <?php echo !empty($userData['sub1'])&&$userData['sub1']=='1'?'selected="selected"':''; ?>>Introdução</option>
                <option value="2" <?php echo !empty($userData['sub1'])&&$userData['sub1']=='2'?'selected="selected"':''; ?>>Identificação das Drogas Segundo a Categoria de Risco</option>
                <option value="3" <?php echo !empty($userData['sub1'])&&$userData['sub1']=='3'?'selected="selected"':''; ?>>Farmacologia e Lactação</option>
                <option value="4" <?php echo !empty($userData['sub1'])&&$userData['sub1']=='4'?'selected="selected"':''; ?>>Guia de Medicamentos</option>
              </select>
            </div>
            <div class="form-group">
              <label>Sessão</label>
              <select class="form-control" name="sub2">
                <option value="1" <?php echo !empty($userData['sub2'])&&$userData['sub1']=='3'&&$userData['sub2']=='1'?'selected="selected"':''; ?>>MECANISMOS</option>
                <option value="2" <?php echo !empty($userData['sub2'])&&$userData['sub1']=='3'&&$userData['sub2']=='2'?'selected="selected"':''; ?>>MÉTODOS DE ESTIMATIVA DA EXCREÇÃO DE DROGAS PARA O LEITE HUMANO</option>
                <option value="3" <?php echo !empty($userData['sub2'])&&$userData['sub1']=='3'&&$userData['sub2']=='3'?'selected="selected"':''; ?>>PRINCÍPIOS GERAIS DE PRESCRIÇÃO DE DROGAS DURANTE O PERÍODO DA AMAMENTAÇÃO</option>
                <option value="1" <?php echo !empty($userData['sub2'])&&$userData['sub1']=='4'&&$userData['sub2']=='1'?'selected="selected"':''; ?>>MEIOS DE CONTRASTES RADIOLÓGICOS</option>
                <option value="2" <?php echo !empty($userData['sub2'])&&$userData['sub1']=='4'&&$userData['sub2']=='2'?'selected="selected"':''; ?>>AGENTES IMUNIZANTES</option>
                <option value="3" <?php echo !empty($userData['sub2'])&&$userData['sub1']=='4'&&$userData['sub2']=='3'?'selected="selected"':''; ?>>FÁRMACOS QUE ATUAM NO SISTEMA NERVOSO CENTRAL</option>
                <option value="4" <?php echo !empty($userData['sub2'])&&$userData['sub1']=='4'&&$userData['sub2']=='4'?'selected="selected"':''; ?>>ANALGÉSICOS, ANTIPIRÉTICOS, ANTI-INFLAMATÓRIOS NÃO ESTERÓIDES E FÁRMACOS PARA TRATAR GOTA</option>
                <option value="5" <?php echo !empty($userData['sub2'])&&$userData['sub1']=='4'&&$userData['sub2']=='5'?'selected="selected"':''; ?>>ANESTÉSICOS E MIORRELAXANTES</option>
                <option value="6" <?php echo !empty($userData['sub2'])&&$userData['sub1']=='4'&&$userData['sub2']=='6'?'selected="selected"':''; ?>>ANTI-HISTAMÍNICOS</option>
                <option value="7" <?php echo !empty($userData['sub2'])&&$userData['sub1']=='4'&&$userData['sub2']=='7'?'selected="selected"':''; ?>>ANTI-INFECCIOSOS</option>
                <option value="8" <?php echo !empty($userData['sub2'])&&$userData['sub1']=='4'&&$userData['sub2']=='8'?'selected="selected"':''; ?>>ANTISSÉPTICOS E DESINFETANTES</option>
                <option value="9" <?php echo !empty($userData['sub2'])&&$userData['sub1']=='4'&&$userData['sub2']=='9'?'selected="selected"':''; ?>>DIURÉTICOS</option>
                <option value="10" <?php echo !empty($userData['sub2'])&&$userData['sub1']=='4'&&$userData['sub2']=='10'?'selected="selected"':''; ?>>FÁRMACOS CARDIOVASCULARES</option>
                <option value="11" <?php echo !empty($userData['sub2'])&&$userData['sub1']=='4'&&$userData['sub2']=='11'?'selected="selected"':''; ?>>FÁRMACOS HEMATOLÓGICOS E PRODUTOS DO SANGUE</option>
                <option value="12" <?php echo !empty($userData['sub2'])&&$userData['sub1']=='4'&&$userData['sub2']=='12'?'selected="selected"':''; ?>>FÁRMACOS PARA O APARELHO RESPIRATÓRI</option>
                <option value="13" <?php echo !empty($userData['sub2'])&&$userData['sub1']=='4'&&$userData['sub2']=='13'?'selected="selected"':''; ?>>FÁRMACOS DE AÇÃO GASTROINTEST</option>
                <option value="14" <?php echo !empty($userData['sub2'])&&$userData['sub1']=='4'&&$userData['sub2']=='14'?'selected="selected"':''; ?>>HORMÔNIOS E ANTAGONISTAS</option>
                <option value="15" <?php echo !empty($userData['sub2'])&&$userData['sub1']=='4'&&$userData['sub2']=='15'?'selected="selected"':''; ?>>IMUNOSSUPRESSORES E ANTINEOPLÁSICOS</option>
                <option value="16" <?php echo !empty($userData['sub2'])&&$userData['sub1']=='4'&&$userData['sub2']=='16'?'selected="selected"':''; ?>>FÁRMACOS QUE AFETAM A HOMEOSTASIA MINERAL ÓSSEA</option>
                <option value="17" <?php echo !empty($userData['sub2'])&&$userData['sub1']=='4'&&$userData['sub2']=='17'?'selected="selected"':''; ?>>FÁRMACOS PARA PELE E MUCOSAS</option>
                <option value="18" <?php echo !empty($userData['sub2'])&&$userData['sub1']=='4'&&$userData['sub2']=='18'?'selected="selected"':''; ?>>VITAMINAS E MINERAIS</option>
                <option value="19" <?php echo !empty($userData['sub2'])&&$userData['sub1']=='4'&&$userData['sub2']=='19'?'selected="selected"':''; ?>>FÁRMACOS UTILIZADOS NO TRATAMENTO DA OBESIDADE</option>
                <option value="20" <?php echo !empty($userData['sub2'])&&$userData['sub1']=='4'&&$userData['sub2']=='20'?'selected="selected"':''; ?>>FÁRMACOS PARA USO OFTALMOLÓGICO</option>
                <option value="21" <?php echo !empty($userData['sub2'])&&$userData['sub1']=='4'&&$userData['sub2']=='21'?'selected="selected"':''; ?>>AGENTES TÓXICOS, ANTÍDOTOS E OUTRAS SUBSTÂNCIAS USADAS EM ENVENENAMENTO</option>
                <option value="22" <?php echo !empty($userData['sub2'])&&$userData['sub1']=='4'&&$userData['sub2']=='22'?'selected="selected"':''; ?>>MISCELÂNEA</option>
              </select>
            </div>
            <div class="form-group">
              <label>Informações</label>
              <textarea class="textarea" name="info"><?php echo !empty($userData['info'])?$userData['info']:''; ?></textarea>
            </div>
            <input type="hidden" name="id" value="<?php echo !empty($userData['id'])?$userData['id']:''; ?>">
            <button type="submit" name="userSubmit" class="btn btn-success" /><i class="fad fa-save"></i> Salvar</button>
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