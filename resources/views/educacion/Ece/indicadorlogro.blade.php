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
            @foreach ($info1 as $key => $item)
            <div class="col-xl-6">
                <div class="card card-border card-primary">
                    <div class="card-header border-primary bg-transparent pb-0">
                        <h3 class="card-title text-primary">RESULTADO general de {{$item->descripcion}}</h3>
                    </div>
                    <div class="card-body">
                        <canvas id="indicador{{$key}}" data-type="Bar" height="200"></canvas>
                    </div>
                </div>
            </div>    
            @endforeach
            
        </div><!-- End row -->
        <form id="form_indicadores" action="#">
            @csrf
            <input type="hidden" name="grado" value="{{ $grado }}">
            <input type="hidden" name="tipo" value="{{ $tipo }}">

            <div class="row">
                <div class="col-md-12">
                    <div class="card card-border">
                        <div class="card-header border-primary bg-transparent pb-0">
                            <h3 class="card-title">Resultados
                                <div class="float-right">
                                    <select id="anio" name="anio" class="form-control form-control-sm"
                                        onchange="satisfactorios();indicadormaterias();">
                                        @foreach ($anios as $item)
                                            <option value="{{ $item->anio }}">{{ $item->anio }}</option>
                                        @endforeach
                                    </select>
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
        </form>
        <!-- End row -->
        <div class="row">
            <div class="col-md-12">
                <div class="card card-border">
                    <div class="card-header border-default bg-transparent pb-0">
                        <h3 class="card-title">Resultados por años</h3>
                    </div>
                    <div class="card-body">
                        <div class="row" id="vistaindcurso">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- End row -->
        <div class="row">
            <div class="col-md-12">
                <div class="card card-border">
                    <div class="card-header border-default bg-transparent pb-0">
                        <h3 class="card-title">Resultados por ugel</h3>
                    </div>
                    <div class="card-body">
                        <div class="row" id="vistaugel">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- End row -->
        <div class="row">
            <div class="col-md-12">
                <div class="card card-border">
                    <div class="card-header border-default bg-transparent pb-0">
                        <h3 class="card-title">Resultados por Provincia</h3>
                    </div>
                    <div class="card-body">
                        <div class="row" id="vistaprovincia">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End row -->
        <div class="row">
            <div class="col-md-12">
                <div class="card card-border">
                    <div class="card-header border-default bg-transparent pb-0">
                        <h3 class="card-title">Resultados
                            <div class="float-right">
                                <select id="provincia" name="provincia" class="form-control form-control-sm"
                                    onchange="cargardistritos();vistaindicador();">
                                    <option value="0">TODOS</option>
                                    @foreach ($provincias as $prov)
                                        <option value="{{ $prov->id }}">{!! $prov->nombre !!}</option>
                                    @endforeach
                                </select>
                                <select id="distrito" name="distrito" class="form-control form-control-sm"
                                    onchange="vistaindicador();">
                                    <option value="0">TODOS</option>
                                </select>
                            </div>
                        </h3>

                    </div>
                    <div class="card-body">
                        <div class="row" id="vistatabla">
                        </div>
                    </div>
                    <!-- End card-body -->
                </div>
                <!-- End card -->

            </div>
            <!-- end col -->

        </div>

    </div>

@endsection

@section('js')
    <script src="{{ asset('/') }}assets/libs/jquery-validation/jquery.validate.min.js"></script>
    <!-- Validation init js-->
    <script src="{{ asset('/') }}assets/js/pages/form-validation.init.js"></script>
    <script src="{{ asset('/') }}assets/libs/chart-js/Chart.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            satisfactorios();
            indicadormaterias();
            indicadorugel();
            indicadorprovincia();
            vistaindicador();
        });

        function vistaindicador() {
            datos = $("#form_indicadores").serialize() + '&provincia=' + $('#provincia').val() + '&distrito=' + $(
                '#distrito').val();
            console.log(datos);
            if (true) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('input[name=_token]').val()
                    },
                    url: "{{ route('ece.indicador.derivados') }}",
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

        function cargardistritos() {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('input[name=_token]').val()
                },
                url: "{{ url('/') }}/ECE/IndicadorDistritos/" + $('#provincia').val(),
                type: 'post',
                dataType: 'JSON',
                success: function(data) {
                    //console.log(data);
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

        function satisfactorios() {
            if (true) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('input[name=_token]').val()
                    },
                    url: "{{ route('ece.indicador.satisfactorio') }}",
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

        function indicadormaterias() {
            if (true) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('input[name=_token]').val()
                    },
                    url: "{{ route('ece.indicador.materia') }}",
                    type: 'post',
                    data: $("#form_indicadores").serialize(),
                    beforeSend: function() {
                        $("#vistaindcurso").html('<br><h3>Cargando datos...</h3>');
                    },
                    success: function(data) {
                        //console.log(data);
                        $("#vistaindcurso").html(data);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(jqXHR);
                    },
                });
            }
        }

        function indicadorugel() {
            if (true) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('input[name=_token]').val()
                    },
                    url: "{{ route('ece.indicador.ugel') }}",
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

        function indicadorprovincia() {
            if (true) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('input[name=_token]').val()
                    },
                    url: "{{ route('ece.indicador.provincia') }}",
                    type: 'post',
                    data: $("#form_indicadores").serialize(),
                    beforeSend: function() {
                        $("#vistaprovincia").html('<br><h3>Cargando datos...</h3>');
                    },
                    success: function(data) {
                        //console.log(data);
                        $("#vistaprovincia").html(data);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(jqXHR);
                    },
                });
            }
        }
        
        @foreach ($info1 as $pos1 => $materia)
        var myChart = new Chart($('#indicador{{$pos1}}'), {
            type: 'bar',
            data: {
                labels: [
                    @foreach ($materia->indicador as $item)
                    {!!'"'.$item->anio.'",'!!}
                    @endforeach
                ],
                datasets: [{
                    label: 'INICIO',
                    data: [
                        @foreach ($materia->indicador as $item)
                        {{ round((($item->previo+$item->inicio) * 100) / $item->evaluados, 2) . ',' }}
                        @endforeach
                    ],
                    backgroundColor: '#F25656', //'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }, {
                    label: 'PROCESO',
                    data: [
                        @foreach ($materia->indicador as $item)
                        {{ round(($item->proceso * 100) / $item->evaluados, 2) . ',' }}
                        @endforeach
                    ],
                    backgroundColor: '#F2CA4C', //'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }, {
                    label: 'SATISFACTORIO',
                    data: [
                        @foreach ($materia->indicador as $item)
                        {{ round(($item->satisfactorio * 100) / $item->evaluados, 2) . ',' }}
                        @endforeach
                    ],
                    backgroundColor: '#22BAA0', // 'rgba(54, 162, 235, 0.2)',
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
                    enabled: true,
                    mode: 'index',
                    intersect: true,
                    //position: 'average'
                },
                plugins: [{
                    afterDatasetsDraw: function(chart, easing) {
                        var ctx = chart.ctx;
                        chart.data.datasets.forEach(function(dataset, i) {
                            var meta = chart.getDatasetMeta(i);
                            if (!meta.hidden) {
                                meta.data.forEach(function(element, index) {
                                    ctx.fillStyle = 'rgb(255, 255, 255)';
                                    var fontSize = 11;
                                    var fontStyle = 'normal';
                                    var fontFamily = 'sans-serif';
                                    ctx.font = Chart.helpers.fontString(fontSize,
                                        fontStyle, fontFamily);
                                    var dataString = dataset.data[index].toString() +
                                        "%";
                                    ctx.textAlign = 'center';
                                    ctx.textBaseline = 'middle';
                                    var padding = 15;
                                    var position = element.tooltipPosition();
                                    ctx.fillText(dataString, position.x, position.y - (
                                        fontSize / 2) + padding);
                                });
                            }
                        });
                    }
                }]
            }
        });
        @endforeach

    </script>

@endsection
