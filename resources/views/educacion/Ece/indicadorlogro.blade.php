@extends('layouts.main',['titlePage'=>$title])

@section('content')
<div class="content">
    @if ($sinaprobar->count()>0)
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-border">
                <div class="card-header border-danger bg-transparent pb-0">
                    <div class="card-title">Importaciones sin aprobar</div>
                </div>
                <div class="card-body">
                    @foreach ($sinaprobar as $item)
                    <div class="alert alert-danger">
                        {{$item->comentario}}, de la fecha {{$item->created_at}}
                    </div>
                    @endforeach
                    
                </div>
            </div>
        </div>
    </div> 
    @endif

    <form id="form_indicadores" action="#">
        @csrf
        <input type="hidden" name="grado" value="{{$grado}}">
        <input type="hidden" name="tipo" value="{{$tipo}}">
        <!--input type="hidden" name="anio" value="2018"-->
        
        <div class="row">        
            <div class="col-md-12">
                <div class="card card-border">
                    <div class="card-header border-primary bg-transparent pb-0">
                        <h3 class="card-title">Resultados de los indicadores
                            <div class="float-right">
                                <select id="anio" name="anio" class="form-control form-control-sm" onchange="satisfactorios();indicadormaterias();">
                                    @foreach ($anios as $item)
                                        <option value="{{$item->anio}}">{{$item->anio}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </h3>
                        
                    </div>
                    <div class="card-body">
                        <div class="row" id="vistaindicadores">
                            <div class="col-md-6 col-xl-3">
                                <div class="card-box">
                                    <div class="media">
                                        <div class="avatar-md bg-info rounded-circle mr-2">
                                            <i class="ion-logo-usd avatar-title font-26 text-white"></i>
                                        </div>
                                        <div class="media-body align-self-center">
                                            <div class="text-right">
                                                <h4 class="my-0 font-weight-bold"><span data-plugin="counterup">20.5</span>%</h4>
                                                <p class="mb-0 mt-1 text-truncate">Total Sales</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end card-box-->
                            </div>   
                            <div class="col-md-6 col-xl-3">
                                <div class="card-box">
                                    <div class="media">
                                        <div class="avatar-md bg-info rounded-circle mr-2">
                                            <i class="ion-logo-usd avatar-title font-26 text-white"></i>
                                        </div>
                                        <div class="media-body align-self-center">
                                            <div class="text-right">
                                                <h4 class="my-0 font-weight-bold"><span data-plugin="counterup">20.5</span>%</h4>
                                                <p class="mb-0 mt-1 text-truncate">Total Sales</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end card-box-->
                            </div>
                            <div class="col-md-6 col-xl-3">
                                <div class="card-box">
                                    <div class="media">
                                        <div class="avatar-md bg-info rounded-circle mr-2">
                                            <i class="ion-logo-usd avatar-title font-26 text-white"></i>
                                        </div>
                                        <div class="media-body align-self-center">
                                            <div class="text-right">
                                                <h4 class="my-0 font-weight-bold"><span data-plugin="counterup">20.5</span>%</h4>
                                                <p class="mb-0 mt-1 text-truncate">Total Sales</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end card-box-->
                            </div>                     
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
        <div class="col-md-6">
            <div class="card card-border">
                <div class="card-header border-primary bg-transparent pb-0">
                    <h3 class="card-title">Indicador Curso</h3>
                </div>
                <div class="card-body">
                    <div class="row" >
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table mb-0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>PREVIO</th>
                                            <th>INICIO</th>
                                            <th>PROCESO</th>
                                            <th>SATISFACTORIO</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>Mark</td>
                                            <td>Otto</td>
                                            <td>@mdo</td>
                                            <td>20</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
        <!-- end col -->
    
    </div>
<!-- End row -->
<div class="row" id="vistaugel">        
    <div class="col-md-6">
        <div class="card card-border">
            <div class="card-header border-primary bg-transparent pb-0">
                <h3 class="card-title">Indicador Curso</h3>
            </div>
            <div class="card-body">
                <div class="row" >
                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>PREVIO</th>
                                        <th>INICIO</th>
                                        <th>PROCESO</th>
                                        <th>SATISFACTORIO</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Mark</td>
                                        <td>Otto</td>
                                        <td>@mdo</td>
                                        <td>20</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div> 
                </div>
            </div>
        </div>
    </div>
    <!-- end col -->

</div>
<!-- End row -->
<div class="row" id="vistaprovincia">        
    <div class="col-md-6">
        <div class="card card-border">
            <div class="card-header border-primary bg-transparent pb-0">
                <h3 class="card-title">Indicador Curso</h3>
            </div>
            <div class="card-body">
                <div class="row" >
                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>PREVIO</th>
                                        <th>INICIO</th>
                                        <th>PROCESO</th>
                                        <th>SATISFACTORIO</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Mark</td>
                                        <td>Otto</td>
                                        <td>@mdo</td>
                                        <td>20</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div> 
                </div>
            </div>
        </div>
    </div>
    <!-- end col -->

</div>
<!-- End row -->
<div class="row">        
    <div class="col-md-12">
        <div class="card card-border">
            <div class="card-header border-primary bg-transparent pb-0">
                <h3 class="card-title">Resultados de los indicadores
                    <div class="float-right">
                        <select id="provincia" name="provincia" class="form-control form-control-sm" onchange="cargardistritos();">
                            <option value="0">TODOS</option>
                            @foreach ($provincias as $prov)
                            <option value="{{$prov->id}}">{!!$prov->nombre!!}</option>
                            @endforeach
                        </select>
                        <select id="distrito" name="distrito" class="form-control input-sm" onchange="vistaindicador();">
                            <option value="0">TODOS</option></select>
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
    <!--div class="row">
        <div class="col-lg-12">
            <div class="card card-border">
                <div class="card-header border-primary bg-transparent pb-0">
                    <div class="card-title text-primary">Filtro</div>
                </div>
                <div class="card-body">
                    <form action="" method="post" name="form_filtro" id="form_filtro">
                        @csrf
                        <input type="hidden" name="grado" value="{{$grado}}">
                        <input type="hidden" name="tipo" value="{{$tipo}}">
                        <div class="row">
                            <div class="col-sm-3">
                                <label class="form-label">AÑO</label>
                                <select id="anio" name="anio" class="form-control" onchange="vistaindicador()">
                                    @foreach ($anios as $item)
                                        <option value="{{$item->anio}}">{{$item->anio}}</option>
                                    @endforeach
                                </select>
                                <span class="held-block"></span>
                            </div>
                            <div class="col-sm-3">
                                <label class="form-label">PROVINCIA</label>
                                <select id="provincia" name="provincia" class="form-control" onchange="cargardistritos();vistaindicador();">
                                    <option value="0">TODOS</option>
                                    @foreach ($provincias as $prov)
                                    <option value="{{$prov->id}}">{!!$prov->nombre!!}</option>
                                    @endforeach
                                </select>
                                <span class="held-block"></span>
                            </div>
                            <div class="col-sm-3">
                                <label class="form-label">DISTRITO</label>
                                <select id="distrito" name="distrito" class="form-control input-sm" onchange="vistaindicador();">
                                    <option value="0">TODOS</option></select>
                                <span class="held-block"></span>
                            </div> 
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div-->
    <!--div class="row">
        <div class="col-lg-12">
            <div class="card card-border">
                <div class="card-header border-primary bg-transparent pb-0">
                    <div class="card-title text-primary">Indicador</div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive" id="vistatabla">
                                {{--!! $tabla!!--}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div-->
    <!-- End row -->
</div>

@endsection

@section('js')
      <script src="{{ asset('/') }}assets/libs/jquery-validation/jquery.validate.min.js"></script>
      <!-- Validation init js-->
      <script src="{{ asset('/') }}assets/js/pages/form-validation.init.js"></script>

    <script>
        $(document).ready(function(){
            satisfactorios();
            indicadormaterias();
            indicadorugel();
            indicadorprovincia();
            //vistaindicador();
        });
        function vistaindicador() {
            if(true){
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('input[name=_token]').val()},
                    url: "{{route($ruta)}}",
                    type: 'post',
                    data: $("#form_filtro").serialize(),
                    beforeSend: function() {
                        $("#vistatabla").html('<br><h3>Cargando datos...</h3>');
                    },
                    success: function(data) {
                        console.log(data);
                        $("#vistatabla").html(data);
                    },
                    error:function(jqXHR,textStatus,errorThrown){
                        console.log(jqXHR);
                    },
                });
            }
        }

        function cargardistritos() {
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('input[name=_token]').val()},
                url:"{{url('/')}}/ECE/IndicadorDistritos/"+$('#provincia').val(),
                type: 'post',
                dataType:'JSON',
                success: function(data) {
                    console.log(data);
                    $("#distrito option").remove();
                    var options = '<option value="">TODOS</option>';
                    $.each(data.distritos, function(index, value) {
                        options += "<option value='" + value.id + "'>" + value.nombre +"</option>"
                    });
                    $("#distrito").append(options);
                },
                error:function(jqXHR,textStatus,errorThrown){
                    console.log(jqXHR);
                },
            });                
        }
        function satisfactorios() {
            if(true){
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('input[name=_token]').val()},
                    url: "{{route('ece.indicador.satisfactorio')}}",
                    type: 'post',
                    data: $("#form_indicadores").serialize(),
                    beforeSend: function() {
                        $("#vistaindicadores").html('<br><h3>Cargando datos...</h3>');
                    },
                    success: function(data) {
                        console.log(data);
                        $("#vistaindicadores").html(data);
                    },
                    error:function(jqXHR,textStatus,errorThrown){
                        console.log(jqXHR);
                    },
                });
            }
        }
        function indicadormaterias() {
            if(true){
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('input[name=_token]').val()},
                    url: "{{route('ece.indicador.materia')}}",
                    type: 'post',
                    data: $("#form_indicadores").serialize(),
                    beforeSend: function() {
                        $("#vistaindcurso").html('<br><h3>Cargando datos...</h3>');
                    },
                    success: function(data) {
                        console.log(data);
                        $("#vistaindcurso").html(data);
                    },
                    error:function(jqXHR,textStatus,errorThrown){
                        console.log(jqXHR);
                    },
                });
            }
        }
        function indicadorugel() {
            if(true){
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('input[name=_token]').val()},
                    url: "{{route('ece.indicador.ugel')}}",
                    type: 'post',
                    data: $("#form_indicadores").serialize(),
                    beforeSend: function() {
                        $("#vistaugel").html('<br><h3>Cargando datos...</h3>');
                    },
                    success: function(data) {
                        console.log(data);
                        $("#vistaugel").html(data);
                    },
                    error:function(jqXHR,textStatus,errorThrown){
                        console.log(jqXHR);
                    },
                });
            }
        }
        function indicadorprovincia() {
            if(true){
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('input[name=_token]').val()},
                    url: "{{route('ece.indicador.provincia')}}",
                    type: 'post',
                    data: $("#form_indicadores").serialize(),
                    beforeSend: function() {
                        $("#vistaprovincia").html('<br><h3>Cargando datos...</h3>');
                    },
                    success: function(data) {
                        console.log(data);
                        $("#vistaprovincia").html(data);
                    },
                    error:function(jqXHR,textStatus,errorThrown){
                        console.log(jqXHR);
                    },
                });
            }
        }
    </script>

@endsection