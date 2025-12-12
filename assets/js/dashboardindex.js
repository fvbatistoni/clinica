    $(function(){

      /* Calcula o Ticket Médio do Ano atual ao carregar a Página */
      $(document).ready(function(){
        var ano = new Date().getFullYear();
        var mes = new Date().getMonth()+1;

          $.get( "ajax/get_ticket_medio_ajax.php", { ano: ano })
            .done(function( product ) {
              data = $.parseJSON(product);
                if(data){
                  $('#ticket-medio').html(data.ticket_medio);
                }
            });

          $.get( "ajax/get_atendimentos_mes_ajax.php", { ano: ano, mes:mes })
            .done(function( product ) {
              data = $.parseJSON(product);
                if(data){
                  $('#atendimentos_mes_atual').html(data.atendimentos);
                }
            });

          $.get( "ajax/get_ocupacao_mes_ajax.php", { ano: ano, mes:mes })
            .done(function( product ) {
              data = $.parseJSON(product);
                if(data){
                  $('#ocupacao_mes_atual').html(data.taxa);
                }
            });

          $.get( "ajax/get_faltas_mes_ajax.php", { ano: ano, mes:mes })
            .done(function( product ) {
              data = $.parseJSON(product);
                if(data){
                  $('#faltas_mes').html(data.taxa);
                }
            });

          $.get( "ajax/get_valores_ano_ajax.php", { ano: ano })
            .done(function( product ) {
              $('#tabela_financeira_anual').html(product);
            });

          $.get( "ajax/get_contagem_consultas_ajax.php", { ano: ano })
            .done(function( product ) {
              $('#contagem_consultas').html(product);
            });

          $.get( "ajax/get_ocupacao_ajax.php", { ano: ano })
            .done(function( product ) {
              $('#ocupacao_agenda').html(product);
            });
      });

     /* Ao selecionar um ano diferente atualiza a OCUPAÇÃo */
      $('#ano').on( 'change', function(){
          var ano = $(this).val();
          $.get( "ajax/get_ocupacao_ajax.php", { ano: ano })
            .done(function( product ) {
              $('#ocupacao_agenda').html(product);
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

     /* Ao selecionar um ano diferente o ticket */
      $('#ano').on( 'change', function(){
          var ano = $(this).val();
          $.get( "ajax/get_ticket_medio_ajax.php", { ano: ano })
            .done(function( product ) {
              data = $.parseJSON(product);

              if(data){
                $('#ticket-medio').html(data.ticket_medio);
            }
          });
      });

     /* Ao selecionar um ano diferente os atendimentos pelo mês */
      $('#ano').on( 'change', function(){
          var ano = $(this).val();
          var mes = new Date().getMonth()+1;
          $.get( "ajax/get_atendimentos_mes_ajax.php", { ano: ano,mes:mes })
            .done(function( product ) {
              data = $.parseJSON(product);

              if(data){
                $('#atendimentos_mes_atual').html(data.atendimentos);
            }
          });
      });

     /* Ao selecionar um ano diferente os atendimentos pelo mês */
      $('#ano').on( 'change', function(){
          var ano = $(this).val();
          var mes = new Date().getMonth()+1;
          $.get( "ajax/get_faltas_mes_ajax.php", { ano: ano,mes:mes })
            .done(function( product ) {
              data = $.parseJSON(product);

              if(data){
                $('#faltas_mes').html(data.taxa);
            }
          });
      });

     /* Ao selecionar um ano diferente os atendimentos pelo mês */
      $('#ano').on( 'change', function(){
          var ano = $(this).val();
          var mes = new Date().getMonth()+1;
          $.get( "ajax/get_ocupacao_mes_ajax.php", { ano: ano,mes:mes })
            .done(function( product ) {
              data = $.parseJSON(product);

              if(data){
                $('#ocupacao_mes_atual').html(data.taxa);
            }
          });
      });


     /* Ao selecionar um ano diferente atualiza a CONTAGEM de consultas */
      $('#ano').on( 'change', function(){
          var ano = $(this).val();
          $.get( "ajax/get_contagem_consultas_ajax.php", { ano: ano })
            .done(function( product ) {
              $('#contagem_consultas').html(product);
            });
      });

    });