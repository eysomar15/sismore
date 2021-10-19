@extends('layouts.main',['activePage'=>'importacion','titlePage'=>'APROBAR IMPORTACION DE DATOS'])

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
@endsection

@section('content') 
<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">Relacion de Importaciones </h4>                            
                        </div>                      
                        
                        <div class="card-body">                                
                            <div class="table-responsive">
                                <table id="importaciones" class="table table-striped table-bordered" style="width:100%">
                                    <thead class="cabecera-dataTable">                                    
                                        <th>Codigo</th>
                                        <th>Fuente</th>
                                        <th>Formato</th>
                                        <th>Usuario crea</th>
                                        <th>Usuario aprueba</th>
                                        <th>Fecha version</th>
                                        <th>Estado</th> 
                                        <th>Aciones</th>
                                    </thead>
                                </table>
                            </div>                                
                        </div>
                    </div>
                </div>
            </div> <!-- End row -->
        </div>
    </div> <!-- End row -->
    
</div> 
  
<!-- Modal  Eliminar -->
<div class="modal fade" id="confirmModalEliminar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Confirmación</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                ¿Desea eliminar el registro seleccionado?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" id="btnEliminar" name="btnEliminar" class="btn btn-danger">Confirmar</button>
            </div>
        </div>
    </div>
</div>  <!-- Fin Modal  Eliminar -->

@endsection 

@section('js')
    {{-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> --}}
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    
    {{-- DATA TABLE --}}
    <script>
   
        $('#importaciones').DataTable({
            "ajax": "{{route('importacion.importacionesLista_DataTable')}}",
            "columns":[
                {data:'id'},
                {data:'nombre'},
                {data:'formato'}, 
                {data:'usuario'},    
                {data:'aprueba'},                 
                {data:'fechaActualizacion'},
                {data:'estado'}, 
                // {data:'comentario'},
                {data:'action', orderable : false}            
            ],
            responsive:true,
            autoWidth:false,
            order:false,
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

    {{-- ELIMINAR --}}
    <script>
        var id;
        //.delete nombre con el que se le llamo en el controlador al boton eliminar
        $(document).on('click','.delete',function(){
            id = $(this).attr('id');
            $('#confirmModalEliminar').modal('show');
        });

        $('#btnEliminar').click(function(){
            $.ajax({
                url:"Importacion/Eliminar/"+id,
                beforeSend:function(){
                    // $('#btnEliminar').text('Eliminando....');
                },
                success:function(data){
                    setTimeout(function(){
                        $('#confirmModalEliminar').modal('hide');
                        toastr.success('El registro fue eliminado correctamente','Mensaje',{timeOut:3000});                       
                        $('#importaciones').DataTable().ajax.reload();
                    },100);//02 segundos
                    // $('#btnEliminar').text('Confirmar');
                }
            });
        });
    </script>
@endsection