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
    'nome' => $searchKeyword
  );
}

// Get count of the users
$con = array(
  'like_or' => $searchArr,
  'return_type' => 'count'
);
$rowCount = $db->getRows('pedidos', $con);

// Initialize pagination class
$pagConfig = array(
  'baseURL' => 'livroIndex.php'.$searchStr,
  'totalRows' => $rowCount,
  'perPage' => $perPageLimit
);
$pagination = new Pagination($pagConfig);

// Get users from database
$con = array(
  'like_or' => $searchArr,
  'start' => $offset,
  'limit' => $perPageLimit,
  'order_by' => 'status DESC, id DESC',
);
$pedidos = $db->getRows('pedidos', $con);

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
            <h1 class="m-0 text-dark">Pedidos</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Pedidos de Livro</li>
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
            <a href="livroAddEdit.php" class="btn btn-primary" role="button" aria-pressed="true"><i class="fad fa-plus"></i> Novo</a>
          </span>
        <hr>
        <!-- Data list table --> 
        <table class="table table-sm table-striped table-bordered" width="100%">
          <thead>
            <tr>
              <th style="width: auto;">ID</th>
              <th style="width: 10%;">Nome</th>
              <th style="width: 15%;">Endereço</th>
              <th style="width: auto;">Contatos</th>
              <th style="width: auto;">Email</th>
              <th style="width: auto;text-align: center;">Qtd</th>
              <th style="width: auto;text-align: center;">Envio</th>
              <th style="width: auto;text-align: center;">Frete</th>
              <th style="width: auto;text-align: center;">Valor</th>
              <th style="width: auto;text-align: center;">Rastreamento</th>
              <th style="width: auto;text-align: center;">Status</th>
              <th style="width: auto;">Pedido</th>
              <th style="width: auto;">Postagem</th>             
              <th colspan="5" style="text-align: center;">Ações</th>
            </tr>
          </thead>
          <tbody>
            <?php
            if(!empty($pedidos)){ $count = 0; 
              foreach($pedidos as $pedido){ $count++;
              // formata a data antes de enviar para o JavaScript
              $dataHora = new DateTime($pedido['created']);
              $pedido['created_formatado'] = $dataHora->format('d/m/Y \à\s H:i') . 'h';
              $pedido['frete_formatado'] = number_format($pedido['frete'], 2, ',', '.');
              $pedido['valor_formatado'] = number_format($pedido['valor'], 2, ',', '.');
            ?>
            <tr>
              <td><?php echo $pedido['id']; ?></td>
              
              <td><?php echo strtoupper(html_entity_decode($pedido['nome'])); ?></td>
              <td><?php
                $endereco = html_entity_decode($pedido['endereco']);
                $enderecoNumero = html_entity_decode($pedido['end_numero'] ?? '');
                $enderecoComplemento = html_entity_decode($pedido['end_complemento'] ?? '');
                $cidade = html_entity_decode($pedido['cidade'] ?? '');
                echo '<strong>Endereço:</strong> '.html_entity_decode($endereco).', '.html_entity_decode($enderecoNumero).', '.html_entity_decode($enderecoComplemento);
                echo ' - '.$cidade.'<br>';
                echo '<span style="font-size:1em;"><strong>CEP:</strong> '.html_entity_decode($pedido['cep']).'</span>';
                ?>
              </td>
              <td><?php echo '<strong>Telefone:</strong> '.html_entity_decode($pedido['telefone']); ?><br>
              <?php echo '<strong>Whatsapp:</strong> '.html_entity_decode($pedido['whatsapp']); ?></td>
              <td><?php echo html_entity_decode($pedido['email']); ?></td>
              <td style="text-align: center;"><?php echo html_entity_decode($pedido['quantidade']); ?></td>
              <td style="text-align: center;"><?php echo html_entity_decode($pedido['tipo_entrega']); ?></td>
              <td style="text-align: center;"><?php echo 'R$ '.number_format($pedido['frete'], 2, ',', '.'); ?></td>
              <td style="text-align: center;"><?php echo 'R$ '.number_format($pedido['valor'], 2, ',', '.'); ?></td>
              <td><?php echo html_entity_decode($pedido['rastreamento']); ?></td>
              <td style="text-align: center;"><?php 
                    switch ($pedido['status']) {
                        case 0:
                            echo "<span class='badge badge-primary'>Recebido</span>";
                            break;
                        case 1:
                            echo "<span class='badge badge-warning'>Processado</span>";
                            break;
                        case 2:
                            echo "<span class='badge badge-info'>Despachado</span>";
                            break;
                        case 3:
                            echo "<span class='badge badge-success'>Recebido</span>";
                            break;
                        case 4:
                            echo "<span class='badge badge-danger'>Cancelado</span>";
                            break;
                    }
                  ?></td>
              <td><?php echo date("d/m/Y",strtotime($pedido['created'])); ?></td>
              <td><?php echo date("d/m/Y",strtotime($pedido['modified'])); ?></td>
              <td style="text-align: center;">
                <a href="#"
                   class="fad fa-copy"
                   onclick="copiarDados(<?php echo htmlspecialchars(json_encode($pedido)); ?>); return false;">
                </a>
              </td>
              <td style="text-align: center;"><a href="https://web.whatsapp.com/send?phone=5519997287078" class="fab fa-whatsapp" target="_blank" rel="noopener noreferrer" style="font-size: 1.2em; vertical-align: middle; line-height: 1; position: relative; top: -0.1em;"></a></td>
              <td style="text-align: center;">
                <a href="#" class="fad fa-print" onclick="window.open('livroView.php?id=<?php echo $pedido['id']; ?>' , 'Visualizar/Imprimir','width=850,height=600,scrollbars=yes,resizable=yes',true);"></a>
              </td>
              <td style="text-align: center;">
                <a href="livroAddEdit.php?id=<?php echo $pedido['id']; ?>" class="fad fa-edit"></a>
              </td>
              <td style="text-align: center;">
                <a href="livroAction.php?action_type=delete&id=<?php echo $pedido['id']; ?>" class="fad fa-trash-alt" onclick="return confirm('Tem certeza que deseja apagar?\n⚠️ Esta ação não pode ser desfeita!')"></a>
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
<script type="text/javascript">
async function copiarDados(pedido) {
  // HTML formatado
  const html = `
    <strong>Número:</strong> ${pedido.id}<br>
    <strong>Nome:</strong> ${pedido.nome}<br>
    <strong>Endereço:</strong> ${pedido.endereco}, ${pedido.end_numero}, ${pedido.end_complemento} - ${pedido.cidade}<br>
    <strong>Telefone:</strong> ${pedido.telefone}<br>
    <strong>Celular:</strong> ${pedido.whatsapp}<br>
    <strong>Quantidade:</strong> ${pedido.quantidade}<br>
    <strong>Email:</strong> ${pedido.email}<br>
    <strong>Entrega:</strong> ${pedido.tipo_entrega}<br>
    <strong>Frete:</strong> ${pedido.frete_formatado}<br>
    <strong>Valor Final:</strong> ${pedido.valor_formatado}<br>
    <hr>
    <small><strong>IP: </strong>${pedido.ip} || <strong>Criado em:</strong> ${pedido.created_formatado} </small>
  `;

  // Versão texto puro
  const texto = 
    `Número: ${pedido.id}\n` +
    `Nome: ${pedido.nome}\n` +
    `Endereço: ${pedido.endereco}, ${pedido.end_numero}, ${pedido.end_complemento} - ${pedido.cidade}\n` +
    `Telefone: ${pedido.telefone}\n` +
    `Celular: ${pedido.whatsapp}\n` +
    `Quantidade: ${pedido.quantidade}\n` +
    `Email: ${pedido.email}` +
    `Entrega: ${pedido.tipo_entrega}` +
    `Frete: ${pedido.frete_formatado}` +
    `Valor Final: ${pedido.valor_formatado}` +
    `IP: ${pedido.ip}` +
    `Criado em: ${pedido.created_formatado}`;

  try {
    await navigator.clipboard.write([
      new ClipboardItem({
        'text/html': new Blob([html], { type: 'text/html' }),
        'text/plain': new Blob([texto], { type: 'text/plain' })
      })
    ]);

    // Mostra notificação discreta de sucesso
    const aviso = document.createElement('div');
    aviso.textContent = '✅ Dados copiados para a área de transferência!';
    aviso.style.position = 'fixed';
    aviso.style.bottom = '20px';
    aviso.style.right = '20px';
    aviso.style.background = '#28a745';
    aviso.style.color = '#fff';
    aviso.style.padding = '10px 15px';
    aviso.style.borderRadius = '6px';
    aviso.style.fontSize = '0.9rem';
    aviso.style.zIndex = '9999';
    aviso.style.boxShadow = '0 2px 5px rgba(0,0,0,0.3)';
    document.body.appendChild(aviso);
    setTimeout(() => aviso.remove(), 2500);
  } 
  catch (err) {
    console.error('Erro ao copiar:', err);
    alert('❌ Não foi possível copiar os dados.');
  }
}
</script>