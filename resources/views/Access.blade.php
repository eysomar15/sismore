@extends('layouts.main_vacio')
@section('title','SELECCIONAR SISTEMA')
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
                        <p class="text-primary">Acceder a:</p>                        
                    </h4>
                    
                    <ul>
                        @foreach ($sistemas as $sistema)
                          
                                {{-- {{$escuela->nombre}} --}}
                                <a href=" {{route('sistema_acceder',$sistema->id)}}"> {{$sistema->nombre}} <br>
                                </a>
                               
                           
                        @endforeach
                    
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
