

 <div class="card">
   
     <div class="card-body">
         <div class="row">
             <div class="col-12">
                 <div class="table-responsive">
                     <table class="table table-striped mb-0">
                         <thead>
                             <tr>                                                 
                                 <th>UNIDAD DE GESTION EDUCATIVA LOCAL</th>
                                 <th class="columna_derecha">TOTAL</th>
                                 <th class="columna_derecha">HOMBRE</th>
                                 <th class="columna_derecha">MUJER</th>
                             </tr>
                         </thead>
                         <tbody>
                             @php
                                 $sunHombre=0;                                            
                                 $sumMujer=0
                             @endphp
                         
                         @foreach ($lista_total_matricula_EBR as $item)
                                 
                             @php
                                 $sunHombre+= $item->hombres;                                           
                                 $sumMujer+= $item->mujeres
                             @endphp

                             <tr>                                            
                             <td>{{$item->nombre}}</td>
                             <td class="columna_derecha">{{ number_format($item->hombres + $item->mujeres,0) }} </td>
                             <td class="columna_derecha">{{number_format($item->hombres,0)}}</td>
                             <td class="columna_derecha">{{number_format($item->mujeres,0)}}</td>
                             </tr>

                             @endforeach

                             <tr> 
                             <td> <b> TOTAL </b></td>
                             <td class="columna_derecha_total"> {{number_format($sunHombre + $sumMujer,0)}} </td>
                             <td class="columna_derecha_total"> {{number_format($sunHombre,0)}} </td>
                             <td class="columna_derecha_total"> {{number_format($sumMujer,0)}}  </td>
                             </tr>                                              
                             
                         </tbody>
                     </table>
                 </div>

             </div>
         </div>
     </div>
 </div>

 <script>
     

    Highcharts.chart('container', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        credits:false,
        title: {
            text: 'TITULO DEL GRAFICO'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        accessibility: {
            point: {
                valueSuffix: '%'
            }
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                }
            }
        },
        series: [{
            name: 'Porcentaje',
            colorByPoint: true,
            data: <?=$data?>
        }]
    });

    
    
</script>



