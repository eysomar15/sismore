@extends('layouts.main',['titlePage'=>'Bienvenido al SISMORE - Ucayali'])

@section('content')


    @if (session('sistema_id') == 1)
        @include('inicioEducacion')
    @elseif (session('sistema_id')==4)
        @include('inicioAdministrador')
    @else
        <h5>.....</h5>
    @endif



@endsection
