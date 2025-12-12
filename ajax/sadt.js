$(function () {	
  function removeCampo() {
	$(".removerCampo").unbind("click");
	$(".removerCampo").bind("click", function () {
	   if($("tr.linhas").length > 1){
		$(this).parent().parent().remove();
	   }
	});
  }
 
  $(".adicionarCampo").click(function () {
	novoCampo = $("tr.linhas:first").clone();
	novoCampo.find("input").val("");
	novoCampo.insertAfter("tr.linhas:last");
	removeCampo();
  });
});

$(document).on('focus','#exame', function(){
   // este if verifica se o campo já tem autocomplete
   if( !$(this).hasClass("ui-autocomplete-input") ){
      $(this).autocomplete({
            source: function( request, response ) {
                
                $.ajax({
                    url: "ajax/pesquisa_tuss.php",
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
                $(this).val(ui.item.cod+' - '+ui.item.label); // display the selected text
                $(this).removeClass("ui-autocomplete-input");
                return false;
            }
        });
   }
});

    $(function() {
  
        $( "#nome_sadt" ).autocomplete({
            source: function( request, response ) {
                
                $.ajax({
                    url: "ajax/fetchNomeSadt.php",
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
                $('#nome_sadt').val(ui.item.label); // display the selected text
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