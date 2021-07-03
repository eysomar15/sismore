@extends('layouts.main',['titlePage'=>'IMPORTAR DATOS - PADRON WEB DE INSTITUCIONES EDUCATIVAS'])

@section('content')

<div class="content">
    <div class="container-fluid">

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
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header card-header-primary">
                                <h4 class="card-title">Padron Web de Instituciones Educativas</h4>
                                <p class="card-category"></p>
                            </div>
                       
                            <form action="{{route('PadronWeb.guardar')}}" method="post" enctype='multipart/form-data'>                            
                                @csrf
                                @if(Session::has('message'))
                                <p>{{Session::get('message')}}</p>
                                @endif
                                <div class="card-body">
                                    
                                    <div class="row">
                                        <label for="name" class="col-sm-2 col-form-label"> Fuente de datos</label>
                                        <div class="col-sm-7">
                                            <label for="name" class="form-control">ESCALE</label>                                          
                                        </div>                                   
                                    </div>  
                                    
                                    <div class="row">
                                        <label for="name" class="col-sm-2 col-form-label"> Fecha Versión </label>
                                        <div class="col-sm-7">
                                            <input type="date" class="form-control" name="fechaActualizacion" placeholder="Ingrese fecha actualizacion" autofocus >
                                        </div>
                                    </div>

                                    <div class="row">
                                        <label for="name" class="col-sm-2 col-form-label"> Comentario </label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control" name="comentario" placeholder="Ingrese comentario"  >
                                        </div>
                                    </div>

                                    <div class="row">
                                        <label for="name" class="col-sm-2 col-form-label"> Archivo </label>
                                        <div class="col-sm-7">
                                            <input type="file" name="file" class="form-control" required > 
                                        </div>                                   
                                    </div>

                                    <div class="card-footer ml-auto mr-auto">
                                        <button type="submit" class="btn btn-primary">Importar</button>
                                    </div>

                                </div>
                           
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

