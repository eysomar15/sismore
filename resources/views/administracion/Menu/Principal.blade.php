@extends('layouts.main',['activePage'=>'usuarios','titlePage'=>'GESTION DE MENU'])

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
@endsection

@section('content')
    <div class="content">

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">FILTRO</h3>
                    </div>
                    <div class="card-body">
                        <div class="form">
                            <form>
                                <input type="hidden" name="fuenteImportacion" value="3">
                                <div class="col-lg-12">
                                    <div class="form-group row">
                                        <label class="col-md-2 col-form-label">SISTEMAS</label>
                                        <div class="col-md-4">
                                            <select class="form-control" name="sistema" id="sistema"
                                                onchange="listarDT();">
                                                <!--option value="0">Seleccionar</option-->
                                                @foreach ($sistemas as $item)
                                                    <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <!--label class="col-md-2 col-form-label">Alumno EIB</label>
                                        <div class="col-md-4">
                                            <select class="form-control" name="tipo" id="tipo" required>
                                                <option value="0">NO</option>
                                                <option value="1">SI</option>
                                            </select>
                                        </div-->
                                    </div>

                                </div>
                            </form>
                        </div>
                        <!-- .form -->
                    </div>
                    <!-- card-body -->
                </div>
                <!-- card -->
            </div>
            <!-- col -->
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            {{-- <div class="card-header card-header-primary">
                            <h4 class="card-title">Relacion de Usuarios </h4>                            
                        </div> --}}

                            <div class="card-body">
                                <div>
                                    {{-- <a href="{{route('Usuario.registrar')}}" class="btn btn-primary"> Nuevo </a> --}}
                                    <button type="button" class="btn btn-primary" onclick="add()"><i
                                            class="fa fa-plus"></i> Nuevo</button>
                                </div>
                                <div class="table-responsive">
                                    <br>
                                    <table id="dtPrincipal" class="table table-striped table-bordered" style="width:100%">
                                        <thead class="cabecera-dataTable">
                                            <!--th>Nº</th-->
                                            <th>Menu</th>
                                            <th>Url</th>
                                            <th>Icon</th>
                                            <th>Parametro</th>
                                            <th>Posicion</th>
                                            <th>Grupo</th>
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
    <div class="modal fade" id="confirmModalEliminar" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
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
    </div> <!-- Fin Modal  Eliminar -->

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
                        <input type="hidden" class="form-control" id="id" name="id">
                        <div class="form-body">
                            <div class="form-group">
                                <label>Sistema<span class="required">*</span></label>
                                <select class="form-control" name="sistema_id" id="sistema_id" onchange="cargarGrupo();">
                                    <option value="">Seleccionar</option>
                                    @foreach ($sistemas as $item)
                                        <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                                    @endforeach
                                </select>
                                <span class="help-block"></span>
                            </div>
                            <div class="form-group">
                                <label>Grupo<span class="required">*</span></label>
                                <select class="form-control" name="dependencia" id="dependencia" onchange="">
                                    <option value="">Seleccionar</option>
                                </select>
                                <span class="help-block"></span>
                            </div>
                            <div class="form-group">
                                <label>Menu<span class="required">*</span></label>
                                <input id="nombre" name="nombre" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                            <div class="form-group">
                                <label>Url<span class="required">*</span></label>
                                <input id="url" name="url" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                            <div class="form-group">
                                <label>Icon<span class="required">*</span></label>
                                <input id="icon" name="icon" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                            <div class="form-group">
                                <label>Parametro<span class="required">*</span></label>
                                <input id="parametro" name="parametro" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                            <div class="form-group">
                                <label>Posicion<span class="required">*</span></label>
                                <input id="posicion" name="posicion" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Guardar</button>
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


    {{-- DATA TABLE --}}
    <script>
        $(document).ready(function() {
            var save_method = '';
            listarDT();
            $("input").change(function() {
                $(this).parent().parent().removeClass('has-error');
                $(this).next().empty();
            });
            $("textarea").change(function() {
                $(this).parent().parent().removeClass('has-error');
                $(this).next().empty();
            });
            $("select").change(function() {
                $(this).parent().parent().removeClass('has-error');
                $(this).next().empty();
            });
        });

        function add() {
            save_method = 'add';
            $('#form')[0].reset();
            $('.form-group').removeClass('has-error');
            $('.help-block').empty();
            $('#modal_form').modal('show');
            $('.modal-title').text('Crear Nuevo Menu');
        };

        function cargarGrupo() {
            $.ajax({
                url: "{{ url('/') }}/Menu/cargarGrupo/" + $('#sistema_id').val(),
                type: 'get',
                success: function(data) {
                    console.log(data)
                    $("#dependencia option").remove();
                    var options = '<option value="">SELECCIONAR</option>';
                    $.each(data.grupo, function(index, value) {
                        options += "<option value='" + value.id + "'>" + value.nombre + "</option>"
                    });
                    $("#dependencia").append(options);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR);
                },
            });
        }

        function save() {
            $('#btnSave').text('guardando...');
            $('#btnSave').attr('disabled', true);
            var url;
            if (save_method == 'add') {
                url = "{{ url('/') }}/Menu/ajax_add";
                msgsuccess = "El registro fue creado exitosamente.";
                msgerror = "El registro no se pudo crear verifique las validaciones.";
            } else {
                url = "{{ url('/') }}/Menu/ajax_update";
                msgsuccess = "El registro fue actualizado exitosamente.";
                msgerror = "El registro no se pudo actualizar. Verifique la operación";
            }
            $.ajax({
                url: url,
                type: "POST",
                data: $('#form').serialize(),
                dataType: "JSON",
                success: function(data) {
                    console.log(data)
                    if (data.status) {
                        $('#modal_form').modal('hide');
                        listarDT();
                        toastr.success(msgsuccess, 'Mensaje');
                    } else {
                        for (var i = 0; i < data.inputerror.length; i++) {
                            $('[name="' + data.inputerror[i] + '"]').parent().parent().addClass('has-error');
                            $('[name="' + data.inputerror[i] + '"]').next().text(data.error_string[i]);
                        }
                    }
                    $('#btnSave').text('Guardar');
                    $('#btnSave').attr('disabled', false);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    toastr.error(msgerror, 'Mensaje');
                    $('#btnSave').text('Guardar');
                    $('#btnSave').attr('disabled', false);
                }
            });
        };

        function edit(id) {
            save_method = 'update';
            $('#form')[0].reset();
            $('.form-group').removeClass('has-error');
            $('.help-block').empty();
            $.ajax({
                url: "{{ url('/') }}/Menu/ajax_edit/" + id,
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    $('[name="id"]').val(data.menu.id);
                    $('[name="sistema_id"]').val(data.menu.sistema_id);
                    $('[name="nombre"]').val(data.menu.nombre);
                    $('[name="url"]').val(data.menu.url);
                    $('[name="icon"]').val(data.menu.icono);
                    $('[name="parametro"]').val(data.menu.parametro);
                    $('[name="posicion"]').val(data.menu.posicion);
                    $.ajax({
                        url: "{{ url('/') }}/Menu/cargarGrupo/" + data.menu.sistema_id,
                        type: 'get',
                        success: function(data2) {
                            $("#dependencia option").remove();
                            var options = '<option value="">SELECCIONAR</option>';
                            $.each(data2.grupo, function(index, value) {
                                options += "<option value='" + value.id + "'>" + value
                                    .nombre + "</option>"
                            });
                            $("#dependencia").append(options);
                            $('[name="dependencia"]').val(data.menu.dependencia);

                            $('#modal_form').modal('show');
                            $('.modal-title').text('Modificar Menu');
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.log(jqXHR);
                        },
                    });

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error get data from ajax');
                }
            });
        };

        function borrar(id) {
            bootbox.confirm("Seguro desea Eliminar este registro?", function(result) {
                if (result === true) {
                    $.ajax({
                        url: "{{ url('/') }}/Menu/ajax_delete/" + id,
                        type: "GET",
                        dataType: "JSON",
                        success: function(data) {
                            $('#modal_form').modal('hide');
                            listarDT();
                            toastr.success('El registro fue eliminado exitosamente.', 'Mensaje');
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            toastr.error(
                                'No se puede eliminar este registro por seguridad de su base de datos, Contacte al Administrador del Sistema',
                                'Mensaje');
                        }
                    });
                }
            });
        };


        function listarDT() {
            $('#dtPrincipal').DataTable({
                "ajax": "{{ url('/') }}/Menu/listarDT/" + $('#sistema').val(),
                "columns": [{
                        data: 'nombre'
                    },
                    {
                        data: 'url'
                    },
                    {
                        data: 'icono'
                    },
                    {
                        data: 'parametro'
                    },
                    {
                        data: 'posicion'
                    },
                    {
                        data: 'grupo'
                    },
                    {
                        data: 'action',
                        orderable: false
                    }
                ],
                responsive: true,
                autoWidth: false,
                order: false,
                destroy: true,
                language: {
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

    {{-- ELIMINAR --}}
    <script>
        var id;
        //.delete nombre con el que se le llamo en el controlador al boton eliminar
        $(document).on('click', '.delete', function() {
            id = $(this).attr('id');
            $('#confirmModalEliminar').modal('show');
        });

        $('#btnEliminar').click(function() {
            $.ajax({
                // url:"Usuario/Eliminar/"+id,
                url: "{{ url('/') }}/Usuario/Eliminar/" + id,
                beforeSend: function() {
                    // $('#btnEliminar').text('Eliminando....');
                },
                success: function(data) {
                    setTimeout(function() {
                        $('#confirmModalEliminar').modal('hide');
                        toastr.success('El registro fue eliminado correctamente', 'Mensaje', {
                            timeOut: 3000
                        });
                        $('#dtPrincipal').DataTable().ajax.reload();
                    }, 100); //02 segundos                   
                }
            });
        });
    </script>
@endsection