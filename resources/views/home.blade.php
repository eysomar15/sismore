@extends('layouts.main',['titlePage'=>'Bienvenido al SISMORE - Ucayali'])

@section('content')


    @if (session('sistema_id')==1)
        @include('inicioEducacion')   
    @else
        <h5>otros sistemas</h5>
    @endif
        
   

@endsection

