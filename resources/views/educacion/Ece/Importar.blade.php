@extends('layouts.main',['titlePage'=>'IMPORTAR DATOS - EXCEL DE INDICADORES'])

@section('content')

    <div class="content">

        @if (count($errors) > 0)
            <div class="alert alert-danger">
                Error al Cargar Archivo <br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Datos de importación</h3>
                    </div>

                    <div class="card-body">
                        @if (Session::has('message'))
                            <div class="alert alert-success alert-dismissible fade show">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                {{ Session::get('message') }}.
                            </div>
                        @endif
                        <div class="form">

                            <form action="{{ route('ece.importar.store') }}" method="post" enctype='multipart/form-data' class="cmxform form-horizontal tasi-form" id="form_importar_indicador">
                                @csrf
                                <div class="col-lg-12">
                                    <div class="form-group row">
                                        <label class="col-md-2 col-form-label">Fuente de datos</label>
                                        <div class="col-md-10">
                                            <select class="form-control" name="fuenteImportacion" id="fuenteImportacion"
                                                required>
                                                <option value="">Seleccionar</option>
                                                @foreach ($fuentes as $item)
                                                    <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                
                                    <div class="form-group row">
                                        <label class="col-md-2 col-form-label">Fecha Versión</label>
                                        <div class="col-md-3">
                                            <input type="date" class="form-control" name="fechaActualizacion"
                                                id="fechaActualizacion" placeholder="Ingrese fecha actualizacion" autofocus
                                                required>
                                        </div>
                                    </div>
                                
                                    <div class="form-group row">
                                        <label class="col-md-2 col-form-label">Comentario</label>
                                        <div class="col-md-4">
                                            <textarea class="form-control" placeholder="comentario opcional" id="comentario" name="comentario"></textarea>
                                        </div>
                                    </div>
                               

                                    <div class="form-group row">
                                        <label class="col-md-2 col-form-label">Alumno EIB</label>
                                        <div class="col-md-2">
                                            <select class="form-control" name="tipo" id="tipo" required>
                                                <option value="0">NO</option>
                                                <option value="1">SI</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-2 col-form-label">Año</label>
                                        <div class="col-md-3">
                                            <select class="form-control" name="anio" id="anio" required>
                                                <option value="">Seleccionar</option>
                                                @for ($i = 2018; $i <= date('Y'); $i++)
                                                    <option value="{{ $i }}">{{ $i }}</option>
                                                @endfor
                                            </select>

                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-2 col-form-label">Nivel</label>
                                        <div class="col-md-5">
                                            <select class="form-control" name="nivel" id="nivel" onchange="cargargrados()" required>
                                                <option value="">Seleccionar</option>
                                                @foreach ($nivels as $item)
                                                    <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-2 col-form-label">Grado</label>
                                        <div class="col-md-5">
                                            <select class="form-control" name="grado" id="grado" required>
                                                <option value="">Seleccionar</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-2 col-form-label">Archivo</label>
                                        <div class="col-md-10">
                                            <input type="file" name="file" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-0">
                                    <div class="offset-lg-2 col-lg-10">
                                        <button class="btn btn-success waves-effect waves-light mr-1" type="submit">Importar</button>
                                        <button class="btn btn-secondary waves-effect" type="button">Cancelar</button>
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
        <!-- End row -->
        <div class="row"></div>

    </div>

@endsection

@section('js')
    <script src="{{ asset('/') }}assets/libs/jquery-validation/jquery.validate.min.js"></script>
    <!-- Validation init js-->
    <script src="{{ asset('/') }}assets/js/pages/form-validation.init.js"></script>
    <script>
        $(document).ready(function(){
        });
        function cargargrados() {
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('input[name=_token]').val()},
                url:"{{url('/')}}/ECE/IndicadorGrados",
                type: 'post',
                dataType:'JSON',
                data:{'nivel':$('#nivel').val()},
                success: function(data) {
                    console.log(data);
                    $("#grado option").remove();
                    var options = '<option value="">SELECCIONAR</option>';
                    $.each(data.grados, function(index, value) {
                        options += "<option value='" + value.id + "'>" + value.descripcion +"</option>"
                    });
                    $("#grado").append(options);
                },
                error:function(jqXHR,textStatus,errorThrown){
                    console.log(jqXHR);
                },
            });                
        }
    </script>
@endsection
