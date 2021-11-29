@extends('layouts.main',['activePage'=>'importacion','titlePage'=>''])

@section('css')
    <script src="{{ asset('/') }}assets/libs/highcharts/highcharts.js"></script>
    <script src="{{ asset('/') }}assets/libs/highcharts/highcharts-more.js"></script>
    <script src="{{ asset('/') }}assets/libs/highcharts/solid-gauge.js"></script>
@endsection

@section('content')
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <!--div class="card-header">
                            <h3 class="card-title">Default Buttons</h3>
                        </div-->
                    <div class="card-body">
                        <form id="form_opciones" name="form_opciones" action="POST">
                            @csrf
                            <div class="form-group row">
                                <label class="col-md-1 col-form-label">Fecha</label>
                                <div class="col-md-3">
                                    <select id="fecha" name="fecha" class="form-control" onchange="historial();">
                                        @foreach ($ingresos as $item)
                                            <option value="{{ $item->id }}">
                                                {{ date('d-m-Y', strtotime($item->fechaActualizacion)) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <label class="col-md-1 col-form-label">Provincia</label>
                                <div class="col-md-3">
                                    <select id="provincia" name="provincia" class="form-control"
                                        onchange="cargardistritos();historial();">
                                        <option value="0">TODOS</option>
                                        @foreach ($provincias as $prov)
                                            <option value="{{ $prov->id }}">{{ $prov->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <label class="col-md-1 col-form-label">Distrito</label>
                                <div class="col-md-3">
                                    <select id="distrito" name="distrito" class="form-control" onchange="historial();">
                                        <option value="0">TODOS</option>
                                    </select>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->
        <div class="row">
            <div class="col-md-6">
                <div class="card card-border card-primary">
                    <div class="card-body">
                        <div id="pie1" style="min-width:400px;height:300px;margin:0 auto;"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-border card-primary">
                    <div class="card-body">
                        <div id="pie2" style="min-width:400px;height:300px;margin:0 auto;"></div>
                    </div>
                </div>
            </div>
        </div>
        {{-- end row --}}
        <div class="row">
            <div class="col-md-6">
                <div class="card card-border card-primary">
                    <div class="card-body">
                        <div id="pie3" style="min-width:400px;height:300px;margin:0 auto;"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-border card-primary">
                    <div class="card-body">
                        <div id="pie4" style="min-width:400px;height:300px;margin:0 auto;"></div>
                    </div>
                </div>
            </div>
        </div>
        {{-- end row --}}        

    </div>


@endsection

@section('js')
    <!-- flot chart -->
    <script src="{{ asset('/') }}assets/libs/highcharts/highcharts.js"></script>
    <script src="{{ asset('/') }}assets/libs/highcharts-modules/exporting.js"></script>
    <script src="{{ asset('/') }}assets/libs/highcharts-modules/export-data.js"></script>
    <script src="{{ asset('/') }}assets/libs/highcharts-modules/accessibility.js"></script>
    <script>
        $(document).ready(function() {
            Highcharts.setOptions({
                colors: Highcharts.map(Highcharts.getOptions().colors, function(color) {
                    return {
                        radialGradient: {
                            cx: 0.5,
                            cy: 0.3,
                            r: 0.7
                        },
                        stops: [
                            [0, color],
                            [1, Highcharts.color(color).brighten(-0.3).get('rgb')] // darken
                        ]
                    };
                })
            });
            historial();

        });

        function cargardistritos() {
            $('#distrito').val('0');
            $.ajax({
                /* headers: {
                    'X-CSRF-TOKEN': $('input[name=_token]').val()
                }, */
                url: "{{ url('/') }}/CentroPobladoDatass/Distritos/" + $('#provincia').val(),
                /* type: 'post', */
                dataType: 'JSON',
                success: function(data) {
                    $("#distrito option").remove();
                    var options = '<option value="0">TODOS</option>';
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

        function historial() {
            $.ajax({
                url: "{{ route('centropobladodatass.saneamiento.info') }}",
                type: 'post',
                data: $('#form_opciones').serialize(),
                dataType: 'JSON',
                success: function(data) {
                    console.log(data);
                    pie01('pie1',data.dato.psa,'','Poblacion con Servicio de Agua','');
                    pie01('pie2',data.dato.pde,'','Poblacion con Disposicion de Excretas','');
                    pie01('pie3',data.dato.vsa,'','viviendas con Servicio de Agua','');
                    pie01('pie4',data.dato.vde,'','viviendas con Disposicion de Excretas','');
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR);
                },
            });
        }

        function pie01(div, datos, titulo, subtitulo, tituloserie) {
            Highcharts.chart(div, {
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'pie'
                },
                title: {
                    text: titulo, //'Browser market shares in January, 2018'
                },
                subtitle: {
                    text: subtitulo,
                },
                tooltip: {
                    //pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>',
                    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>',
                },
                accessibility: {
                    point: {
                        valueSuffix: '%'
                    }
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            //format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                            format: '{point.percentage:.1f}% ({point.conteo})',
                            connectorColor: 'silver'
                        }
                    }
                },
                series: [{
                    showInLegend:true,
                    //name: 'Share',                    
                    data: datos,
                }],
                credits: false,
            });
        }
    </script>

@endsection
