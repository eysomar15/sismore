<div class="col-md-6">
    <div class="card-header bg-primary py-3 text-white">
        <h5  class="card-title mb-0 text-white"> INSTITUCIONES EDUCATIVAS </h5>
    </div>
    <div class="table-responsive">
        <table style="width: 100%;  "  border="1px solid #000"  >
            <thead>
                <tr>                                                 

                    <th class="titulo_tabla">DISTRITO</th>
                    <th class="titulo_tabla">ACTIVAS</th>
                    <th class="titulo_tabla">INACTIVAS</th>
                    <th class="titulo_tabla">TOTAL</th>
                </tr>
            </thead>

            {{-- {{$sumatoria_Provincia}} --}}
            <tbody>
               {{$lista_resumen_porDistrito}}

               <h1>
                   sssss
               </h1>

               {{$sumatoria_Provincia}}

              

               {{--  --}}

               
                @foreach ($sumatoria_Provincia as $item)

                    <tr>     
                        <td class="fila_tabla"><b>1</b>  </td>
                        <td class="fila_tabla"><b>1</b>  </td>
                        <td class="fila_tabla"><b>1</b>  </td>
                        <td class="fila_tabla"><b>1</b>  </td>
                        
                                                               
                        {{-- <td class="fila_tabla"><b> {{$item->provincia}} </b>  </td>
                    
                        <td class="columna_derecha_total fila_tabla">{{number_format($item->suma_activas,0)}}</td>
                        <td class="columna_derecha_total fila_tabla">{{number_format($item->suma_inactivas,0)}}</td>  
                        <td class="columna_derecha_total fila_tabla">{{number_format($item->suma_inactivas,0)}}</td>             --}}
                   </tr>

                    @foreach ($lista_resumen_porDistrito as $item2)
                        
                        @php
                            // $sunHombre+= $item->hombres;                                           
                            // $sumMujer+= $item->mujeres
                        @endphp

                        <tr>                                            
    
                            <td class="fila_tabla">{{$item2->distrito}}</td>

                            <td class="columna_derecha fila_tabla">{{ number_format($item2->activas,0) }} </td>
                            <td class="columna_derecha fila_tabla">{{number_format($item2->inactivas,0)}}</td>
                            <td class="columna_derecha fila_tabla">{{number_format($item2->total,0)}}</td>
                        </tr>

                    @endforeach
                @endforeach

                {{-- <tr> 
                <td> <b> TOTAL </b></td>
                    <td class="columna_derecha_total"> {{number_format($sunHombre + $sumMujer,0)}} </td>
                    <td class="columna_derecha_total"> {{number_format($sunHombre,0)}} </td>
                    <td class="columna_derecha_total"> {{number_format($sumMujer,0)}}  </td>
                </tr>                                               --}}
                
            </tbody>
        </table>
    </div>

    <div >
        <div  class="col-md-6">
            Fuente: PADRON WEB - ESCALE         
        </div>
    </div>

</div>

{{-- <div class="col-md-6">
    <div id="{{$contenedor}}">       
        @include('graficos.Circular')
    </div>
</div> --}}

