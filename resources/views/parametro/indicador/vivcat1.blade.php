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
             
        {{--<div class="col-xl-6">
            <div class="card card-border card-primary">
                <div class="card-header border-primary bg-transparent pb-0">
                    <h3 class="card-title text-primary">mi grafica xxx</h3>
                </div>
                <div class="card-body">
                    <canvas id="myChart1" height="300" width="500"></canvas>
                    <canvas id="myChart2" height="300" width="500"></canvas>
                </div>
            </div>
        </div>--}}
    </div><!-- End row -->    
@endsection

@section('js')

    <!-- flot chart -->
    <!--script src="{{ asset('/') }}assets/libs/flot-charts/jquery.flot.js"></script-->
    <script src="{{ asset('/') }}assets/libs/chart-js/Chart.bundle.min.js"></script>
    <!--script src="{{ asset('/') }}assets/chartjs/chart.js"></script-->
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
        } 
        //console.log(myChart1.type);
        /*var myChart = new Chart($('#prueba'), {
        type: "bar",
        data: {
        labels: ["ONE", "TWO", "THREE", "FOUR", "FIVE", "SIX", "SEVEN", "EIGHT"],
        datasets: [{
            label: "Quota Eni mensile",
            backgroundColor: [
                "rgba(255, 255, 153, 1)",
                "rgba(255, 255, 153, 1)",
                "rgba(255, 255, 153, 1)",
                "rgba(255, 255, 153, 1)",
                "rgba(255, 255, 153, 1)",
                "rgba(255, 255, 153, 1)",
                "rgba(255, 255, 153, 1)",
                "rgba(255, 255, 153, 1)"
            ],
            borderColor: [
                "rgba(255, 255, 153, 1)",
                "rgba(255, 255, 153, 1)",
                "rgba(255, 255, 153, 1)",
                "rgba(255, 255, 153, 1)",
                "rgba(255, 255, 153, 1)",
                "rgba(255, 255, 153, 1)",
                "rgba(255, 255, 153, 1)",
                "rgba(255, 255, 153, 1)"
            ],
            borderWidth: 1,
            data: [10, 11, 18, 10, 13, 28, 12, 16]
        }
        ]
        },
        options: {
            legend: {
                display: false
            },
            scales: {
                xAxes: [{
                    ticks:{
                        maxRotation: 90,
                        minRotation: 90,
                        display: "top"
                    },          
                }],
                yAxes: [{
                    display: false
                }]
            },
            tooltips: {
                enabled: true
            },
            maintainAspectRatio: true,
            responsive: true
        }
        });*/
        /*var miPrueba=new Chart($('#prueba1'),{
            type:'doughnut',
            data:{
                labels:['SI','NO'],
                datasets:[{
                    data:[40,60],
                    backgroundColor:['rgba(225,99,132,0.2)','rgba(54, 162, 235, 0.2)'],
                }]
            },
            options:{
                responsive:true,
                //events:['click'],
                tooltips:{
                    mode:'index'
                },
                
            },
        });*/
        /*new Chart(document.getElementById("prueba"),{
            "type":"line",
            "data":{
                "labels":["January","February","March","April","May","June","July"],
                "datasets":[{
                    "label":"My First Dataset",
                    "data":[65,59,80,81,56,55,40],
                    "fill":false,
                    "borderColor":"rgb(75, 192, 192)",
                    "lineTension":0.1}]
                },
            "options":{}
        });*/
        /*var speedData = {
        labels: ["0s", "10s", "20s", "30s", "40s", "50s", "60s"],
        datasets: [{
            label: "Car Speed",
            data: [0, 59, 75, 20, 20, 55, 40],
        }]
        };
        
        var chartOptions = {
            maintainAspectRatio: false,
                    
                    scales: {
                        xAxes: [{                            
                            stacked: true // this should be set to make the bars stacked
                        }],
                        yAxes: [{
                            stacked: true ,// this also..
                             ticks:{mirror:true}
                        }]
                    },
                    legend: {
                        position: 'bottom',
                        padding: 5,
                        labels:
                        {
                            pointStyle: 'circle',
                            usePointStyle: true
                        }
                    },
                    title: {
                        display: true,
                        text: 'Custom Chart Title'
                    },

 
        };
            var lineChart = new Chart($('#prueba'), {
                type: 'line',
                data: speedData,
                options: chartOptions
            });*/
        /*var myChart = new Chart(document.getElementById("prueba"), {
                        type: 'line',
                    data: {
                                    labels: ["January", "February", "March", "April", "May", "June"],
                                    datasets: [{
                                        label: "Variables - Rojo",
                                        backgroundColor: 'red',
                                        borderColor: 'red',
                                     data: [65, 59, 80, 81, 56, 55],
                                    //    data: datos,
                                        fill: false,
                                    }, {
                                        label: "Fijos - Azul",
                                        fill: false,
                                        backgroundColor: 'blue',
                                        borderColor: 'blue',
                                        data: [12, 10, 4, 11, 3, 9],
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    title:{
                                        display:true,
                                        text:'Chart.js Line Chart'
                                    },
                                    tooltips: {
                                        mode: 'index',
                                        intersect: false,
                                    },
                                    hover: {
                                        mode: 'nearest',
                                        intersect: true
                                    },
                                    scales: {
                                        xAxes: [{
                                            display: true,
                                            scaleLabel: {
                                                display: true,
                                                labelString: 'Month'
                                            }
                                        }],
                                        yAxes: [{
                                            display: true,
                                            scaleLabel: {
                                                display: true,
                                                labelString: 'Value'
                                            }
                                        }]
                                    }
                            }
                    });*/
    </script>

@endsection
