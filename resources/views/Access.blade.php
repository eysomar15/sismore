<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>SISMORE</title>
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

<body class="" style="background-image: url('{{asset('/')}}/img/fondo1.png');background-size: 100% 100%;">
    <div class="container">
            
        <div class="row"><br> </div>
        {{-- <div class="row justify-content-center">
            <h4 class="text-white">GOBIERNO REGIONAL DE UCAYALI</h4> 
        </div> --}}
        <div class="row justify-content-center">
            <h5 class="text-white text-center">BIENVENIDO</h5>{{-- text-white --}}
        </div>
        <div class="row justify-content-center">
            <h2 class="text-white text-center">SISTEMA DE MONITOREO REGIONAL</h2>{{-- text-white --}}
        </div>
        <div class="row justify-content-center">
            <div class="">
                <img style="width:250px;text-align:center" src="{{ asset('img/logoblanco.png')}}">
            </div>
        </div>
        <br>
        <br>
        {{-- <div class="row justify-content-center">
            <div class="col-md-4">
                <img style="width:200px;text-align:center" src="{{ asset('img/LogoT02.jpg')}}">
            </div>
            <br>
        </div> --}}
        <div class="row justify-content-center"> 
            <h5 class="text-white text-center">SELECCIONAR MODULO</h5>{{-- text-white --}}
        </div>
        <div class="row justify-content-center">
            @foreach ($sistemas as $sistema)
                <div class="col-md-3 col-xl-3">
                    <div class="card-box">
                        <a href=" {{ route('sistema_acceder', $sistema->sistema_id) }}">
                            <div class="media">
                                <div class="avatar-md bg-info rounded-circle mr-2">
                                    <i class="{{$sistema->icono}} avatar-title font-26 text-white"></i>
                                </div>
                                <div class="media-body align-self-center">
                                    <div class="text-right">
                                        {{-- <h4 class="font-20 my-0 font-weight-bold"><span
                                                data-plugin="counterup">15852</span></h4> --}}
                                        <p class="mb-0 mt-1 text-truncate">{{$sistema->nombre}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4">
                                {{-- <h6 class="text-uppercase">Target <span class="float-right">60%</span></h6> --}}
                                <div class="progress progress-sm m-0">
                                    <div class="progress-bar bg-info" role="progressbar" aria-valuenow="60"
                                        aria-valuemin="0" aria-valuemax="100" style="width:  100%">
                                        <span class="sr-only">60% Complete</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <!-- end card-box-->
                </div>


            @endforeach
        </div>
        
    </div>
</body>

</html>

