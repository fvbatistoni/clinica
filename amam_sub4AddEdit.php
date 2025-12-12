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
  $userData = $db->getRows('amamentacao_sub4', $conditions);
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
            <h1 class="m-0 text-dark">Painel de Controle</h1>
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
        <div class="panel-heading"><a href="amam_sub4Index.php" class="float-right"><i class="fad fa-backward"></i> Voltar</a></div>
        <div class="panel-body">
          <form method="post" action="amam_sub4Action.php" class="form">
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
              <label>Sub3</label>
              <select class="form-control" name="sub3">
              <option value="1" <?php echo !empty($userData['sub3'])&&$userData['sub1']=='4'&&$userData['sub2']=='1'&&$userData['sub3']=='1'?'selected="selected"':''; ?>>Compostos radioativos</option>
              <option value="2" <?php echo !empty($userData['sub3'])&&$userData['sub1']=='4'&&$userData['sub2']=='1'&&$userData['sub3']=='2'?'selected="selected"':''; ?>>Outros meios de contraste</option>
              <option value="1" <?php echo !empty($userData['sub3'])&&$userData['sub1']=='4'&&$userData['sub2']=='2'&&$userData['sub3']=='1'?'selected="selected"':''; ?>>Soros e Imunoglobulinas</option>
              <option value="2" <?php echo !empty($userData['sub3'])&&$userData['sub1']=='4'&&$userData['sub2']=='2'&&$userData['sub3']=='2'?'selected="selected"':''; ?>>Vacinas</option>
              <option value="3" <?php echo !empty($userData['sub3'])&&$userData['sub1']=='4'&&$userData['sub2']=='2'&&$userData['sub3']=='3'?'selected="selected"':''; ?>>Agentes diagn&oacute;sticos</option>
              <option value="1" <?php echo !empty($userData['sub3'])&&$userData['sub1']=='4'&&$userData['sub2']=='3'&&$userData['sub3']=='1'?'selected="selected"':''; ?>>Antiepil&eacute;ticos (anticonvulsivantes)</option>
              <option value="2" <?php echo !empty($userData['sub3'])&&$userData['sub1']=='4'&&$userData['sub2']=='3'&&$userData['sub3']=='2'?'selected="selected"':''; ?>>Antidepressivos e estabilizadores do humor</option>
              <option value="3" <?php echo !empty($userData['sub3'])&&$userData['sub1']=='4'&&$userData['sub2']=='3'&&$userData['sub3']=='3'?'selected="selected"':''; ?>>Antipsic&oacute;ticos (neurol&eacute;pticos)</option>
              <option value="4" <?php echo !empty($userData['sub3'])&&$userData['sub1']=='4'&&$userData['sub2']=='3'&&$userData['sub3']=='4'?'selected="selected"':''; ?>>Antiparkinsonianos</option>
              <option value="5" <?php echo !empty($userData['sub3'])&&$userData['sub1']=='4'&&$userData['sub2']=='3'&&$userData['sub3']=='5'?'selected="selected"':''; ?>>F&aacute;rmacos contra enxaqueca</option>
              <option value="6" <?php echo !empty($userData['sub3'])&&$userData['sub1']=='4'&&$userData['sub2']=='3'&&$userData['sub3']=='6'?'selected="selected"':''; ?>>Hipn&oacute;ticos e ansiol&iacute;ticos</option>
              <option value="7" <?php echo !empty($userData['sub3'])&&$userData['sub1']=='4'&&$userData['sub2']=='3'&&$userData['sub3']=='7'?'selected="selected"':''; ?>>F&aacute;rmacos usados no tratamento dos transtorn</option>
              <option value="1" <?php echo !empty($userData['sub3'])&&$userData['sub1']=='4'&&$userData['sub2']=='4'&&$userData['sub3']=='1'?'selected="selected"':''; ?>>Analg&eacute;sicos n&atilde;o opi&oacute;ides e an</option>
              <option value="2" <?php echo !empty($userData['sub3'])&&$userData['sub1']=='4'&&$userData['sub2']=='4'&&$userData['sub3']=='2'?'selected="selected"':''; ?>>Analg&eacute;sicos opi&oacute;ides</option>
              <option value="3" <?php echo !empty($userData['sub3'])&&$userData['sub1']=='4'&&$userData['sub2']=='4'&&$userData['sub3']=='3'?'selected="selected"':''; ?>>F&aacute;rmacos para tratamento da gota e antiartr</option>
              <option value="1" <?php echo !empty($userData['sub3'])&&$userData['sub1']=='4'&&$userData['sub2']=='5'&&$userData['sub3']=='1'?'selected="selected"':''; ?>>Anest&eacute;sicos</option>
              <option value="2" <?php echo !empty($userData['sub3'])&&$userData['sub1']=='4'&&$userData['sub2']=='5'&&$userData['sub3']=='2'?'selected="selected"':''; ?>>Relaxantes musculares</option>
              <option value="1" <?php echo !empty($userData['sub3'])&&$userData['sub1']=='4'&&$userData['sub2']=='7'&&$userData['sub3']=='1'?'selected="selected"':''; ?>>Antibi&oacute;ticos</option>
              <option value="2" <?php echo !empty($userData['sub3'])&&$userData['sub1']=='4'&&$userData['sub2']=='7'&&$userData['sub3']=='2'?'selected="selected"':''; ?>>Antif&uacute;ngicos (sist&ecirc;micos)</option>
              <option value="3" <?php echo !empty($userData['sub3'])&&$userData['sub1']=='4'&&$userData['sub2']=='7'&&$userData['sub3']=='3'?'selected="selected"':''; ?>>Antivirais</option>
              <option value="4" <?php echo !empty($userData['sub3'])&&$userData['sub1']=='4'&&$userData['sub2']=='7'&&$userData['sub3']=='4'?'selected="selected"':''; ?>>F&aacute;rmacos antiameb&iacute;ase e antigiard&ia</option>
              <option value="5" <?php echo !empty($userData['sub3'])&&$userData['sub1']=='4'&&$userData['sub2']=='7'&&$userData['sub3']=='5'?'selected="selected"':''; ?>>F&aacute;rmacos antileshimaniose</option>
              <option value="6" <?php echo !empty($userData['sub3'])&&$userData['sub1']=='4'&&$userData['sub2']=='7'&&$userData['sub3']=='6'?'selected="selected"':''; ?>>F&aacute;rmacos antimal&aacute;ria</option>
              <option value="7" <?php echo !empty($userData['sub3'])&&$userData['sub1']=='4'&&$userData['sub2']=='7'&&$userData['sub3']=='7'?'selected="selected"':''; ?>>F&aacute;rmacos antitripanossom&iacute;ase</option>
              <option value="8" <?php echo !empty($userData['sub3'])&&$userData['sub1']=='4'&&$userData['sub2']=='7'&&$userData['sub3']=='8'?'selected="selected"':''; ?>>F&aacute;rmacos anti-helm&iacute;nticos</option>
              <option value="9" <?php echo !empty($userData['sub3'])&&$userData['sub1']=='4'&&$userData['sub2']=='7'&&$userData['sub3']=='9'?'selected="selected"':''; ?>>F&aacute;rmacos tuberculost&aacute;ticos</option>
              <option value="10" <?php echo !empty($userData['sub3'])&&$userData['sub1']=='4'&&$userData['sub2']=='7'&&$userData['sub3']=='10'?'selected="selected"':''; ?>>F&aacute;rmacos anti-hansen&iacute;ase</option>
              <option value="1" <?php echo !empty($userData['sub3'])&&$userData['sub1']=='4'&&$userData['sub2']=='8'&&$userData['sub3']=='1'?'selected="selected"':''; ?>>Antiss&eacute;pticos</option>
              <option value="2" <?php echo !empty($userData['sub3'])&&$userData['sub1']=='4'&&$userData['sub2']=='8'&&$userData['sub3']=='2'?'selected="selected"':''; ?>>Desinfetantes</option>
              <option value="1" <?php echo !empty($userData['sub3'])&&$userData['sub1']=='4'&&$userData['sub2']=='10'&&$userData['sub3']=='1'?'selected="selected"':''; ?>>Vasopressores</option>
              <option value="2" <?php echo !empty($userData['sub3'])&&$userData['sub1']=='4'&&$userData['sub2']=='10'&&$userData['sub3']=='2'?'selected="selected"':''; ?>>Antianginosos</option>
              <option value="3" <?php echo !empty($userData['sub3'])&&$userData['sub1']=='4'&&$userData['sub2']=='10'&&$userData['sub3']=='3'?'selected="selected"':''; ?>>Antiarr&iacute;tmicos</option>
              <option value="4" <?php echo !empty($userData['sub3'])&&$userData['sub1']=='4'&&$userData['sub2']=='10'&&$userData['sub3']=='4'?'selected="selected"':''; ?>>Anti-hiperlip&ecirc;micos</option>
              <option value="5" <?php echo !empty($userData['sub3'])&&$userData['sub1']=='4'&&$userData['sub2']=='10'&&$userData['sub3']=='5'?'selected="selected"':''; ?>>Anti-hipertensivos</option>
              <option value="6" <?php echo !empty($userData['sub3'])&&$userData['sub1']=='4'&&$userData['sub2']=='10'&&$userData['sub3']=='6'?'selected="selected"':''; ?>>F&aacute;rmacos utilizados para hipertens&atilde;o</option>
              <option value="7" <?php echo !empty($userData['sub3'])&&$userData['sub1']=='4'&&$userData['sub2']=='10'&&$userData['sub3']=='7'?'selected="selected"':''; ?>>Cardiot&ocirc;nicos e f&aacute;rmacos usados no tr</option>
              <option value="1" <?php echo !empty($userData['sub3'])&&$userData['sub1']=='4'&&$userData['sub2']=='11'&&$userData['sub3']=='1'?'selected="selected"':''; ?>>F&aacute;rmacos antian&ecirc;micos</option>
              <option value="2" <?php echo !empty($userData['sub3'])&&$userData['sub1']=='4'&&$userData['sub2']=='11'&&$userData['sub3']=='2'?'selected="selected"':''; ?>>F&aacute;rmacos que afetam a coagula&ccedil;&atild</option>
              <option value="3" <?php echo !empty($userData['sub3'])&&$userData['sub1']=='4'&&$userData['sub2']=='11'&&$userData['sub3']=='3'?'selected="selected"':''; ?>>Substitutos do plasma e fra&ccedil;&otilde;es plas</option>
              <option value="4" <?php echo !empty($userData['sub3'])&&$userData['sub1']=='4'&&$userData['sub2']=='11'&&$userData['sub3']=='4'?'selected="selected"':''; ?>>Outros f&aacute;rmacos</option>
              <option value="1" <?php echo !empty($userData['sub3'])&&$userData['sub1']=='4'&&$userData['sub2']=='12'&&$userData['sub3']=='1'?'selected="selected"':''; ?>>Antiasm&aacute;ticos</option>
              <option value="2" <?php echo !empty($userData['sub3'])&&$userData['sub1']=='4'&&$userData['sub2']=='12'&&$userData['sub3']=='2'?'selected="selected"':''; ?>>Antituss&iacute;genos, mucol&iacute;ticos, expecto</option>
              <option value="3" <?php echo !empty($userData['sub3'])&&$userData['sub1']=='4'&&$userData['sub2']=='12'&&$userData['sub3']=='3'?'selected="selected"':''; ?>>Descongestionantes nasais</option>
              <option value="1" <?php echo !empty($userData['sub3'])&&$userData['sub1']=='4'&&$userData['sub2']=='13'&&$userData['sub3']=='1'?'selected="selected"':''; ?>>Anti&aacute;cidos e outras drogas antiulcerosas</option>
              <option value="2" <?php echo !empty($userData['sub3'])&&$userData['sub1']=='4'&&$userData['sub2']=='13'&&$userData['sub3']=='2'?'selected="selected"':''; ?>>Antiem&eacute;ticos e gastrocin&eacute;ticos</option>
              <option value="3" <?php echo !empty($userData['sub3'])&&$userData['sub1']=='4'&&$userData['sub2']=='13'&&$userData['sub3']=='3'?'selected="selected"':''; ?>>Antiespasm&oacute;ticos</option>
              <option value="4" <?php echo !empty($userData['sub3'])&&$userData['sub1']=='4'&&$userData['sub2']=='13'&&$userData['sub3']=='4'?'selected="selected"':''; ?>>Cat&aacute;rticos (laxantes)</option>
              <option value="1" <?php echo !empty($userData['sub3'])&&$userData['sub1']=='4'&&$userData['sub2']=='14'&&$userData['sub3']=='1'?'selected="selected"':''; ?>>Corticoster&oacute;ides</option>
              <option value="2" <?php echo !empty($userData['sub3'])&&$userData['sub1']=='4'&&$userData['sub2']=='14'&&$userData['sub3']=='2'?'selected="selected"':''; ?>>Androg&ecirc;nios</option>
              <option value="3" <?php echo !empty($userData['sub3'])&&$userData['sub1']=='4'&&$userData['sub2']=='14'&&$userData['sub3']=='3'?'selected="selected"':''; ?>>Antidiab&eacute;ticos orais e insulina</option>
              <option value="4" <?php echo !empty($userData['sub3'])&&$userData['sub1']=='4'&&$userData['sub2']=='14'&&$userData['sub3']=='4'?'selected="selected"':''; ?>>Horm&ocirc;nios tireoideanos e f&aacute;rmacos ant</option>
              <option value="5" <?php echo !empty($userData['sub3'])&&$userData['sub1']=='4'&&$userData['sub2']=='14'&&$userData['sub3']=='5'?'selected="selected"':''; ?>>Contraceptivos</option>
              <option value="6" <?php echo !empty($userData['sub3'])&&$userData['sub1']=='4'&&$userData['sub2']=='14'&&$userData['sub3']=='6'?'selected="selected"':''; ?>>Ocit&oacute;cicos, erg&oacute;ticos, prostaglandin</option>
              <option value="7" <?php echo !empty($userData['sub3'])&&$userData['sub1']=='4'&&$userData['sub2']=='14'&&$userData['sub3']=='7'?'selected="selected"':''; ?>>Outros antagonistas hormonais</option>
              <option value="8" <?php echo !empty($userData['sub3'])&&$userData['sub1']=='4'&&$userData['sub2']=='14'&&$userData['sub3']=='8'?'selected="selected"':''; ?>>Outros horm&ocirc;nios</option>
              <option value="1" <?php echo !empty($userData['sub3'])&&$userData['sub1']=='4'&&$userData['sub2']=='15'&&$userData['sub3']=='1'?'selected="selected"':''; ?>>Imunossupressores</option>
              <option value="2" <?php echo !empty($userData['sub3'])&&$userData['sub1']=='4'&&$userData['sub2']=='15'&&$userData['sub3']=='2'?'selected="selected"':''; ?>>Antineopl&aacute;sicos</option>
              <option value="1" <?php echo !empty($userData['sub3'])&&$userData['sub1']=='4'&&$userData['sub2']=='17'&&$userData['sub3']=='1'?'selected="selected"':''; ?>>Escabicidas/pediculicidas</option>
              <option value="2" <?php echo !empty($userData['sub3'])&&$userData['sub1']=='4'&&$userData['sub2']=='17'&&$userData['sub3']=='2'?'selected="selected"':''; ?>>Antif&uacute;ngicos</option>
              <option value="3" <?php echo !empty($userData['sub3'])&&$userData['sub1']=='4'&&$userData['sub2']=='17'&&$userData['sub3']=='3'?'selected="selected"':''; ?>>Anti-infecciosos</option>
              <option value="4" <?php echo !empty($userData['sub3'])&&$userData['sub1']=='4'&&$userData['sub2']=='17'&&$userData['sub3']=='4'?'selected="selected"':''; ?>>Anti-inflamat&oacute;rios e antipruriginosos</option>
              <option value="5" <?php echo !empty($userData['sub3'])&&$userData['sub1']=='4'&&$userData['sub2']=='17'&&$userData['sub3']=='5'?'selected="selected"':''; ?>>F&aacute;rmacos adstringentes</option>
              <option value="6" <?php echo !empty($userData['sub3'])&&$userData['sub1']=='4'&&$userData['sub2']=='17'&&$userData['sub3']=='6'?'selected="selected"':''; ?>>Agentes queratopl&aacute;sticos, queratol&iacute;t</option>
              <option value="7" <?php echo !empty($userData['sub3'])&&$userData['sub1']=='4'&&$userData['sub2']=='17'&&$userData['sub3']=='7'?'selected="selected"':''; ?>>Agentes bloqueadores ultravioletas</option>
              <option value="8" <?php echo !empty($userData['sub3'])&&$userData['sub1']=='4'&&$userData['sub2']=='17'&&$userData['sub3']=='8'?'selected="selected"':''; ?>>F&aacute;rmacos usados no tratamento da acne e pso</option>
              <option value="1" <?php echo !empty($userData['sub3'])&&$userData['sub1']=='4'&&$userData['sub2']=='21'&&$userData['sub3']=='1'?'selected="selected"':''; ?>>Geral</option>
              <option value="2" <?php echo !empty($userData['sub3'])&&$userData['sub1']=='4'&&$userData['sub2']=='21'&&$userData['sub3']=='2'?'selected="selected"':''; ?>>Espec&iacute;ficos</option>
              <option value="1" <?php echo !empty($userData['sub3'])&&$userData['sub1']=='4'&&$userData['sub2']=='22'&&$userData['sub3']=='1'?'selected="selected"':''; ?>>Drogas de v&iacute;cio e abuso</option>
              <option value="2" <?php echo !empty($userData['sub3'])&&$userData['sub1']=='4'&&$userData['sub2']=='22'&&$userData['sub3']=='2'?'selected="selected"':''; ?>>F&aacute;rmacos usados no tratamento da depend&eci</option>
              <option value="3" <?php echo !empty($userData['sub3'])&&$userData['sub1']=='4'&&$userData['sub2']=='22'&&$userData['sub3']=='3'?'selected="selected"':''; ?>>F&aacute;rmacos agonistas e antagonistas colin&eac</option>
              <option value="4" <?php echo !empty($userData['sub3'])&&$userData['sub1']=='4'&&$userData['sub2']=='22'&&$userData['sub3']=='4'?'selected="selected"':''; ?>>Agentes ambientais</option>
              <option value="5" <?php echo !empty($userData['sub3'])&&$userData['sub1']=='4'&&$userData['sub2']=='22'&&$userData['sub3']=='5'?'selected="selected"':''; ?>>Repelente</option>
              <option value="6" <?php echo !empty($userData['sub3'])&&$userData['sub1']=='4'&&$userData['sub2']=='22'&&$userData['sub3']=='6'?'selected="selected"':''; ?>>Alimentos</option>
              <option value="7" <?php echo !empty($userData['sub3'])&&$userData['sub1']=='4'&&$userData['sub2']=='22'&&$userData['sub3']=='7'?'selected="selected"':''; ?>>Fitoter&aacute;picos</option>
              <option value="8" <?php echo !empty($userData['sub3'])&&$userData['sub1']=='4'&&$userData['sub2']=='22'&&$userData['sub3']=='8'?'selected="selected"':''; ?>>Cosm&eacute;ticos</option>
              <option value="9" <?php echo !empty($userData['sub3'])&&$userData['sub1']=='4'&&$userData['sub2']=='22'&&$userData['sub3']=='9'?'selected="selected"':''; ?>>F&aacute;rmacos n&atilde;o classificados nas se&cc</option>
            </select>
            </div>
            <div class="form-group">
              <label>Sub4</label>
              <select class="form-control" name="sub4">
                <option value="1" <?php echo !empty($userData['sub4'])&&$userData['sub1']=='4'&&$userData['sub2']=='7'&&$userData['sub3']=='1'&&$userData['sub4']=='1'?'selected="selected"':''; ?>>Penicilinas</option>
                <option value="2" <?php echo !empty($userData['sub4'])&&$userData['sub1']=='4'&&$userData['sub2']=='7'&&$userData['sub3']=='1'&&$userData['sub4']=='2'?'selected="selected"':''; ?>>Cefalosporinas</option>
                <option value="4" <?php echo !empty($userData['sub4'])&&$userData['sub1']=='4'&&$userData['sub2']=='7'&&$userData['sub3']=='1'&&$userData['sub4']=='4'?'selected="selected"':''; ?>>Aminoglicos&iacute;deos</option>
                <option value="5" <?php echo !empty($userData['sub4'])&&$userData['sub1']=='4'&&$userData['sub2']=='7'&&$userData['sub3']=='1'&&$userData['sub4']=='5'?'selected="selected"':''; ?>>Sulfonamidas</option>
                <option value="6" <?php echo !empty($userData['sub4'])&&$userData['sub1']=='4'&&$userData['sub2']=='7'&&$userData['sub3']=='1'&&$userData['sub4']=='6'?'selected="selected"':''; ?>>Quinolonas</option>
                <option value="1" <?php echo !empty($userData['sub4'])&&$userData['sub1']=='4'&&$userData['sub2']=='10'&&$userData['sub3']=='5'&&$userData['sub4']=='1'?'selected="selected"':''; ?>>Beta bloqueadores</option>
                <option value="1" <?php echo !empty($userData['sub4'])&&$userData['sub1']=='4'&&$userData['sub2']=='13'&&$userData['sub3']=='4'&&$userData['sub4']=='1'?'selected="selected"':''; ?>>Laxantes de origem vegetal (formadores de massa)</option>
                <option value="2" <?php echo !empty($userData['sub4'])&&$userData['sub1']=='4'&&$userData['sub2']=='13'&&$userData['sub3']=='4'&&$userData['sub4']=='2'?'selected="selected"':''; ?>>Laxantes estimulantes</option>
                <option value="3" <?php echo !empty($userData['sub4'])&&$userData['sub1']=='4'&&$userData['sub2']=='13'&&$userData['sub3']=='4'&&$userData['sub4']=='3'?'selected="selected"':''; ?>>Laxantes lubrificantes</option>
              </select>
            </div>
            <div class="form-group">
              <label>Info</label>
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