@extends('layouts.main',['titlePage'=>'INDICADOR'])

@section('content')
    <!--div class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-fill bg-success">
                    <div class="card-header bg-transparent">
                        <h3 class="card-title text-white">{{$title}}</h3>
                    </div>
                </div>
            </div>
        </div>
       
    </div-->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <!--div class="card-header">
                    <h3 class="card-title">Default Buttons</h3>
                </div-->
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-md-1 col-form-label">Provincia</label>
                        <div class="col-md-3">
                            <select id="provincia" name="provincia" class="form-control" onchange="cargardistritos();cargarhistorial();">
                                <option value="0">TODOS</option>
                                @foreach ($provincias as $prov)
                                <option value="{{$prov->id}}">{{$prov->nombre}}</option>
                                @endforeach
                            </select>
                        </div>
                        <label class="col-md-1 col-form-label">Distrito</label>
                        <div class="col-md-3">
                            <select id="distrito" name="distrito" class="form-control" onchange="cargarhistorial();">
                                <option value="0">TODOS</option>
                            </select>
                        </div>
                        <label class="col-md-1 col-form-label">Fecha</label>
                        <div class="col-md-3">
                            <select id="fecha" name="fecha" class="form-control" onchange="cargarhistorial();">
                                @foreach ($ingresos as $item)
                                <option value="{{$item->id}}">{{date('d-m-Y',strtotime($item->fechaActualizacion))}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="button-list text-center">
                        <button type="button" class="btn btn-primary">Centros Poblados<br><span id="v1"></span></button>
                        <button type="button" class="btn btn-primary">Poblacion Total<br><span id="v2"></span></button>
                        <button type="button" class="btn btn-primary">Total Viviendas<br><span id="v3"></span></button>
                        <button type="button" class="btn btn-primary">centro Salud<br><span id="v4"></span></button>
                        <button type="button" class="btn btn-primary">Energia Electrica<br><span id="v5"></span></button>
                        <button type="button" class="btn btn-primary">Internet<br><span id="v6"></span></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->
    <div class="row">
        <div class="col-md-6">
            <div class="card card-border">
                <div class="card-header bg-transparent pb-0">
                    <h3 class="card-title">{{$title}}</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table mb-0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Cantidad</th>
                                            <th>Porcentaje</th>
                                        </tr>
                                    </thead>
                                    <tbody id='vistax1'>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>                    
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-border card-primary">
                <div class="card-body">
                    <div id="con1" style="min-width:400px;height:300px;margin:0 auto;" ></div>
                </div>
            </div>
        </div>
        
    </div><!-- End row -->    
@endsection

@section('js')

    <!-- flot chart -->
    <script src="{{ asset('/') }}assets/libs/highcharts/highcharts.js"></script>
    <script src="{{ asset('/') }}assets/libs/highcharts-modules/exporting.js"></script>
    <script src="{{ asset('/') }}assets/libs/highcharts-modules/export-data.js"></script>
    <script src="{{ asset('/') }}assets/libs/highcharts-modules/accessibility.js"></script>
    <script src="{{ asset('/') }}assets/libs/chart-js/Chart.bundle.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            cargarhistorial();
            
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
        function cargarhistorial() {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('input[name=_token]').val()
                },
                url: "{{ url('/') }}/INDICADOR/PNSR1/" + $('#provincia').val()+"/"+$('#distrito').val()+"/{{$indicador_id}}/"+$('#fecha').val(),
                type: 'post',
                dataType: 'JSON',
                success: function(data) {
                    $('#v1').html(data.centros_poblados);
                    $('#v2').html(data.poblacion_total);
                    $('#v3').html(data.total_viviendas);
                    $('#v4').html(data.centro_salud);
                    $('#v5').html(data.energia_electrica);
                    $('#v6').html(data.internet);
                    vista='';
                    total=0;
                    data.indicador.forEach(element => {total+=element.y});
                    data.indicador.forEach(element => {
                        por=element.y*100/total;
                        vista+='<tr><td>'+element.name+'</td><td>'+element.y+'</td><td>'+por.toFixed(2)+'</td></tr>';
                    });
                    vista+='<tr><th>Total</th><th>'+total+'</th><th>100</th></tr>';
                    $('#vistax1').html(vista);
                    grafica1(data.indicador);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR);
                },
            });
        }        
        function grafica1(datos){
            Highcharts.chart('con1',{
                chart:{
                    type:'pie',
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                },
                title:{
                    text:''
                },
                tooltip:{
                    pointFormat:'<b>{series.name}:</b>{point.y}',
                },
                plotOptions:{
                    pie:{
                        allowPointSelect:true,
                        cursor:'pointer',
                        dataLabels:{
                            enabled:true,
                            format:'<b>{point.name}: {point.percentage:.2f}%</b>'
                        },
                    }
                },
                series:[{
                    name:'Cantidad',
                    colorByPoint:true,
                    data:datos,
                }],
                credits:false,

            });
        } 
    </script>

@endsection
