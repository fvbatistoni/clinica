$(document).ready(function(){
  $.ajax({
    url: "data.php",
    method: "GET",
    success: function(data) {
      console.log(data);
      var player = [];
      var score = [data[0].jan,data[0].fev,data[0].mar,data[0].abr,data[0].mai,data[0].jun,data[0].jul];


      var chartdata = {
        labels: ['jan','fev','mar','abr','mai','jun','jul','ago','set','out','nov','dez'],
        datasets : [
          {
            label: 'Player Score',
            backgroundColor: 'rgba(200, 200, 200, 0.75)',
            borderColor: 'rgba(200, 200, 200, 0.75)',
            hoverBackgroundColor: 'rgba(200, 200, 200, 1)',
            hoverBorderColor: 'rgba(200, 200, 200, 1)',
            data: score
          }
        ]
      };

      var ctx = $("#mycanvas");

      var barGraph = new Chart(ctx, {
        type: 'bar',
        data: chartdata
      });
    },
    error: function(data) {
      console.log(data);
    }
  });
});