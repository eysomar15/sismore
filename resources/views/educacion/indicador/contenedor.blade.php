@extends('layouts.main',['titlePage'=>''])

@section('content')
    <div class="content">
        <div class="row" id="vistaugel">
            <div class="col-md-6">
                <div class="card card-border">
                    <div class="card-header border-primary bg-transparent pb-0">
                        <h3 class="card-title">Indicador de Ucayali</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table class="table mb-0">
                                        <thead>
                                            <tr>
                                                <!--th>DEPARTAMENTO</th-->
                                                <th>AÑO</th>
                                                <th>RESULTADO</th>
                                                <th>NOTA</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($inds as $item)
                                                <tr>
                                                    <!--td>{{ $item->departamento }}</td-->
                                                    <td>{{ $item->anio }}</td>
                                                    <td>{{ $item->resultado }}</td>
                                                    <td>{{ $item->nota }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-6">
                <div class="card">
                    <div class="card-header py-3 bg-transparent">
                        <div class="card-widgets">
                            <a href="javascript:;" data-toggle="reload"><i class="mdi mdi-refresh"></i></a>
                            <a data-toggle="collapse" href="#cardCollpase1" role="button" aria-expanded="false"
                                aria-controls="cardCollpase1"><i class="mdi mdi-minus"></i></a>
                            <a href="#" data-toggle="remove"><i class="mdi mdi-close"></i></a>
                        </div>
                        <h5 class="card-title mb-0"> Grafica 1</h5>
                    </div>
                    <div id="cardCollpase1" class="collapse show">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="indicador1" style="position: relative;height: 320px"></div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end card-->
            </div>
            <div class="col-xl-6">
                <div class="card card-border card-primary">
                    <div class="card-header border-primary bg-transparent pb-0">
                        <h3 class="card-title text-primary">GRAFICA 2</h3>
                    </div>
                    <div class="card-body">
                        <canvas id="indicador2" data-type="Bar" height="300" width="800"></canvas>
                    </div>
                </div>
            </div>
        </div><!-- End row -->
    </div>
@endsection

@section('js')

    <!-- flot chart -->
    <script src="{{ asset('/') }}assets/libs/flot-charts/jquery.flot.js"></script>
    <script src="{{ asset('/') }}assets/libs/chart-js/Chart.bundle.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $.plot('#indicador1', [{
                    data: {{ $minds }},
                    label: "Resultados",
                    color: "#317eeb"
                },
                /*{
                    data: {{ $minds }},
                    label: "Pages/Visit",
                    color: "#1a2942"
                }*/
            ], {
                series: {
                    lines: {
                        show: !0,
                        fill: !0,
                        lineWidth: 1,
                        fillColor: {
                            colors: [{
                                opacity: .5
                            }, {
                                opacity: .5
                            }]
                        }
                    },
                    points: {
                        show: !0
                    },
                    shadowSize: 0
                },
                legend: {
                    position: "ne",
                    margin: [0, -24],
                    noColumns: 0,
                    backgroundColor: "transparent",
                    labelBoxBorderColor: null,
                    labelFormatter: function(t, a) {
                        return t + "&nbsp;&nbsp;"
                    },
                    width: 30,
                    height: 2
                },
                grid: {
                    hoverable: !0,
                    clickable: !0,
                    tickColor: "#f9f9f9",
                    borderColor: "rgba(108, 120, 151, 0.1)",
                    borderWidth: 1,
                    labelMargin: 10,
                    backgroundColor: "transparent"
                },
                /*yaxis: {
                    min: 0,
                    max: 15,
                    tickColor: "rgba(108, 120, 151, 0.1)",
                    font: {
                        color: "#8a93a9"
                    }
                },
                xaxis: {
                    tickColor: "rgba(108, 120, 151, 0.1)",
                    font: {
                        color: "#8a93a9"
                    }
                },*/
                tooltip: !0,
                tooltipOpts: {
                    content: "%s: Value of %x is %y",
                    shifts: {
                        x: -60,
                        y: 25
                    },
                    defaultTheme: !1
                }
            }); //fin plot
        });
        //var ctx = document.getElementById('indicador2').getContext('2d');
        var myChart = new Chart($('#indicador2'), {
            type: 'bar',
            data: {
                labels: {{$info['labels']}},//['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                datasets: [{
                    label: 'RESULTADOS',
                    data: {{$info['datas']}},
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        //'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        //'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

@endsection
