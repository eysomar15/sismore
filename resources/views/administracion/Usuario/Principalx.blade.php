@extends('layouts.main',['activePage'=>'usuarios','titlePage'=>'GESTIONAR USUARIOS'])

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
                        {{-- <div class="card-header card-header-primary">
                            <h4 class="card-title">Relacion de Usuarios </h4>                            
                        </div>
                        --}}
                        
                        <div class="card-body"> 
                            <div>
                                <a href="{{route('Usuario.registrar')}}" class="btn btn-primary"> Nuevo </a>
                            </div>                        

                            @if(session('success'))                           
                                <br>    
                                <div class="card-header bg-success" role="success">
                                    <h3 class="card-title text-white">{{session('success')}}</h3>
                                </div>
                            @endif                        
                                                  
                            <div class="table-responsive">
                                <br>
                                <table id="dtPrincipal" class="table table-striped table-bordered" style="width:100%">
                                    <thead class="cabecera-dataTable">  
                                        <th>Codigo</th>                                  
                                        <th>Usuario</th>   
                                        <th>Email</th>                                       
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

<!-- Bootstrap modal -->
<div id="modal_form" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" id="form" class="form-horizontal" autocomplete="off">
                        @csrf
                        <input type="hidden" class="form-control" id="usuario_id" name="usuario_id">
                        <div class="form-body">
                            <div class="form-group">
                                <label>Sistema<span class="required">*</span></label>
                                <select class="form-control" name="sistema_id" id="sistema_id" onchange="cargarPerfil();">
                                    <option value="">Seleccionar</option>
                                    @foreach ($sistemas as $item)
                                        <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                                    @endforeach
                                </select>
                                <span class="help-block"></span>
                            </div>
                            <div class="form-group">
                                <label>Perfiles<span class="required">*</span></label>
                                <ul class="" id="perfiles"></ul><!--list-unstyled-->
                                <span class="help-block"></span>
                            </div>
                            
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btnSavePerfil" onclick="savePerfil()" class="btn btn-primary">Guardar</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->

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
   
        $('#dtPrincipal').DataTable({
            "ajax": "{{route('Usuario.Lista_DataTable')}}",
            "columns":[
                {data:'id'},
                {data:'usuario'},                
                {data:'email'},
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

        function perfil(id) {
            $('#form')[0].reset();
            $('.form-group').removeClass('has-error');
            $('.help-block').empty();
            $('#modal_form').modal('show');
            $('.modal-title').text('Seleccionar Perfil');
            $('#usuario_id').val(id);
            $("#perfiles li").remove();
        };

        function cargarPerfil() {
            $.ajax({
                url: "{{ url('/') }}/Usuario/CargarPerfil/" + $('#sistema_id').val()+"/"+$('#usuario_id').val(),
                type: 'get',
                success: function(data) {
                    $("#perfiles li").remove();
                    var options = "<li><div class='radio radio-primary'><input id='perfilx' name='perfil' type='radio' checked> <label for='perfilx'>NINGUNO</label></div></li>";
                    $.each(data.perfil, function(index, value) {
                        activo='';
                        $.each(data.usuarioperfil,function(index2,value2){
                            if(value2.perfil_id==value.id) activo='checked';
                        });                        
                        options += "<li><div class='radio radio-primary'><input id='perfil"+index+"' name='perfil' type='radio' value='"+value.id+"' "+activo+">"+
                                    " <label for='perfil"+index+"'>"+value.nombre+"</label></div></li>";
                        //options += "<li><label><input id='perfil' name='perfil[]' type='checkbox' value='"+value.id+"' "+activo+"> "+value.nombre+"</label></li>";
                    });
                    
                    $("#perfiles").append(options);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR);
                },
            });
        }     
        function savePerfil() {
            $('#btnSavePerfil').text('guardando...'); 
            $('#btnSavePerfil').attr('disabled', true); 
            $.ajax({
            url: "{{ url('/') }}/Usuario/ajax_add_perfil",
            type: "POST",
            data: $('#form').serialize(),
            dataType: "JSON",
            success: function(data) {
                console.log(data)
                if (data.status) {
                    $('#modal_form').modal('hide');
                    toastr.success('El registro fue creado exitosamente.', 'Mensaje');
                } else {
                    for (var i = 0; i < data.inputerror.length; i++) {
                        $('[name="' + data.inputerror[i] + '"]').parent().parent().addClass('has-error'); 
                        $('[name="' + data.inputerror[i] + '"]').next().text(data.error_string[i]); 
                    }
                }
                $('#btnSavePerfil').text('Guardar');  
                $('#btnSavePerfil').attr('disabled', false); 
            },
            error: function(jqXHR, textStatus, errorThrown) {
                toastr.error('El registro no se pudo crear verifique las validaciones.', 'Mensaje');
                $('#btnSavePerfil').text('Guardar'); 
                $('#btnSavePerfil').attr('disabled', false);  
            }
            });
        };           

        $('#btnEliminar').click(function(){
            $.ajax({
                // url:"Usuario/Eliminar/"+id,
                url: "{{ url('/') }}/Usuario/Eliminar/" + id,
                beforeSend:function(){
                    // $('#btnEliminar').text('Eliminando....');
                },
                success:function(data){
                    setTimeout(function(){
                        $('#confirmModalEliminar').modal('hide');
                        toastr.success('El registro fue eliminado correctamente','Mensaje',{timeOut:3000});                       
                        $('#dtPrincipal').DataTable().ajax.reload();
                    },100);//02 segundos                   
                }
            });
        });
    </script>
@endsection