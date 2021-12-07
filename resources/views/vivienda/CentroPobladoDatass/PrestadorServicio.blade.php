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
                        <div id="bar1" style="min-width:400px;height:300px;margin:0 auto;"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-border card-primary">
                    <div class="card-body">
                        <div id="bar2" style="min-width:400px;height:300px;margin:0 auto;"></div>
                    </div>
                </div>
            </div>
        </div>
        {{-- end row --}}

        <div class="row">
            <div class="col-md-6">
                <div class="card card-border card-primary">
                    <div class="card-body">
                        <div id="pie1" style="min-width:400px;height:300px;margin:0 auto;"></div>
                    </div>
                </div>
            </div> 
        </div>
        {{-- end row --}}
        
        {{-- <div class="row">
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
        </div> --}}
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
                url: "{{ route('centropobladodatass.prestadorservicio.info') }}",
                type: 'post',
                data: $('#form_opciones').serialize(),
                dataType: 'JSON',
                success: function(data) {
                    console.log(data);
                    barra01('bar1', data.dato.oc, '', 'ORGANIZACIONES COMUNALES', '');
                    barra01('bar2', data.dato.ta, '', 'TOTAL ASOCIADOS', '');
                    pie01('pie1', data.dato.cf, '', 'CUOTA FAMILIAR', '');
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
                            format: '{point.percentage:.1f}% ({point.y})',
                            connectorColor: 'silver'
                        }
                    }
                },
                series: [{
                    showInLegend: true,
                    //name: 'Share',                    
                    data: datos,
                }],
                credits: false,
            });
        }

        function barra01(div, datos, titulo, subtitulo, tituloserie) {
            //function graficar2(datax,titulo){
            Highcharts.chart(div, {
                chart: {
                    type: 'bar',
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
                    title: {
                        enabled: false,
                        text: 'Porcentaje',
                    }
                },
                series: [{
                    name: tituloserie, //'Distritos con servicio de agua potable',
                    colorByPoint: true,
                    data: datos,
                    showInLegend:tituloserie!=''
                }],
                tooltip: {
                    pointFormat: '{series.name} tiene: <b>{point.y}</b> centros poblados',
                },
                plotOptions: {
                    series: {
                        borderWidth: 0,
                        dataLabels: {
                            enabled: true,
                            format: '{point.y}',
                        },
                    }
                },
                credits: false,
            });
        }

        function cargardatatable1() {
            table_principal = $('#datatable1').DataTable({
                "ajax": "{{ url('/') }}/CentroPobladoDatass/Saneamiento/DT/" + $('#provincia').val() + "/" +
                    $('#distrito').val() + "/" + $('#fecha').val(),
                "columns": [{
                        data: 'item'
                    },
                    {
                        data: 'ubigeo'
                    },
                    {
                        data: 'centro_poblado'
                    },
                    {
                        data: 'poblaciontotal'
                    },
                    {
                        data: 'poblacionconagua'
                    },
                    {
                        data: 'poblacionconexcretas'
                    },
                    {
                        data: 'viviendashabitadasconagua'
                    },
                    {
                        data: 'viviendashabitadasconexcretas'
                    },
                ],
                "responsive": false,
                "autoWidth": true,
                "order": false,
                "destroy": true,
                "language": {
                    "lengthMenu": "Mostrar " +
                        `<select class="custom-select custom-select-sm form-control form-control-sm">
                        <option value = '10'> 10</option>
                        <option value = '25'> 25</option>
                        <option value = '50'> 50</option>
                        <option value = '100'>100</option>
                        <option value = '-1'>Todos</option>
                        </select>` + " registros por página",
                    "info": "Mostrando la página _PAGE_ de _PAGES_",
                    "infoEmpty": "No records available",
                    "infoFiltered": "(Filtrado de _MAX_ registros totales)",
                    "emptyTable": "No hay datos disponibles en la tabla.",
                    "info": "Del _START_ al _END_ de _TOTAL_ registros ",
                    "infoEmpty": "Mostrando 0 registros de un total de 0. registros",
                    "infoFiltered": "(filtrados de un total de _MAX_ )",
                    "infoPostFix": "",
                    "loadingRecords": "Cargando...",
                    "processing": "Procesando...",
                    "search": "Buscar:",
                    "searchPlaceholder": "Dato para buscar",
                    "zeroRecords": "No se han encontrado coincidencias.",
                    "paginate": {
                        "next": "siguiente",
                        "previous": "anterior"
                    }
                }
            });
        }
    </script>

@endsection
