@extends('layouts.main',['titlePage'=>'INDICADOR'])

@section('content')
    <div class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-fill bg-success">
                    <div class="card-header bg-transparent">
                        <h3 class="card-title text-white">{{$title}}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" id="">
            <div class="col-md-6">
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
                <div class="card card-border card-primary">
                    <div class="card-header border-primary bg-transparent pb-0">
                        <h3 class="card-title text-primary">GRAFICA</h3>
                    </div>
                    <div class="card-body">
                        <canvas id="indicador2" data-type="Bar" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div><!-- End row -->
    </div>
@endsection

@section('js')

    <!-- flot chart -->
    <!--script src="{{ asset('/') }}assets/libs/flot-charts/jquery.flot.js"></script-->
    <script src="{{ asset('/') }}assets/libs/chart-js/Chart.bundle.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            
        });
        //var ctx = document.getElementById('indicador2').getContext('2d');
        var myChart = new Chart($('#indicador2'), {
            type: 'bar',
            data: {
                labels: {{$info['labels']}},//['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                datasets: [{
                    label: 'RESULTADO',
                    data: {{$info['datas']}},
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
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
                    //position: 'bottom',
                },               
                scales: {
                    yAxes: [{
                        stacked: true,
                        ticks: {
                          beginAtZero: true,
                          min: 0,
                          max: {{$limit}}
                        },
                        /*scaleLabel: {
                            display: true,
                            labelString: 'Porcentaje'
                        }*/
                    }],
                    xAxes: [{
                        stacked: true,
                        ticks: {
                          beginAtZero: true                          
                        },
                        /*scaleLabel: {
                            display: true,
                            labelString: 'Año'
                        }*/
                    }]
                },                
                tooltips: {
                    enabled: true,
                    mode: 'index',
                    intersect: true
                    //position: 'average'
                },
            }
        });
    </script>

@endsection
