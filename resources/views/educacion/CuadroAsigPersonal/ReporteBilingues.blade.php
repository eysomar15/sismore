@extends('layouts.main',['activePage'=>'importacion','titlePage'=>'DIRECCIÓN REGIONAL DE EDUCACIÓN DE UCAYALI'])


@section('content') 

   <div class="col-md-6">
    <div>
        <h5  style="color: #427bf5;"> {{$title}} </h5>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered mb-0">
            <thead>
                <tr>                                                 
                    <th class="titulo_tabla">NIVEL EDUCATIVO</th>
                    <th class="titulo_tabla">DOCENTES BILINGUES</th>
                    <th class="titulo_tabla">TOTAL DOCENTES</th>
                    <th class="titulo_tabla">PORCENTAJE</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $sumaColA=0;$sumaColB=0;
                @endphp
            
                @foreach ($dataCabecera as $itemCab)

                <tr>                                            
                            <td class="fila_tabla"><b>{{$itemCab->ugel}}</b></td>
                            <td class="columna_derecha_total fila_tabla">{{ number_format($itemCab->Bilingue,0) }} </td>
                            <td class="columna_derecha_total fila_tabla">{{ number_format($itemCab->total,0) }} </td>
                            <td class="columna_derecha_total fila_tabla">{{ number_format($itemCab->porcentaje,2) }} </td>
                </tr>

                    @foreach ($data as $item)

                        @if ($itemCab->ugel==$item->ugel)
                        @php
                            $sumaColA+= $item->Bilingue; 
                            $sumaColB+= $item->total; 
                        @endphp

                        <tr>                                            
                            <td class="fila_tabla">{{$item->nivel_educativo}}</td>
                            <td class="columna_derecha fila_tabla">{{ number_format($item->Bilingue,0) }} </td>
                            <td class="columna_derecha fila_tabla">{{ number_format($item->total,0) }} </td>
                            <td class="columna_derecha fila_tabla">{{ number_format($item->porcentaje,2) }} </td>
                        </tr>

                        @endif

                    @endforeach
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

@endsection 