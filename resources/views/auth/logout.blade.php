@extends('layouts.main_vacio')
@section('title','SESION TERMINADA')
@section('content')


<div class="" style="background:linear-gradient(60deg, #0539a8, #00030a)">

    {{-- style="background-image: url('{{ asset('img/login.jpg') }}'); background-size: cover; background-position: top center;align-items: center;" --}}
     
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
                
                <div>
                    <br><br><br><br><br><br><br><br>
                </div>

                <div class="card mt-4">
                    
                    <h4 class=" text-center mb-0 "  >
                        <br>
                        <p class="text-primary">Sistema de Monitoreo Regional</p>
                            
                        <img style="width:200px;text-align:center" src="{{ asset('img/LogoT02.jpg')}}">
                    </h4>

                    <h4 class=" text-center mb-0 "  >
                      <br>
                      <p class="text-primary">Sesión Cerrada Correctamente</p>
                
                    </h4>

                    <ul class="metismenu" style="text-align: center">
                    <li>
                      <a href="{{route('login')}}" class="waves-effect">
                         
                          <span> Volver a Iniciar Sesión</span>                  
                      </a>                   
                    </li>
                    </ul>

                </div>

                <div>
                    <br><br><br><br><br><br><br> <br><br><br><br><br> <br><br><br><br><br><br><br>
                </div>
                 
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->
    </div>
</div>


@endsection