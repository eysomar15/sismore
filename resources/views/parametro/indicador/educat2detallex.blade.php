@extends('layouts.main',['titlePage'=>'DETALLE'])

@section('content')
    <div class="content">
        <!--div class="row">
            <div class="col-lg-12">
                <div class="card card-fill bg-success">
                    <div class="card-header bg-transparent">
                        <h3 class="card-title text-white">{{ $title }}</h3>
                    </div>
                </div>
            </div>
        </div-->
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
                            <h3 class="card-title">{{ $title }}
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
                        <h3 class="card-title text-primary">Porcentaje de estudiantes por nivel de logro de aprendizaje según UGEL {{$anio->anio}}
                            <div class="float-right">
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <button type="button" class="btn btn-info btn-xs waves-effect waves-light" onclick="abrirdetalle({{$key}},'{{$anio->anio}}')">Detalle</button>
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

    </div>


    @foreach ($anios as $key => $anio)
    <!--  Modal content for the above example -->
    <div id="modal_detalle_{{$key}}" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myLargeModalLabel">Porcentaje de estudiantes por nivel de logro de aprendizaje según UGEL {{$anio->anio}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <!--div class="row" id="vistaugel"></div-->
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-primary text-center">UGEL</th>
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
                                        @foreach ($anio->indicador as $ind)
                                        <tr>
                                            <td class="text-primary text-center">{{$ind->ugel}}</td>
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
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->    
    @endforeach

@endsection

@section('js')
    <script src="{{ asset('/') }}assets/libs/chart-js/Chart.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            satisfactorios();
            vistaindicador();
            //vistaindicador2();
            
        }); 
        function cargardistritos() {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('input[name=_token]').val()
                },
                url: "{{ url('/') }}/INDICADOR/Distritos/" + $('#provincia').val(),
                type: 'post',
                dataType: 'JSON',
                success: function(data) {
                    $("#distrito option").remove();
                    var options = '<option value="">TODOS</option>';
                    $.each(data.distritos, function(index, value) {
                        options += "<option value='" + value.id + "'>" + value.nombre + "</option>"
                    });
                    $("#distrito").append(options);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR);
                },
            });
        }
        function vistaindicador() {
            datos = $("#form_indicadores").serialize() + '&provincia=' + $('#provincia').val() + '&distrito=' + $('#distrito').val()+ '&gestion=' + $('#gestion').val()+ '&area=' + $('#area').val();
            console.log(datos);
            if (true) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('input[name=_token]').val()
                    },
                    url: "{{ route('ind.ajax.derivados') }}",
                    type: 'post',
                    data: datos,
                    beforeSend: function() {
                        $("#vistatabla").html('<br><h3>Cargando datos...</h3>');
                    },
                    success: function(data) {
                        //  console.log(data);
                        $("#vistatabla").html(data);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(jqXHR);
                    },
                });
            }
        }
        /*function vistaindicador2() {
            datos = $("#form_indicadores").serialize() + '&provincia=' + $('#provincia').val() + '&distrito=' + $('#distrito').val()+ '&gestion=' + $('#gestion').val()+ '&area=' + $('#area').val();
            console.log(datos);
            if (true) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('input[name=_token]').val()
                    },
                    url: "{{ route('ind.ajax.derivados2') }}",
                    type: 'post',
                    data: datos,
                    beforeSend: function() {
                        $("#vistatabla2").html('<br><h3>Cargando datos...</h3>');
                    },
                    success: function(data) {
                        //  console.log(data);
                        $("#vistatabla2").html(data);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(jqXHR);
                    },
                });
            }
        }*/
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
                        $("#vistaindicadores").html(data);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(jqXHR);
                    },
                });
            }
        }
        function abrirdetalle(pos,anio){
            $('input[name=aniox]').val(anio);
            $('#modal_detalle_'+pos).modal('show');
            //indicadorugel();
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
