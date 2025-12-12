<?php

require_once('dbconn.php');

$sth = $dbconn->prepare("SELECT `id`, `nome_paciente`, `data`, `hora_atendimento` FROM agendas order by id desc LIMIT 5");
$sth->execute();
/* Fetch all of rows in the result set */
$result = $sth->fetchAll();

?>
<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  <script src="Chart.min.js"></script>
  <script src="utils.js"></script>
<style>
.container{
  margin: 20px auto;
}
h2 {
  text-align: center;
}
table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

td, th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}

tr:nth-child(even) {
    background-color: #dddddd;
}

body{
  font-family:Arial, Helvetica, sans-serif;
  font-size:13px;
}
.success, .error{
  border: 1px solid;
  margin: 10px 0px;
  padding:15px 10px 15px 50px;
  background-repeat: no-repeat;
  background-position: 10px center;
}

.success {
  color: #4F8A10;
  background-color: #DFF2BF;
  background-image:url('success.png');
  display: none;
}
.error {
  display: none;
  color: #D8000C;
  background-color: #FFBABA;
  background-image: url('error.png');
}
</style>
</head>
<body>
  <div class="container">
    <h2>Selecione o ano</h2>
<hr>
    <select class="form-control" id="ano">
      <option value='2020'>2020</option>
      <option value='2019'>2019</option>
      <option value='2018'>2018</option>
      <option value='2017'>2017</option>
      <option value='2016'>2016</option>
      <option value='2015'>2015</option>
    </select>

<hr>

    <h2>Ticket Médio</h2>
    <h2>R$ <div id="ticket-medio"></div></h2>

<hr>

    <h2>Financeiro</h2>
    <div id="tabela_financeira_anual"></div>

<hr>
    <h2>Contagem de Consultas</h2>
    <div id="contagem_consultas"></div> 
 <hr>
  <div style="width:75%;">
    <canvas id="canvas"></canvas>
  </div>

  </div>
  <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
  <script>
    $(function(){

      /* Calcula o Ticket Médio do Ano atual ao carregar a Página */
      $(document).ready(function(){
        var ano = new Date().getFullYear();

          $.get( "get_ticket_medio_ajax.php", { ano: ano })
            .done(function( product ) {
              data = $.parseJSON(product);
                if(data){
                  $('#ticket-medio').html(data.ticket_medio);
                }
            });

          $.get( "get_valores_ano_ajax.php", { ano: ano })
            .done(function( product ) {
              $('#tabela_financeira_anual').html(product);
            });

          $.get( "get_contagem_consultas_ajax.php", { ano: ano })
            .done(function( product ) {
              $('#contagem_consultas').html(product);
            });

      });

     /* Ao selecionar um ano diferente atualiza o FINANCEIRO */
      $('#ano').on( 'change', function(){
          var ano = $(this).val();
          $.get( "get_valores_ano_ajax.php", { ano: ano })
            .done(function( product ) {
              $('#tabela_financeira_anual').html(product);
            });
      });

     /* Ao selecionar um ano diferente o ticket */
      $('#ano').on( 'change', function(){
          var ano = $(this).val();
          $.get( "get_ticket_medio_ajax.php", { ano: ano })
            .done(function( product ) {
              data = $.parseJSON(product);

              if(data){
                $('#ticket-medio').html(data.ticket_medio);
            }
          });
      });

     /* Ao selecionar um ano diferente atualiza a CONTAGEM de consultas */
      $('#ano').on( 'change', function(){
          var ano = $(this).val();
          $.get( "get_contagem_consultas_ajax.php", { ano: ano })
            .done(function( product ) {
              $('#contagem_consultas').html(product);
            });
      });

    });
 </script>
 
  <script>
    var MONTHS = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

    var randomScalingFactor = function() {
      return Math.round(Math.random() * 100);
    };

    var config = {
      type: 'line',
      data: {
        labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
        datasets: [{
          label: 'My First dataset',
          backgroundColor: window.chartColors.red,
          borderColor: window.chartColors.red,
          data: [
            randomScalingFactor(),
            randomScalingFactor(),
            randomScalingFactor(),
            randomScalingFactor(),
            randomScalingFactor(),
            randomScalingFactor(),
            randomScalingFactor()
          ],
          fill: false,
        }, {
          label: 'My Second dataset',
          fill: false,
          backgroundColor: window.chartColors.blue,
          borderColor: window.chartColors.blue,
          data: [
            randomScalingFactor(),
            randomScalingFactor(),
            randomScalingFactor(),
            randomScalingFactor(),
            randomScalingFactor(),
            randomScalingFactor(),
            randomScalingFactor()
          ],
        }]
      },
      options: {
        responsive: true,
        title: {
          display: true,
          text: 'Chart.js Line Chart'
        },
        tooltips: {
          mode: 'index',
          intersect: false,
        },
        hover: {
          mode: 'nearest',
          intersect: true
        },
        scales: {
          xAxes: [{
            display: true,
            scaleLabel: {
              display: true,
              labelString: 'Month'
            }
          }],
          yAxes: [{
            display: true,
            scaleLabel: {
              display: true,
              labelString: 'Value'
            },
            ticks: {
              min: 0,
              max: 100,

              // forces step size to be 5 units
              stepSize: 5
            }
          }]
        }
      }
    };

    window.onload = function() {
      var ctx = document.getElementById('canvas').getContext('2d');
      window.myLine = new Chart(ctx, config);
    };

    document.getElementById('randomizeData').addEventListener('click', function() {
      config.data.datasets.forEach(function(dataset) {
        dataset.data = dataset.data.map(function() {
          return randomScalingFactor();
        });
      });

      window.myLine.update();
    });

    var colorNames = Object.keys(window.chartColors);
    document.getElementById('addDataset').addEventListener('click', function() {
      var colorName = colorNames[config.data.datasets.length % colorNames.length];
      var newColor = window.chartColors[colorName];
      var newDataset = {
        label: 'Dataset ' + config.data.datasets.length,
        backgroundColor: newColor,
        borderColor: newColor,
        data: [],
        fill: false
      };

      for (var index = 0; index < config.data.labels.length; ++index) {
        newDataset.data.push(randomScalingFactor());
      }

      config.data.datasets.push(newDataset);
      window.myLine.update();
    });

    document.getElementById('addData').addEventListener('click', function() {
      if (config.data.datasets.length > 0) {
        var month = MONTHS[config.data.labels.length % MONTHS.length];
        config.data.labels.push(month);

        config.data.datasets.forEach(function(dataset) {
          dataset.data.push(randomScalingFactor());
        });

        window.myLine.update();
      }
    });

    document.getElementById('removeDataset').addEventListener('click', function() {
      config.data.datasets.splice(0, 1);
      window.myLine.update();
    });

    document.getElementById('removeData').addEventListener('click', function() {
      config.data.labels.splice(-1, 1); // remove the label first

      config.data.datasets.forEach(function(dataset) {
        dataset.data.pop();
      });

      window.myLine.update();
    });

  </script>
</body>
</html>