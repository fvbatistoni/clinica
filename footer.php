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
<!-- MonthPicker -->
<script src="assets/js/jquery.mtz.monthpicker.js"></script>
<script>
$('#monthpicker1').monthpicker();
</script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Popper -->
<script src="plugins/popper/popper.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- SweetAlert2 -->
<script src="plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="plugins/toastr/toastr.min.js"></script>
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="plugins/sparklines/sparkline.js"></script>
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
<script>
$(document).ready(function () {
  const $editor = $('#editorprescricao');
  if ($editor.length) {
    //console.log("Editor encontrado, inicializando Summernote...");

    $.getJSON('ajax/get_presc_preferidas_ajax.php', function (data) {
      $editor.summernote({
        height: 200,
        placeholder: 'Adicione a prescrição',
        hint: {
          mentions: data,
          match: /\B\[\[(\w*)$/,
          search: function (keyword, callback) {
            callback($.grep(this.mentions, function (item) {
              return item.name.indexOf(keyword) === 0;
            }));
          },
          template: function (item) {
            return item.name;
          },
          content: function (item) {
            return $('<x>' + item.descricao + '</x>')[0];
          }
        }
      });
    });
  } else {
   // console.log("Campo #editorprescricao não encontrado nesta página.");
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

<script type="text/javascript" src="assets/js/dashboardindex.js"></script>
<!-- Ações no formulário de Atestado -->
<script src="ajax/nome_prescricao.js"></script>
<!-- Ações no formulário de Atestado -->
<script src="ajax/atestado.js"></script>
<!-- Ações no formulário de SADT -->
<script src="ajax/sadt.js"></script>
<!-- Toggle Financeiro -->
<script src="plugins/bootstrap4-toggle/bootstrap4-toggle.min.js"></script>
<script type="text/javascript">
$('.toggle-status').change(function() {

    let id = $(this).data('id');   // 1) pega o ID
    let status = $(this).prop('checked') ? 1 : 0;  // 2) protege status 0/1

    $.ajax({
        url: 'financeiro_movimentoAction.php',
        type: 'POST',
        data: {
            action_type: 'update_status',
            id: id,
            status: status      // 3) envia para o PHP
        },
        success: function(response) {
            console.log('Status atualizado:', response);
        },
        error: function() {
            alert('Erro ao atualizar o status.');
        }
    });
});
</script>
</body>
</html>
