@extends('layouts.main',['titlePage'=>'INDICADORES'])

@section('content')
    <div class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-fill bg-success">
                    <div class="card-header bg-transparent">
                        <h3 class="card-title text-white">{{$title}}</h3>
                    </div>
                </div>
            </div>
        </div>
        @if ($sinaprobar->count() > 0)
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-border">
                        <div class="card-header border-danger bg-transparent pb-0">
                            <div class="card-title">Importaciones sin aprobar</div>
                        </div>
                        <div class="card-body">
                            @foreach ($sinaprobar as $item)
                                <div class="alert alert-danger">
                                    {{ $item->comentario }}, de la fecha {{ $item->created_at }}
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        @endif

        <form id="form_indicadores" action="#">
            @csrf
            <input type="hidden" name="grado" value="{{ $grado }}">
            <input type="hidden" name="tipo" value="{{ $tipo }}">

            <div class="row">
                <div class="col-md-12">
                    <div class="card card-border">
                        <div class="card-header border-primary bg-transparent pb-0">
                            <h3 class="card-title">Resultados
                                <div class="float-right">
                                    <select id="anio" name="anio" class="form-control form-control-sm"
                                        onchange="satisfactorios();indicadormaterias();">
                                        @foreach ($anios as $item)
                                            <option value="{{ $item->anio }}">{{ $item->anio }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </h3>

                        </div>
                        <div class="card-body">
                            <div class="row" id="vistaindicadores">
                            </div>
                        </div>
                        <!-- End card-body -->
                    </div>
                    <!-- End card -->

                </div>
                <!-- end col -->

            </div>
        </form>
        <!-- End row -->
        <div class="row" id="vistaindcurso">
            
        </div>
        <!-- End row -->
        <div class="row" id="vistaugel">
        </div>
        <!-- End row -->
        <div class="row" id="vistaprovincia">
             
        </div>
        <!-- End row -->
        <div class="row">
            <div class="col-md-12">
                <div class="card card-border">
                    <div class="card-header border-primary bg-transparent pb-0">
                        <h3 class="card-title">Resultados de los indicadores
                            <div class="float-right">
                                <select id="provincia" name="provincia" class="form-control form-control-sm"
                                    onchange="cargardistritos();vistaindicador();">
                                    <option value="0">TODOS</option>
                                    @foreach ($provincias as $prov)
                                        <option value="{{ $prov->id }}">{!! $prov->nombre !!}</option>
                                    @endforeach
                                </select>
                                <select id="distrito" name="distrito" class="form-control form-control-sm"
                                    onchange="vistaindicador();">
                                    <option value="0">TODOS</option>
                                </select>
                            </div>
                        </h3>

                    </div>
                    <div class="card-body">
                        <div class="row" id="vistatabla">
                        </div>
                    </div>
                    <!-- End card-body -->
                </div>
                <!-- End card -->

            </div>
            <!-- end col -->

        </div>

    </div>

@endsection

@section('js')
    <script src="{{ asset('/') }}assets/libs/jquery-validation/jquery.validate.min.js"></script>
    <!-- Validation init js-->
    <script src="{{ asset('/') }}assets/js/pages/form-validation.init.js"></script>

    <script>
        $(document).ready(function() {
            satisfactorios();
            indicadormaterias();
            indicadorugel();
            indicadorprovincia();
            vistaindicador();
        });

        function vistaindicador() {
            datos = $("#form_indicadores").serialize() + '&provincia=' + $('#provincia').val() + '&distrito=' + $(
                '#distrito').val();
            console.log(datos);
            if (true) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('input[name=_token]').val()
                    },
                    url: "{{ route('ece.indicador.derivados') }}",
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

        function cargardistritos() {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('input[name=_token]').val()
                },
                url: "{{ url('/') }}/ECE/IndicadorDistritos/" + $('#provincia').val(),
                type: 'post',
                dataType: 'JSON',
                success: function(data) {
                    //console.log(data);
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

        function satisfactorios() {
            if (true) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('input[name=_token]').val()
                    },
                    url: "{{ route('ece.indicador.satisfactorio') }}",
                    type: 'post',
                    data: $("#form_indicadores").serialize(),
                    beforeSend: function() {
                        $("#vistaindicadores").html('<br><h3>Cargando datos...</h3>');
                    },
                    success: function(data) {
                        //console.log(data);
                        $("#vistaindicadores").html(data);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(jqXHR);
                    },
                });
            }
        }

        function indicadormaterias() {
            if (true) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('input[name=_token]').val()
                    },
                    url: "{{ route('ece.indicador.materia') }}",
                    type: 'post',
                    data: $("#form_indicadores").serialize(),
                    beforeSend: function() {
                        $("#vistaindcurso").html('<br><h3>Cargando datos...</h3>');
                    },
                    success: function(data) {
                        //console.log(data);
                        $("#vistaindcurso").html(data);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(jqXHR);
                    },
                });
            }
        }

        function indicadorugel() {
            if (true) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('input[name=_token]').val()
                    },
                    url: "{{ route('ece.indicador.ugel') }}",
                    type: 'post',
                    data: $("#form_indicadores").serialize(),
                    beforeSend: function() {
                        $("#vistaugel").html('<br><h3>Cargando datos...</h3>');
                    },
                    success: function(data) {
                        //console.log(data);
                        $("#vistaugel").html(data);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(jqXHR);
                    },
                });
            }
        }

        function indicadorprovincia() {
            if (true) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('input[name=_token]').val()
                    },
                    url: "{{ route('ece.indicador.provincia') }}",
                    type: 'post',
                    data: $("#form_indicadores").serialize(),
                    beforeSend: function() {
                        $("#vistaprovincia").html('<br><h3>Cargando datos...</h3>');
                    },
                    success: function(data) {
                        //console.log(data);
                        $("#vistaprovincia").html(data);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(jqXHR);
                    },
                });
            }
        }
    </script>

@endsection