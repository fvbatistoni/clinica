$(document).ready(function(){
  var ano = new Date().getFullYear();

  var score_atual = [];
  var score_menos_um = [];
  var score_menos_dois = [];

  $.ajax({
    url: "ajax/get_faltas_ano_ajax.php?ano="+ano,
    type: 'get',
    dataType: 'JSON',
    success: function(data) {
      score_atual.push(data.jan,data.fev,data.mar,data.abr,data.mai,data.jun,data.jul,data.ago,data.set,data.out,data.nov,data.dez);
    }
  });

  $.ajax({
    url: "ajax/get_faltas_ano_ajax.php?ano="+(ano-1),
    type: 'get',
    dataType: 'JSON',    
    success: function(dado_menos_um){
      score_menos_um.push(dado_menos_um.jan,dado_menos_um.fev,dado_menos_um.mar,dado_menos_um.abr,dado_menos_um.mai,dado_menos_um.jun,dado_menos_um.jul,dado_menos_um.ago,dado_menos_um.set,dado_menos_um.out,dado_menos_um.nov,dado_menos_um.dez);      
    }
  });

  $.ajax({
    url: "ajax/get_faltas_ano_ajax.php?ano="+(ano-2),
    type: 'get',
    dataType: 'JSON',    
    success: function(dado_menos_dois){
      score_menos_dois.push(dado_menos_dois.jan,dado_menos_dois.fev,dado_menos_dois.mar,dado_menos_dois.abr,dado_menos_dois.mai,dado_menos_dois.jun,dado_menos_dois.jul,dado_menos_dois.ago,dado_menos_dois.set,dado_menos_dois.out,dado_menos_dois.nov,dado_menos_dois.dez);      
    }
  });

  var chartdata = {
    labels: ['jan','fev','mar','abr','mai','jun','jul','ago','set','out','nov','dez'],
    datasets : [
      {
        label: ano,
        backgroundColor: 'rgba(0, 100, 0, 1)',
        borderColor: 'rgba(0, 100, 0, 1)',
        fill: false,
        data: score_atual
      },
      {
        label: (ano-1),
        backgroundColor: 'rgba(178, 34, 34, 1)',
        borderColor: 'rgba(178, 34, 34, 1)',
        fill: false,
        data: score_menos_um
      },
      {
        label: (ano-2),
        backgroundColor: 'rgba(255, 140, 0, 1)',
        borderColor: 'rgba(255, 140, 0, 1)',
        fill: false,
        data: score_menos_dois
      }          
    ]
  };

  var ctx = $("#canvas_faltas");

  var barGraph = new Chart(ctx, {
    type: 'line',
    data: chartdata,
    options: {

        elements: {
            line: {
                tension: 0, // disables bezier curves
            }
        }
    }
  });

});