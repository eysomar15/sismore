@extends('layouts.main')
@section('title','INICIAR SESION')
@section('content')


<div class="account-pages my-5" style="background:linear-gradient(60deg, #0539a8, #f5f7fb)"
    {{-- style="background-image: url('{{ asset('img/login.jpg') }}'); background-size: cover; background-position: top center;align-items: center;" --}}
     >
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                  
                    <div class="card mt-4">

                        {{-- <img style="width:200px;text-align:center" src="{{ asset('img/LogoT02.jpg')}}">  --}}

                       
                            <h4 class=" text-center mb-0 "  >
<<<<<<< HEAD
                                 <br> Sistema de Monitoreo Regional desde no se<br><br>
=======
                                 <br>
                                 <p class="text-primary">Sistema de Monitoreo Regional xxxx</p>
                                 <br><br>
>>>>>>> 8487ed3e67333a176bab0e435d3b6831c4c9d610
                                <img style="width:200px;text-align:center" src="{{ asset('img/LogoT02.jpg')}}">
                             </h4>
                              
                      

                        {{-- <div class="card-header bg-img p-5 position-relative">
                            <div class="bg-overlay"></div>
                                <h4 class="text-white text-center mb-0">Iniciar Sesión</h4>
                        </div> --}}

                        <div class="card-body p-4 mt-2">
                            {{-- <form action="#" class="p-3"> --}}

                            <form class="form" method="POST" action="{{ route('login') }}">
                                @csrf

                                <div class="form-group mb-3">
                                    
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                                    name="email" value="{{ old('email') }}" required autocomplete="email"  placeholder="email" autofocus>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">                                   
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                                    name="password" required autocomplete="current-password" placeholder="Password">
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="checkbox-signin">
                                        <label class="custom-control-label" for="checkbox-signin">Recordarme</label>
                                    </div>
                                </div>

                                <div class="form-group text-center mt-5 mb-4">
                                    <button class="btn btn-primary waves-effect width-md waves-light" type="submit"> Iniciar login con Ronald </button>
                                </div>

                                <br>
                               
            
                            </form>

                        </div>
                        
                        <!-- end card-body -->
                    </div>
                    <!-- end card -->
                
                    <!-- end row -->
                    
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->

        </div>
    </div>


@endsection
