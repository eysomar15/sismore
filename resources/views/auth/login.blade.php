<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>INICIAR SESION</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Responsive bootstrap 4 admin template" name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('/') }}assets/images/favicon.ico">

    <!-- App css -->
    <link href="{{ asset('/') }}assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" id="bootstrap-stylesheet" />
    <link href="{{ asset('/') }}assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/') }}assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-stylesheet" />
    <link href="{{ asset('/') }}assets/css/otros/personalizado.css" rel="stylesheet" type="text/css" />

</head>

<body class="authentication-page bg-white" >
    <div class="row bg-blue">
        <div class="col-12">
            <div class="row justify-content-center p-0 mb-0">
                <H5 class="text-white mb-0">GOBIERNO REGIONAL DE UCAYALI</H5>
            </div>
            <div class="row justify-content-center ">
                <H2 class="text-white text-center">SISTEMA DE MONITOREO REGIONAL</H2>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12"><br>
            <div class="row justify-content-center ">
                <img style="width:200px;text-align:center" src="{{ asset('img/logo.png') }}">
            </div>
        </div>

    </div>
    <div class="account-pages" >{{--  my-5 --}}
        <div class="container" >

            <div class="row justify-content-center ">
                <div class="col-md-4 {{-- col-lg-4 col-xl-5 --}}">
                    <div class="card mt-4 border">
                        <div class="card-header bg-blue {{-- p-5 --}} position-relative">
                            {{-- <div class="bg-overlay"></div> --}}
                            <h1 class="text-white text-center mb-0">SISMORE</h1>
                        </div>
                        <div class="card-body p-4 mt-2">
                            {{-- <form action="#" class="p-3"> --}}
                            <form class="form p-3" method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="form-group mb-3">
                                    <label for="exampleInputEmail1">Usuario</label>
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                                    name="email" value="{{ old('email') }}" required autocomplete="email"  placeholder="email" autofocus>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
    
                                <div class="form-group mb-3">   
                                    <label for="exampleInputPassword1">Contraseña</label>                                
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                                    name="password" required autocomplete="current-password" placeholder="Password">
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                {{-- <div class="form-group mb-3">
                                    <input class="form-control" type="email" required="" placeholder="Username">
                                </div>

                                <div class="form-group mb-3">
                                    <input class="form-control" type="password" required="" placeholder="Password">
                                </div> --}}
                                <div class="form-group row mb-0">
                                    <div class="col-sm-12">
                                        <a href="pages-recoverpw.html"><i class="fa fa-lock mr-1"></i>  ¿Olvidaste tu contraseña?</a>
                                    </div>
                                    {{-- <div class="col-sm-5 text-right">
                                        <a href="pages-register.html">Create an account</a>
                                    </div> --}}
                                </div>
                                {{-- <div class="form-group mb-3">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="checkbox-signin">
                                        <label class="custom-control-label" for="checkbox-signin">Remember me</label>
                                    </div>
                                </div> --}}

                                <div class="form-group text-center mt-2 mb-0    x">{{-- mb-4 --}}
                                    <button class="btn btn-primary waves-effect width-md waves-light" type="submit">Iniciar Sesión</button>
                                </div>
                                {{-- <div class="form-group row mb-0">
                                    <div class="col-sm-7">
                                        <a href="pages-recoverpw.html"><i class="fa fa-lock mr-1"></i> Forgot your
                                            password?</a>
                                    </div>
                                    <div class="col-sm-5 text-right">
                                        <a href="pages-register.html">Create an account</a>
                                    </div>
                                </div> --}}
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
    {{-- <div class="row align-self-end bg-blue mb-0">
        <div class="col-12">
            <div class="row justify-content-center mb-0">
                <p class="text-white">Copyright © 2021 - GRU</p>
            </div>
        </div>
    </div> --}}
    {{-- <!-- Vendor js -->
    <script src="{{ asset('/') }}assets/js/vendor.min.js"></script>

    <!-- App js -->
    <script src="{{ asset('/') }}assets/js/app.min.js"></script> --}}

</body>

</html>
