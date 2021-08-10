@extends('layouts.main',['titlePage'=>'INDICADORES'])

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
        <form id="form_indicadores" action="#">
            @csrf
            <input type="hidden" name="grado" value="{{ $grado }}">
            <input type="hidden" name="aniox" value="">
            <input type="hidden" name="tipo" value="{{ $tipo }}">
            <input type="hidden" name="materia" value="{{ $materia }}">

            <div class="row">
                <div class="col-md-12">
                    <div class="card card-border">
                        <div class="card-header border-primary bg-transparent pb-0">
                            <h3 class="card-title">Resultados
                                <div class="float-right">
                                    <div class="form-group row">
                                        <label class="col-md-4 col-form-label">año</label>
                                        <div class="col-md-8">
                                            <select id="anio" name="anio" class="form-control" onchange="satisfactorios();">
                                                @foreach ($anios as $item)
                                                    <option value="{{ $item->anio }}">{{ $item->anio }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </h3>

                        </div>
                        <div class="card-body">
                            <div class="row" id="vistaindicadores">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form><!--End form-->
        <div class="row">
            @foreach ($anios as $key => $anio)
            <div class="col-xl-6">
                <div class="card card-border card-primary">
                    <div class="card-header border-primary bg-transparent pb-0">
                        <h3 class="card-title text-primary">Indicador del curso de {{$anio->anio}}
                            <div class="float-right">
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <button type="button" class="btn btn-info btn-xs waves-effect waves-light" onclick="abrirdetalle('{{$anio->anio}}')">Detalle</button-->
                                    </div>
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
        <div class="row">
            <div class="col-xl-12">
                <div class="card card-border card-primary">
                    <div class="card-header border-primary bg-transparent pb-0">
                        <h3 class="card-title text-primary">Resumen por UGEl</h3>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Provincia</label>
                            <div class="col-md-4">
                                <select id="provincia" name="provincia" class="form-control" onchange="cargardistritos();vistaindicador();">
                                    <option value="0">TODOS</option>
                                </select>
                            </div>
                        
                            <label class="col-md-2 col-form-label">Distrito</label>
                            <div class="col-md-4">
                                <select id="distrito" name="distrito" class="form-control" onchange="vistaindicador();">
                                    <option value="0">TODOS</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">

                    </div>
                </div>
            </div>    
        </div><!-- End row -->
        <div class="row">
        </div><!-- End row -->
    </div>


    <!--  Modal content for the above example -->
    <div id="modal_detalle" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myLargeModalLabel">{{$title}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div class="row" id="vistaugel"></div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->    

@endsection

@section('js')
    <script src="{{ asset('/') }}assets/libs/chart-js/Chart.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            satisfactorios();
            
        }); 
        
        function satisfactorios() {
            if (true) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('input[name=_token]').val()
                    },
                    url: "{{ route('ind.ajax.satisfactorio') }}",
                    type: 'post',
                    data: $("#form_indicadores").serialize(),
                    beforeSend: function() {
                        $("#vistaindicadores").html('<br><h3>Cargando datos...</h3>');
                    },
                    success: function(data) {
                        //console.log(data);
                        $("#vistaindicadores").html(data);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(jqXHR);
                    },
                });
            }
        }
        function abrirdetalle(anio){
            $('input[name=aniox]').val(anio);
            $('#modal_detalle').modal('show');
            indicadorugel();
        }
        function indicadorugel() {
            if (true) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('input[name=_token]').val()
                    },
                    url: "{{ route('ind.ajax.ugel') }}",
                    type: 'post',
                    data: $("#form_indicadores").serialize(),
                    beforeSend: function() {
                        $("#vistaugel").html('<br><h3>Cargando datos...</h3>');
                    },
                    success: function(data) {
                        //console.log(data);
                        $("#vistaugel").html(data);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(jqXHR);
                    },
                });
            }
        }
        @foreach ($anios as $pos1 => $anio)
        var myChart = new Chart($('#indicador{{$pos1}}'), {
            type: 'bar',
            data: {
                labels: [
                    @foreach ($anio->indicador as $item)
                    {!!'"'.$item->ugel.'",'!!}
                    @endforeach
                ],
                datasets: [{
                    label: 'PREVIO',
                    data: [
                        @foreach ($anio->indicador as $item)
                        {{ round(($item->previo  * 100) / $item->evaluados, 2) . ',' }}
                        @endforeach
                    ],
                    backgroundColor: '#7C7D7D', //'rgba(54, 162, 235, 0.2)',
                    borderColor: '#7C7D7D',
                    borderWidth: 1,
                },{
                    label: 'INICIO',
                    data: [
                        @foreach ($anio->indicador as $item)
                        {{ round(( $item->inicio * 100) / $item->evaluados, 2) . ',' }}
                        @endforeach
                    ],
                    backgroundColor: '#F25656', //'rgba(54, 162, 235, 0.2)',
                    borderColor: '#F25656',
                    borderWidth: 1,
                }, {
                    label: 'PROCESO',
                    data: [
                        @foreach ($anio->indicador as $item)
                        {{ round(($item->proceso * 100) / $item->evaluados, 2) . ',' }}
                        @endforeach
                    ],
                    backgroundColor: '#F2CA4C', //'rgba(54, 162, 235, 0.2)',
                    borderColor: '#F2CA4C',
                    borderWidth: 1
                }, {
                    label: 'SATISFACTORIO',
                    data: [
                        @foreach ($anio->indicador as $item)
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
                            labelString: 'UGEL'
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
