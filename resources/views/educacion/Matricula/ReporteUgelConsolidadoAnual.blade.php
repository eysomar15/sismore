                    

<div class="col-md-12">  
    
    <div class="content" >
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">      
                        <div id="barra1" class="form-group row">       
                            @include('graficos.Barra')
                     
                        </div> 
                    </div> 
                </div> 
            </div> 
        </div> 
    </div> 

    <div class="card-header bg-primary py-3 text-white">
        <h5  class="card-title mb-0 text-white"> Suma de Total de estudiantes matriculados : {{$descripcion_nivel}}</h5>
    </div>                 

    <div class="table-responsive">
        
        <table class="table table-bordered mb-0" >
            <thead>
                <tr >
                    <th colspan="1"  class="titulo_tabla" >UGEL / DISTRITO</th>
                    @foreach($anioConsolidadoAnual as $indice => $elemento) 
                        <th colspan="1" class="titulo_tabla"> {{$elemento->anio}} </th>
                    @endforeach
                </tr>                          
            </thead>

            <tbody>

                @php
                    $recorre=1;
                @endphp
                
                @foreach($ugelConsolidadoAnual as $indice => $elemento)                                      
                    <tr>                                            
                        <td class="fila_tabla"><b>  {{$elemento->ugel}} </b>  </td>
                                                                    
                        @for($i=1 ; $i<=$anioConsolidadoAnual->count();$i++)  

                            <td class="columna_derecha fila_tabla">
                                {{number_format($total_matricula_ComsolidadoAnual->where('posUgel', $recorre)->where('posAnio', $i)->first()->cantidadAlumnos,0)}} 
                            </td>
                        @endfor

                        @php
                        $recorre+=1;
                        @endphp                                   

                    </tr>  
                @endforeach     
                
                <tr >
                    <th colspan="1"   class="fila_tabla" >TOTAL</th>
                    @foreach($anioConsolidadoAnual as $indice => $elemento) 
                        <th colspan="1" class="columna_derecha_total fila_tabla">{{number_format($elemento->cantidadAlumnos,0)}} </th>
                    @endforeach
                </tr>  
                
            </tbody>

        </table>
    </div>

    <br><br>

    <div class="table-responsive">
        
        <table class="table table-bordered mb-0" >
            <thead>
                <tr >
                    <th colspan="1" rowspan="2" class="titulo_tabla" >UGEL / DISTRITO </th>
                    @foreach($anioConsolidadoAnual as $indice => $elemento) 
                        <th colspan="5" class="titulo_tabla"> {{$elemento->anio}} </th>
                    @endforeach
                </tr>  
                
                <tr >
                    @foreach($anioConsolidadoAnual as $indice => $elemento) 
                        <th colspan="1"  class="titulo_tabla"> Aprob. </th>
                        <th colspan="1" class="titulo_tabla"> Retir. </th>
                        <th colspan="1" class="titulo_tabla"> Req. Recup.</th>
                        <th colspan="1" class="titulo_tabla"> Desap. </th>
                        <th colspan="1" class="titulo_tabla"> Total </th>
                    @endforeach
                </tr>
            </thead>

            <tbody>

                @php
                    $recorre=1;
                @endphp
                
                @foreach($ugelConsolidadoAnual as $indice => $elemento)                                      
                    <tr>                                            
                        <td class="fila_tabla"><b>  {{$elemento->ugel}} </b>  </td>
                                                                    
                        @for($i=1 ; $i<=$anioConsolidadoAnual->count();$i++)
                            <td class="columna_derecha fila_tabla">
                                {{number_format($total_matricula_ComsolidadoAnual->where('posUgel', $recorre)->where('posAnio', $i)->first()->cantidadAprobados,0)}} 
                            </td>
                            <td class="columna_derecha fila_tabla">
                                {{number_format($total_matricula_ComsolidadoAnual->where('posUgel', $recorre)->where('posAnio', $i)->first()->cantidadRetirados,0)}} 
                            </td>
                            <td class="columna_derecha fila_tabla">
                                {{number_format($total_matricula_ComsolidadoAnual->where('posUgel', $recorre)->where('posAnio', $i)->first()->cantidadRequieren_Recup,0)}} 
                            </td>
                            <td class="columna_derecha fila_tabla">
                                {{number_format($total_matricula_ComsolidadoAnual->where('posUgel', $recorre)->where('posAnio', $i)->first()->cantidadDesaprobados,0)}} 
                            </td>
                            <td class="columna_derecha fila_tabla">
                                {{number_format($total_matricula_ComsolidadoAnual->where('posUgel', $recorre)->where('posAnio', $i)->first()->cantidadAlumnos,0)}} 
                            </td>
                        @endfor

                        @php
                        $recorre+=1;
                        @endphp                                   

                    </tr>  
                @endforeach     
                
                <tr >
                    <th colspan="1"   class="fila_tabla" >TOTAL</th>
                    @foreach($anioConsolidadoAnual as $indice => $elemento) 
                        <th colspan="1" class="columna_derecha_total fila_tabla">{{number_format($elemento->cantidadAlumnos,0)}} </th>
                    @endforeach
                </tr>  
                
            </tbody>

        </table>

    </div>
    {{-- /fin tablas --}}







    <br><br>
    @foreach($anioConsolidadoAnual as $indice => $anio) 
    <div class="col-md-6">  
        <div class="table-responsive">
            @php
                $anioConsolidadoAnual_poranios = $anioConsolidadoAnual->where('anio', $anio->anio);
  
            @endphp     
        
            <table class="table table-bordered mb-0" >
                <thead>
                    <tr >
                        <th colspan="1" rowspan="2" class="titulo_tabla" >UGEL / DISTRITO </th>
                        @foreach($anioConsolidadoAnual_poranios as $indice => $elemento) 
                            <th colspan="5" class="titulo_tabla"> {{$elemento->anio}} </th>
                        @endforeach
                    </tr>  
                    
                    <tr >
                        @foreach($anioConsolidadoAnual_poranios as $indice => $elemento) 
                            <th colspan="1"  class="titulo_tabla"> Aprob. </th>
                            <th colspan="1" class="titulo_tabla"> Retir. </th>
                            <th colspan="1" class="titulo_tabla"> Req. Recup.</th>
                            <th colspan="1" class="titulo_tabla"> Desap. </th>
                            <th colspan="1" class="titulo_tabla"> Total </th>
                        @endforeach
                    </tr>
                </thead>
              
                <tbody>

                    @php
                        $recorre=1;
                        $aniow = $anio->anio;
                    @endphp
                    {{$aniow}}

                     
                    @foreach($ugelConsolidadoAnual as $indice => $elemento)                                      
                        <tr>                                            
                            <td class="fila_tabla"><b>  {{$elemento->ugel}} </b>  </td>
                                                
                            @for($i=1 ; $i<=$anioConsolidadoAnual_poranios->count();$i++)
                                <td class="columna_derecha fila_tabla">
                                    {{number_format($total_matricula_ComsolidadoAnual->where('anio', 2018 )->where('posUgel', $recorre)->where('posAnio', $i)->first()->cantidadAprobados,0)}} 
                                </td>
                                <td class="columna_derecha fila_tabla">
                                    {{number_format($total_matricula_ComsolidadoAnual->where('posUgel', $recorre)->where('posAnio', $i)->first()->cantidadRetirados,0)}} 
                                </td>
                                <td class="columna_derecha fila_tabla">
                                    {{number_format($total_matricula_ComsolidadoAnual->where('posUgel', $recorre)->where('posAnio', $i)->first()->cantidadRequieren_Recup,0)}} 
                                </td>
                                <td class="columna_derecha fila_tabla">
                                    {{number_format($total_matricula_ComsolidadoAnual->where('posUgel', $recorre)->where('posAnio', $i)->first()->cantidadDesaprobados,0)}} 
                                </td>
                                <td class="columna_derecha fila_tabla">
                                    {{number_format($total_matricula_ComsolidadoAnual->where('posUgel', $recorre)->where('posAnio', $i)->first()->cantidadAlumnos,0)}} 
                                </td>
                            @endfor

                            @php
                            $recorre+=1;
                            @endphp                                   

                        </tr>  
                    @endforeach     
                    
                    <tr >
                        <th colspan="1"   class="fila_tabla" >TOTAL</th>
                        @foreach($anioConsolidadoAnual as $indice => $elemento) 
                            <th colspan="1" class="columna_derecha_total fila_tabla">{{number_format($elemento->cantidadAlumnos,0)}} </th>
                        @endforeach
                    </tr>  
                    
                </tbody>

            </table>
            
        </div>
        {{-- /fin tablas --}}
    </div>
    @endforeach

</div>


                    
                   