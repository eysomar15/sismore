@extends('layouts.main',['titlePage'=>'INDICADORES'])

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
            
        });
        //var ctx = document.getElementById('indicador2').getContext('2d');
        var myChart = new Chart($('#indicador2'), {
            type: 'bar',
            data: {
                labels:  ,//['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                datasets: [{
                    label: 'RESULTADOS',
                    data:  ,
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
