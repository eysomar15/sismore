@extends('layouts.main',['titlePage'=>'DETALLE'])

@section('content')
    <div class="content">
        <form id="form_indicadores" action="#">
            @csrf
            <input type="hidden" name="grado" id ="grado" value="{{ $grado }}">
            <input type="hidden" name="aniox" id="aniox" value="">
            <input type="hidden" name="tipo" id="tipo" value="{{ $tipo }}">
            <input type="hidden" name="materia" id="materia" value="{{ $mt->id }}">

            <div class="row">
                <div class="col-md-12">
                    <div class="card card-border">
                        <div class="card-header border-primary bg-transparent pb-0">
                            <h3 class="card-title">{{ $title }}
                                <div class="float-right">
                                    <div class="form-group row">
                                        <label class="col-md-4 col-form-label">año</label>
                                        <div class="col-md-8">
                                            <select id="anio" name="anio" class="form-control" onchange="satisfactorios();vistaindicador();cambiarfechas();cargardatatable1();">
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
            <div class="col-xl-12">
                <div class="card card-border card-primary">
                    <div class="card-header border-primary bg-transparent pb-0">
                        <h3 class="card-title text-primary">Porcentaje de Estudiantes según Nivel de Logro Alcanzado a nivel regional en la Materia {{$mt->descripcion}} en el año <span id="anio1"></span>
                        </h3>
                        
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Provincia</label>
                            <div class="col-md-4">
                                <select id="provincia" name="provincia" class="form-control" onchange="cargardistritos(); vistaindicador();">
                                    <option value="0">TODOS</option>
                                    @foreach ($provincias as $ges)
                                    <option value="{{$ges->id}}">{{$ges->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <label class="col-md-2 col-form-label">Distrito</label>
                            <div class="col-md-4">
                                <select id="distrito" name="distrito" class="form-control" onchange="vistaindicador();">
                                    <option value="0">TODOS</option>
                                </select>
                            </div>
                        </div>
                        <div class="row" id="vistatabla">
                        </div>
                    </div>
                </div>
            </div>    
        </div><!-- End row -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card card-border card-primary">
                    <div class="card-header border-primary bg-transparent pb-0">
                        <h3 class="card-title text-primary">Resumen general por gestion y area en el año <span id="anio2"></span></h3>
                    </div> 
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Gestion</label>
                            <div class="col-md-4">
                                <select id="gestion" name="gestion" class="form-control" onchange="cargardatatable1();">
                                    <option value="0">TODOS</option>
                                    @foreach ($gestions as $ges)
                                    <option value="{{$ges->id}}">{{$ges->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <label class="col-md-2 col-form-label">Area</label>
                            <div class="col-md-4">
                                <select id="area" name="area" class="form-control" onchange="cargardatatable1();">
                                    <option value="0">TODOS</option>
                                    @foreach ($areas as $area)
                                    <option value="{{$area->id}}">{{$area->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="table-responsive">
                                    <table id="datatable1" class="table table-striped table-bordered" style="width:100%">
                                        <thead class="cabecera-dataTable">                                    
                                            <th class="text-primary">IIEE</th>
                                            <th class="text-secondary text-center">CANTIDAD</th>
                                            <th class="text-secondary text-center">PREVIO</th>
                                            <th class="text-danger text-center">CANTIDAD</th>
                                            <th class="text-danger text-center">INICIO</th>
                                            <th class="text-warning text-center">CANTIDAD</th>
                                            <th class="text-warning text-center">PROCESO</th>
                                            <th class="text-success text-center">CANTIDAD</th>
                                            <th class="text-success text-center">SATISFACTORIO</th>
                                        </thead>
                                    </table>
                                </div>   
                            </div>                           
                        </div>
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
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script>
        $(document).ready(function() {
            satisfactorios();
            vistaindicador();
            cambiarfechas();
            cargardatatable1();
        }); 
        function cambiarfechas(){
            $('#anio1').html($('#anio').val());
            $('#anio2').html($('#anio').val());
        }
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
            datos = $("#form_indicadores").serialize() + '&provincia=' + $('#provincia').val() + '&distrito=' + $('#distrito').val();
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
        function vistaindicador2() {
            datos = $("#form_indicadores").serialize() + '&gestion=' + $('#gestion').val()+ '&area=' + $('#area').val();
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
        }
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
        function abrirdetalle(anio){
            $('input[name=aniox]').val(anio);
            $('#modal_detalle').modal('show');
            indicadorugel();
        }
        function cargardatatable1(){
            $('#datatable1').DataTable({
                "ajax": "{{url('/')}}/INDICADOR/Derivados2x/" + $('#anio').val()+ "/" + $('#grado').val()+"/" + 
                $('#tipo').val()+"/" + $('#materia').val()+"/" + $('#gestion').val()+ "/" + $('#area').val(),
                "columns":[
                    {data:'nombre'},
                    {data:'previo'},
                    {data:'p1'},
                    {data:'inicio'}, 
                    {data:'p2'},
                    {data:'proceso'},  
                    {data:'p3'},
                    {data:'satisfactorio'},
                    {data:'p4'},    
                ],
                "responsive":true,
                "autoWidth":false,
                "order":false,
                "destroy":true,
                "language": {
                    "lengthMenu": "Mostrar "+
                    `<select class="custom-select custom-select-sm form-control form-control-sm">
                        <option value = '10'> 10</option>
                        <option value = '25'> 25</option>
                        <option value = '50'> 50</option>
                        <option value = '100'>100</option>
                        <option value = '-1'>Todos</option>
                        </select>` + " registros por página",          
                    "info": "Mostrando la página _PAGE_ de _PAGES_" ,
                    "infoEmpty": "No records available",
                    "infoFiltered": "(Filtrado de _MAX_ registros totales)",  
                    "emptyTable":			"No hay datos disponibles en la tabla.",
                    "info":		   			"Del _START_ al _END_ de _TOTAL_ registros ",
                    "infoEmpty":			"Mostrando 0 registros de un total de 0. registros",
                    "infoFiltered":			"(filtrados de un total de _MAX_ )",
                    "infoPostFix":			"",           
                    "loadingRecords":		"Cargando...",
                    "processing":			"Procesando...",
                    "search":				"Buscar:",
                    "searchPlaceholder":	"Dato para buscar",
                    "zeroRecords":			"No se han encontrado coincidencias.",            
                    "paginate":{
                        "next":"siguiente",
                        "previous":"anterior"
                        }
                    }
            }); 
        }
       /* function indicadorugel() {
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
        }*/
    </script>

@endsection
