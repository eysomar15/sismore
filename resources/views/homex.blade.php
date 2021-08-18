@extends('layouts.main',['titlePage'=>'Bienvenido al SISMORE - Ucayali'])

@section('content')
<div class="content">

   <br><br>
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

        </div>
        <!-- end row -->

        {{-- <div class="row">
            <div class="col-xl-8">
                <div class="card">
                    <div class="card-header py-3 bg-transparent">
                        <div class="card-widgets">
                            <a href="javascript:;" data-toggle="reload"><i class="mdi mdi-refresh"></i></a>
                            <a data-toggle="collapse" href="#cardCollpase1" role="button" aria-expanded="false" aria-controls="cardCollpase1"><i class="mdi mdi-minus"></i></a>
                            <a href="#" data-toggle="remove"><i class="mdi mdi-close"></i></a>
                        </div>
                        <h5 class="card-title mb-0"> Website Stats</h5>
                    </div>
                    <div id="cardCollpase1" class="collapse show">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="website-stats" style="position: relative;height: 320px"></div>
                                    <div class="row text-center mt-4">
                                        <div class="col-sm-4">
                                            <h5 class="my-1"><span data-plugin="counterup">86,956</span></h5>
                                            <small class="text-muted"> Weekly Report</small>
                                        </div>
                                        <div class="col-sm-4">
                                            <h5 class="my-1"><span data-plugin="counterup">86,69</span></h5>
                                            <small class="text-muted">Monthly Report</small>
                                        </div>
                                        <div class="col-sm-4">
                                            <h5 class="my-1"><span data-plugin="counterup">948,16</span></h5>
                                            <small class="text-muted">Yearly Report</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end card-->
            </div>
            <!-- end col -->

            <div class="col-xl-4">
                <div class="card">
                    <div class="card-header py-3 bg-transparent">
                        <div class="card-widgets">
                            <a href="javascript:;" data-toggle="reload"><i class="mdi mdi-refresh"></i></a>
                            <a data-toggle="collapse" href="#cardCollpase2" role="button" aria-expanded="false" aria-controls="cardCollpase2"><i class="mdi mdi-minus"></i></a>
                            <a href="#" data-toggle="remove"><i class="mdi mdi-close"></i></a>
                        </div>
                        <h5 class="card-title mb-0"> Website Stats</h5>
                    </div>

                    <div id="cardCollpase2" class="collapse show">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="pie-chart">
                                        <div id="pie-chart-container" class="flot-chart" style="height: 320px">
                                        </div>
                                    </div>
                                    <div class="row text-center mt-4">
                                        <div class="col-sm-6">
                                            <h5 class="my-1"><span data-plugin="counterup">86,69</span></h5>
                                            <small class="text-muted"> Weekly Report</small>
                                        </div>
                                        <div class="col-sm-6">
                                            <h5 class="my-1"><span data-plugin="counterup">86,69</span></h5>
                                            <small class="text-muted">Monthly Report</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    
                </div>
                <!-- end card-->
            </div>
            <!-- end col -->
        </div> --}}
        <!-- End row -->

      
    </div>
    
@endsection

@section('js')
 <!-- flot chart -->
        <script src="{{asset('/')}}assets/libs/flot-charts/jquery.flot.js"></script>
        <script src="{{asset('/')}}assets/libs/flot-charts/jquery.flot.time.js"></script>
        <script src="{{asset('/')}}assets/libs/flot-charts/jquery.flot.tooltip.min.js"></script>
        
        {{-- este scrip genera conflicto con el <script src="assets/js/pages/dashboard.init.js"></script> --}}
        {{-- <script src="assets/libs/flot-charts/jquery.flot.resize.js"></script> --}}
        
        
        <script src="{{asset('/')}}assets/libs/flot-charts/jquery.flot.pie.js"></script>
        <script src="{{asset('/')}}assets/libs/flot-charts/jquery.flot.selection.js"></script>
        <script src="{{asset('/')}}assets/libs/flot-charts/jquery.flot.stack.js"></script>
        <script src="{{asset('/')}}assets/libs/flot-charts/jquery.flot.crosshair.js"></script> 

        <!-- Dashboard init JS -->
        <script src="{{asset('/')}}assets/js/pages/dashboard.init.js"></script>
@endsection