/**
 * ChartJS Script
 *
 * @author Shahzaib
 */

"use strict";

$( function ()
{
  if ( document.getElementById( 'chart' ) != null )
  {
    var chart1 = document.getElementById( 'chart' ).getContext( '2d' );
    var chart2 = new Chart( chart1, {
      type: 'bar',
      data: {
        labels: $( '.tickets_stats_months' ).val().split( ',' ),
        datasets: [
          {
            data: $( '.tickets_stats_counts' ).val().split( ',' )
          }
        ]
      },
      options: {
        legend: {
          display: false
        }
      }
    });
  }
  else
  {
    console.log( 'Missing Canvas' );
  }
});
