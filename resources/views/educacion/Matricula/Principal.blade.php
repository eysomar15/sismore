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
                            <select id="anio" name="anio" class="form-control" onchange="cargarReporte();cargarReporte2(); ">                               
                                @foreach ($anios as $item)
                                    <option value="{{ $item->id }}"> {{ $item->anio }} </option>
                                @endforeach
                            </select>
                        </div>
                       
                        <label class="col-md-1 col-form-label">Fecha</label>
                        <div class="col-md-2">
                            <select id="mes" name="mes." class="form-control" onchange="cargarReporte();">
                                <option value="0">TODOS</option>
                            </select>
                        </div>
                        
                    </div>

                    <div class="col-lg-6" id="datos01">
                        Cargando datos.....
                    </div>  <!-- tabla de datos -->

                    <div class="col-lg-6" id="datos02">
                        Cargando datos.....
                    </div>  <!-- tabla de datos -->

                </div>               
                <!-- card-body -->

            </div>
              
        </div> <!-- End col -->
    </div> <!-- End row -->

        <div>
                <div id="container"></div>
        </div>  <!-- grafico -->


    {{-- <li>
        <a href="{{route('Matricula.prueba','04')}}" class="waves-effect">
            <i class="mdi mdi-chart-tree"></i>
            <span> PDRC </span>
        </a>                    
    </li> --}}

  
</div>
@endsection 

@section('js')

<script src="{{ asset('/') }}assets/libs/highcharts/highcharts.js"></script>

<script src="{{ asset('/') }}assets/libs/highcharts-modules/exporting.js"></script>
<script src="{{ asset('/') }}assets/libs/highcharts-modules/export-data.js"></script>
<script src="{{ asset('/') }}assets/libs/highcharts-modules/accessibility.js"></script>



{{-- https://www.youtube.com/watch?v=HU-hffAZqYw --}}

    <script type="text/javascript">        

        function cargarReporte() {
            
            $.ajax({              
                url: "{{ url('/') }}/Matricula/prueba/" + $('#anio').val(),
            }).done(function (data) {               
                $('#datos01').html(data);
            }).fail(function () {
                alert("Lo sentimos a ocurrido un error");
            });
        }

        function cargarReporte2() {
            
            $.ajax({              
                url: "{{ url('/') }}/Matricula/prueba2/" + $('#anio').val(),
            }).done(function (data) {               
                $('#datos02').html(data);
            }).fail(function () {
                alert("Lo sentimos a ocurrido un error");
            });
        }



        $(function () {
            // Obtiene mediante ajax la partial view
            $.ajax({
                url: "{{ url('/') }}/Matricula/prueba/" + $('#anio').val(),                 
            }).done(function (data) {                
                $('#datos01').html(data);
            }).fail(function () {
                alert("Lo sentimos a ocurrido un error");
            });
        });

    </script>

   



@endsection
