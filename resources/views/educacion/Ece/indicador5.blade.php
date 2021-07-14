@extends('layouts.main',['titlePage'=>'Alumnos que logran los aprendizajes del grado (% de alumnos de 2° grado de secundaria participantes en evaluación censal)'])

@section('content')

<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-border">
                <div class="card-header border-primary bg-transparent pb-0">
                    <div class="card-title text-primary">Filtro</div>
                </div>
                <div class="card-body">
                    <form action="" method="post" name="form1">
                        @csrf
                        <div class="row">
                            <div class="col-sm-3">
                                <label class="form-label">AÑO</label>
                                <select id="anio" name="anio" class="form-control">
                                    @for ($i = 2018; $i < date('Y'); $i++)
                                    <option value="{{$i}}">{{$i}}</option>    
                                    @endfor
                                </select>
                                <span class="held-block"></span>
                            </div>
                            <div class="col-sm-3">
                                <label class="form-label">PROVINCIA</label>
                                <select id="grado" name="grado" class="form-control">
                                    <option value="0">TODOS</option>
                                    @foreach ($provincias as $prov)
                                    <option value="">{!!$prov->nombre!!}</option>
                                    @endforeach
                                </select>
                                <span class="held-block"></span>
                            </div>
                            <div class="col-sm-3">
                                <label class="form-label">DISTRITO</label>
                                <select id="seccion" name="seccion" class="form-control input-sm"><option value="0">TODOS</option></select>
                                <span class="held-block"></span>
                            </div> 
                            <!--div class="col-sm-6">
                                <label class="form-label">GRADO</label>
                                <select id="grado" name="grado" class="form-control input-sm"><option value="">SELECCIONAR</option></select>
                                <span class="held-block"></span>
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label">SECCION</label>
                                <select id="seccion" name="seccion" class="form-control input-sm"><option value="">SELECCIONAR</option></select>
                                <span class="held-block"></span>
                            </div--> 
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-border">
                <div class="card-header border-primary bg-transparent pb-0">
                    <div class="card-title text-primary">Indicador</div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                {!! $tabla!!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End row -->
</div>

@endsection

@section('js')
      <script src="{{ asset('/') }}assets/libs/jquery-validation/jquery.validate.min.js"></script>
      <!-- Validation init js-->
      <script src="{{ asset('/') }}assets/js/pages/form-validation.init.js"></script>

@endsection