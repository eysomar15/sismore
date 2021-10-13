{{-- @extends('layouts.main',['activePage'=>'importacion','titlePage'=>'DIRECCIÓN REGIONAL DE EDUCACIÓN DE UCAYALI']) --}}
{{-- 
@section('css')
    
    <link href="{{ asset('/') }}assets/libs/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />

@endsection  --}}

{{-- @section('content')  --}}

<script src="{{ asset('/') }}assets/libs/isotope/isotope.pkgd.min.js"></script>
<script src="{{ asset('/') }}assets/libs/magnific-popup/jquery.magnific-popup.min.js"></script>
<script src="{{ asset('/') }}assets/js/pages/gallery.init.js"></script>

<script src="{{ asset('/') }}assets/libs/highcharts/highcharts.js"></script>
<script src="{{ asset('/') }}assets/libs/highcharts/highcharts-more.js"></script>
<script src="{{ asset('/') }}assets/libs/highcharts-modules/exporting.js"></script>
<script src="{{ asset('/') }}assets/libs/highcharts-modules/export-data.js"></script>
<script src="{{ asset('/') }}assets/libs/highcharts-modules/accessibility.js"></script>

<input type="hidden" id="hoja" value="1">


<div class="content">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">      
                    <div id="barra1">       
                        {{-- se carga con el scrip lineas abajo --}}
                    </div> 
                </div> 
            </div> 
        </div> 
    </div> 
</div> 

<div class="content">    
    <div class="row">
        <div class="col-md-12">           
            <div class="card">
                
                <div class="card-body">

                    <div class="form-group row">
                        <label class="col-md-1 col-form-label">Año</label>
                        <div class="col-md-2">
                            <select id="anio" name="anio" class="form-control" onchange="cargar_fechas_matricula();">                               
                                @foreach ($anios as $item)
                                    <option value="{{ $item->id }}"> {{ $item->anio }} </option>
                                @endforeach
                            </select>
                        </div>
                       
                        <label class="col-md-1 col-form-label">Fecha</label>
                        <div class="col-md-2">
                            <select id="matricula_fechas" name="matricula_fechas" class="form-control"  onchange="cargar_resumen_matricula();">
                                @foreach ($fechas_matriculas as $item)
                                    <option value="{{ $item->matricula_id }}"> {{ $item->fechaActualizacion }} </option>
                                @endforeach
                            </select>
                        </div>
                        
                    </div>                    
                           
                    <div class="progress progress-sm m-0">
                        <div class="progress-bar bg-secondary" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
                    </div>
                    <br>
                    <div class="col-md-12">                       
                        <div class="portfolioFilter">
                            <a href="#" onClick="cargar_resumen_porUgel();"       class="current waves-effect waves-light">UGELES</a>
                            <a href="#" onClick="cargar_matricula_porDistrito();" class="waves-effect waves-light" > DISTRITOS </a>    
                            <a href="#" onClick="cargar_matricula_porInstitucion();" class="waves-effect waves-light" > INSTITUCIONES </a>                  
                        </div>                        
                    </div>

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

{{-- @endsection  --}}

{{-- @section('js') --}}


{{-- https://www.youtube.com/watch?v=HU-hffAZqYw --}}

    <script type="text/javascript"> 
        
        
        $(document).ready(function() {
            
            //alert($('#anio').val());
            cargar_Grafico();
            cargar_fechas_matricula();
            //cargar_resumen_matricula(); 
            // alert($('#anio').val());
            // alert($('#matricula_fechas').val());
        });

        function cargar_Grafico() {
            
            $.ajax({  
                headers: {
                     'X-CSRF-TOKEN': $('input[name=_token]').val()
                },                           
                url: "{{ url('/') }}/Matricula/GraficoBarrasPrincipal/"+ $('#anio').val(),
                type: 'post',
            }).done(function (data) {               
                $('#barra1').html(data);
            }).fail(function () {
                alert("Lo sentimos a ocurrido un error");
            });
        }


        function cargar_fechas_matricula() {
           
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('input[name=_token]').val()
                },
                url: "{{ url('/') }}/Matricula/Fechas/" + $('#anio').val(),
                type: 'post',
                dataType: 'JSON',
                success: function(data) {
                    console.log(data);
                    $("#matricula_fechas option").remove();
                    
                    var options = null;
                    
                    $.each(data.fechas_matriculas, function(index, value) {
                        options += "<option value='" + value.matricula_id + "'>" + value.fechaActualizacion + "</option>";                       
                    });
                    
                    $("#matricula_fechas").append(options);                  
                    cargar_resumen_matricula(); 
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR);
                   
                },
            });
            
            cargar_Grafico();
        }

        function cargar_resumen_matricula() {   

            if($('#hoja').val()==1)       
                cargar_resumen_porUgel();          
            else  
            {
                if($('#hoja').val()==2)
                    cargar_matricula_porDistrito();  
                else
                    cargar_matricula_porInstitucion(); 
            }       
                               
        }

        function cargar_resumen_porUgel() {            
            $('#hoja').val(1);
            $.ajax({  
                headers: {
                     'X-CSRF-TOKEN': $('input[name=_token]').val()
                },                           
                url: "{{ url('/') }}/Matricula/ReporteUgel/" + $('#anio').val() + "/" + $('#matricula_fechas').val(),
                type: 'post',
            }).done(function (data) {               
                $('#datos01').html(data);
            }).fail(function () {
                alert("Lo sentimos a ocurrido un error");
            });
        }

        function cargar_matricula_porDistrito() {
            $('#hoja').val(2);
            $.ajax({  
                headers: {
                     'X-CSRF-TOKEN': $('input[name=_token]').val()
                },                           
                url: "{{ url('/') }}/Matricula/ReporteDistrito/" + $('#anio').val() + "/" + $('#matricula_fechas').val(),
                type: 'post',
            }).done(function (data) {               
                $('#datos01').html(data);
            }).fail(function () {
                alert("Lo sentimos a ocurrido un error");
            });
        }

        function cargar_matricula_porInstitucion() {
            $('#hoja').val(3);
            $.ajax({  
                headers: {
                     'X-CSRF-TOKEN': $('input[name=_token]').val()
                },                           
                url: "{{ url('/') }}/Matricula/ReporteInstitucion/" + $('#anio').val() + "/" + $('#matricula_fechas').val(),
                type: 'post',
            }).done(function (data) {               
                $('#datos01').html(data);
            }).fail(function () {
                alert("Lo sentimos a ocurrido un error");
            });
        }


        
  
       
    </script>



{{-- @endsection --}}
