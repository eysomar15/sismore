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
                        <label class="col-md-2 col-form-label">Provincia</label>
                        <div class="col-md-4">
                            <select id="provincia" name="provincia" class="form-control" onchange="cargardistritos();cargarhistorial();">
                                <option value="0">TODOS</option>
                                @foreach ($provincias as $prov)
                                <option value="{{$prov->id}}">{{$prov->nombre}}</option>
                                @endforeach
                            </select>
                        </div>
                        <label class="col-md-2 col-form-label">Distrito</label>
                        <div class="col-md-4">
                            <select id="distrito" name="distrito" class="form-control" onchange="cargarhistorial();">
                                <option value="0">TODOS</option>
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
        <div class="col-xl-6">
            <div class="card card-border card-primary">
                <div class="card-header border-primary bg-transparent pb-0">
                    <h3 class="card-title text-primary">{{$title}}
                        <!--div class="float-right">
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <button type="button" class="btn btn-primary btn-xs" onclick=" ">Ver detalle</button>
                                </div>
                            </div>
                        </div-->
                    </h3>
                </div>
                <!--div class="card-body">
                    <canvas id="indicador" data-type="Bar" height="150" ></canvas>
                </div-->
                <div class="card-body">
                    <canvas id="xxx" data-type="Bar" height="150" ></canvas>
                </div>
            </div>
        </div>
             
        <div class="col-xl-6">
            <div class="card card-border card-primary">
                <!--div class="card-header border-primary bg-transparent pb-0">
                    <h3 class="card-title text-primary">mi grafica xxx</h3>
                </div-->
                <div class="card-body">
                    <div id="con1" style="min-width:320px;height:300px;margin:0 auto;" ></div>
                    <!--div id="con1" style="min-width:320px;height:400px;margin:0 auto;"></div-->
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
                url: "{{ url('/') }}/INDICADOR/PNSR1/" + $('#provincia').val()+"/"+$('#distrito').val()+"/{{$indicador_id}}",
                type: 'post',
                dataType: 'JSON',
                success: function(data) {
                    $('#v1').html(data.centros_poblados);
                    $('#v2').html(data.poblacion_total);
                    $('#v3').html(data.total_viviendas);
                    $('#v4').html(data.centro_salud);
                    $('#v5').html(data.energia_electrica);
                    $('#v6').html(data.internet);
                    labelx=[];
                    datax=[];
                    data.indicador.forEach((element,i) => {
                        labelx[i]=element.opcion;
                        datax[i]=element.conteo;
                    });
                    console.log(datax)
                    grafica1(labelx,datax);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR);
                },
            });
        }        
        function grafica1(labelsx,datasx){
            var myChart1 = new Chart($('#xxx'), {
            type: 'doughnut',
            data: {
                labels:labelsx,
                datasets: [{
                    data: datasx,
                    backgroundColor:['red','blue'] ,//'rgba(54, 162, 235, 0.2)',//'#1097EE',
                    //borderColor:'rgba(54, 162, 235, 0.2)',// '#1097EE',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                title: {
                    display: false,
                    text: 'Sin titulo'
                },
                legend: {
                    display: true,
                    position: 'bottom',
                },
                tooltips: {
                    enabled: true,
                    mode: 'index',
                    intersect: true,
                    position: 'average'
                },
                
            }
        });
        /*Highcharts.chart('con1',{
            chart:{
                type:'pie'
            },
            title:{
                text:'{{$title}}'
            },
            series:[{
                name:'indicador',
                data:[{
                    name:labelsx[0],
                    y:datasx[0],
                },{
                    name:labelsx[1],
                    y:datasx[1],
                }]
            }],

        });*/
        } 
    </script>

@endsection
