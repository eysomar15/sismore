@extends('layouts.main',['activePage'=>'importacion','titlePage'=>'DIRECCIÓN REGIONAL DE EDUCACIÓN DE UCAYALI'])

 {{-- @section('css')
   
@endsection  --}}

@section('content') 
<div class="content">
    <input type="hidden" id="hoja" value="1">
    
    <div class="row">
        <div class="col-md-12">           
            <div class="card">
                
                <div class="card-body">

                    <div class="form-group row">
                        <label class="col-md-1 col-form-label">Año</label>
                        <div class="col-md-2">
                            <select id="anio" name="anio" class="form-control" onchange="cargar_fechas();">                               
                                @foreach ($anios as $item)
                                    <option value="{{ $item->id }}"> {{ $item->anio }} </option>
                                @endforeach
                            </select>
                        </div>
                       
                        <label class="col-md-1 col-form-label">Fecha</label>
                        <div class="col-md-2">
                            <select id="fechas" name="matricula_fechas" class="form-control"  onchange="cargar_resumen();">
                                @foreach ($fechas_tabletas as $item)
                                    <option value="{{ $item->tableta_id }}"> {{ $item->fechaActualizacion }} </option>
                                @endforeach
                            </select>
                        </div>
                        
                    </div>                    
                           
                    <div class="progress progress-sm m-0">
                        <div class="progress-bar bg-secondary" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
                    </div>
                    <br>


                    {{-- <div class="col-md-12">                       
                        <div class="portfolioFilter">
                            <a href="#" onClick="cargar_resumen_porUgel();"  class="current waves-effect waves-light">UGELES</a>
                            <a href="#" onClick="cargar_matricula_porDistrito();" class="waves-effect waves-light" > DISTRITOS </a>                  
                        </div>                        
                    </div> --}}

                    <br>
                    <div id="datos01" class="form-group row">                        
                            Cargando datos.....                        
                    </div>

                </div>               
                <!-- card-body -->

            </div>
              
        </div> <!-- End col -->
    </div> <!-- End row -->
  
</div>



<figure class="highcharts-figure">
    <div id="container"></div>
    <p class="highcharts-description">
        A basic column chart compares rainfall values between four cities.
        Tokyo has the overall highest amount of rainfall, followed by New York.
        The chart is making use of the axis crosshair feature, to highlight
        months as they are hovered over.
    </p>
</figure>

@endsection 

@section('js')


<script src="{{ asset('/') }}assets/libs/isotope/isotope.pkgd.min.js"></script>
<script src="{{ asset('/') }}assets/libs/magnific-popup/jquery.magnific-popup.min.js"></script>
<script src="{{ asset('/') }}assets/js/pages/gallery.init.js"></script>

<script src="{{ asset('/') }}assets/libs/highcharts/highcharts.js"></script>
<script src="{{ asset('/') }}assets/libs/highcharts-modules/exporting.js"></script>
<script src="{{ asset('/') }}assets/libs/highcharts-modules/export-data.js"></script>
<script src="{{ asset('/') }}assets/libs/highcharts-modules/accessibility.js"></script>
{{-- https://www.youtube.com/watch?v=HU-hffAZqYw --}}

    <script type="text/javascript"> 
        
        
        $(document).ready(function() {
            cargar_fechas();
            //cargar_resumen_matricula();
        });


        function cargar_fechas() {
           
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('input[name=_token]').val()
                },
                url: "{{ url('/') }}/Tableta/Fechas/" + $('#anio').val(),
                type: 'post',
                dataType: 'JSON',
                success: function(data) {
                    console.log(data);
                    $("#fechas option").remove();
                    
                    var options = null;
                    
                    $.each(data.fechas_tabletas, function(index, value) {
                        options += "<option value='" + value.tableta_id + "'>" + value.fechaActualizacion + "</option>";                       
                    });
                    
                    $("#fechas").append(options);                  
                    cargar_resumen(); 
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR);
                   
                },
            });
            
        }

        function cargar_resumen() {   

            if($('#hoja').val()==1)       
                cargar_resumen_porUgel();          
            else         
                cargar_matricula_porDistrito();                   
        }

        function cargar_resumen_porUgel() { 
            $('#hoja').val(1);
            $.ajax({  
                headers: {
                     'X-CSRF-TOKEN': $('input[name=_token]').val()
                },                           
                url: "{{ url('/') }}/Tableta/ReporteUgel/" + $('#anio').val() + "/" + $('#fechas').val(),
                type: 'post',
            }).done(function (data) {               
                $('#datos01').html(data);
            }).fail(function () {
                alert("Lo sentimos a ocurrido un error");
            });
           
        }

        function cargar_matricula_porDistrito() {
            $('#hoja').val(2);
            
        }
  
        

        Highcharts.chart('container', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Monthly Average Rainfall'
            },
            subtitle: {
                text: 'Source: WorldClimate.com'
            },
            xAxis: {
                categories: 
                     <?=$data5?>
                ,
                crosshair: true
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Rainfall (mm)'
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y} tabletas</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: [{
                        name: 'A Distribuir',
                        data:<?=$data?>

                    }, {
                        name: 'Despachadas',
                        data: <?=$data2?>

                    }, {
                        name: 'Recepcionadas',
                        data: <?=$data3?>

                    }, {
                        name: 'Asignadas',
                        data: <?=$data4?>

                    }]
                });
       
    </script>



@endsection
