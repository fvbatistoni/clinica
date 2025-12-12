    $(function() {
  
        $( "#nome_movimentacao" ).autocomplete({
            source: function( request, response ) {
                
                $.ajax({
                    url: "ajax/fetchNomeMovimentacao.php",
                    type: 'post',
                    dataType: "json",
                    data: {
                        search: request.term
                    },
                    success: function( data ) {
                        response( data );
                    }
                });
            },
            select: function (event, ui) {
                $('#nome_movimentacao').val(ui.item.label); // display the selected text
                return false;
            }
        });

    });

    function split( val ) {
      return val.split( /,\s*/ );
    }
    function extractLast( term ) {
      return split( term ).pop();
    }