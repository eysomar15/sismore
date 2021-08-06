@extends('layouts.main',['titlePage'=>'Bienvenido al SISMORE - Ucayali'])

@section('content')
    @if (session('sistema_id')==1)
    @include('inicioEducacion')   
    @else
    <h5>No hay nada</h5>
    @endif
        
@endsection

@section('js')
 <!-- flot chart -->
        {{--<script src="{{asset('/')}}assets/libs/flot-charts/jquery.flot.js"></script>
        <script src="{{asset('/')}}assets/libs/flot-charts/jquery.flot.time.js"></script>
        <script src="{{asset('/')}}assets/libs/flot-charts/jquery.flot.tooltip.min.js"></script>
        
        {{-- este scrip genera conflicto con el <script src="assets/js/pages/dashboard.init.js"></script> --}}
        {{-- <script src="assets/libs/flot-charts/jquery.flot.resize.js"></script> --}}
        
        
        {{--<script src="{{asset('/')}}assets/libs/flot-charts/jquery.flot.pie.js"></script>
        <script src="{{asset('/')}}assets/libs/flot-charts/jquery.flot.selection.js"></script>
        <script src="{{asset('/')}}assets/libs/flot-charts/jquery.flot.stack.js"></script>
        <script src="{{asset('/')}}assets/libs/flot-charts/jquery.flot.crosshair.js"></script> --}}

        <!-- Dashboard init JS -->
        {{--<script src="{{asset('/')}}assets/js/pages/dashboard.init.js"></script> --}}
@endsection