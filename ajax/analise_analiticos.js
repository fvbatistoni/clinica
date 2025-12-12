    $(function(){

      /* Calcula o Ticket Médio do Ano atual ao carregar a Página */
      $(document).ready(function(){
        var ano = new Date().getFullYear();
        var mes = new Date().getMonth();


          $.get( "ajax/analiticos_ajax.php", { ano: ano,mes: mes })
            .done(function( product ) {
              $('#analiticos').html(product);
            });

      });

     /* Ao selecionar um ano diferente atualiza o FINANCEIRO */
      $('#monthpicker1').on( 'change', function(){
          var data_qualquer = $(this).val();
          var arr_data = data_qualquer.split('/');
          $.get( "ajax/analiticos_ajax.php", { ano: arr_data[1],mes: arr_data[0] })
            .done(function( product ) {
              $('#analiticos').html(product);
            });
      });

    });