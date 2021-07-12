@extends('layouts.main',['titlePage'=>'IMPORTAR DATOS - EXCEL DE INDICADORES'])

@section('content')

<div class="content">

    @if(count($errors)>0)
        <div class="alert alert-danger">
            Error al Cargar Archivo <br><br>
            <ul>
                @foreach($errors -> all() as $error)
                <li>{{$error}}</li>
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
                    <p>{{Session::get('message')}}</p>
                    @endif  
                    <div class="form">

                        <form action="{{route('ece.importar.store')}}" method="post" enctype='multipart/form-data'
                            class="cmxform form-horizontal tasi-form"  >                            
                            @csrf

                            <div class="form-group row">
                                <label class="col-md-2 col-form-label">Tipo</label>
                                <div class="col-md-10">
                                    <select name="tipo" id="tipo" required>
                                        <option value="">Seleccionar</option>
                                        <option value="0">SIN IEB</option>
                                        <option value="1">CON IEB</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-2 col-form-label">Anio</label>
                                <div class="col-md-10">
                                    <select name="anio" id="anio" required>
                                        <option value="">Seleccionar</option>
                                        @for ($i = 2018; $i <= date('Y'); $i++)
                                        <option value="{{$i}}">{{$i}}</option>
                                        @endfor
                                    </select>
                                    
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-2 col-form-label">Grado</label>
                                <div class="col-md-10">
                                    <select name="grado" id="grado" required>
                                        <option value="">Seleccionar</option>
                                        @foreach ($grados as $item)
                                        <option value="{{$item->id}}">{{$item->descripcion}} - {{$item->nombre}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label">Materia</label>
                                <div class="col-md-10">
                                    <select name="materia" id="materia" required>
                                        <option value="">Seleccionar</option>
                                        @foreach ($materias as $item)
                                        <option value="{{$item->id}}">{{$item->descripcion}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>                            

                            <div class="form-group row">
                                <label class="col-md-2 col-form-label">Archivo</label>
                                <div class="col-md-10">
                                    <input type="file" name="file" class="form-control" required > 
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

</div>

@endsection

@section('js')
      <script src="{{ asset('/') }}assets/libs/jquery-validation/jquery.validate.min.js"></script>
      <!-- Validation init js-->
      <script src="{{ asset('/') }}assets/js/pages/form-validation.init.js"></script>

@endsection