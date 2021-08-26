@extends('layouts.main',['activePage'=>'importacion','titlePage'=>'DIRECCIÓN REGIONAL DE EDUCACIÓN DE UCAYALI'])

 {{-- @section('css')
   
@endsection  --}}

@section('content') 
<div class="content">
    
    <div class="row">
        <div class="col-md-12">           
            <div class="card">
                
                <div class="card-body">

                    <div class="form-group row">
                        <label class="col-md-1 col-form-label">Año</label>
                        <div class="col-md-2">
                            <select id="anio" name="anio" class="form-control" onchange="cargarResumen_Matricula();cargar_fechas(); ">                               
                                @foreach ($anios as $item)
                                    <option value="{{ $item->id }}"> {{ $item->anio }} </option>
                                @endforeach
                            </select>
                        </div>
                       
                        <label class="col-md-1 col-form-label">Fecha</label>
                        <div class="col-md-2">
                            <select id="mes" name="mes." class="form-control" onchange="cargarResumen_Matricula();">
                                @foreach ($fechas_matriculas as $item)
                                    <option value="{{ $item->matricula_id }}"> {{ $item->fechaActualizacion }} </option>
                                @endforeach
                            </select>
                        </div>
                        
                    </div>                  
                           
                    <div class="progress progress-sm m-0">
                        <div class="progress-bar bg-secondary" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                         
                        </div>
                    </div>
                
                    <br>
                    <div id="datos01" class="form-group row">                        
                            Cargando datos.....                        
                    </div>

                    <div class="col-lg-12" id="datos02">
                        Cargando datos.....2222
                    </div>  <!-- tabla de datos -->

                </div>               
                <!-- card-body -->

            </div>
              
        </div> <!-- End col -->
    </div> <!-- End row -->
  
</div>
@endsection 

@section('js')

<script src="{{ asset('/') }}assets/libs/highcharts/highcharts.js"></script>

<script src="{{ asset('/') }}assets/libs/highcharts-modules/exporting.js"></script>
<script src="{{ asset('/') }}assets/libs/highcharts-modules/export-data.js"></script>
<script src="{{ asset('/') }}assets/libs/highcharts-modules/accessibility.js"></script>
{{-- https://www.youtube.com/watch?v=HU-hffAZqYw --}}

    <script type="text/javascript"> 
        
        $(function () {
            cargarResumen_Matricula();
        });// ejecuta al cargar la pagina


        function cargarResumen_Matricula() {
            
            $.ajax({              
                url: "{{ url('/') }}/Matricula/Reporte/" + $('#anio').val(),
            }).done(function (data) {               
                $('#datos01').html(data);
            }).fail(function () {
                alert("Lo sentimos a ocurrido un error");
            });
        }

        function cargarReporte2() {
            
            $.ajax({              
                url: "{{ url('/') }}/Matricula/Reporte2/" + $('#anio').val(),
            }).done(function (data) {               
                $('#datos02').html(data);
            }).fail(function () {
                alert("Lo sentimos a ocurrido un error a2");
            });
        }

       
    </script>

   



@endsection
