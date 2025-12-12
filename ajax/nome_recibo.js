    $(function() {
  
        $( "#pagador" ).autocomplete({
            source: function( request, response ) {
                
                $.ajax({
                    url: "ajax/fetchNomeRecibo.php",
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
                $('#pagador').val(ui.item.label); // display the selected text
                $('#cpf').val(ui.item.cpf);
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