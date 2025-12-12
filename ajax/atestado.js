  $(function(){
    $("input[name=beneficiario_complemento]").hide();
    $("input[name=beneficiario]").click(function() {
      if($(this).val()=="2"){
        $("input[name=beneficiario_complemento]").show();
      } else {
        $("input[name=beneficiario_complemento]").hide();
      }
    }); 


    $("#motivo_1").hide();
    $("#motivo_2").hide();
    $("#motivo_6").hide();
    $("input[name=motivo]").click(function(){
      if ($(this).val()=="1") {
        $("#motivo_1").attr("name","motivo_complemento").show();
      } else {
        $("#motivo_1").attr("name","").hide();
      }
      if ($(this).val()=="2") {
        $("#motivo_2").attr("name","motivo_complemento").show();
      } else {
        $("#motivo_2").attr("name","").hide();
      }
      if ($(this).val()=="6") {
        $("#motivo_6").attr("name","motivo_complemento").show();
      } else {
        $("#motivo_6").attr("name","").hide();
      }
    });
    
  }); 

    $(function() {
  
        $( "#nome_atestado" ).autocomplete({
            source: function( request, response ) {
                
                $.ajax({
                    url: "ajax/fetchNomeAtestado.php",
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
                $('#nome_atestado').val(ui.item.label); // display the selected text
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