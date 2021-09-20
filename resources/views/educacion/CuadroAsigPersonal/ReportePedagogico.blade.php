@extends('layouts.main',['activePage'=>'importacion','titlePage'=>'DIRECCIÓN REGIONAL DE EDUCACIÓN DE UCAYALI'])

@section('css')

    <script src="{{ asset('/') }}assets/libs/highcharts/highcharts.js"></script>
    <script src="{{ asset('/') }}assets/libs/highcharts/highcharts-more.js"></script>
    <script src="{{ asset('/') }}assets/libs/highcharts-modules/exporting.js"></script>
    <script src="{{ asset('/') }}assets/libs/highcharts-modules/export-data.js"></script>
    <script src="{{ asset('/') }}assets/libs/highcharts-modules/accessibility.js"></script>

@endsection 

@section('content') 
<div class="content">
    <div class="card">
        <div class="card-body">
        <div class="row">
            
            <div class="col-md-6">
                <div>
                    <h5  style="color: #427bf5;"> {{$title}} </h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered mb-0">
                        <thead>
                            <tr>                                                 
                                <th class="titulo_tabla">UNIDAD DE GESTION EDUCATIVA LOCAL</th>
                                <th class="titulo_tabla">TITULO PEDAGOCIGO</th>
                                <th class="titulo_tabla">TOTAL DOCENTES</th>
                                <th class="titulo_tabla">PORCENTAJE</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $sumaColA=0;$sumaColB=0;
                            @endphp
                        
                        @foreach ($Lista as $item)
                                
                            @php
                                $sumaColA+= $item->pedagogico; 
                                $sumaColB+= $item->total; 
                            @endphp

                            <tr>                                            
                                <td class="fila_tabla">{{$item->ugel}}</td>
                                <td class="columna_derecha fila_tabla">{{ number_format($item->pedagogico,0) }} </td>
                                <td class="columna_derecha fila_tabla">{{ number_format($item->total,0) }} </td>
                                <td class="columna_derecha fila_tabla">{{ number_format($item->porcentaje,2) }} </td>
                            </tr>

                            @endforeach

                            <tr> 
                                <td class="columna_derecha_total fila_tabla"> <b> TOTAL </b></td>
                                <td class="columna_derecha_total fila_tabla"> {{number_format($sumaColA,0)}} </td>
                                <td class="columna_derecha_total fila_tabla"> {{number_format($sumaColB,0)}} </td>
                                <td class="columna_derecha_total fila_tabla"> {{number_format($sumaColA*100/$sumaColB,2)}} </td>
                            </tr>                                              
                            
                        </tbody>
                    </table>
                </div>

                <div >
                    <div  class="col-md-12">
                        Fuente: Sistema de Administración y Control de Plazas – NEXUS        
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div id="{{$contenedor}}">       
                    @include('graficos.Circular')
                </div>
            </div> 
        </div></div>
    </div>
</div>  

               
@endsection 