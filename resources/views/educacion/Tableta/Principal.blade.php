@extends('layouts.main',['activePage'=>'importacion','titlePage'=>'DIRECCIÓN REGIONAL DE EDUCACIÓN DE UCAYALI'])

@section('css')

    <script src="{{ asset('/') }}assets/libs/highcharts/highcharts.js"></script>
    <script src="{{ asset('/') }}assets/libs/highcharts/highcharts-more.js"></script>
    <script src="{{ asset('/') }}assets/libs/highcharts-modules/exporting.js"></script>
    <script src="{{ asset('/') }}assets/libs/highcharts-modules/export-data.js"></script>
    <script src="{{ asset('/') }}assets/libs/highcharts-modules/accessibility.js"></script>

@endsection 

@section('content') 


<figure class="highcharts-figure">           
    <div id="barra1">       
        @include('graficos.Barra')
    </div> 
</figure>


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


@endsection 

@section('js')

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
       
    </script>
    
@endsection
