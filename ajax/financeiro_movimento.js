    $(function(){

      /* Calcula o Ticket Médio do Ano atual ao carregar a Página */
      $(document).ready(function(){
        var ano = new Date().getFullYear();


          $.get( "ajax/get_valores_ano_ajax.php", { ano: ano })
            .done(function( product ) {
              $('#tabela_financeira_anual').html(product);
            });

      });

     /* Ao selecionar um ano diferente atualiza o FINANCEIRO */
      $('#ano').on( 'change', function(){
          var ano = $(this).val();
          $.get( "ajax/get_valores_ano_ajax.php", { ano: ano })
            .done(function( product ) {
              $('#tabela_financeira_anual').html(product);
            });
      });

    });