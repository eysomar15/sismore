
@section('css')


<script src="{{ asset('/') }}assets/libs/highcharts/highcharts.js"></script>
<script src="{{ asset('/') }}assets/libs/highcharts/highcharts-more.js"></script>

<script src="{{ asset('/') }}assets/libs/highcharts-modules/exporting.js"></script>
<script src="{{ asset('/') }}assets/libs/highcharts-modules/export-data.js"></script>
<script src="{{ asset('/') }}assets/libs/highcharts-modules/accessibility.js"></script>


<script src="https://code.highcharts.com/modules/solid-gauge.js"></script> 

@endsection 

<div>

    <div id="container-speed" class="chart-container"></div>
     
</div>

<div class="content">
    <div class="container-fluid">
     <!--Widget-4 -->
        <div class="row">
            <div class="col-md-6 col-xl-6">
                <div class="card-box">
                    <div class="media">
                        <div class="avatar-md bg-info rounded-circle mr-2">
                            <i class=" ion-md-home avatar-title font-26 text-white"></i>
                        </div>
                        <div class="media-body align-self-center">
                            <div class="text-right">
                                <h4 class="font-20 my-0 font-weight-bold"><span data-plugin="counterup">{{$instituciones_activas}}</span></h4>
                                <p class="mb-0 mt-1 text-truncate">Instituciones Educativas Activas</p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <h6 class="text-uppercase">Representa <span class="float-right">{{$porcentajeInstituciones_activas}}%</span></h6>
                        <div class="progress progress-sm m-0">
                            <div class="progress-bar bg-info" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: {{$porcentajeInstituciones_activas}}%">
                                {{-- <span class="sr-only">60% Complete</span> --}}
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end card-box-->
            </div>

            <div class="col-md-6 col-xl-6">
                <div class="card-box">
                    <div class="media">
                        <div class="avatar-md bg-purple rounded-circle">
                            <i class=" ion-ios-people avatar-title font-26 text-white"></i>
                        </div>
                        <div class="media-body align-self-center">
                            <div class="text-right">
                                <h4 class="font-20 my-0 font-weight-bold"><span data-plugin="counterup">{{$titulados_sum}}</span></h4>
                                <p class="mb-0 mt-1 text-truncate">Docentes títulados(Ini. Prim. y Secun.)</p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <h6 class="text-uppercase">Representa <span class="float-right">{{$porcentajeTitulados}}%</span></h6>
                        <div class="progress progress-sm m-0">
                            <div class="progress-bar bg-purple" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100" style="width: {{$porcentajeTitulados}}%">
                                {{-- <span class="sr-only">90% Complete</span> --}}
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end card-box-->
            </div>

           
            <div class="col-md-6 col-xl-6">
                <div class="card-box">
                    <div class="media">
                        <div class="avatar-md bg-primary rounded-circle">
                            <i class="  ion ion-logo-rss avatar-title font-26 text-white"></i>
                        </div>
                        <div class="media-body align-self-center">
                            <div class="text-right">
                                <h4 class="font-20 my-0 font-weight-bold"><span data-plugin="counterup">{{$locales_tieneInternet}}</span></h4>
                                <p class="mb-0 mt-1 text-truncate">Locales Edu. Con Internet</p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <h6 class="text-uppercase">Representa <span class="float-right">{{$porcentajeLocales_tieneInternet}}%</span></h6>
                        <div class="progress progress-sm m-0">
                            <div class="progress-bar bg-primary" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100" style="width: {{$porcentajeLocales_tieneInternet}}%">
                                {{-- <span class="sr-only">60% Complete</span> --}}
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end card-box-->
            </div>

            <div class="col-md-6 col-xl-6">
                <div class="card-box">
                    <div class="media">
                        <div class="avatar-md bg-success rounded-circle">
                            <i class="ion ion-ios-home avatar-title font-26 text-white"></i>
                        </div>
                        <div class="media-body align-self-center">
                            <div class="text-right">
                                <h4 class="font-20 my-0 font-weight-bold"><span data-plugin="counterup">{{$localesEducativos}}</span></h4>
                                <p class="mb-0 mt-1 text-truncate">Locales Educativos</p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <h6 class="text-uppercase">- <span class="float-right"></span></h6>
                        <div class="progress progress-sm m-0">
                            <div class="progress-bar bg-success" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                                {{-- <span class="sr-only">57% Complete</span> --}}
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end card-box-->
            </div>

            
            <div class="col-md-6 col-xl-6">                
                    <div id="medidor1">       
                        @include('graficos.Medidor')
                    </div> 
            </div>

            <div class="col-md-6 col-xl-6">                
                <div id="medidor2">       
                    @include('graficos.Medidor')
                </div> 
            </div>

        </div>
        <!-- end row -->
    </div>
</div>










    
