@extends('layouts.main',['activePage'=>'usuarios','titlePage'=>'GESTION DE MENU'])

@section('css')


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap4.min.css">

    <!-- Plugins css -->
    {{-- <link href="{{ asset('/') }}assets/libs/select2/select2.min.css" rel="stylesheet" type="text/css" /> --}}


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
                        </div> --}}

                            <div class="card-body">
                                <div>
                                    {{-- <a href="{{route('Usuario.registrar')}}" class="btn btn-primary"> Nuevo </a> --}}
                                    <button type="button" class="btn btn-primary" onclick="add()"><i class="fa fa-plus"></i> Nuevo</button>
                                </div>
                                <div class="table-responsive">
                                    <br>
                                    <table id="dtPrincipal" class="table table-striped table-bordered" style="width:100%">
                                        <thead class="cabecera-dataTable">
                                            <!--th>Nº</th-->
                                            <th>DNI</th>
                                            <th>Usuario</th>
                                            <th>Nombre</th>
                                            <th>Sistema Asignado</th>
                                            <th>Email</th>
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

    <!-- Bootstrap modal -->
    <div id="modal_form" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="form_title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" id="form" class="form-horizontal" autocomplete="off">
                        @csrf
                        <input type="hidden" id="id" name="id">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Datos Personales</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="form">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label>DNI<span class="required">*</span></label>
                                                        <input id="dni" name="dni" class="form-control" type="text" maxlength="8">
                                                        <span class="help-block"></span>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label>Nombre<span class="required">*</span></label>
                                                        <input id="nombre" name="nombre" class="form-control" type="text" onkeyup="this.value=this.value.toUpperCase()">
                                                        <span class="help-block"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label>Apellido<span class="required">*</span></label>
                                                        <input id="apellidos" name="apellidos" class="form-control" type="text" onkeyup="this.value=this.value.toUpperCase()">
                                                        <span class="help-block"></span>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label>Sexo<span class="required">*</span></label>
                                                        <select id="sexo" name="sexo" class="form-control">
                                                            <option value="M">MASCULINO</option>
                                                            <option value="F">FEMENINO</option>
                                                        </select>
                                                        <span class="help-block"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label>Correo Electronico<span class="required">*</span></label>
                                                        <input id="email" name="email" class="form-control" type="email" required>
                                                        <span class="help-block"></span>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label>Celular<span class="required">*</span></label>
                                                        <input id="celular" name="celular" class="form-control" type="text">
                                                        <span class="help-block"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label>Entidad<span class="required">*</span></label>
                                                        <select id="entidad" name="entidad" class="form-control">
                                                            <option value="">SELECCIONAR</option>
                                                        </select>
                                                        <span class="help-block"></span>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label>Oficina<span class="required">*</span></label>
                                                        <input type="text" id="oficina" name="oficina" class="form-control">
                                                        <span class="help-block"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label>Cargo<span class="required">*</span></label>
                                                        <input type="text" id="cargo" name="cargo" class="form-control">
                                                        <span class="help-block"></span>
                                                    </div>

                                                </div>
                                            </div>
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
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Acceso</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="form">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label>Usuario<span class="required">*</span></label>
                                                        <input id="usuario" name="usuario" class="form-control" type="text">
                                                        <span class="help-block"></span>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label>Password<span class="required">*</span></label>
                                                        <input id="password" name="password" class="form-control" type="password">
                                                        <span class="help-block"></span>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label>Confirmar Password<span class="required">*</span></label>
                                                        <input id="password2" name="password2" class="form-control" type="password">
                                                        <span class="help-block"></span>
                                                    </div>
                                                </div>
                                            </div>
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
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Sistemas disponibles</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="form">
                                            <div class="form-group" id="form-group-sistemas">                                                
                                                <label>Seleccionar sistema<span class="required">*</span></label>
                                                <div class="row">
                                                    @foreach ($sistemas as $item)
                                                        <div class="col-md-3">
                                                            <input type="checkbox" id="checkbox{{ $item->id }}"
                                                                name="sistemas[]" {{ $item->elegido }}
                                                                value="{{ $item->id }}">
                                                            {{ $item->nombre }}
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <span class="help-block" id="help-block-sistemas"></span>
                                            </div>

                                        </div>
                                        <!-- .form -->
                                    </div>
                                    <!-- card-body -->
                                </div>
                                <!-- card -->
                            </div>
                            <!-- col -->
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

    <!-- Bootstrap modal -->
    <div id="modal_perfil" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Seleccionar Perfil</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" id="form_perfil" class="form-horizontal" autocomplete="off">
                        @csrf
                        <input type="hidden" class="form-control" id="usuario_id" name="usuario_id">
                        <div class="form-body">
                            <div class="form-group">
                                <label>Sistema<span class="required">*</span></label>
                                <select class="form-control" name="sistema_id" id="sistema_id" onchange="cargarPerfil();">
                                    <option value="">Seleccionar</option>
                                    @foreach ($sistemas2 as $item)
                                        <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                                    @endforeach
                                </select>
                                <span class="help-block"></span>
                            </div>
                            <div class="form-group">
                                <label>Perfiles<span class="required">*</span></label>
                                <ul class="" id="perfiles"></ul>
                                <!--list-unstyled-->
                                <span class="help-block"></span>
                            </div>

                        </div>
                    </form>
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table id="dtperfil" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <!--th>#</th-->
                                            <th>Sistema</th>
                                            <th>Perfil Asignado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btnSavePerfil" onclick="savePerfil()" class="btn btn-primary">Guardar</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!-- End Bootstrap modal -->

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

@endsection

@section('js')
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap4.min.js"></script>
    <script>
         var id;
                //.delete nombre con el que se le llamo en el controlador al boton eliminar
                $(document).on('click', '.delete', function() {
                    id = $(this).attr('id');
                    $('#confirmModalEliminar').modal('show');
                });

        $(document).ready(function() {
            var save_method = '';
            var tabla_perfil;
            var tabla_principal;

            //add();
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
            tablaPrincipal();
            
        });
        function tablaPrincipal(){
            tabla_principal = $('#dtPrincipal').DataTable({
                "ajax": "{{ route('Usuario.Lista_DataTable') }}",
                "columns": [{
                    data: 'dni'
                }, {
                    data: 'usuario'
                }, {
                    data: 'nombrecompleto'
                }, {
                    data: 'sistemas'
                }, {
                    data: 'email'
                }, {
                    data: 'estado'
                }, {
                    data: 'action',
                    orderable: false
                }],
                responsive: true,
                /* autoWidth: false, */
                order: false,
                //destroy: true,
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
        function reload_table() {
            tabla_principal.ajax.reload(null, false);
        }

        function listarDTperfiles(usuario_id) {
            tabla_perfil = $('#dtperfil').DataTable({
                "ajax": "{{ url('/') }}/Usuario/DTSistemasAsignados/" + usuario_id,
                "columns": [{
                    data: 'sistema'
                }, {
                    data: 'perfil'
                }, ],
                responsive: true,
                searching: false,
                paging: false,
                info: false,
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

        function reload_table_perfil() {
            tabla_perfil.ajax.reload(null, false);
        }

        function add() {
            save_method = 'add';
            $('#form')[0].reset();
            $('.form-group').removeClass('has-error');
            $('.help-block').empty();
            $('#modal_form').modal('show');
            $('.modal-title').text('Nuevo Usuario');
            $('#id').val('');
        }

        function addunidadejecutora() {
            $('#form_unidadejecutora')[0].reset();
            $('#modal_unidadejecutora').modal('show');
        }



        function save() {
            $('#btnSave').text('guardando...');
            $('#btnSave').attr('disabled', true);
            var url;
            if (save_method == 'add') {
                url = "{{ url('/') }}/Usuario/ajax_add";
                msgsuccess = "El registro fue creado exitosamente.";
                msgerror = "El registro no se pudo crear verifique las validaciones.";
            } else {
                url = "{{ url('/') }}/Usuario/ajax_update";
                msgsuccess = "El registro fue actualizado exitosamente.";
                msgerror = "El registro no se pudo actualizar. Verifique la operación";
            }
            $.ajax({
                url: url,
                type: "POST",
                data: $('#form').serialize(),
                dataType: "JSON",
                success: function(data) {
                    console.log(data);
                    if (data.status) {                        
                        $('#modal_form').modal('hide');
                        reload_table();
                        toastr.success(msgsuccess, 'Mensaje');
                    } else {
                        for (var i = 0; i < data.inputerror.length; i++) {
                            $('[name="' + data.inputerror[i] + '"]').parent().parent().addClass('has-error');
                            $('[name="' + data.inputerror[i] + '"]').next().text(data.error_string[i]);
                            if (data.inputerror[i] == "sistemas") {
                                $("#form-group-sistemas").addClass('has-error');
                                $("#help-block-sistemas").text(data.error_string[i]);
                            }
                        }
                    }
                    $('#btnSave').text('Guardar');
                    $('#btnSave').attr('disabled', false);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    $('#btnSave').text('Guardar');
                    $('#btnSave').attr('disabled', false);
                    toastr.error(msgerror, 'Mensaje');
                }
            });
        }

        function edit(id) {
            save_method = 'update';
            $('#form')[0].reset();
            $('.form-group').removeClass('has-error');
            $('.help-block').empty();
            $.ajax({
                url: "{{ url('/') }}/Usuario/ajax_edit/" + id,
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    $('[name="id"]').val(data.usuario.id);
                    $('[name="dni"]').val(data.usuario.dni);
                    $('[name="nombre"]').val(data.usuario.nombre);
                    $('[name="apellidos"]').val(data.usuario.apellidos);
                    $('[name="sexo"]').val(data.usuario.sexo);
                    $('[name="email"]').val(data.usuario.email);
                    $('[name="celular"]').val(data.usuario.celular);
                    $('[name="usuario"]').val(data.usuario.usuario);
                    data.sistemas.forEach(item => {
                        $('#checkbox' + item.sistema_id).prop("checked", true);
                    });
                    $('#modal_form').modal('show');
                    $('.modal-title').text('Modificar Usuario');
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    toastr.error('Error get data from ajax', 'Mensaje');
                }
            });
        }

        function borrar(id) {
            bootbox.confirm("Seguro desea Eliminar este registro?", function(result) {
                if (result === true) {
                    $.ajax({
                        url: "{{ url('/') }}/Usuario/ajax_delete/" + id,
                        type: "GET",
                        dataType: "JSON",
                        success: function(data) {
                            reload_table();
                            toastr.success('El registro fue eliminado exitosamente.', 'Mensaje');
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            alert('No se puede eliminar este registro por seguridad de su base de datos, Contacte al Administrador del Usuario')
                            toastr.error(
                                'No se puede eliminar este registro por seguridad de su base de datos, Contacte al Administrador del Usuario',
                                'Mensaje');
                        }
                    });
                }
            });
        }


        function perfil(id) {
            $('#form_perfil')[0].reset();
            $('.form-group').removeClass('has-error');
            $('.help-block').empty();
            $('#modal_perfil').modal('show');
            //$('.modal-title').text('Seleccionar Perfil');
            $('#usuario_id').val(id);
            $("#perfiles li").remove();
            listarDTperfiles(id);
        }

        function cargarPerfil() {
            $.ajax({
                url: "{{ url('/') }}/Usuario/CargarPerfil/" + $('#sistema_id').val() + "/" + $('#usuario_id')
                    .val(),
                type: 'get',
                success: function(data) {
                    $("#perfiles li").remove();
                    var options =
                        "<li><div class='radio radio-primary'><input id='perfilx' name='perfil' type='radio' checked> <label for='perfilx'>NINGUNO</label></div></li>";
                    $.each(data.perfil, function(index, value) {
                        activo = '';
                        $.each(data.usuarioperfil, function(index2, value2) {
                            if (value2.perfil_id == value.id) activo = 'checked';
                        });
                        options += "<li><div class='radio radio-primary'><input id='perfil" + index +
                            "' name='perfil' type='radio' value='" + value.id + "' " + activo + ">" +
                            " <label for='perfil" + index + "'>" + value.nombre + "</label></div></li>";
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
                data: $('#form_perfil').serialize(),
                dataType: "JSON",
                success: function(data) {
                    console.log(data)
                    if (data.status) {
                        reload_table_perfil();
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
        }
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
