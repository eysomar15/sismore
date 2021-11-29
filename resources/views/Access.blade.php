@extends('layouts.main_vacio')
@section('title', 'SELECCIONAR SISTEMA')


@section('content')

    {{-- <div class="" style="background:linear-gradient(60deg,#165588, #011646)"> --}}
    <div class="" style="background-image: url('{{asset('/')}}/img/fondo001.jpg');background-size: 100% 100%;">
        <div class="container">
            <div class="row"><br><br><br><br><br></div>
            <div class="row justify-content-center">
                <h4 class="text-primary">GOBIERNO REGIONAL DE UCAYALI</h4>{{-- text-white --}}
            </div>
            <div class="row justify-content-center">                
                <h2 class="text-primary">SISTEMA DE MONITOREO REGIONAL</h2>{{-- text-white --}}
            </div>
            <div class="row justify-content-center">
                {{-- <div class="col-md-4">
                    <img style="width:200px;text-align:center" src="{{ asset('img/LogoT02.jpg')}}">
                </div> --}}
                <br>
            </div>
            <div class="row justify-content-center">
                @foreach ($sistemas as $sistema)
                    <div class="col-md-4 col-xl-4">
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
            <div>
                <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>{{-- <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br> --}}
            </div>
        </div>
    </div>

    {{-- <div class="" style="background:linear-gradient(60deg,#165588, #011646)">
        <div class="container">
            <div>
                <br><br><br><br><br><br><br><br>
            </div>


            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">                    
                                 
                    <div class="card mt-4">
                        
                        <h4 class=" text-center mb-0 "  >
                            <br>
                            <p class="font-weight-bold">ACCEDER A:</p>                        
                        </h4>
                      
                        <div class="card-box">
                            @foreach ($sistemas as $sistema)

                                <a href=" {{route('sistema_acceder',$sistema->sistema_id)}}">

                                    <div class="media">
                                        <div class="avatar-md bg-info rounded-circle mr-2">
                                            <i class= "{{$sistema->icono}} avatar-title font-26 text-white"></i>
                                        </div>
                                        <div class="media-body align-self-center">
                                            <div class="text-right">
                                                <h4 class="font-20 my-0 font-weight-bold"><span data-plugin="counterup"> {{$sistema->nombre}} <br> </span></h4>                                    
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-4">                     
                                        <div class="progress progress-sm m-0">
                                            <div class="progress-bar bg-info" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                                            </div>
                                        </div>
                                    </div>

                                </a>
                                <br>
                            @endforeach  
                        </div>               
                       
                    </div>

                    <div>
                        <br><br><br><br><br><br><br> <br><br><br><br><br> <br><br><br><br><br><br><br><br><br><br>
                    </div>
                    
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>
    </div> --}}

@endsection
