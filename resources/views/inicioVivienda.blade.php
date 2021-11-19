@section('css')


    <script src="{{ asset('/') }}assets/libs/highcharts/highcharts.js"></script>
    <script src="{{ asset('/') }}assets/libs/highcharts/highcharts-more.js"></script>
    <script src="{{ asset('/') }}assets/libs/highcharts/solid-gauge.js"></script>

    <script src="{{ asset('/') }}assets/libs/highcharts-modules/exporting.js"></script>
    <script src="{{ asset('/') }}assets/libs/highcharts-modules/export-data.js"></script>
    <script src="{{ asset('/') }}assets/libs/highcharts-modules/accessibility.js"></script>



    {{-- <script src="https://code.highcharts.com/modules/solid-gauge.js"></script> --}}

@endsection

<div>

    <div id="container-speed" class="chart-container"></div>

</div>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            @php
                $color = ['info', 'purple', 'success', 'primary', 'pink', 'dark', 'warning', 'secondary'];
            @endphp
            @foreach ($data as $pos => $dato)
                <div class="col-md-6 col-xl-3">
                    <div class="card-box">
                        <div class="media">
                            <div class="avatar-md bg-{{ $color[$pos] }} rounded-circle mr-2">
                                <i class="ion-logo-usd avatar-title font-26 text-white"></i>
                                {{-- <i class="ion-logo-usd avatar-title font-26 text-white"></i> --}}
                            </div>
                            <div class="media-body align-self-center">
                                <div class="text-right">
                                    <h4 class="font-20 my-0 font-weight-bold"><span
                                            data-plugin="counterup">{{ number_format($dato['y']) }}</span>
                                    </h4>
                                    <p class="mb-0 mt-1 text-truncate">Total</p>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4">
                            <h6 class="text-uppercase">{{ $dato['name'] }}
                                <!--span class="float-right">60%</span-->
                            </h6>
                            <div class="progress progress-sm m-0">
                                <div class="progress-bar bg-{{ $color[$pos] }}" role="progressbar" aria-valuenow="60"
                                    aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                                    <span class="sr-only">60% Complete</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end card-box-->
                </div>
            @endforeach

            {{-- @foreach ($sistemas as $pos => $sis)
                <div class="col-md-6 col-xl-3">
                    <div class="card-box">
                        <div class="media">
                            <div class="avatar-md bg-{{ $color[$pos] }} rounded-circle mr-2">
                                <i class="{{ $sis->icono }} avatar-title font-26 text-white"></i>
                                <i class="ion-logo-usd avatar-title font-26 text-white"></i>
                            </div>
                            <div class="media-body align-self-center">
                                <div class="text-right">
                                    <h4 class="font-20 my-0 font-weight-bold"><span
                                            data-plugin="counterup">{{ $sis->nrousuario }}</span>
                                    </h4>
                                    <p class="mb-0 mt-1 text-truncate">Accesos de Usuario</p>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4">
                            <h6 class="text-uppercase">Sistema {{ $sis->nombre }}
                                <!--span class="float-right">60%</span-->
                            </h6>
                            <div class="progress progress-sm m-0">
                                <div class="progress-bar bg-{{ $color[$pos] }}" role="progressbar" aria-valuenow="60"
                                    aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                                    <span class="sr-only">60% Complete</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end card-box-->
                </div>
            @endforeach --}}
        </div>
        <!-- end row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-fill bg-primary">
                    <div class="card-header bg-transparent">
                        <h3 class="card-title text-white">Información General</h3>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->

        <div class="row">
            @foreach ($data2 as $pos => $dato)
                <div class="col-md-6 col-xl-3">
                    <div class="card-box">
                        <div class="media">
                            <div class="avatar-md bg-{{ $color[$pos] }} rounded-circle mr-2">
                                <i class="ion-logo-usd avatar-title font-26 text-white"></i>
                                {{-- <i class="ion-logo-usd avatar-title font-26 text-white"></i> --}}
                            </div>
                            <div class="media-body align-self-center">
                                <div class="text-right">
                                    <h4 class="font-20 my-0 font-weight-bold"><span
                                            data-plugin="counterup">{{ number_format($dato['y']) }}</span>
                                    </h4>
                                    <p class="mb-0 mt-1 text-truncate">{{ $dato['name'] }}</p>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="mt-4">
                            <h6 class="text-uppercase">{{ $dato['name'] }}
                                <!--span class="float-right">60%</span-->
                            </h6>
                            <div class="progress progress-sm m-0">
                                <div class="progress-bar bg-{{ $color[$pos] }}" role="progressbar" aria-valuenow="60"
                                    aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                                    <span class="sr-only">60% Complete</span>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                    <!-- end card-box-->
                </div>
            @endforeach
        </div>
        <!-- end row -->
        <div class="row">
            <div class="col-xl-6">
                <div class="card card-border card-primary">
                    <div class="card-body">
                        <div id="con1" style="min-width:400px;height:300px;margin:0 auto;"></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="card card-border card-primary">
                    <div class="card-body">
                        <div id="con2" style="min-width:400px;height:300px;margin:0 auto;"></div>
                    </div>
                </div>
            </div>
        </div>
        {{-- end  row --}}
    </div>
</div>
@section('js')

    <script type="text/javascript">
        $(document).ready(function() {
            graficar('con1', {!! $grafica[0] !!}, 'TOTAL DE CENTRO POBLADOS', '', 'Provincias');
            graficar('con2', {!! $grafica[1] !!}, 'TOTAL DE CENTRO POBLADOS <BR>CON SERVICIO DE AGUA', '','Provincias');
        });

        function graficar(div, datax, titulo, subtitulo, tituloserie) {
            Highcharts.chart(div, {
                chart: {
                    type: 'column',
                },
                title: {
                    text: titulo,
                },
                subtitle: {
                    text: subtitulo,
                },
                xAxis: {
                    type: 'category',
                },
                yAxis: {
                    max:100,
                    title: {
                        enabled: false,
                        text: 'Porcentaje',
                    }
                },
                series: [{
                    name: tituloserie,
                    colorByPoint: true,
                    data: datax,
                }],
                tooltip: {
                    //headerFormat: '<span style="font-size: 10px">{point.key}</span><br/>',
                    pointFormat: '<span style="color:{point.color}">\u25CF</span> Hay: <b>{point.conteo}</b><br/>',
                    //pointFormat: '<span style="color:{point.color}">\u25CF</span> {series.name}: <b>{point.conteo}</b><br/>',
                    shared: true
                },
                plotOptions: {
                    series: {
                        borderWidth: 0,
                        dataLabels: {
                            enabled: true,
                            format: '{point.y:.1f}%',
                        },
                    }
                },
                credits: false,
            });
        }
        /*  Highcharts.chart('barra1', {
             chart: {
                 type: 'column'
             },
             credits: false,
             title: {
                 text: 'titulo 1'
             },
             subtitle: {
                 text: 'titulo 2'
             },
             xAxis: {
                 categories: [],
                 crosshair: true
             },
             yAxis: {
                 min: 0,
                 title: {
                     text: 'titulo 3'
                 }
             },
             tooltip: {
                 headerFormat: '<span style="font-size:12px">{point.key}</span><table>',
                 pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                     '<td style="padding:0"><b>{point.y} </b></td></tr>',
                 footerFormat: '</table>',
                 shared: true,
                 useHTML: true
             },

             plotOptions: {
                 column: {
                     pointPadding: 0.2,
                     borderWidth: 0,
                     dataLabels: {
                         enabled: true,

                         format: '{y}'
                     }

                     // dataLabels: {
                     //         enabled: true,
                     //         rotation: -90,
                     //         color: '#FFFFFF',
                     //         align: 'right',
                     //         format: '{point.y}', // one decimal
                     //         y: 10, // 10 pixels down from the top
                     //         style: {
                     //             fontSize: '14px',
                     //             fontFamily: 'Verdana, sans-serif'
                     //         }
                     //     }
                 }
             },
             series: []
         }); */
    </script>
@endsection
