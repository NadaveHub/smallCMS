(() => {
  'use strict'

  const ctx = document.getElementById('myChart')
  
  if (ctx) {
    new Chart(ctx, {
      type: 'line',
      data: {
        labels: dynamicChartLabels, 
        datasets: [{
          data: dynamicChartData, 
          lineTension: 0,
          backgroundColor: 'transparent',
          borderColor: '#007bff',
          borderWidth: 4,
          pointBackgroundColor: '#007bff'
        }]
      },
      options: {
        plugins: {
          legend: {
            display: false
          },
          tooltip: {
            boxPadding: 3
          }
        }
      }
    })
  }
})()