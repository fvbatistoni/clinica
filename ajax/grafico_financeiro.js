
  var ano = new Date().getFullYear();

  var santa_tereza = [];
  var unimed = [];
  var clinica_campinas = [];
  var particular = [];
  var amil = [];
  var sul_america = [];
  var aluguel = [];

  $.ajax({
    url: "ajax/get_financeiro_ano_ajax.php?ano="+ano,
    type: 'get',
    dataType: 'JSON',
    success: function(data) {
      
      santa_tereza.push(data[0].jan,data[0].fev,data[0].mar,data[0].abr,data[0].mai,data[0].jun,data[0].jul,data[0].ago,data[0].set,data[0].out,data[0].nov,data[0].dez);
      unimed.push(data[1].jan,data[1].fev,data[1].mar,data[1].abr,data[1].mai,data[1].jun,data[1].jul,data[1].ago,data[1].set,data[1].out,data[1].nov,data[1].dez);
      clinica_campinas.push(data[2].jan,data[2].fev,data[2].mar,data[2].abr,data[2].mai,data[2].jun,data[2].jul,data[2].ago,data[2].set,data[2].out,data[2].nov,data[2].dez);
      particular.push(data[3].jan,data[3].fev,data[3].mar,data[3].abr,data[3].mai,data[3].jun,data[3].jul,data[3].ago,data[3].set,data[3].out,data[3].nov,data[3].dez);
      amil.push(data[4].jan,data[4].fev,data[4].mar,data[4].abr,data[4].mai,data[4].jun,data[4].jul,data[4].ago,data[4].set,data[4].out,data[4].nov,data[4].dez);
      sul_america.push(data[5].jan,data[5].fev,data[5].mar,data[5].abr,data[5].mai,data[5].jun,data[5].jul,data[5].ago,data[5].set,data[5].out,data[5].nov,data[5].dez);
      aluguel.push(-data[6].jan,-data[6].fev,-data[6].mar,-data[6].abr,-data[6].mai,-data[6].jun,-data[6].jul,-data[6].ago,-data[6].set,-data[6].out,-data[6].nov,-data[6].dez);
      console.log(data);
    }
  });


  var chartdata = {
    labels: ['jan','fev','mar','abr','mai','jun','jul','ago','set','out','nov','dez'],
      datasets: [{
        label: 'Unimed',
        backgroundColor: 'rgba(15, 157, 88,1)',
        data: unimed
      }, {
        label: 'Amil',
        backgroundColor: 'rgba(70, 189, 198,1)',
        data: amil
      }, {
        label: 'Particular',
        backgroundColor: 'rgba(171, 48, 196,1)',
        data: particular
      }, {
        label: 'Santa Tereza',
        backgroundColor: 'rgba(66, 133, 244,1)',
        data: santa_tereza
      }, {
        label: 'Sul América',
        backgroundColor: 'rgba(255, 109, 0,1)',
        data: sul_america
      }, {
        label: 'Clínica Campinas',
        backgroundColor: 'rgba(244, 180, 0,1)',
        data: clinica_campinas
      }, {
        label: 'Aluguel',
        backgroundColor: 'rgba(219, 68, 55,1)',
        data: aluguel
      }]

    };
window.onload = function() {
  var ctx = $("#canvas_financeiro");

  var barGraph = new Chart(ctx, {
        type: 'bar',
        data: chartdata,
        options: {
          tooltips: {
            mode: 'index',
            intersect: false
          },
          responsive: true,
          scales: {
            xAxes: [{
              stacked: true,
            }],
            yAxes: [{
              stacked: true
            }]
          }
        }
      });  
};


