@extends('layouts.main',['titlePage'=>'Indicadores de la Actividad Estratégico Institucional'])

@section('content')
<div class="content">

   
    <div class="container-fluid">
     <!--Widget-4 -->
     <h5>Porcentaje de docentes de EBR, del nivel primario, que cuentan con título pedagógico</h5><br>
        <div class="row">
            
            <div class="col-md-6 col-xl-3">
               
                <div class="card-box">
                    {{-- <h5>NIVEL PRIMARIO </h5> --}}
                    <div class="media">
                        <div class="avatar-md bg-info rounded-circle mr-2">
                            <i class=" ion-ios-people avatar-title font-26 text-white"></i>
                        </div>
                        
                        <div class="media-body align-self-center">
                            <div class="text-right">
                                <h4 class="font-20 my-0 font-weight-bold"><span data-plugin="counterup">{{$titulados_inicial}} </span></h4>
                                <p class="mb-0 mt-1 text-truncate">Docentes Titulados Pedagógico </p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <h4 > Porcentaje <span class="float-right">{{$porcentajeTitulados_inicial}}%</span></h4>
                        <div class="progress progress-sm m-0">
                            <div class="progress-bar bg-info" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" 
                            style="width: {{$porcentajeTitulados_inicial}}%">
                                {{-- <span class="sr-only">60% Complete</span> --}}
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end card-box-->
            </div>

   
        <!-- end row -->


      
    </div>
    
     
    <div class="container-fluid">
        <!--Widget-4 -->
       
           <h5>Número de docentes bilingües</h5><br>
           <div class="row">
               
               <div class="col-md-6 col-xl-3">
                  
                   <div class="card-box">
                       {{-- <h5>NIVEL PRIMARIO </h5> --}}
                       <div class="media">
                           <div class="avatar-md bg-info rounded-circle mr-2">
                               <i class=" ion-ios-people avatar-title font-26 text-white"></i>
                           </div>
                           
                           <div class="media-body align-self-center">
                               <div class="text-right">
                                   <h4 class="font-20 my-0 font-weight-bold"><span data-plugin="counterup">{{$bilingues}} </span></h4>
                                   <p class="mb-0 mt-1 text-truncate">Docentes bilingües </p>
                               </div>
                           </div>
                       </div>
                       
                   </div>
                   <!-- end card-box-->
               </div>
           
   
            
           </div>
           <!-- end row -->
   
   
         
       </div>
@endsection

@section('js')
 <!-- flot chart -->
        <script src="{{asset('/')}}assets/libs/flot-charts/jquery.flot.js"></script>
        <script src="{{asset('/')}}assets/libs/flot-charts/jquery.flot.time.js"></script>
        <script src="{{asset('/')}}assets/libs/flot-charts/jquery.flot.tooltip.min.js"></script>
        
        {{-- este scrip genera conflicto con el <script src="assets/js/pages/dashboard.init.js"></script> --}}
        {{-- <script src="assets/libs/flot-charts/jquery.flot.resize.js"></script> --}}
        
        
        <script src="{{asset('/')}}assets/libs/flot-charts/jquery.flot.pie.js"></script>
        <script src="{{asset('/')}}assets/libs/flot-charts/jquery.flot.selection.js"></script>
        <script src="{{asset('/')}}assets/libs/flot-charts/jquery.flot.stack.js"></script>
        <script src="{{asset('/')}}assets/libs/flot-charts/jquery.flot.crosshair.js"></script> 

        <!-- Dashboard init JS -->
        <script src="{{asset('/')}}assets/js/pages/dashboard.init.js"></script>
@endsection