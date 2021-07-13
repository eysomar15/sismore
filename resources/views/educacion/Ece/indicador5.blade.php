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
                    <form action="">

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
                    @foreach ($materias as $key => $item)
                        {{$key+1}}-{{$item->descripcion}}<br>
                    @endforeach
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