<<<<<<< HEAD
@extends('layouts.main', ['activePage' => 'usuarios', 'titlePage' => 'GESTION DE GERENCIAS'])
=======
@extends('layouts.main',['activePage'=>'usuarios','titlePage'=>'GESTION DE GERENCIAS'])
>>>>>>> 4465f79f1094a72e3a14a68f37e6ea816b2643da

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
                        </div> --}}

                            <div class="card-body">
                                <!-- <input type="hidden" id="tipogobierno" name="tipogobierno" value="3"> -->
                                <div class="row justify-content-between ">
                                    <div class="col-4 ">
                                        <div class="row form-group">
                                            <label class="col-md-4 col-form-label">GOBIERNO</label>
                                            <div class="col-md-8">
                                                <select class="form-control" name="tipogobierno" id="tipogobierno"
<<<<<<< HEAD
                                                    onchange="cargarunidadejecutora();listarDT();">
                                                    {{-- <option value="0">SELECCIONAR</option> --}}
                                                    @foreach ($tipogobierno as $item)
                                                        <option value="{{ $item->id }}"
                                                            {{ $item->id == 3 ? 'selected' : '' }}>
                                                            {{ $item->tipogobierno }}
                                                        </option>
=======
                                                    onchange="listarDT();">
                                                    {{-- <option value="0">SELECCIONAR</option> --}}
                                                    @foreach ($tipogobierno as $item)
                                                        <option value="{{ $item->id }}" {{$item->id==3?'selected':''}}>{{ $item->tipogobierno }}</option>
>>>>>>> 4465f79f1094a72e3a14a68f37e6ea816b2643da
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
<<<<<<< HEAD

                                    <div class="col-4 ">
                                        {{-- <div class="row justify-content-end">
                                            <button type="button" class="btn btn-primary" onclick="add_entidad()"><i
                                                    class="fa fa-plus"></i> Nuevo</button>
                                        </div> --}}

                                    </div>

                                </div>
                                <div class="row justify-content-between ">
=======
>>>>>>> 4465f79f1094a72e3a14a68f37e6ea816b2643da
                                    <div class="col-4 ">
                                        <div class="row form-group">
                                            <label class="col-md-4 col-form-label">UNIDAD EJECUTORA</label>
                                            <div class="col-md-8">
<<<<<<< HEAD
                                                <select class="form-control" name="entidad" id="entidad"
                                                    onchange="listarDT();">

=======
                                                <select class="form-control" name="tipogobierno" id="tipogobierno"
                                                    onchange="listarDT();">
                                                    {{-- <option value="0">SELECCIONAR</option> --}}
                                                    @foreach ($tipogobierno as $item)
                                                        <option value="{{ $item->id }}" {{$item->id==3?'selected':''}}>{{ $item->tipogobierno }}</option>
                                                    @endforeach
>>>>>>> 4465f79f1094a72e3a14a68f37e6ea816b2643da
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4 ">
                                        <div class="row justify-content-end">
                                            <button type="button" class="btn btn-primary" onclick="add_entidad()"><i
                                                    class="fa fa-plus"></i> Nuevo</button>
                                        </div>

                                    </div>

                                </div>

                                <div class="table-responsive">
                                    <br>
                                    <table id="dtPrincipal" class="table table-striped table-bordered" style="width:100%">
                                        <thead class="cabecera-dataTable" id="xxx">
                                            <!--th>N??</th-->
                                            <th>Codigo</th>
<<<<<<< HEAD
                                            <th>Gerencia</th>
=======
                                            <!-- <th>Tipo de Gobierno</th> -->
                                            <th>Unidad Ejecutora</th>
>>>>>>> 4465f79f1094a72e3a14a68f37e6ea816b2643da
                                            <th>Abreviado</th>
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
    <div id="modal_form_entidad" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
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
                    <form action="" id="form_entidad" class="form-horizontal" autocomplete="off">
                        @csrf
                        <input type="hidden" class="form-control" id="entidad_id" name="entidad_id">
                        <div class="form-body">
<<<<<<< HEAD
                            <div class="form-group">
                                <label>Tipo Gobierno <span class="required">*</span></label>
                                <select id="entidad_tipogobierno" name="entidad_tipogobierno" class="form-control">
                                    @foreach ($tipogobierno as $item)
                                        <option value="{{ $item->id }}">{{ $item->tipogobierno }}</option>
                                    @endforeach
=======
                        <div class="form-group">
                                <label>Tipo Gobierno <span class="required">*</span></label>
                                <select  id="entidad_tipogobierno" name="entidad_tipogobierno" class="form-control">
                                @foreach ($tipogobierno as $item)
                                    <option value="{{ $item->id }}">{{ $item->tipogobierno }}</option>
                                @endforeach
>>>>>>> 4465f79f1094a72e3a14a68f37e6ea816b2643da
                                </select>
                                <span class="help-block"></span>
                            </div>
                            <div class="form-group">
                                <label>Codigo <span class="required">*</span></label>
                                <input type="text" id="entidad_codigo" name="entidad_codigo" class="form-control">
                                <span class="help-block"></span>
                            </div>
                            <div class="form-group">
                                <label>Unidad Ejecutora <span class="required">*</span></label>
<<<<<<< HEAD
                                <input id="entidad_nombre" name="entidad_nombre" class="form-control" type="text"
                                    onkeyup="this.value=this.value.toUpperCase()">
=======
                                <input id="entidad_nombre" name="entidad_nombre" class="form-control" type="text" onkeyup="this.value=this.value.toUpperCase()">
>>>>>>> 4465f79f1094a72e3a14a68f37e6ea816b2643da
                                <span class="help-block"></span>
                            </div>
                            <div class="form-group">
                                <label>Abreviatura <span class="required">*</span></label>
<<<<<<< HEAD
                                <input id="entidad_abreviado" name="entidad_abreviado" class="form-control"
                                    type="text" onkeyup="this.value=this.value.toUpperCase()">
=======
                                <input id="entidad_abreviado" name="entidad_abreviado" class="form-control" type="text" onkeyup="this.value=this.value.toUpperCase()">
>>>>>>> 4465f79f1094a72e3a14a68f37e6ea816b2643da
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
<<<<<<< HEAD
                    <button type="button" id="btnSaveentidad" onclick="saveentidad()"
                        class="btn btn-primary">Guardar</button>
=======
                    <button type="button" id="btnSaveentidad" onclick="saveentidad()" class="btn btn-primary">Guardar</button>
>>>>>>> 4465f79f1094a72e3a14a68f37e6ea816b2643da
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!-- End Bootstrap modal -->
<<<<<<< HEAD
@endsection
=======

    
    @endsection
>>>>>>> 4465f79f1094a72e3a14a68f37e6ea816b2643da

@section('js')
    {{-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> --}}
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap4.min.js"></script>


    {{-- DATA TABLE --}}
    <script>
        var save_method = '';
        $(document).ready(function() {
            var save_method = '';
            var table_principal;
            $("input").change(function() {
                $(this).parent().removeClass('has-error');
                $(this).next().empty();
            });
            $("textarea").change(function() {
                $(this).parent().removeClass('has-error');
                $(this).next().empty();
            });
            $("select").change(function() {
                $(this).parent().removeClass('has-error');
                $(this).next().empty();
            });
            /* $("#entidad").change(function(){
                $("#opcionesx").html('Gerencia');
            }); */
            /* $("#entidadgerencia").change(function(){
                $("#opcionesx").html('Oficina');
                if($(this).val()==0){
                    $("#opcionesx").html('Gerencia');
                }
            }); */
            listarDT();
            //cargar_gerencia('')
        });

        function listarDT() {
            table_principal = $('#dtPrincipal').DataTable({
<<<<<<< HEAD
                "ajax": "{{ url('/') }}/Entidad/CargarGerencia/" + $('#entidad').val(),
                "columns": [{
                        data: 'codigo',
                    },
                    {
                        data: 'entidad',
                    }, {
                        data: 'abreviado',
                    }, {
                        data: 'action',
                        orderable: false
                    }
                ],
=======
                "ajax": "{{ url('/') }}/Entidad/listar/" + $('#tipogobierno').val(),
                "columns": [{
                    data: 'codigo',
                },/* {
                    data: 'nombretipogobierno',
                }, */{
                    data: 'unidad_ejecutora',
                }, {
                    data: 'abreviatura',
                }, {
                    data: 'action',
                    orderable: false
                }],
>>>>>>> 4465f79f1094a72e3a14a68f37e6ea816b2643da
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
                        </select>` + " registros por p??gina",
                    "info": "Mostrando la p??gina _PAGE_ de _PAGES_",
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

        function reload_table_principal() {
            table_principal.ajax.reload(null, false);
        }

        function add_entidad() {
            save_method = 'add';
            $('#form_entidad')[0].reset();
            $('#form_entidad .form-group').removeClass('has-error');
<<<<<<< HEAD
            $('#form_entidad .help-block').empty();
            $('#entidad_tipogobierno').val($('#tipogobierno').val());
            $('#modal_form_entidad').modal('show');
            $('#modal_form_entidad .modal-title').text('Crear Nueva Entidad');

        };

=======
            $('#form_entidad .help-block').empty();     
            $('#entidad_tipogobierno').val( $('#tipogobierno').val());
            $('#modal_form_entidad').modal('show');
            $('#modal_form_entidad .modal-title').text('Crear Nueva Entidad');

        };     
>>>>>>> 4465f79f1094a72e3a14a68f37e6ea816b2643da
        function edit(id) {
            save_method = 'update';
            $('#form_entidad')[0].reset();
            $('#form_entidad .form-group').removeClass('has-error');
<<<<<<< HEAD
            $('#form_entidad .help-block').empty();
            $('#entidad_tipogobierno').val($('#tipogobierno').val());
            $.ajax({
                url: "{{ url('/') }}/Entidad/ajax_edit_entidad/" + id,
                type: "GET",
                data: {
                    "entidad": id
                },
=======
            $('#form_entidad .help-block').empty();     
            $('#entidad_tipogobierno').val( $('#tipogobierno').val());
            $.ajax({
                url: "{{ url('/') }}/Entidad/ajax_edit_entidad/"+id,
                type: "GET",
                data: {"entidad":id},
>>>>>>> 4465f79f1094a72e3a14a68f37e6ea816b2643da
                dataType: "JSON",
                success: function(data) {
                    console.log(data);
                    $("#entidad_id").val(data.entidad.id);
                    $("#entidad_codigo").val(data.entidad.codigo);
                    $("#entidad_tipogobierno").val(data.entidad.tipogobierno);
                    $("#entidad_nombre").val(data.entidad.unidad_ejecutora);
                    $("#entidad_abreviado").val(data.entidad.abreviatura);
<<<<<<< HEAD

=======
                    
>>>>>>> 4465f79f1094a72e3a14a68f37e6ea816b2643da
                    $('#modal_form_entidad').modal('show');
                    $('#modal_form_entidad .modal-title').text('Modificar Entidad');
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    toastr.error("El registro no se pudo crear verifique las validaciones.", 'Mensaje');
                }
            });
<<<<<<< HEAD


        };

        function saveentidad() {
            $('#btnSaveentidad').text('guardando...');
            $('#btnSaveentidad').attr('disabled', true);
            var url = save_method == "add" ? "{{ route('entidad.ajax.addentidad') }}" :
                "{{ route('entidad.ajax.updateentidad') }}";
=======
            

        };     
        function saveentidad() {
            $('#btnSaveentidad').text('guardando...');
            $('#btnSaveentidad').attr('disabled', true);
            var url=save_method=="add"?"{{route('entidad.ajax.addentidad')}}":"{{route('entidad.ajax.updateentidad')}}";
>>>>>>> 4465f79f1094a72e3a14a68f37e6ea816b2643da
            $.ajax({
                url: url,
                type: "POST",
                data: $('#form_entidad').serialize(),
                dataType: "JSON",
                success: function(data) {
                    console.log(data);
                    if (data.status) {
                        $('#modal_form_entidad').modal('hide');
                        reload_table_principal();
                        toastr.success("El registro fue creado exitosamente.", 'Mensaje');
                    } else {
                        for (var i = 0; i < data.inputerror.length; i++) {
                            $('[name="' + data.inputerror[i] + '"]').parent().addClass('has-error');
                            $('[name="' + data.inputerror[i] + '"]').next().text(data.error_string[i]);
                        }
                    }
                    $('#btnSaveentidad').text('Guardar');
                    $('#btnSaveentidad').attr('disabled', false);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    toastr.error("El registro no se pudo crear verifique las validaciones.", 'Mensaje');
                    $('#btnSaveentidad').text('Guardar');
                    $('#btnSaveentidad').attr('disabled', false);
                }
            });
        };
<<<<<<< HEAD

        function cargarunidadejecutora() {
            $.ajax({
                url: "{{ url('/') }}/Entidad/CargarEntidad/" + $('#tipogobierno').val(),
                type: 'get',
                success: function(data) {
                    console.log(data);
                    $('#entidad option ').remove();
                    var opt = '<option value="">SELECCIONAR</option>';
                    $.each(data.unidadejecutora, function(index, value) {
                        opt += '<option value="' + value.id + '">' + value.unidad_ejecutora +
                            '</option>';
                    });
                    $('#entidad').append(opt);

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR);
                },
            });
        }
=======
    
>>>>>>> 4465f79f1094a72e3a14a68f37e6ea816b2643da
    </script>
@endsection
