
    <div class="col-md-6">
        <div>
            <h5  style="color: #427bf5;"> Total matrícula EBR según UGEL al {{$fecha_Matricula_texto}} </h5>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered mb-0">
                <thead>
                    <tr>                                                 
                        <th>UNIDAD DE GESTION EDUCATIVA LOCAL</th>
                        <th class="columna_derecha">TOTAL</th>
                        <th class="columna_derecha">HOMBRE</th>
                        <th class="columna_derecha">MUJER</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $sunHombre=0;                                            
                        $sumMujer=0
                    @endphp
                
                @foreach ($lista_total_matricula_EBR as $item)
                        
                    @php
                        $sunHombre+= $item->hombres;                                           
                        $sumMujer+= $item->mujeres
                    @endphp

                    <tr>                                            
                    <td>{{$item->nombre}}</td>
                    <td class="columna_derecha">{{ number_format($item->hombres + $item->mujeres,0) }} </td>
                    <td class="columna_derecha">{{number_format($item->hombres,0)}}</td>
                    <td class="columna_derecha">{{number_format($item->mujeres,0)}}</td>
                    </tr>

                    @endforeach

                    <tr> 
                    <td> <b> TOTAL </b></td>
                    <td class="columna_derecha_total"> {{number_format($sunHombre + $sumMujer,0)}} </td>
                    <td class="columna_derecha_total"> {{number_format($sunHombre,0)}} </td>
                    <td class="columna_derecha_total"> {{number_format($sumMujer,0)}}  </td>
                    </tr>                                              
                    
                </tbody>
            </table>
        </div>

        <div >
            <div  class="col-md-6">
                Fuente: SIAGIE- MINEDU          
            </div>
        </div>

    </div>
        
    <div class="col-md-6">
        <div id="{{$contenedor}}">       
            @include('graficos.Circular')
        </div>
    </div> 


<br><br><br>
<div class="col-md-12">
    <div>
        <br><br> <h5  style="color: #427bf5;"> Total matrícula nivel INICIAL por Ciclo, Edad  y Sexo según UGEL al {{$fecha_Matricula_texto}} </h5>
    </div>

  
    <div class="table-responsive">
        <table class="table table-bordered mb-0" >
            <thead>
                <tr>
                    <th colspan="1" rowspan="4" class="columna_inherit">UNIDAD DE GESTION EDUCATIVA LOCAL</th>
                    <th colspan="3" class="columna_centro">TOTAL</th>
                    <th colspan="12" class="columna_centro">MATRICULA POR EDAD Y SEXO</th>
                </tr>

                <tr> 
                    <th class="columna_derecha" rowspan="3" >TOTAL</th>
                    <th class="columna_derecha" rowspan="3">HOMBRE</th>
                    <th class="columna_derecha" rowspan="3">MUJER</th>
                    <th class="columna_centro" colspan="6" style="color: #9c9205;">CICLO I</th>
                    <th class="columna_centro" colspan="6" style="color: #039717;">CICLO II</th>                                     

                </tr>

                <tr> 
                    
                    <th class="columna_centro" colspan="2" style="color: #9c9205;"> 0</th>
                    <th class="columna_centro" colspan="2" style="color: #9c9205;"> 1</th>
                    <th class="columna_centro" colspan="2" style="color: #9c9205;"> 2</th>
                    <th class="columna_centro" colspan="2" style="color: #039717;"> 3</th>
                    <th class="columna_centro" colspan="2" style="color: #039717;"> 4</th>
                    <th class="columna_centro" colspan="2" style="color: #039717;"> 5</th>
                    

                </tr>

                <tr>                   
                    <th class="columna_centro">H</th>
                    <th class="columna_centro">M</th>
                    <th class="columna_centro">H</th>
                    <th class="columna_centro">M</th>
                    <th class="columna_centro">H</th>
                    <th class="columna_centro">M</th>
                    <th class="columna_centro">H</th>
                    <th class="columna_centro">M</th>
                    <th class="columna_centro">H</th>
                    <th class="columna_centro">M</th>
                    <th class="columna_centro">H</th>
                    <th class="columna_centro">M</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $sunHombre=0; $sumMujer=0; $sum_primer_nivel_hombre=0; $sum_primer_nivel_mujer=0;
                    $sum_segundo_nivel_hombre=0; $sum_segundo_nivel_mujer=0;$sum_tercero_nivel_hombre=0; 
                    $sum_tercero_nivel_mujer=0; $sum_cuarto_nivel_hombre=0;$sum_cuarto_nivel_mujer=0;
                    $sum_quinto_nivel_hombre=0; $sum_quinto_nivel_mujer=0;$sum_cero_nivel_hombre=0;$sum_cero_nivel_mujer=0;
                @endphp
            
            @foreach ($lista_total_matricula_Inicial as $item)
                    
                @php
                    $sunHombre+= $item->hombres;
                    $sumMujer+= $item->mujeres;
                    $sum_primer_nivel_hombre+= $item->primer_nivel_hombre; 
                    $sum_primer_nivel_mujer+= $item->primer_nivel_mujer;
                    $sum_segundo_nivel_hombre+= $item->segundo_nivel_hombre;
                    $sum_segundo_nivel_mujer+=$item->segundo_nivel_mujer;
                    $sum_tercero_nivel_hombre+=$item->tercero_nivel_hombre;
                    $sum_tercero_nivel_mujer+=$item->tercero_nivel_mujer;

                    $sum_cuarto_nivel_hombre+= $item->cuarto_nivel_hombre;
                    $sum_cuarto_nivel_mujer+= $item->cuarto_nivel_mujer;
                    $sum_quinto_nivel_hombre+=$item->quinto_nivel_hombre;
                    $sum_quinto_nivel_mujer+=$item->quinto_nivel_mujer;
                    $sum_cero_nivel_hombre+=$item->cero_nivel_hombre;
                    $sum_cero_nivel_mujer+= $item->cero_nivel_mujer;
                @endphp

                <tr>                                            
                    <td>{{$item->nombre}}</td>
                    <td class="columna_derecha">{{ number_format($item->hombres + $item->mujeres,0) }} </td>
                    <td class="columna_derecha">{{number_format($item->hombres,0)}}</td>
                    <td class="columna_derecha">{{number_format($item->mujeres,0)}}</td>

                    <td class="columna_derecha">{{number_format($item->cero_nivel_hombre,0)}}</td>
                    <td class="columna_derecha">{{number_format($item->cero_nivel_mujer,0)}}</td>
                    <td class="columna_derecha">{{number_format($item->primer_nivel_hombre,0)}}</td>
                    <td class="columna_derecha">{{number_format($item->primer_nivel_mujer,0)}}</td> 
                    <td class="columna_derecha">{{number_format($item->segundo_nivel_hombre,0)}}</td>
                    <td class="columna_derecha">{{number_format($item->segundo_nivel_mujer,0)}}</td>
                    <td class="columna_derecha">{{number_format($item->tercero_nivel_hombre,0)}}</td>
                    <td class="columna_derecha">{{number_format($item->tercero_nivel_mujer,0)}}</td>
                    <td class="columna_derecha">{{number_format($item->cuarto_nivel_hombre,0)}}</td>
                    <td class="columna_derecha">{{number_format($item->cuarto_nivel_mujer,0)}}</td>
                    <td class="columna_derecha">{{number_format($item->quinto_nivel_hombre,0)}}</td>
                    <td class="columna_derecha">{{number_format($item->quinto_nivel_mujer,0)}}</td>

                    
                </tr>

                @endforeach
                
                <tr> 
                    <td> <b> TOTAL </b></td>
                    <td class="columna_derecha_total"> {{number_format($sunHombre + $sumMujer,0)}} </td>
                    <td class="columna_derecha_total"> {{number_format($sunHombre,0)}} </td>
                    <td class="columna_derecha_total"> {{number_format($sumMujer,0)}}  </td>

                    <td class="columna_derecha_total"> {{number_format($sum_cero_nivel_hombre,0)}}  </td>  
                    <td class="columna_derecha_total"> {{number_format($sum_cero_nivel_mujer,0)}}  </td> 
                    <td class="columna_derecha_total"> {{number_format($sum_primer_nivel_hombre,0)}}  </td>
                    <td class="columna_derecha_total"> {{number_format($sum_primer_nivel_mujer,0)}}  </td>
                    <td class="columna_derecha_total"> {{number_format($sum_segundo_nivel_hombre,0)}}  </td> 
                    <td class="columna_derecha_total"> {{number_format($sum_segundo_nivel_mujer,0)}}  </td>
                    <td class="columna_derecha_total"> {{number_format($sum_tercero_nivel_hombre,0)}}  </td>
                    <td class="columna_derecha_total"> {{number_format($sum_tercero_nivel_mujer,0)}}  </td> 

                    <td class="columna_derecha_total"> {{number_format($sum_cuarto_nivel_hombre,0)}}  </td> 
                    <td class="columna_derecha_total"> {{number_format($sum_cuarto_nivel_mujer,0)}}  </td>
                    <td class="columna_derecha_total"> {{number_format($sum_quinto_nivel_hombre,0)}}  </td>
                    <td class="columna_derecha_total"> {{number_format($sum_quinto_nivel_mujer,0)}}  </td> 

                </tr>                                              
                
            </tbody>
        </table>
    </div>

    <div class="form-group row">
        <div  class="col-md-6">
            Fuente: SIAGIE- MINEDU          
        </div>

        <div  class="col-md-6" style="text-align: right">
            H: Hombre / M: Mujer   
        </div>
    </div>
     
</div>


<div class="col-md-12">
    <div>
        <br><br> <h5  style="color: #427bf5;"> Total matrícula nivel PRIMARIA por grado y sexo según UGEL al {{$fecha_Matricula_texto}} </h5>
    </div>

  
    <div class="table-responsive">
        <table class="table table-bordered mb-0">
            <thead>
                <tr>
                    <th colspan="1" rowspan="3" class="columna_inherit">UNIDAD DE GESTION EDUCATIVA LOCAL</th>
                    <th colspan="3" class="columna_centro">TOTAL</th>
                    <th colspan="12" class="columna_centro">MATRICULA POR GRADO Y SEXO</th>
                </tr>
                <tr> 
                    <th class="columna_derecha" rowspan="2" >TOTAL</th>
                    <th class="columna_derecha" rowspan="2">HOMBRE</th>
                    <th class="columna_derecha" rowspan="2">MUJER</th>
                    <th class="columna_centro" colspan="2"> 1°</th>
                    <th class="columna_centro" colspan="2"> 2°</th>
                    <th class="columna_centro" colspan="2"> 3°</th>
                    <th class="columna_centro" colspan="2"> 4°</th>
                    <th class="columna_centro" colspan="2"> 5°</th>
                    <th class="columna_centro" colspan="2"> 6°</th>

                </tr>

                <tr>                   
                    <th class="columna_centro">H</th>
                    <th class="columna_centro">M</th>
                    <th class="columna_centro">H</th>
                    <th class="columna_centro">M</th>
                    <th class="columna_centro">H</th>
                    <th class="columna_centro">M</th>
                    <th class="columna_centro">H</th>
                    <th class="columna_centro">M</th>
                    <th class="columna_centro">H</th>
                    <th class="columna_centro">M</th>
                    <th class="columna_centro">H</th>
                    <th class="columna_centro">M</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $sunHombre=0; $sumMujer=0; $sum_primer_nivel_hombre=0; $sum_primer_nivel_mujer=0;
                    $sum_segundo_nivel_hombre=0; $sum_segundo_nivel_mujer=0;$sum_tercero_nivel_hombre=0; 
                    $sum_tercero_nivel_mujer=0; $sum_cuarto_nivel_hombre=0;$sum_cuarto_nivel_mujer=0;
                    $sum_quinto_nivel_hombre=0; $sum_quinto_nivel_mujer=0;$sum_sexto_nivel_hombre=0;$sum_sexto_nivel_mujer=0;
                @endphp
            
            @foreach ($lista_total_matricula_Primaria as $item)
                    
                @php
                    $sunHombre+= $item->hombres;
                    $sumMujer+= $item->mujeres;
                    $sum_primer_nivel_hombre+= $item->primer_nivel_hombre; 
                    $sum_primer_nivel_mujer+= $item->primer_nivel_mujer;
                    $sum_segundo_nivel_hombre+= $item->segundo_nivel_hombre;
                    $sum_segundo_nivel_mujer+=$item->segundo_nivel_mujer;
                    $sum_tercero_nivel_hombre+=$item->tercero_nivel_hombre;
                    $sum_tercero_nivel_mujer+=$item->tercero_nivel_mujer;

                    $sum_cuarto_nivel_hombre+= $item->cuarto_nivel_hombre;
                    $sum_cuarto_nivel_mujer+= $item->cuarto_nivel_mujer;
                    $sum_quinto_nivel_hombre+=$item->quinto_nivel_hombre;
                    $sum_quinto_nivel_mujer+=$item->quinto_nivel_mujer;
                    $sum_sexto_nivel_hombre+=$item->sexto_nivel_hombre;
                    $sum_sexto_nivel_mujer+= $item->sexto_nivel_mujer;
                @endphp

                <tr>                                            
                    <td>{{$item->nombre}}</td>
                    <td class="columna_derecha">{{ number_format($item->hombres + $item->mujeres,0) }} </td>
                    <td class="columna_derecha">{{number_format($item->hombres,0)}}</td>
                    <td class="columna_derecha">{{number_format($item->mujeres,0)}}</td>
                    <td class="columna_derecha">{{number_format($item->primer_nivel_hombre,0)}}</td>
                    <td class="columna_derecha">{{number_format($item->primer_nivel_mujer,0)}}</td> 
                    <td class="columna_derecha">{{number_format($item->segundo_nivel_hombre,0)}}</td>
                    <td class="columna_derecha">{{number_format($item->segundo_nivel_mujer,0)}}</td>
                    <td class="columna_derecha">{{number_format($item->tercero_nivel_hombre,0)}}</td>
                    <td class="columna_derecha">{{number_format($item->tercero_nivel_mujer,0)}}</td>
                    <td class="columna_derecha">{{number_format($item->cuarto_nivel_hombre,0)}}</td>
                    <td class="columna_derecha">{{number_format($item->cuarto_nivel_mujer,0)}}</td>
                    <td class="columna_derecha">{{number_format($item->quinto_nivel_hombre,0)}}</td>
                    <td class="columna_derecha">{{number_format($item->quinto_nivel_mujer,0)}}</td>

                    <td class="columna_derecha">{{number_format($item->sexto_nivel_hombre,0)}}</td>
                    <td class="columna_derecha">{{number_format($item->sexto_nivel_mujer,0)}}</td>
                </tr>

                @endforeach
                
                <tr> 
                    <td> <b> TOTAL </b></td>
                    <td class="columna_derecha_total"> {{number_format($sunHombre + $sumMujer,0)}} </td>
                    <td class="columna_derecha_total"> {{number_format($sunHombre,0)}} </td>
                    <td class="columna_derecha_total"> {{number_format($sumMujer,0)}}  </td>
                    <td class="columna_derecha_total"> {{number_format($sum_primer_nivel_hombre,0)}}  </td>
                    <td class="columna_derecha_total"> {{number_format($sum_primer_nivel_mujer,0)}}  </td>
                    <td class="columna_derecha_total"> {{number_format($sum_segundo_nivel_hombre,0)}}  </td> 
                    <td class="columna_derecha_total"> {{number_format($sum_segundo_nivel_mujer,0)}}  </td>
                    <td class="columna_derecha_total"> {{number_format($sum_tercero_nivel_hombre,0)}}  </td>
                    <td class="columna_derecha_total"> {{number_format($sum_tercero_nivel_mujer,0)}}  </td> 

                    <td class="columna_derecha_total"> {{number_format($sum_cuarto_nivel_hombre,0)}}  </td> 
                    <td class="columna_derecha_total"> {{number_format($sum_cuarto_nivel_mujer,0)}}  </td>
                    <td class="columna_derecha_total"> {{number_format($sum_quinto_nivel_hombre,0)}}  </td>
                    <td class="columna_derecha_total"> {{number_format($sum_quinto_nivel_mujer,0)}}  </td>  

                    <td class="columna_derecha_total"> {{number_format($sum_sexto_nivel_hombre,0)}}  </td>  
                    <td class="columna_derecha_total"> {{number_format($sum_sexto_nivel_mujer,0)}}  </td>                    

                </tr>                                              
                
            </tbody>
        </table>
    </div>

    <div class="form-group row">
        <div  class="col-md-6">
            Fuente: SIAGIE- MINEDU          
        </div>

        <div  class="col-md-6" style="text-align: right">
            H: Hombre / M: Mujer   
        </div>
    </div>
     
</div>


<div class="col-md-12">
    <div>
        <br><br><h5  style="color: #427bf5;"> Total matrícula nivel SECUNDARIA por grado y sexo según UGEL al {{$fecha_Matricula_texto}} </h5>
    </div>

  
    <div class="table-responsive">
        <table class="table table-bordered mb-0">
            <thead>
                <tr>
                    <th colspan="1" rowspan="3" class="columna_inherit">UNIDAD DE GESTION EDUCATIVA LOCAL</th>
                    <th colspan="3" class="columna_centro">TOTAL</th>
                    <th colspan="10" class="columna_centro">MATRICULA POR GRADO Y SEXO</th>
                </tr>
                <tr> 
                    <th class="columna_derecha" rowspan="2" >TOTAL</th>
                    <th class="columna_derecha" rowspan="2">HOMBRE</th>
                    <th class="columna_derecha" rowspan="2">MUJER</th>
                    <th class="columna_centro" colspan="2"> 1°</th>
                    <th class="columna_centro" colspan="2"> 2°</th>
                    <th class="columna_centro" colspan="2"> 3°</th>
                    <th class="columna_centro" colspan="2"> 4°</th>
                    <th class="columna_centro" colspan="2"> 5°</th>

                </tr>

                <tr>                   
                    <th class="columna_centro">H</th>
                    <th class="columna_centro">M</th>
                    <th class="columna_centro">H</th>
                    <th class="columna_centro">M</th>
                    <th class="columna_centro">H</th>
                    <th class="columna_centro">M</th>
                    <th class="columna_centro">H</th>
                    <th class="columna_centro">M</th>
                    <th class="columna_centro">H</th>
                    <th class="columna_centro">M</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $sunHombre=0; $sumMujer=0; $sum_primer_nivel_hombre=0; $sum_primer_nivel_mujer=0;
                    $sum_segundo_nivel_hombre=0; $sum_segundo_nivel_mujer=0;$sum_tercero_nivel_hombre=0; 
                    $sum_tercero_nivel_mujer=0; $sum_cuarto_nivel_hombre=0;$sum_cuarto_nivel_mujer=0;
                    $sum_quinto_nivel_hombre=0; $sum_quinto_nivel_mujer=0;
                @endphp
            
            @foreach ($lista_total_matricula_Secundaria as $item)
                    
                @php
                    $sunHombre+= $item->hombres;
                    $sumMujer+= $item->mujeres;
                    $sum_primer_nivel_hombre+= $item->primer_nivel_hombre; 
                    $sum_primer_nivel_mujer+= $item->primer_nivel_mujer;
                    $sum_segundo_nivel_hombre+= $item->segundo_nivel_hombre;
                    $sum_segundo_nivel_mujer+=$item->segundo_nivel_mujer;
                    $sum_tercero_nivel_hombre+=$item->tercero_nivel_hombre;
                    $sum_tercero_nivel_mujer+=$item->tercero_nivel_mujer;

                    $sum_cuarto_nivel_hombre+= $item->cuarto_nivel_hombre;
                    $sum_cuarto_nivel_mujer+= $item->cuarto_nivel_mujer;
                    $sum_quinto_nivel_hombre+=$item->quinto_nivel_hombre;
                    $sum_quinto_nivel_mujer+=$item->quinto_nivel_mujer;
                @endphp

                <tr>                                            
                    <td>{{$item->nombre}}</td>
                    <td class="columna_derecha">{{ number_format($item->hombres + $item->mujeres,0) }} </td>
                    <td class="columna_derecha">{{number_format($item->hombres,0)}}</td>
                    <td class="columna_derecha">{{number_format($item->mujeres,0)}}</td>
                    <td class="columna_derecha">{{number_format($item->primer_nivel_hombre,0)}}</td>
                    <td class="columna_derecha">{{number_format($item->primer_nivel_mujer,0)}}</td> 
                    <td class="columna_derecha">{{number_format($item->segundo_nivel_hombre,0)}}</td>
                    <td class="columna_derecha">{{number_format($item->segundo_nivel_mujer,0)}}</td>
                    <td class="columna_derecha">{{number_format($item->tercero_nivel_hombre,0)}}</td>
                    <td class="columna_derecha">{{number_format($item->tercero_nivel_mujer,0)}}</td>
                    <td class="columna_derecha">{{number_format($item->cuarto_nivel_hombre,0)}}</td>
                    <td class="columna_derecha">{{number_format($item->cuarto_nivel_mujer,0)}}</td>
                    <td class="columna_derecha">{{number_format($item->quinto_nivel_hombre,0)}}</td>
                    <td class="columna_derecha">{{number_format($item->quinto_nivel_mujer,0)}}</td>
                </tr>

                @endforeach
                
                <tr> 
                    <td> <b> TOTAL </b></td>
                    <td class="columna_derecha_total"> {{number_format($sunHombre + $sumMujer,0)}} </td>
                    <td class="columna_derecha_total"> {{number_format($sunHombre,0)}} </td>
                    <td class="columna_derecha_total"> {{number_format($sumMujer,0)}}  </td>
                    <td class="columna_derecha_total"> {{number_format($sum_primer_nivel_hombre,0)}}  </td>
                    <td class="columna_derecha_total"> {{number_format($sum_primer_nivel_mujer,0)}}  </td>
                    <td class="columna_derecha_total"> {{number_format($sum_segundo_nivel_hombre,0)}}  </td> 
                    <td class="columna_derecha_total"> {{number_format($sum_segundo_nivel_mujer,0)}}  </td>
                    <td class="columna_derecha_total"> {{number_format($sum_tercero_nivel_hombre,0)}}  </td>
                    <td class="columna_derecha_total"> {{number_format($sum_tercero_nivel_mujer,0)}}  </td> 

                    <td class="columna_derecha_total"> {{number_format($sum_cuarto_nivel_hombre,0)}}  </td> 
                    <td class="columna_derecha_total"> {{number_format($sum_cuarto_nivel_mujer,0)}}  </td>
                    <td class="columna_derecha_total"> {{number_format($sum_quinto_nivel_hombre,0)}}  </td>
                    <td class="columna_derecha_total"> {{number_format($sum_quinto_nivel_mujer,0)}}  </td>                     

                </tr>                                              
                
            </tbody>
        </table>
    </div>

    <div class="form-group row">
        <div  class="col-md-6">
            Fuente: SIAGIE- MINEDU          
        </div>

        <div  class="col-md-6" style="text-align: right">
            H: Hombre / M: Mujer   
        </div>
    </div>
     
</div>