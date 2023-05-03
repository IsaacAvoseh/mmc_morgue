/* global Chart:false */

$(function () {
  'use strict'

  var ticksStyle = {
    fontColor: '#495057',
    fontStyle: 'bold'
  }

  var mode = 'index'
  var intersect = true

  var $salesChart = $('#sales-chart')
  // eslint-disable-next-line no-unused-vars
  // var salesChart = new Chart($salesChart, {
  //   type: 'bar',
  //   data: {
  //     labels: ['JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC'],
  //     datasets: [
  //       {
  //         backgroundColor: '#007bff',
  //         borderColor: '#007bff',
  //         data: [1000, 2000, 3000, 2500, 2700, 2500, 3000]
  //       },
  //       {
  //         backgroundColor: '#ced4da',
  //         borderColor: '#ced4da',
  //         data: [700, 1700, 2700, 2000, 1800, 1500, 2000]
  //       }
  //     ]
  //   },
  //   options: {
  //     maintainAspectRatio: false,
  //     tooltips: {
  //       mode: mode,
  //       intersect: intersect
  //     },
  //     hover: {
  //       mode: mode,
  //       intersect: intersect
  //     },
  //     legend: {
  //       display: false
  //     },
  //     scales: {
  //       yAxes: [{
  //         // display: false,
  //         gridLines: {
  //           display: true,
  //           lineWidth: '4px',
  //           color: 'rgba(0, 0, 0, .2)',
  //           zeroLineColor: 'transparent'
  //         },
  //         ticks: $.extend({
  //           beginAtZero: true,

  //           // Include a dollar sign in the ticks
  //           callback: function (value) {
  //             if (value >= 1000) {
  //               value /= 1000
  //               value += 'k'
  //             }

  //             return '$' + value
  //           }
  //         }, ticksStyle)
  //       }],
  //       xAxes: [{
  //         display: true,
  //         gridLines: {
  //           display: false
  //         },
  //         ticks: ticksStyle
  //       }]
  //     }
  //   }
  // })

  var $visitorsChart = $('#visitors-chart')
  // eslint-disable-next-line no-unused-vars
  // var visitorsChart = new Chart($visitorsChart, {
  //   data: {
  //     labels: ['1st','2nd','3rd','4th', '5th', '6th','7th','8th','9th','10th','11th','12th','13th','14th','15th','16th','17th','18th', '20th','21st', '22nd','23rd', '24th', '25th', '26th','27th', '28th','29th','30th', '31th'],
  //     datasets: [{
  //       type: 'line',
  //       data: [10, 20, 70, 67, 80, 77, 90, 80, 80, 80, 80, 80, 80, 0,0,0,66,77,23,22,34,23,0,56,34,88,12,56,52,20,30,0],
  //       backgroundColor: 'transparent',
  //       borderColor: '#007bff',
  //       pointBorderColor: '#007bff',
  //       pointBackgroundColor: '#007bff',
  //       fill: false
  //       // pointHoverBackgroundColor: '#007bff',
  //       // pointHoverBorderColor    : '#007bff'
  //     },
  //     {
  //       type: 'line',
  //       data: [10, 20, 70, 67, 80, 77, 90, 80, 80, 80, 80, 80, 80, 0, 0, 0, 66, 77, 23, 22, 34, 23, 0, 56, 34, 88, 12, 56, 52, 20, 30, 0],

  //       backgroundColor: 'tansparent',
  //       borderColor: '#ced4da',
  //       pointBorderColor: '#ced4da',
  //       pointBackgroundColor: '#ced4da',
  //       fill: false
  //       // pointHoverBackgroundColor: '#ced4da',
  //       // pointHoverBorderColor    : '#ced4da'
  //     }]
  //   },
  //   options: {
  //     maintainAspectRatio: false,
  //     tooltips: {
  //       mode: mode,
  //       intersect: intersect
  //     },
  //     hover: {
  //       mode: mode,
  //       intersect: intersect
  //     },
  //     legend: {
  //       display: false
  //     },
  //     scales: {
  //       yAxes: [{
  //         // display: false,
  //         gridLines: {
  //           display: true,
  //           lineWidth: '4px',
  //           color: 'rgba(0, 0, 0, .2)',
  //           zeroLineColor: 'transparent'
  //         },
  //         ticks: $.extend({
  //           beginAtZero: true,
  //           suggestedMax: 100
  //         }, ticksStyle)
  //       }],
  //       xAxes: [{
  //         display: true,
  //         gridLines: {
  //           display: false
  //         },
  //         ticks: ticksStyle
  //       }]
  //     }
  //   }
  // })

  $.ajax({
    url: '/chart-data',
    type: 'GET',
    dataType: 'json',
    success: function(data) {
        // Create the chart
      var $visitorsChart = $('#visitors-chart')
        var visitorsChart = new Chart($visitorsChart, {
            data: {
                labels: ['1st', '2nd', '3rd', '4th', '5th', '6th', '7th', '8th', '9th', '10th', '11th', '12th', '13th', '14th', '15th', '16th', '17th', '18th', '19th', '20th', '21st', '22nd', '23rd', '24th', '25th', '26th', '27th', '28th', '29th', '30th', '31st'],
                datasets: [{
                        type: 'line',
                        data: data.current_month,
                        backgroundColor: 'transparent',
                        borderColor: '#007bff',
                        pointBorderColor: '#007bff',
                        pointBackgroundColor: '#007bff',
                        fill: false
                    },
                    {
                        type: 'line',
                        data: data.previous_month,
                        backgroundColor: 'tansparent',
                        borderColor: '#ced4da',
                        pointBorderColor: '#ced4da',
                        pointBackgroundColor: '#ced4da',
                        fill: false
                    }
                ]
            },
          options: {
            maintainAspectRatio: false,
            tooltips: {
              mode: mode,
              intersect: intersect
            },
            hover: {
              mode: mode,
              intersect: intersect
            },
            legend: {
              display: false
            },
            scales: {
              yAxes: [{
                // display: false,
                gridLines: {
                  display: true,
                  lineWidth: '4px',
                  color: 'rgba(0, 0, 0, .2)',
                  zeroLineColor: 'transparent'
                },
                ticks: $.extend({
                  beginAtZero: true,
                  suggestedMax: 50
                }, ticksStyle)
              }],
              xAxes: [{
                display: true,
                gridLines: {
                  display: false
                },
                ticks: ticksStyle
              }]
            }
          }
        });
    },
    error: function() {
        console.log('Error loading chart data');
    }
});

})

// lgtm [js/unused-local-variable]
