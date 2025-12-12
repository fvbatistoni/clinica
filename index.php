<?php
require_once 'header.php';
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
            <h1 class="m-0 text-dark">Informações e Estatísticas Gerais</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Informações e Estatísticas Gerais</li>
              <li class="breadcrumb-item">
                <!-- select -->
                <label>Ano:</label>
                  <select class="form-control form-control-sm" id="ano">
                    <option value='<?php echo date("Y"); ?>'><?php echo date("Y"); ?></option>
                    <option value='<?php echo date("Y",strtotime('-1year')); ?>'><?php echo date("Y",strtotime('-1year')); ?></option>
                    <option value='<?php echo date("Y",strtotime('-2year')); ?>'><?php echo date("Y",strtotime('-2year')); ?></option>
                    <option value='<?php echo date("Y",strtotime('-3year')); ?>'><?php echo date("Y",strtotime('-3year')); ?></option>
                    <option value='<?php echo date("Y",strtotime('-4year')); ?>'><?php echo date("Y",strtotime('-4year')); ?></option>
                    <option value='<?php echo date("Y",strtotime('-5year')); ?>'><?php echo date("Y",strtotime('-5year')); ?></option>
                    <option value='<?php echo date("Y",strtotime('-6year')); ?>'><?php echo date("Y",strtotime('-6year')); ?></option>
                    <option value='<?php echo date("Y",strtotime('-7year')); ?>'><?php echo date("Y",strtotime('-7year')); ?></option>
                    <option value='<?php echo date("Y",strtotime('-8year')); ?>'><?php echo date("Y",strtotime('-8year')); ?></option>
                    <option value='<?php echo date("Y",strtotime('-9year')); ?>'><?php echo date("Y",strtotime('-9year')); ?></option>
                  </select>
            </li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3><div id="ticket-medio"></div></h3>

                <p>Ticket Médio (R$)</p>
              </div>
              <div class="icon">
                <i class="fad fa-usd-square mr-1"></i>
              </div>
              <a class="small-box-footer" data-toggle="modal" data-target="#modal-historico-ticket-medio">Histórico <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
    <!-- Modal Ticket Médio -->
      <div class="modal fade" id="modal-historico-ticket-medio">
        <div class="modal-dialog modal-md">
          <div class="modal-content bg-info">
            <div class="modal-header">
              <h4 class="modal-title">Histórico Ticket Médio</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              Histórico aqui --> gerar tabela -- ainda em compreensão
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>    
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3><div id="atendimentos_mes_atual"></div></h3>

                <p>Consultas este mês</p>
              </div>
              <div class="icon">
                <i class="fad fa-chart-line mr-1"></i>
              </div>
              <a class="small-box-footer" data-toggle="modal" data-target="#modal-contagem-consultas">Detalhes <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->

              <!-- Modal Contagem de Consultas -->
                <div class="modal fade" id="modal-contagem-consultas">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title">Contagem de Atendimentos</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <div id="contagem_consultas"></div>
                      </div>
                    </div>
                    <!-- /.modal-content -->
                  </div>
                  <!-- /.modal-dialog -->
                </div>
                <!-- /.modal -->

          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3><div id="ocupacao_mes_atual"></div></h3>

                <p>Ocupação da Agenda (%)</p>
              </div>
              <div class="icon">
                <i class="fad fa-coins mr-1"></i>
              </div>
              <a class="small-box-footer" data-toggle="modal" data-target="#modal-ocupacao-agenda">Detalhes <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

    <!-- Modal Contagem de Consultas -->
      <div class="modal fade" id="modal-ocupacao-agenda">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Ocupação da Agenda</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">              
              <div class="row">
                <div class="col-md-4">
                  <p class="text-muted"><b>Cálculo:</b> Agendadas/Disponibilizadas</p>
                </div>
                <div class="col-md-8">
                  <div id="ocupacao_agenda" style="max-width: 50%; font-size: small"></div>
                </div>
              </div>
              
              
              <canvas id="canvas_ocupacao" style="max-width: 100%; background-color: #FFF"></canvas>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->

          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3><div id="faltas_mes"></div></h3>

                <p>Faltas (%)</p>
              </div>
              <div class="icon">
                <i class="fad fa-chart-pie mr-1"></i>
              </div>
              <a class="small-box-footer" data-toggle="modal" data-target="#modal-faltas">Detalhes <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

    <!-- Modal Contagem de Consultas -->
      <div class="modal fade" id="modal-faltas">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Faltas na Agenda (%)</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p class="text-muted"><b>Forma de Cálculo:</b> Faltas / Consultas Agendadas</p>
              <canvas class="chart" id="canvas_faltas" style="max-width: 100%; background-color: #FFF"></canvas>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->

          <!-- ./col -->
        </div>
        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
          <section class="col-lg-7 connectedSortable">
            <!-- Custom tabs (Charts with tabs)-->


            <!-- DIRECT CHAT -->
            <div class="card bg-success collapsed-card">
              <div class="card-header">

                <h3 class="card-title">
                  <i class="fad fa-comments-dollar mr-1"></i>
                  Financeiro
                </h3>
                <!-- tools card -->
                <div class="card-tools">
                  <button type="button" class="btn btn-success btn-sm" data-card-widget="collapse">
                    <i class="fas fa-plus"></i>
                  </button>
                </div>
                <!-- /. tools -->
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <canvas class="chart" id="canvas_financeiro" style="max-width: 100%; background-color: #FFF"></canvas>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                Falta implementar uma forma de mudar o ANO (JS)
              </div>
              <!-- /.card-footer-->
            </div>
            <!--/.direct-chat -->

          </section>
          <!-- /.Left col -->
          <!-- right col (We are only adding the ID to make the widgets sortable)-->
          <section class="col-lg-5 connectedSortable">

            <!-- Map card -->
            <!-- solid sales graph -->
            <div class="card collapsed-card bg-gradient-primary">
              <div class="card-header border-0">
                <h3 class="card-title">
                  <i class="fad fa-clock mr-1"></i>
                  Pontualidade (minutos)
                </h3>

                <div class="card-tools">
                  <button type="button" class="btn bg-primary btn-sm" data-card-widget="collapse">
                    <i class="fas fa-plus"></i>
                  </button>
                </div>
              </div>
              <div class="card-body collapse">
                <canvas class="chart" id="canvas_pontualidade" style="max-width: 100%; background-color: #FFF"></canvas>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- solid sales graph -->
            <div class="card collapsed-card bg-gradient-light">
              <div class="card-header border-0">
                <h3 class="card-title">
                  <i class="fad fa-tools mr-1"></i>Produtividade (atendimentos/hora)
                </h3>

                <div class="card-tools">
                  <button type="button" class="btn bg-light btn-sm" data-card-widget="collapse">
                    <i class="fas fa-plus"></i>
                  </button>
                </div>
              </div>
              <div class="card-body collapse">                
                <canvas class="chart" id="canvas_produtividade" style="max-width: 100%; background-color: #FFF"></canvas>
              </div>
              <!-- /.card-body -->
              <div class="card-footer border-0">
                <p class="text-muted"><b>Cálculo:</b> Atendimentos / Horas trabalhadas</p>
              </div>
            </div>
            <!-- /.card -->
          </section>
          <!-- right col -->
        </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?php
	include 'footer.php'; // Fecha a div wrapper
  include 'graficos.php'; // Fecha a div wrapper
?>