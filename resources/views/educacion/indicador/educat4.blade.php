@extends('layouts.main',['titlePage'=>'INDICADOR'])

@section('content')
    <div class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-fill bg-success">
                    <div class="card-header bg-transparent">
                        <h3 class="card-title text-white">{{ $title }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            {{--<div class="col-md-6">
                <div class="card card-border">
                    <div class="card-header border-primary bg-transparent pb-0">
                        <h3 class="card-title">Region de Ucayali</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table class="table mb-0">
                                        <thead>
                                            <tr>
                                                <th>PROFESORES</th>
                                                <th>CANTIDAD</th>
                                                <th>%</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($inds as $item)
                                                <tr>
                                                    <td>{{ $item->titulado }}</td>
                                                    <td>{{ $item->suma }}</td>
                                                    <td>{{ round(($item->suma * 100) / $total, 2) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>--}}
            <div class="col-xl-6">
                <div class="card card-border card-primary">
                    <div class="card-header border-primary bg-transparent pb-0">
                        <h3 class="card-title text-primary">GRAFICA</h3>
                    </div>
                    <div class="card-body">
                        <canvas id="indicador1" data-type="Bar" height="150" ></canvas>
                    </div>
                </div>
            </div>
        {{--</div><!-- End row -->
        <div class="row">--}}
            {{--<div class="col-md-6">
                <div class="card card-border">
                    <div class="card-header border-primary bg-transparent pb-0">
                        <h3 class="card-title">Por Ugel</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table class="table mb-0">
                                        <thead>
                                            <tr>
                                                <th>UGEL</th>
                                                <th># DE PROFESORES</th>
                                                <th>% TITULADO</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($indu as $item)
                                                <tr>
                                                    <td>{{ $item->nombre }}</td>
                                                    <td>{{ $item->titulado }}</td>
                                                    <td>{{ round(($item->titulado * 100) / $item->total, 2) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>--}}
            <div class="col-xl-6">
                <div class="card card-border card-primary">
                    <div class="card-header border-primary bg-transparent pb-0">
                        <h3 class="card-title text-primary">GRAFICA
                            <div class="float-right">
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <button type="button" class="btn btn-primary btn-xs" onclick="alert('jajajajaja')">Ver detalle</button>
                                    </div>
                                </div>
                            </div>
                        </h3>
                    </div>
                    <div class="card-body">
                        <canvas id="indicador2" data-type="Bar" height="150" ></canvas>
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

        });
        var myChart = new Chart($('#indicador1'), {
            type: 'bar',
            data: {
                labels:{!!$graf1['labels']!!},
                datasets: [{
                    label: 'PROFESORES',
                    data: {{$graf1['datas']}},
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',//'#1097EE',
                    borderColor:'rgba(54, 162, 235, 0.2)',// '#1097EE',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                /*title: {
                    display: false,
                    text: 'Estudiantes del 2do grado de primaria que logran el nivel satisfactorio en Lectura'
                },*/
                legend: {
                    display: true,
                    position: 'bottom',
                },
                scales: {
                    yAxes: [{
                        stacked: true,
                        ticks: {
                            beginAtZero: true,
                            min: 0,
                            max: 100
                        },
                        scaleLabel: {
                            display: true,
                            labelString: 'Porcentaje'
                        }
                    }],
                    xAxes: [{
                        stacked: true,
                        ticks: {
                            beginAtZero: true
                        },
                        scaleLabel: {
                            display: false,
                            labelString: 'Estado'
                        }
                    }]
                },  
                tooltips: {
                    enabled: false,
                    mode: 'index',
                    intersect: true,
                    position: 'average'
                },
                maintainAspectRatio: true,
                hover: {
                    animationDuration: 0
                },
                animation: {
                    duration: 1,
                    onComplete: function() {
                    let chartInstance = this.chart,
                        ctx = chartInstance.ctx;
                        ctx.textAlign = 'center';
                        //ctx.textBaseline = 'bottom';
                        this.data.datasets.forEach(function(dataset, i){
                            let meta = chartInstance.controller.getDatasetMeta(i);
                            meta.data.forEach(function(bar, index) {
                                let data = dataset.data[index];
                                if(data>0){
                                    ctx.fillText(data+'%', bar._model.x ,bar._model.y+4.5+(bar._model.base-bar._model.y)/2);
                                }
                                
                            });
                        });
                    },
                },
            }
        });
        var myChart = new Chart($('#indicador2'), {
            type: 'bar',
            data: {
                labels:{!!$graf2['labels']!!},
                datasets: [{
                    label: 'TITULADOS',
                    data: {{$graf2['datas']}},
                    backgroundColor:'rgba(54, 162, 235, 0.2)' ,//'#1097EE',
                    borderColor: 'rgba(54, 162, 235, 0.2)',//'#1097EE',
                    borderWidth: 1
                }]
            },
            options: {
                
                responsive: true,
                /*title: {
                    display: false,
                    text: 'Estudiantes del 2do grado de primaria que logran el nivel satisfactorio en Lectura'
                },*/
                legend: {
                    display: true,
                    position: 'bottom',
                },
                scales: {
                    yAxes: [{
                        stacked: true,
                        ticks: {
                            beginAtZero: true,
                            min: 0,
                            max: 100
                        },
                        scaleLabel: {
                            display: true,
                            labelString: 'Porcentaje'
                        }
                    }],
                    xAxes: [{
                        stacked: true,
                        ticks: {
                            beginAtZero: true
                        },
                        scaleLabel: {
                            display: false,
                            labelString: 'Ugel'
                        }
                    }]
                },  
                tooltips: {
                    enabled: false,
                    mode: 'index',
                    intersect: true,
                    position: 'average'
                },
                maintainAspectRatio: true,
                hover: {
                    animationDuration: 0
                },
                animation: {
                    duration: 1,
                    onComplete: function() {
                    let chartInstance = this.chart,
                        ctx = chartInstance.ctx;
                        ctx.textAlign = 'center';
                        //ctx.textBaseline = 'bottom';
                        this.data.datasets.forEach(function(dataset, i){
                            let meta = chartInstance.controller.getDatasetMeta(i);
                            meta.data.forEach(function(bar, index) {
                                let data = dataset.data[index];
                                if(data>0){
                                    ctx.fillText(data+'%', bar._model.x ,bar._model.y+4.5+(bar._model.base-bar._model.y)/2);
                                }
                                
                            });
                        });
                    },
                },
            }
        });

    </script>

@endsection
