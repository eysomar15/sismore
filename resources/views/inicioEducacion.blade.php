
{{-- @section('css')


<script src="{{ asset('/') }}assets/libs/highcharts/highcharts.js"></script>
<script src="{{ asset('/') }}assets/libs/highcharts/highcharts-more.js"></script>
<script src="{{ asset('/') }}assets/libs/highcharts/solid-gauge.js"></script>

<script src="{{ asset('/') }}assets/libs/highcharts-modules/exporting.js"></script>
<script src="{{ asset('/') }}assets/libs/highcharts-modules/export-data.js"></script>
<script src="{{ asset('/') }}assets/libs/highcharts-modules/accessibility.js"></script>


@endsection  --}}

<div>

    <div id="container-speed" class="chart-container"></div>
     
</div>

<div class="content">
    <div class="container-fluid">
     <!--Widget-4 -->
        <div class="row">
            <div class="col-md-3 col-xl-3">
                <div class="card-box">
                    <div class="media">
                        <div class="avatar-md bg-success rounded-circle mr-2">
                            <i class=" ion-md-home avatar-title font-26 text-white"></i>
                        </div>
                        <div class="media-body align-self-center">
                            <div class="text-right">
                                <h4 class="font-20 my-0 font-weight-bold"><span data-plugin="counterup"> {{number_format($instituciones_activas,0)}} </span></h4>
                                <p class="mb-0 mt-1 text-truncate">Activas </p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <h6 class="text-uppercase">Instituciones Educativas <span class="float-right"> </span></h6>
                        {{-- <div class="progress progress-sm m-0">
                            <div class="progress-bar bg-success" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                             
                            </div>
                        </div> --}}
                    </div>
                </div>
                <!-- end card-box-->
            </div>

            <div class="col-md-3 col-xl-3">
                <div class="card-box">
                    <div class="media">
                        <div class="avatar-md bg-info rounded-circle mr-2">
                            <i class=" ion ion-md-person avatar-title font-26 text-white"></i>
                        </div>
                        <div class="media-body align-self-center">
                            <div class="text-right">
                                <h4 class="font-20 my-0 font-weight-bold"><span data-plugin="counterup">{{number_format($locales_educativos,0)}}   </span></h4>
                                <p class="mb-0 mt-1 text-truncate">Total </p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <h6 class="text-uppercase">Locales Educativos<span class="float-right"> </span></h6>
                      
                    </div>
                </div>
                <!-- end card-box-->
            </div>

            <div class="col-md-3 col-xl-3">
                <div class="card-box">
                    <div class="media">
                        <div class="avatar-md bg-info rounded-circle mr-2">
                            <i class=" ion ion-md-person avatar-title font-26 text-white"></i>
                        </div>
                        <div class="media-body align-self-center">
                            <div class="text-right">
                                <h4 class="font-20 my-0 font-weight-bold"><span data-plugin="counterup">{{number_format($nroDocentes,0)}} </span></h4>
                                <p class="mb-0 mt-1 text-truncate">Total - Gestión Pública </p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <h6 class="text-uppercase">Docentes <span class="float-right"> </span></h6>
                        
                    </div>
                </div>
                <!-- end card-box-->
            </div>

            <div class="col-md-3 col-xl-3">
                <div class="card-box">
                    <div class="media">
                        <div class="avatar-md bg-info rounded-circle mr-2">
                            <i class=" ion ion-md-person avatar-title font-26 text-white"></i>
                        </div>
                        <div class="media-body align-self-center">
                            <div class="text-right">
                                <h4 class="font-20 my-0 font-weight-bold"><span data-plugin="counterup">{{number_format($totalMatriculados,0)}}  </span></h4>
                                <p class="mb-0 mt-1 text-truncate">Total - Gestión Pública y Privada</p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <h6 class="text-uppercase"> Matriculados Educ. Básica Regular  <span class="float-right"> </span></h6>
                       
                    </div>
                </div>
                <!-- end card-box-->
            </div>


            {{-- <div class="alert alert-info alert-dismissible mb-0 fade show">
       
                <p>dsfdsfdsf</p>
               
            </div> --}}

            <div class="col-md-6 col-xl-6">
                <div class="alert alert-info">                                                          
                        <div id="barraMatriculaUgel">       
                            {{-- se carga con el scrip lineas abajo --}}
                        </div>                     
                </div>                 
            </div>

            <div class="col-md-6 col-xl-6">
                <div class="alert alert-info"> 
                        <div id="GraficoBarras_Docentes_Ugeles">      
                          
                        </div> 
                </div>   
                
            </div>

            <div class="col-md-6 col-xl-6">
                <br>
            </div>
            <div class="col-md-6 col-xl-6">
                <br>
            </div>

            <div class="col-md-6 col-xl-6">
                <div class="alert alert-info">
                    <div id="barraMatriculaTipoGestion">       
                        {{-- se carga con el scrip lineas abajo --}}
                    </div>                    
                </div> 
            </div>

            <div class="col-md-6 col-xl-6">
                <div class="alert alert-info">
                    <div id="GraficoBarras_Instituciones_Distrito">       
                        {{-- se carga con el scrip lineas abajo --}}
                    </div>                    
                </div> 
            </div>

            <div class="col-md-6 col-xl-6">
                <br>
            </div>
            <div class="col-md-6 col-xl-6">
                <br>
            </div>

            <div class="col-md-6 col-xl-6">
                <div class="alert alert-info">
                    {{-- <div class="card-header bg-transparent pb-0">                        
                    </div> --}}
                                      
                        <div id="barra1">       
                            {{-- se carga con el scrip lineas abajo --}}
                        </div> 
                     
                </div>   
                
            </div>

            

          
            <div class="col-md-6 col-xl-6">
                <div class="card card-border">
                    {{-- <div class="card-header bg-transparent pb-0">                        
                    </div>  --}}
                    <div class="card-body">
                        <div class="media">
                            <div class="avatar-md bg-primary rounded-circle mr-2">
                                <i class=" ion-md-people avatar-title font-26 text-white"></i>
                            </div>
                            <div class="media-body align-self-center">
                                <div class="text-right">
                                    <h4 class="font-20 my-0 font-weight-bold"><span data-plugin="counterup">{{number_format($totalMatriculados,0)}}  </span></h4>
                                    <p class="mb-0 mt-1 text-truncate">Total </p>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4">
                            <h6 class="text-uppercase">Alumnos Matriculados EBR - Gestión Pública y Privada<span class="float-right"> </span></h6>
                            <div class="progress progress-sm m-0">
                            
                            </div>
                        </div>

                        <div class="mt-4">
                            <h6 class="text-uppercase">Inicial <span class="float-right"> {{number_format($matriculadosInicial,0)}} </span></h6>
                            <div class="progress progress-sm m-0">                           
                            </div>
                            <h6 class="text-uppercase">Primaria <span class="float-right">{{number_format($matriculadosPrimaria,0)}}</span></h6>
                            <div class="progress progress-sm m-0">                           
                            </div>
                            <h6 class="text-uppercase">Secundaria <span class="float-right">{{number_format($matriculadosSecundaria,0)}}</span></h6>

                            <div class="progress progress-sm m-0">                           
                            </div>
                            <br><br><br><br><br><br><br>
                        </div>
                    </div>
                </div>
                <!-- end card-box-->
            </div>
            

           

        </div>
        <!-- end row -->
    </div>
</div>


@section('js')


    <script src="{{ asset('/') }}assets/libs/highcharts/highcharts.js"></script>
    <script src="{{ asset('/') }}assets/libs/highcharts/highcharts-more.js"></script>
    <script src="{{ asset('/') }}assets/libs/highcharts-modules/exporting.js"></script>
    <script src="{{ asset('/') }}assets/libs/highcharts-modules/export-data.js"></script>
    <script src="{{ asset('/') }}assets/libs/highcharts-modules/accessibility.js"></script>

    <script type="text/javascript"> 
        
        $(document).ready(function() {
            cargar_Grafico();  
            cargar_GraficoBarra_MatriculaUgel();   
            cargar_GraficoBarra_MatriculaTipoGestion();   
            cargar_GraficoBarras_Docentes_Ugeles();    
            cargar_GraficoBarras_Instituciones_Distrito();
        });

        function cargar_Grafico() {
            
            $.ajax({  
                headers: {
                     'X-CSRF-TOKEN': $('input[name=_token]').val()
                },                           
                url: "{{ url('/') }}/Tableta/GraficoBarrasPrincipal/"+ 0,
                type: 'post',
            }).done(function (data) {               
                $('#barra1').html(data);
            }).fail(function () {
                alert("Lo sentimos a ocurrido un error");
            });
        }

        function cargar_GraficoBarra_MatriculaUgel() {            
            $.ajax({  
                headers: {
                     'X-CSRF-TOKEN': $('input[name=_token]').val()
                },                           
                url: "{{ url('/') }}/Matricula/GraficoBarras_MatriculaUgel/"+ {{$matricula_id}},
                type: 'post',
            }).done(function (data) {               
                $('#barraMatriculaUgel').html(data);
            }).fail(function () {
                alert("Lo sentimos a ocurrido un error");
            });
        }

        function cargar_GraficoBarra_MatriculaTipoGestion() {            
            $.ajax({  
                headers: {
                     'X-CSRF-TOKEN': $('input[name=_token]').val()
                },                           
                url: "{{ url('/') }}/Matricula/GraficoBarras_MatriculaTipoGestion/"+ {{$matricula_id}},
                type: 'post',
            }).done(function (data) {               
                $('#barraMatriculaTipoGestion').html(data);
            }).fail(function () {
                alert("Lo sentimos a ocurrido un error");
            });
        }

        function cargar_GraficoBarras_Docentes_Ugeles() {            
            $.ajax({  
                headers: {
                     'X-CSRF-TOKEN': $('input[name=_token]').val()
                },                           
                url: "{{ url('/') }}/CuadroAsigPersonal/Docentes/GraficoBarras_Docentes_Ugeles/"+ {{$ultimo_Importacion_id_dePlaza}},
                type: 'post',
            }).done(function (data) {               
                $('#GraficoBarras_Docentes_Ugeles').html(data);
            }).fail(function () {
                alert("Lo sentimos a ocurrido un error");
            });
        }

        function cargar_GraficoBarras_Instituciones_Distrito() {            
            $.ajax({  
                headers: {
                     'X-CSRF-TOKEN': $('input[name=_token]').val()
                },                           
                url: "{{ url('/') }}/InstEducativa/GraficoBarras_Instituciones_Distrito",
                type: 'post',
            }).done(function (data) {               
                $('#GraficoBarras_Instituciones_Distrito').html(data);
            }).fail(function () {
                alert("Lo sentimos a ocurrido un error");
            });
        }

       
    </script>
    
@endsection









    
