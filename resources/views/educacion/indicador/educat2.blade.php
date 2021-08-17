@extends('layouts.main',['titlePage'=>'INDICADORES'])
{{--,'breadcrumb'=>['Relacion de indicadores','Indicador']--}}
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
        @if ($sinaprobar->count() > 0)
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-border">
                        <div class="card-header border-danger bg-transparent pb-0">
                            <div class="card-title">Importaciones sin aprobar</div>
                        </div>
                        <div class="card-body">
                            @foreach ($sinaprobar as $item)
                                <div class="alert alert-danger">
                                    {{ $item->comentario }}, de la fecha {{ $item->created_at }}
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        @endif
        <div class="row">
            @foreach ($materias as $key => $materia)
            <div class="col-xl-6">
                <div class="card card-border card-primary">
                    <div class="card-header border-primary bg-transparent pb-0">
                        <h3 class="card-title text-primary">Estudiantes del {{$gt[0]->grado}} grado de {{$gt[0]->nivel}} que logran el nivel satisfactorio en  {{$materia->descripcion}}
                            <div class="float-right">
                                <!--div class="form-group row">
                                    <div class="col-md-12">
                                        <a href="{{route('ind.det.edu',['indicador_id'=>$indicador_id,'grado'=>$grado,'tipo'=>$tipo,'materia'=>$materia->id])}}"  class="btn btn-primary btn-xs">Ver detalle</a>
                                    </div>
                                </div-->
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary btn-xs waves-effect waves-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="mdi mdi-chevron-down"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a href="#" class="dropdown-item" onclick="abrirdetalle({{$key}})">Informacion</a></li>
                                        <li class="dropdown-divider"></li>
                                        <li><a href="{{route('ind.det.edu',['indicador_id'=>$indicador_id,'grado'=>$grado,'tipo'=>$tipo,'materia'=>$materia->id])}}" class="dropdown-item">Detalle</a></li>
                                        <li><a href="{{route('ind.res.edu',['indicador_id'=>$indicador_id,'grado'=>$grado,'tipo'=>$tipo,'materia'=>$materia->id])}}" class="dropdown-item">Resumen</a></li>
                                    </ul>
                                </div>
                            </div>
                            
                        </h3>
                    </div>
                    <div class="card-body">
                        <canvas id="indicador{{$key}}" data-type="Bar" height="200"></canvas>
                    </div>
                    <div  class="card-footer text-muted bg-transparent px-0 text-center">Leyenda: 
                        <span class="badge" style="background-color:#7C7D7D;">PREVIO</span>
                        <span class="badge" style="background-color:#F25656;">INICIO</span>
                        <span class="badge" style="background-color:#F2CA4C;">PROCESO</span>
                        <span class="badge" style="background-color:#22BAA0;">SATISFACTORIO</span>
                    </div>
                </div>
            </div>    
            @endforeach
            
        </div><!-- End row -->
 
    </div>

    @foreach ($materias as $pos => $materia)
    <!--  Modal content for the above example -->
    <div id="modal_detalle_{{$pos}}" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myLargeModalLabel">Estudiantes del {{$gt[0]->grado}} grado de {{$gt[0]->nivel}} que logran el nivel satisfactorio en  {{$materia->descripcion}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-primary text-center">AÑO</th>
                                            <th class="text-secondary text-center">CANTIDAD</th>
                                            <th class="text-secondary text-center">PREVIO</th>
                                            <th class="text-danger text-center">CANTIDAD</th>
                                            <th class="text-danger text-center">INICIO</th>
                                            <th class="text-warning text-center">CANTIDAD</th>
                                            <th class="text-warning text-center">PROCESO</th>
                                            <th class="text-success text-center">CANTIDAD</th>
                                            <th class="text-success text-center">SATISFACTORIO</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($materia->indicador as $ind)
                                        <tr>
                                            <td class="text-primary text-center">{{$ind->anio}}</td>
                                            <td class="text-secondary text-center">{{$ind->previo}}</td>
                                            <td class="text-secondary text-center">{{round($ind->previo * 100 / $ind->evaluados, 2)}} %</td>
                                            <td class="text-danger text-center">{{$ind->inicio}}</td>
                                            <td class="text-danger text-center">{{round($ind->inicio * 100 / $ind->evaluados, 2)}} %</td>
                                            <td class="text-warning text-center">{{$ind->proceso}}</td>
                                            <td class="text-warning text-center">{{round($ind->proceso * 100 / $ind->evaluados, 2)}} %</td>
                                            <td class="text-success text-center">{{$ind->satisfactorio}}</td>
                                            <td class="text-success text-center">{{round($ind->satisfactorio * 100 / $ind->evaluados, 2)}} %</td>
                                        </tr>    
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->    
    @endforeach

@endsection

@section('js')
    <script src="{{ asset('/') }}assets/libs/chart-js/Chart.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
           
        });
        function abrirdetalle(pos){
            $('#modal_detalle_'+pos).modal('show');
        }
        @foreach ($materias as $pos1 => $materia)
        var myChart = new Chart($('#indicador{{$pos1}}'), {
            type: 'bar',
            data: {
                labels: [
                    @foreach ($materia->indicador as $item)
                    {!!'"'.$item->anio.'",'!!}
                    @endforeach
                ],
                datasets: [{
                    label: 'PREVIO',
                    data: [
                        @foreach ($materia->indicador as $item)
                        {{ round(($item->previo  * 100) / $item->evaluados, 2) . ',' }}
                        @endforeach
                    ],
                    backgroundColor: '#7C7D7D', //'rgba(54, 162, 235, 0.2)',
                    borderColor: '#7C7D7D',
                    borderWidth: 1,
                },{
                    label: 'INICIO',
                    data: [
                        @foreach ($materia->indicador as $item)
                        {{ round(( $item->inicio * 100) / $item->evaluados, 2) . ',' }}
                        @endforeach
                    ],
                    backgroundColor: '#F25656', //'rgba(54, 162, 235, 0.2)',
                    borderColor: '#F25656',
                    borderWidth: 1,
                }, {
                    label: 'PROCESO',
                    data: [
                        @foreach ($materia->indicador as $item)
                        {{ round(($item->proceso * 100) / $item->evaluados, 2) . ',' }}
                        @endforeach
                    ],
                    backgroundColor: '#F2CA4C', //'rgba(54, 162, 235, 0.2)',
                    borderColor: '#F2CA4C',
                    borderWidth: 1
                }, {
                    label: 'SATISFACTORIO',
                    data: [
                        @foreach ($materia->indicador as $item)
                        {{ round(($item->satisfactorio * 100) / $item->evaluados, 2) . ',' }}
                        @endforeach
                    ],
                    backgroundColor: '#22BAA0', // 'rgba(54, 162, 235, 0.2)',
                    borderColor: '#22BAA0',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                title: {
                    display: false,
                    text: 'Estudiantes del 2do grado de primaria que logran el nivel satisfactorio en Lectura'
                },
                legend: {
                    display: false,
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
                            display: true,
                            labelString: 'Año'
                        }
                    }]
                },  
                tooltips: {
                    enabled: false,
                    mode: 'index',
                    intersect: true,
                    //position: 'average'
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
        @endforeach
        
    </script>

@endsection
