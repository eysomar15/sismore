@extends('layouts.main',['activePage'=>'importacion','titlePage'=>'DIRECCIÓN REGIONAL DE EDUCACIÓN DE UCAYALI'])


@section('content') 
<div class="content">
    <input type="hidden" id="hoja" value="1">
    
    <div class="row">
        <div class="col-md-12">           
            <div class="card">
                
                <div class="card-body">
                           
                    
                    <div class="col-md-12">                       
                        <div class="portfolioFilter">
                            <a href="#" onClick="cargar_resumen_porUgel();"  class="current waves-effect waves-light">UGELES</a>
                            <a href="#" onClick="cargar_resumen_porDistrito();" class="waves-effect waves-light" > DISTRITOS </a>                  
                        </div>                        
                    </div>

                    <div class="progress progress-sm m-0">
                        <div class="progress-bar bg-secondary" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
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
            cargar_resumen_porUgel();
        });

        function cargar_resumen_matricula() {   

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
                url: "{{ url('/') }}/CuadroAsigPersonal/ReporteUgel",
                type: 'post',
            }).done(function (data) {               
                $('#datos01').html(data);
            }).fail(function () {
                alert("Lo sentimos a ocurrido un error");
            });

            // alert("1");
        }

        function cargar_resumen_porDistrito() {
            $('#hoja').val(2);
            // $.ajax({  
            //     headers: {
            //          'X-CSRF-TOKEN': $('input[name=_token]').val()
            //     },                           
            //     url: "{{ url('/') }}/Matricula/ReporteDistrito/" + $('#anio').val() + "/" + $('#matricula_fechas').val(),
            //     type: 'post',
            // }).done(function (data) {               
            //     $('#datos01').html(data);
            // }).fail(function () {
            //     alert("Lo sentimos a ocurrido un error");
            // });
            alert("2");
        }
  
       
    </script>



@endsection