@extends('layouts.main',['titlePage'=>'RELACION DE INDICADORES '])

@section('content')

<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-border">
                <div class="card-header bg-transparent pb-0">                                     
                </div>
                
                <div class="card-body">
                    <h3 > {{$nombre_niv1}}  </h3>
                    @php
                        $i=1;
                    @endphp

                    @foreach ($listaNivel3_deClasificador as $key => $item)
                        <br>
                        <h6>
                            {{$nombre_niv2}} : {{$item->codigoAdicional}}  {{$item->nombre_niv3}}
                        </h6>
                        <div class="progress progress-sm m-0">                
                        </div>

                        @foreach ($listaIndicadores as $key => $indicador)
                            @if($item->id_niv3==$indicador->clasificador_id)
                            <h6>
                            {{$i++}}.- <a href="{{route('indicador.'.$clase_codigo,$indicador->id)}}">{{$indicador->indicador}}</a>
                            </h6>
                            @endif
                        @endforeach
                    @endforeach
                </div>

            </div>
        </div>
      <!-- col -->
  </div>


</div>

@endsection

@section('js')
      <script src="{{ asset('/') }}assets/libs/jquery-validation/jquery.validate.min.js"></script>
      <!-- Validation init js-->
      <script src="{{ asset('/') }}assets/js/pages/form-validation.init.js"></script>

@endsection