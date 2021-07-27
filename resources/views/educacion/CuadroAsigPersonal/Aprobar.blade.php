@extends('layouts.main',['activePage'=>'importacion','titlePage'=>'APROBAR IMPORTACION'])

@section('css')
    <!-- Table datatable css -->
    <link href="{{ asset('/') }}assets/libs/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
@endsection

@section('content') 
<div class="content">
    
    <div class="row">
        <div class="col-md-12">           
            <div class="card">
                
                <div class="card-header">
                    <h3 class="card-title">DATOS DE IMPORTACION </h3>                           
                </div>
                
                <div class="card-body">
                    <div class="form">
                
                    <form action="{{route('CuadroAsigPersonal.procesar',$importacion_id)}}" method="post" enctype='multipart/form-data'
                        class="cmxform form-horizontal tasi-form">                            
                        @csrf
                        @if(Session::has('message'))
                            <p>{{Session::get('message')}}</p>
                        @endif

                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Fuente de datos</label>
                            <div class="col-md-5">
                                <input type="text" class="form-control" readonly="readonly" value="{{$importacion->formato}} - {{$importacion->nombre}}">                                
                            </div>
                        
                            <label class="col-md-2 col-form-label">Fecha Versión</label>
                            <div class="col-md-3">
                                <input type="text" class="form-control" readonly="readonly" value="{{$importacion->fechaActualizacion}}">                              
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Usuario Creación</label>
                            <div class="col-md-5">
                                <input type="text" class="form-control" readonly="readonly" value="{{$importacion->usuario}}">                                
                            </div>
                       
                            <label class="col-md-2 col-form-label">Fecha Creación</label>
                            <div class="col-md-3">
                                <input type="text" class="form-control" readonly="readonly" value="{{$importacion->created_at}}">                           
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Comentario</label>
                            <div class="col-md-10">
                                <textarea class="form-control"  id="ccomment" readonly="readonly" name="comentario" >{{$importacion->comentario}}</textarea>                                                     
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="offset-lg-2 col-lg-10">
                                <button class="btn btn-success waves-effect waves-light mr-1" type="submit">Guardar</button>
                                <button class="btn btn-secondary waves-effect" id="btnEliminar" type="button" 
                                onClick="{{route('importacion.inicio')}}">Cancelar</button>
                            </div>
                        </div>
                      
                    </form>

                    </div>
                </div>               
                <!-- card-body -->
                
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="PadronWeb" class="table table-striped table-bordered" style="width:10500px">
                            <thead class="text-primary">                              
                               
                                <th style="width:80px">region</th>
                                <th style="width:180px">unidad_ejecutora</th>
                                <th style="width:100px">organo_intermedio</th>
                                <th style="width:100px">provincia</th>
                                <th style="width:100px">distrito</th>
                                <th style="width:200px">tipo_ie</th>
                                <th style="width:160px">gestion</th>
                                <th style="width:200px">zona</th>
                                <th style="width:80px">codmod_ie</th>
                                <th style="width:80px">codigo_local</th>
                                <th style="width:80px">clave8</th>
                                <th style="width:80px">nivel_educativo</th>
                                <th style="width:200px">institucion_educativa</th>
                                <th style="width:80px">codigo_plaza</th>
                                <th style="width:80px">tipo_trabajador</th>
                                <th style="width:280px">sub_tipo_trabajador</th>
                                <th style="width:300px">cargo</th>
                                <th style="width:80px">situacion_laboral</th>
                                <th style="width:480px">motivo_vacante</th>
                                <th style="width:80px">documento_identidad</th>
                                <th style="width:80px">codigo_modular</th>
                                <th style="width:80px">apellido_paterno</th>
                                <th style="width:80px">apellido_materno</th>
                                <th style="width:160px">nombres</th>
                                <th style="width:80px">fecha_ingreso</th>
                                <th style="width:80px">categoria_remunerativa</th>
                                <th style="width:80px">jornada_laboral</th>
                                <th style="width:260px">estado</th>
                                <th style="width:80px">fecha_nacimiento</th>
                                <th style="width:80px">fecha_inicio</th>
                                <th style="width:80px">fecha_termino</th>
                                <th style="width:80px">tipo_registro</th>
                                <th style="width:80px">ley</th>
                                <th style="width:80px">preventiva</th>
                                <th style="width:80px">referencia_preventiva</th>
                                <th style="width:80px">especialidad</th>
                                <th style="width:160px">tipo_estudios</th>
                                <th style="width:80px">estado_estudios</th>
                                <th style="width:80px">grado</th>
                                <th style="width:460px">mencion</th>
                                <th style="width:300px">especialidad_profesional</th>
                                <th style="width:80px">fecha_resolucion</th>
                                <th style="width:80px">numero_resolucion</th>
                                <th style="width:300px">centro_estudios</th>
                                <th style="width:80px">celular</th>
                                <th style="width:80px">email</th>
                            </thead>
                         
                        </table>
                    </div>
                    
                </div>
                <!-- card-body -->
            </div>
              
        </div> <!-- End col -->
    </div> <!-- End row -->
  
</div>
@endsection 


@section('js')
  
    <script src="{{ asset('/') }}assets/libs/datatables/jquery.dataTables.min.js"></script>
    <script src="{{ asset('/') }}assets/libs/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="{{ asset('/') }}assets/libs/datatables/dataTables.responsive.min.js"></script>
    <script src="{{ asset('/') }}assets/libs/datatables/responsive.bootstrap4.min.js"></script>

    <script>
        $('#PadronWeb').DataTable({
            "ajax": "{{route('CuadroAsigPersonal.ListaImportada_DataTable',$importacion_id)}}",
            "columns":[             
                {data:'region'},{data:'unidad_ejecutora'},{data:'organo_intermedio'},{data:'provincia'},
                {data:'distrito'},{data:'tipo_ie'},{data:'gestion'},{data:'zona'},{data:'codmod_ie'},
                {data:'codigo_local'},{data:'clave8'},{data:'nivel_educativo'},{data:'institucion_educativa'},
                {data:'codigo_plaza'},{data:'tipo_trabajador'},{data:'sub_tipo_trabajador'},{data:'cargo'},
                {data:'situacion_laboral'},{data:'motivo_vacante'},{data:'documento_identidad'},{data:'codigo_modular'},
                {data:'apellido_paterno'},{data:'apellido_materno'},{data:'nombres'},{data:'fecha_ingreso'},
                {data:'categoria_remunerativa'},{data:'jornada_laboral'},{data:'estado'},{data:'fecha_nacimiento'},
                {data:'fecha_inicio'},{data:'fecha_termino'},{data:'tipo_registro'},{data:'ley'},{data:'preventiva'},
                {data:'referencia_preventiva'},{data:'especialidad'},{data:'tipo_estudios'},{data:'estado_estudios'},
                {data:'grado'},{data:'mencion'},{data:'especialidad_profesional'},{data:'fecha_resolucion'},
                {data:'numero_resolucion'},{data:'centro_estudios'},{data:'celular'},{data:'email'},                
            ],
            // responsive:true,
            autoWidth:true,
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
        }

        );
    </script>
@endsection