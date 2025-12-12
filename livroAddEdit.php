<?php
$postData = $pedidoData = array();

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

// Get pedido data
if (!empty($_GET['id'])) {
    include 'DB.class.php';
    $db = new DB();
    $conditions['where'] = array(
        'id' => $_GET['id'],
    );
    $conditions['return_type'] = 'single';
    $pedidoData = $db->getRows('pedidos', $conditions);
}

// Pre-filled data
$pedidoData = !empty($postData) ? $postData : $pedidoData;

// Define action
$actionLabel = !empty($_GET['id']) ? 'Editar' : 'Adicionar';

$status = isset($pedidoData['status']) ? $pedidoData['status'] : "0";
$pedidoEntrega = isset($pedidoData['tipo_entrega']) ? $pedidoData['tipo_entrega'] : "SIMPLES";

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
            <h1 class="m-0 text-dark">Adicionar/Editar Prescrição</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Prescrições</li>
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
          <form method="post" action="livroAction.php" class="form">
            <div class="form-group">
              <label for="nome">Nome Completo</label>
              <input type="text" class="form-control" name="nome" id="nome" required maxlength="100" value="<?php echo !empty($pedidoData['nome']) ? $pedidoData['nome'] : ''; ?>">
            </div>
            <div class="form-row">
              <div class="form-group col-md-2">
                <label for="cep">CEP</label>
                <input type="text" class="form-control" name="cep" id="cep"
                       required placeholder="00000-000" maxlength="9" value="<?php echo !empty($pedidoData['cep']) ? $pedidoData['cep'] : ''; ?>">
              </div>
              <div class="form-group col-md-6">
                <label for="endereco">Endereço</label>
                <div class="input-group">
                  <input type="text" class="form-control" name="endereco" id="endereco" required maxlength="200" value="<?php echo !empty($pedidoData['endereco']) ? $pedidoData['endereco'] : ''; ?>">
                </div>
              </div>
              <div class="form-group col-md-3">
                <label for="cidade">Cidade</label>
                <div class="input-group">
                  <input type="text" class="form-control" name="cidade" id="cidade" required maxlength="200" value="<?php echo !empty($pedidoData['cidade']) ? $pedidoData['cidade'] : ''; ?>">
                </div>
              </div>
              <div class="form-group col-md-1">
                <label for="cep">Número</label>
                <input type="text" class="form-control" name="end_numero" id="end_numero" required maxlength="20" value="<?php echo !empty($pedidoData['end_numero']) ? $pedidoData['end_numero'] : ''; ?>">
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-4">
                <label for="cep">Complemento (apartamento/casa)</label>
                <input type="text" class="form-control" name="end_complemento" id="end_complemento" maxlength="200" value="<?php echo !empty($pedidoData['end_complemento']) ? $pedidoData['end_complemento'] : ''; ?>">
              </div>
              <div class="form-group col-md-2">
                <label for="telefone">Telefone</label>
                <input type="text" class="form-control" name="telefone" id="telefone"
                       required maxlength="20" placeholder="(19) XXXX-XXXX" value="<?php echo !empty($pedidoData['telefone']) ? $pedidoData['telefone'] : ''; ?>">
              </div>
              <div class="form-group col-md-2">
                <label for="telefone">Whatsapp</label>
                <input type="text" class="form-control" name="whatsapp" id="whatsapp"
                       required maxlength="20" placeholder="(19) 9XXXX-XXXX" value="<?php echo !empty($pedidoData['whatsapp']) ? $pedidoData['whatsapp'] : ''; ?>">
              </div>
              <div class="form-group col-md-4">
                <label for="email">E-mail</label>
                <input type="email" class="form-control" name="email" id="email" required maxlength="100" value="<?php echo !empty($pedidoData['email']) ? $pedidoData['email'] : ''; ?>">
              </div>
            </div>        
            <div class="form-row">
              <div class="form-group col-md-1">            
                <label for="quantidade">Quantidade</label>
                <input type="text" class="form-control" name="quantidade" id="quantidade" required maxlength="10" value="<?php echo !empty($pedidoData['quantidade']) ? $pedidoData['quantidade'] : ''; ?>">
              </div>
              <div class="form-group col-md-2">
                <label>Tipo de Entrega</label><br>
                <div class="form-control d-flex align-items-center justify-content-around">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="tipo_entrega" id="simples" value="SIMPLES" required <?= ($pedidoEntrega == "SIMPLES") ? 'checked' : '' ?>>
                    <label class="form-check-label" for="simples">NORMAL</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="tipo_entrega" id="sedex" value="SEDEX" required <?= ($pedidoEntrega == "SEDEX") ? 'checked' : '' ?>>
                    <label class="form-check-label" for="sedex">SEDEX</label>
                  </div>
                </div>
              </div>
              <div class="form-group col-md-2 text-center">
                <label>Valor Frete</label><br>                
                <input type="number" class="form-control" name="frete" id="frete" placeholder="Valor decimal" step="0.01" 
                value="<?php 
                  switch ($pedidoData['tipo_entrega']) {
                      case "SIMPLES":
                          $label = '8.90';
                          break;
                      case "SEDEX":
                          $label = '24.90';
                          break;
                      default:
                          $label = '0';
                  }
                  echo $label; ?>"
                >
              </div>
              <div class="form-group col-md-2 text-center">
                <label>Valor Estimado</label><br>
                <input type="number" class="form-control" name="valor" id="valor" step="0.01" readonly>
              </div>
              <div class="form-group col-md-2">            
                <label for="rastreamento">Rastreamento</label>
                <input type="text" class="form-control" name="rastreamento" id="rastreamento" maxlength="25" value="<?php echo !empty($pedidoData['rastreamento']) ? $pedidoData['rastreamento'] : ''; ?>">
              </div>              
              <div class="form-group col-md-3">
                <label>Status</label><br>
                <select class="form-control" name="status">
                  <option value="0" <?= ($status == "0") ? 'selected' : '' ?>>Recebido</option>
                  <option value="1" <?= ($status == "1") ? 'selected' : '' ?>>Processado</option>
                  <option value="2" <?= ($status == "2") ? 'selected' : '' ?>>Despachado</option>
                  <option value="3" <?= ($status == "3") ? 'selected' : '' ?>>Finalizado</option>
                  <option value="4" <?= ($status == "4") ? 'selected' : '' ?>>Cancelado</option>
                </select>
              </div>
            </div>
            <input type="hidden" name="id" value="<?php echo !empty($pedidoData['id']) ? $pedidoData['id'] : ''; ?>">
            <button type="submit" id="pedidoSubmit" name="pedidoSubmit" class="btn btn-success" /><i class="fad fa-save"></i> Salvar</button>
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
// ===== UTIL =====
function limpar($s) {
    return htmlspecialchars(strip_tags(trim($s ?? '')), ENT_QUOTES, 'UTF-8');
}
	include 'footer.php'; // Fecha a div wrapper
?>
<script type="text/javascript">
$(function() {
  // Quando clicar em qualquer opção de tipo_entrega
  $('input[name="tipo_entrega"]').on('change', function() {
    const tipo = $(this).val();
    let frete = 0;

    switch (tipo) {
      case 'SIMPLES':
        frete = 3.80;
        break;
      case 'SEDEX':
        frete = 13.50;
        break;
      default:
        frete = 0;
    }

    // Atualiza o campo frete com duas casas decimais
    $('#frete').val(frete.toFixed(2));

    // Se quiser atualizar o valor total também (opcional)
    atualizarValor();
  });

  // Atualiza valor total automaticamente ao mudar quantidade ou frete
  $('#quantidade, #frete').on('input change', atualizarValor);

  // Função de cálculo de valor total
  function atualizarValor() {
    const qtd = parseFloat($('#quantidade').val()) || 0;
    const frete = parseFloat($('#frete').val()) || 0;
    const valor = (qtd * 40) + frete;
    $('#valor').val(valor.toFixed(2));
  }

  // Executa na carga inicial
  atualizarValor();
});
</script>
<script type="text/javascript">
// === Busca automática do endereço (ViaCEP) ===
$('#cep').on('blur', function(){
  const cep = $(this).val().replace(/\D/g, '');
  if(cep.length !== 8){ return; }

  $('#loadingCep').removeClass('d-none');
  $('#endereco').val('Buscando endereço...');
  $('#cidade').val('Buscando cidade...');

  $.getJSON(`https://viacep.com.br/ws/${cep}/json/`, function(dados){
    if(!("erro" in dados)){
      let logradouro = dados.logradouro || '';
      let bairro = dados.bairro ? `, ${dados.bairro}` : '';
      let cidade = dados.localidade ? ` - ${dados.localidade}` : '';
      let uf = dados.uf ? `/${dados.uf}` : '';
      $('#endereco').val(`${logradouro}${bairro}`);
      $('#cidade').val(`${cidade}${uf}`);
    } else {
      $('#endereco').val('');
      alert('CEP não encontrado.');
    }
  }).fail(function(){
    $('#endereco').val('');
    alert('Erro ao consultar o CEP.');
  }).always(function(){
    $('#loadingCep').addClass('d-none');
  });
});
</script>