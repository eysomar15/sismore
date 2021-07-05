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
                
                    <form action="{{route('PadronWeb.procesar',$importacion_id)}}" method="post" enctype='multipart/form-data'
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
                                <input type="text" class="form-control" readonly="readonly" value="{{$importacion->name}}">                                
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
                                <button class="btn btn-secondary waves-effect" type="button">Cancelar</button>
                            </div>
                        </div>
                        
                        {{-- <div class="card-body">
                            
                            <div class="row">
                                <label for="name" class="col-sm-2 col-form-label"> Fuente de datos</label>
                                <div class="col-sm-7">
                                    <label for="name" class="form-control">{{$importacion->formato}} - {{$importacion->nombre}}</label>                                          
                                </div>                                   
                            </div>  
                            
                            <div class="row">
                                <label for="name" class="col-sm-2 col-form-label"> Fecha Versión </label>
                                <div class="col-sm-7">                                            
                                    <label for="name" class="form-control"> {{$importacion->fechaActualizacion}}  </label>
                                </div>
                            </div>
            
                            <div class="row">
                                <label for="name" class="col-sm-2 col-form-label"> Comentario </label>
                                <div class="col-sm-7">
                                    <label for="name" class="form-control"> {{$importacion->comentario}} </label>                                            
                                </div>
                            </div>

                            <div class="row">
                                <label for="name" class="col-sm-2 col-form-label"> Usuario Creación </label>
                                <div class="col-sm-7">                                            
                                    <label for="name" class="form-control"> {{$importacion->name}}  </label>
                                </div>
                            </div>
            
                            <div class="row">
                                <label for="name" class="col-sm-2 col-form-label"> Fecha Creación</label>
                                <div class="col-sm-7">
                                    <label for="name" class="form-control"> {{$importacion->created_at}} </label>                                            
                                </div>
                            </div>
            
                            <div class="card-footer ml-auto mr-auto">
                                <button type="submit" class="btn btn-success">Guardar</button>
                                
                            </div>                    
                        </div>                            --}}
                    </form>

                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="PadronWeb" class="table table-striped table-bordered" style="width:7200px">
                            <thead class="text-primary">                                       
                                
                                <th style="width:100px">CodModular</th>
                                <th style="width:80px">Anexo</th>
                                <th style="width:100px">CodLocal</th>
                                <th style="width:300px">Nombre</th>
                                <th style="width:60px">CodNivel</th>
                                <th style="width:240px">Nivel</th>
                                <th style="width:80px">Forma</th>
                                <th style="width:80px">cod_Car</th>
                                <th style="width:160px">d_Cod_Car</th>
                                <th style="width:80px">TipsSexo</th>
                                <th style="width:80px">d_TipsSexo</th>
                                <th style="width:80px">gestion</th>
                                <th style="width:200px">d_Gestion</th>
                                <th style="width:80px">ges_Dep</th>
                                <th style="width:200px">d_Ges_Dep</th>                                            
                                <th style="width:360px">director</th>
                                <th style="width:80px">telefono</th>
                                <th style="width:100px">email</th>
                                <th style="width:80px">pagWeb</th>
                                <th style="width:400px">dir_Cen</th>
                                <th style="width:380px">referencia</th>
                                <th style="width:180px">localidad</th>
                                <th style="width:80px">codcp_Inei</th>
                                <th style="width:80px">codccpp</th>
                                <th style="width:280px">cen_Pob</th>
                                <th style="width:80px">area_Censo</th>
                                <th style="width:80px">d_areaCenso</th>
                                <th style="width:80px">codGeo</th>
                                <th style="width:180px">d_Dpto</th>
                                <th style="width:180px">d_Prov</th>
                                <th style="width:180px">d_Dist</th>
                                <th style="width:120px">d_Region</th>
                                <th style="width:80px">codOOII</th>
                                <th style="width:220px">d_DreUgel</th>
                                <th style="width:80px">tipoProg</th>
                                <th style="width:140px">d_TipoProg</th>
                                <th style="width:80px">cod_Tur</th>
                                <th style="width:180px">D_Cod_Tur</th>
                                <th style="width:80px">estado</th>
                                <th style="width:80px">d_Estado</th>
                                <th style="width:180px">fecha_Act</th>                                          
                                
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
            "ajax": "{{route('PadronWeb.ListaImportada_DataTable',$importacion_id)}}",
            "columns":[             
                {data:'cod_Mod'},{data:'anexo'},{data:'cod_Local'},{data:'cen_Edu'},{data:'niv_Mod'},
                {data:'d_Niv_Mod'},{data:'d_Forma'},{data:'cod_Car'},{data:'d_Cod_Car'},{data:'TipsSexo'},
                {data:'d_TipsSexo'},{data:'gestion'},{data:'d_Gestion'},{data:'ges_Dep'},{data:'d_Ges_Dep'},
                {data:'director'},{data:'telefono'},{data:'email'},{data:'pagWeb'},{data:'dir_Cen'},
                {data:'referencia'},{data:'localidad'},{data:'codcp_Inei'},{data:'codccpp'},{data:'cen_Pob'},
                {data:'area_Censo'},{data:'d_areaCenso'},{data:'codGeo'},{data:'d_Dpto'},{data:'d_Prov'},
                {data:'d_Dist'},{data:'d_Region'},{data:'codOOII'},{data:'d_DreUgel'},{data:'tipoProg'},
                {data:'d_TipoProg'},{data:'cod_Tur'},{data:'D_Cod_Tur'},{data:'estado'},{data:'d_Estado'},
                {data:'fecha_Act'},                
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