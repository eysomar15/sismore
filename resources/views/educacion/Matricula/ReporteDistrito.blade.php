

<div class="col-md-12">
 <div>
     <h5 style="color: #427bf5;"> Total matrícula nivel INICIAL por Ciclo, Edad  y Sexo según Distrito al fecha_Matricula_texto}} </h5>
 </div>


 <div class="table-responsive">
  {{-- class="table table-striped mb-0" --}}
     <table style="width: 100%;  "  border="1px solid #000"  >
         <thead>
             <tr >
                 <th  colspan="1" rowspan="4" class="columna_inherit filita titulo_tabla" >DISTRITO</th>
                 <th colspan="3" class="titulo_tabla">TOTAL</th>
                 <th colspan="12" class="titulo_tabla">MATRICULA POR EDAD Y SEXO</th>
             </tr>

             <tr> 
                 <th class="titulo_tabla" rowspan="3" >TOTAL</th>
                 <th class="titulo_tabla" rowspan="3">HOMBRE</th>
                 <th class="titulo_tabla" rowspan="3">MUJER</th>
                 <th class="titulo_tabla" colspan="6" >CICLO I</th>
                 <th class="titulo_tabla" colspan="6" >CICLO II</th>                                   

             </tr>

             <tr> 
                 
                 <th class="titulo_tabla" colspan="2" > 0</th>
                 <th class="titulo_tabla" colspan="2" > 1</th>
                 <th class="titulo_tabla" colspan="2" > 2</th>
                 <th class="titulo_tabla" colspan="2" > 3</th>
                 <th class="titulo_tabla" colspan="2" > 4</th>
                 <th class="titulo_tabla" colspan="2" > 5</th>                 

             </tr>

             <tr>                   
                 <th class="titulo_tabla">H</th>
                 <th class="titulo_tabla">M</th>
                 <th class="titulo_tabla">H</th>
                 <th class="titulo_tabla">M</th>
                 <th class="titulo_tabla">H</th>
                 <th class="titulo_tabla">M</th>
                 <th class="titulo_tabla">H</th>
                 <th class="titulo_tabla">M</th>
                 <th class="titulo_tabla">H</th>
                 <th class="titulo_tabla">M</th>
                 <th class="titulo_tabla">H</th>
                 <th class="titulo_tabla">M</th>
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
                 <td class="fila_tabla">{{$item->provincia}} - {{$item->distrito}}</td>
                 <td class="columna_derecha fila_tabla">{{ number_format($item->hombres + $item->mujeres,0) }} </td>
                 <td class="columna_derecha fila_tabla">{{number_format($item->hombres,0)}}</td>
                 <td class="columna_derecha fila_tabla">{{number_format($item->mujeres,0)}}</td>

                 <td class="columna_derecha fila_tabla">{{number_format($item->cero_nivel_hombre,0)}}</td>
                 <td class="columna_derecha fila_tabla">{{number_format($item->cero_nivel_mujer,0)}}</td>
                 <td class="columna_derecha fila_tabla">{{number_format($item->primer_nivel_hombre,0)}}</td>
                 <td class="columna_derecha fila_tabla">{{number_format($item->primer_nivel_mujer,0)}}</td> 
                 <td class="columna_derecha fila_tabla">{{number_format($item->segundo_nivel_hombre,0)}}</td>
                 <td class="columna_derecha fila_tabla">{{number_format($item->segundo_nivel_mujer,0)}}</td>
                 <td class="columna_derecha fila_tabla">{{number_format($item->tercero_nivel_hombre,0)}}</td>
                 <td class="columna_derecha fila_tabla">{{number_format($item->tercero_nivel_mujer,0)}}</td>
                 <td class="columna_derecha fila_tabla">{{number_format($item->cuarto_nivel_hombre,0)}}</td>
                 <td class="columna_derecha fila_tabla">{{number_format($item->cuarto_nivel_mujer,0)}}</td>
                 <td class="columna_derecha fila_tabla">{{number_format($item->quinto_nivel_hombre,0)}}</td>
                 <td class="columna_derecha fila_tabla">{{number_format($item->quinto_nivel_mujer,0)}}</td>

                 
             </tr>

             @endforeach
             
             <tr> 
                 <td class="fila_tabla"> <b> TOTAL </b></td>
                 <td class="columna_derecha_total fila_tabla"> {{number_format($sunHombre + $sumMujer,0)}} </td>
                 <td class="columna_derecha_total fila_tabla"> {{number_format($sunHombre,0)}} </td>
                 <td class="columna_derecha_total fila_tabla"> {{number_format($sumMujer,0)}}  </td>

                 <td class="columna_derecha_total fila_tabla"> {{number_format($sum_cero_nivel_hombre,0)}}  </td>  
                 <td class="columna_derecha_total fila_tabla"> {{number_format($sum_cero_nivel_mujer,0)}}  </td> 
                 <td class="columna_derecha_total fila_tabla"> {{number_format($sum_primer_nivel_hombre,0)}}  </td>
                 <td class="columna_derecha_total fila_tabla"> {{number_format($sum_primer_nivel_mujer,0)}}  </td>
                 <td class="columna_derecha_total fila_tabla"> {{number_format($sum_segundo_nivel_hombre,0)}}  </td> 
                 <td class="columna_derecha_total fila_tabla"> {{number_format($sum_segundo_nivel_mujer,0)}}  </td>
                 <td class="columna_derecha_total fila_tabla"> {{number_format($sum_tercero_nivel_hombre,0)}}  </td>
                 <td class="columna_derecha_total fila_tabla"> {{number_format($sum_tercero_nivel_mujer,0)}}  </td> 

                 <td class="columna_derecha_total fila_tabla"> {{number_format($sum_cuarto_nivel_hombre,0)}}  </td> 
                 <td class="columna_derecha_total fila_tabla"> {{number_format($sum_cuarto_nivel_mujer,0)}}  </td>
                 <td class="columna_derecha_total fila_tabla"> {{number_format($sum_quinto_nivel_hombre,0)}}  </td>
                 <td class="columna_derecha_total fila_tabla"> {{number_format($sum_quinto_nivel_mujer,0)}}  </td>

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