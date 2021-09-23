<?php

namespace App\Http\Controllers\Educacion;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\tablaXImport;
use App\Models\Educacion\Importacion;
use App\Models\Educacion\Matricula;
use App\Models\Educacion\MatriculaDetalle;
use App\Models\Parametro\Anio;
use App\Repositories\Educacion\ImportacionRepositorio;
use App\Repositories\Educacion\InstitucionEducativaRepositorio;
use App\Repositories\Educacion\MatriculaRepositorio;
use App\Utilities\Utilitario;

use Exception;

class MatriculaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function importar()
    {  
        $mensaje = "";
        $anios = Anio::orderBy('anio', 'desc')->get();
        
        return view('Educacion.Matricula.Importar',compact('mensaje','anios'));
    } 
    
    public function guardar(Request $request)
    { 
        $this->validate($request,['fileInicial' => 'required|mimes:xls,xlsx']);    
        $archivoInicial = $request->file('fileInicial');
        $arrayInicial = (new tablaXImport )-> toArray($archivoInicial);  

        $this->validate($request,['filePrimaria' => 'required|mimes:xls,xlsx']);    
        $archivoPrimaria = $request->file('filePrimaria');
        $arrayPrimaria = (new tablaXImport )-> toArray($archivoPrimaria); 

        $this->validate($request,['fileSecundaria' => 'required|mimes:xls,xlsx']);    
        $archivoSecundaria = $request->file('fileSecundaria');
        $arraySecundaria = (new tablaXImport )-> toArray($archivoSecundaria); 

        $this->validate($request,['fileEBE' => 'required|mimes:xls,xlsx']);    
        $archivoEBE = $request->file('fileEBE');
        $arrayEBE = (new tablaXImport )-> toArray($archivoEBE); 

        $anios = Anio::orderBy('anio', 'desc')->get();

        $i = 0;
        $cadena ='';

        // VALIDACION DE LOS FORMATOS DE LOS 04 NIVELES
        try{
            foreach ($arrayInicial as $key => $value) {
                foreach ($value as $row) {
                   if(++$i > 1) break;
                   $cadena =  $cadena
                   .$row['dre'].$row['ugel'].$row['departamento'].$row['provincia'].$row['distrito'].$row['centropoblado']
                   .$row['cod_mod'].$row['anexo'].$row['nombre_ie'].$row['nivel'].$row['modalidad'].$row['tipo_ie']
                   .$row['total_estudiantes_matriculados_inicial']                    
                   .$row['matricula_definitiva'].$row['matricula_en_proceso'].$row['dni_validado']
                   .$row['dni_sin_validar'].$row['registrado_sin_dni'].$row['total_grados'].$row['total_secciones']
                   .$row['nominas_generadas'].$row['nominas_aprobadas'].$row['nominas_por_rectificar']                    
                   .$row['cero_anios_hombre'].$row['cero_anios_mujer']
                   .$row['uno_anios_hombre'].$row['uno_anios_mujer'].$row['dos_anios_hombre'].$row['dos_anios_mujer']
                   .$row['tres_anios_hombre'].$row['tres_anios_mujer'].$row['cuatro_anios_hombre'].$row['cuatro_anios_mujer']
                   .$row['cinco_anios_hombre'].$row['cinco_anios_mujer'].$row['masde_cinco_anios_hombre'].$row['masde_cinco_anios_mujer'];              }
            }
        }catch (Exception $e) {
           $mensaje = "Formato de archivo Nivel Inicial no reconocido, porfavor verifique si el formato es el correcto y vuelva a importar";           
           return view('Educacion.Matricula.Importar',compact('mensaje','anios'));            
        }       
        
        $i = 0;
        $cadena ='';

        try{
             foreach ($arrayPrimaria as $key => $value) {
                 foreach ($value as $row) {
                    if(++$i > 1) break;
                    $cadena =  $cadena
                    .$row['dre'].$row['ugel'].$row['departamento'].$row['provincia'].$row['distrito'].$row['centropoblado']
                    .$row['cod_mod'].$row['anexo'].$row['nombre_ie'].$row['nivel'].$row['modalidad'].$row['tipo_ie']
                    .$row['total_estudiantes_matriculados_primaria'].$row['matricula_definitiva'].$row['matricula_en_proceso']
                    .$row['dni_validado'].$row['dni_sin_validar'].$row['registrado_sin_dni'].$row['total_grados']
                    .$row['total_secciones'].$row['nominas_generadas'].$row['nominas_aprobadas'].$row['nominas_por_rectificar']
                    .$row['primer_grado_hombre'].$row['primer_grado_mujer'].$row['segundo_grado_hombre'].$row['segundo_grado_mujer']
                    .$row['tercer_grado_hombre'].$row['tercer_grado_mujer'].$row['cuarto_grado_hombre'].$row['cuarto_grado_mujer']
                    .$row['quinto_grado_hombre'].$row['quinto_grado_mujer'].$row['sexto_grado_hombre'].$row['sexto_grado_mujer'];             
                }
             }
        }catch (Exception $e) {
            $mensaje = "Formato de archivo Nivel Primaria no reconocido, porfavor verifique si el formato es el correcto y vuelva a importar";           
            return view('Educacion.Matricula.Importar',compact('mensaje','anios'));            
        }  
        
        $i = 0;
        $cadena ='';

        try{
             foreach ($arraySecundaria as $key => $value) {
                 foreach ($value as $row) {
                    if(++$i > 1) break;
                    $cadena =  $cadena
                    .$row['dre'].$row['ugel'].$row['departamento'].$row['provincia'].$row['distrito'].$row['centropoblado']
                    .$row['cod_mod'].$row['anexo'].$row['nombre_ie'].$row['nivel'].$row['modalidad'].$row['tipo_ie']
                    .$row['total_estudiantes_matriculados_secundaria'].$row['matricula_definitiva'].$row['matricula_en_proceso']
                    .$row['dni_validado'].$row['dni_sin_validar'].$row['registrado_sin_dni'].$row['total_grados']
                    .$row['total_secciones'].$row['nominas_generadas'].$row['nominas_aprobadas'].$row['nominas_por_rectificar']
                    .$row['primer_grado_hombre'].$row['primer_grado_mujer'].$row['segundo_grado_hombre'].$row['segundo_grado_mujer']
                    .$row['tercer_grado_hombre'].$row['tercer_grado_mujer'].$row['cuarto_grado_hombre'].$row['cuarto_grado_mujer']
                    .$row['quinto_grado_hombre'].$row['quinto_grado_mujer'];             
                }
             }
        }catch (Exception $e) {
            $mensaje = "Formato de archivo Nivel Secundaria no reconocido, porfavor verifique si el formato es el correcto y vuelva a importar";           
            return view('Educacion.Matricula.Importar',compact('mensaje','anios'));            
        } 

        $i = 0;
        $cadena ='';

        try{
             foreach ($arrayEBE as $key => $value) {
                 foreach ($value as $row) {
                    if(++$i > 1) break;
                    $cadena =  $cadena
                    .$row['dre'].$row['ugel'].$row['departamento'].$row['provincia'].$row['distrito'].$row['centropoblado']
                    .$row['cod_mod'].$row['anexo'].$row['nombre_ie'].$row['nivel'].$row['modalidad'].$row['tipo_ie']
                    .$row['total_estudiantes_matriculados_ebe'].$row['matricula_definitiva'].$row['matricula_en_proceso']
                    .$row['dni_validado'].$row['dni_sin_validar'].$row['registrado_sin_dni'].$row['total_grados']
                    .$row['total_secciones'].$row['nominas_generadas'].$row['nominas_aprobadas'].$row['nominas_por_rectificar']
                    .$row['tres_anios_hombre'].$row['tres_anios_mujer'].$row['cuatro_anios_hombre'].$row['cuatro_anios_mujer']
                    .$row['cinco_anios_hombre'].$row['cinco_anios_mujer'].$row['primer_grado_hombre'].$row['primer_grado_mujer']
                    .$row['segundo_grado_hombre'].$row['segundo_grado_mujer'].$row['tercer_grado_hombre'].$row['tercer_grado_mujer']
                    .$row['cuarto_grado_hombre'].$row['cuarto_grado_mujer'].$row['quinto_grado_hombre'].$row['quinto_grado_mujer']
                    .$row['sexto_grado_hombre'].$row['sexto_grado_mujer'];             
                }
             }
        }catch (Exception $e) {
            $mensaje = "Formato de archivo EBE no reconocido, porfavor verifique si el formato es el correcto y vuelva a importar";           
            return view('Educacion.Matricula.Importar',compact('mensaje','anios'));            
        }   
        
         // FIN VALIDACION DE LOS FORMATOS DE LOS 04 NIVELES

        $existeMismaFecha = ImportacionRepositorio :: Importacion_PE($request['fechaActualizacion'],8);

        if( $existeMismaFecha != null)
        {
            $mensaje = "Error, Ya existe archivos prendientes de aprobar para la fecha de versión ingresada";          
            return view('Educacion.Matricula.Importar',compact('mensaje','anios'));            
        }

        else
        {
            $creacionExitosa = 1;

            try{
                $importacion = Importacion::Create([
                    'fuenteImportacion_id'=>8, // valor predeterminado
                    'usuarioId_Crea'=> auth()->user()->id,
                    'usuarioId_Aprueba'=>null,
                    'fechaActualizacion'=>$request['fechaActualizacion'],
                    'comentario'=>$request['comentario'],
                    'estado'=>'PE'
                  ]); 
    
                $Matricula = Matricula::Create([
                    'importacion_id'=>$importacion->id, // valor predeterminado
                    'anio_id'=> $request['anio'],
                    'estado'=>'PE'
                  ]); 
               
            }catch (Exception $e) {
                $creacionExitosa = 0;
            }
            
            $mensajeNivel = "";
    
            if($creacionExitosa==1)
            {
                $creacionExitosa = $this->guardar_inicial($arrayInicial,$Matricula->id);
    
                if($creacionExitosa==1)
                {
                    $creacionExitosa = $this->guardar_primaria($arrayPrimaria,$Matricula->id);
                    if($creacionExitosa==1)
                    {
                        $creacionExitosa = $this->guardar_secundaria($arraySecundaria,$Matricula->id);
                        if($creacionExitosa==1)
                        {
                            $creacionExitosa = $this->guardar_EBE($arrayEBE,$Matricula->id);
                            if($creacionExitosa==0)
                            {
                                $mensajeNivel = "EBE";  
                            }
                        }
                        else
                        {
                            $mensajeNivel = "Nivel SECUNDARIA";  
                        }
                    }
                    else
                    {
                        $mensajeNivel = "Nivel PRIMARIA";  
                    }
                }
                else
                { 
                    $mensajeNivel ="Nivel INICIAL";
                }
            }
    
            if($creacionExitosa==0)
            {
                $importacion->estado = 'EL';
                $importacion->save();
    
                $Matricula->estado = 'EL';
                $Matricula->save();
    
                $mensaje = "Error en la carga de ".$mensajeNivel.", verifique los datos de su archivo y/o comuniquese con el administrador del sistema";          
                return view('Educacion.Matricula.Importar',compact('mensaje','anios'));
            }
    
            return redirect()->route('Matricula.Matricula_Lista',$importacion->id);

        }

    }   

    public function guardar_inicial($array,$matricula_id)
    {
        $creacionExitosa = 1;

        try{
            foreach ($array as $key => $value) {
                foreach ($value as $row) {
                   
                    $institucion_educativa = InstitucionEducativaRepositorio::InstitucionEducativa_porCodModular($row['cod_mod'])->first();
                    if($institucion_educativa!=null)
                    {
                        $MatriculaDetalle = MatriculaDetalle::Create([
                      
                            'matricula_id'=>$matricula_id,                        
                            'institucioneducativa_id'=>$institucion_educativa->id,
                            'nivel'=>'I',
                            'total_estudiantes_matriculados'=>$row['total_estudiantes_matriculados_inicial'],
                            'matricula_definitiva'=>$row['matricula_definitiva'],
                            'matricula_en_proceso'=>$row['matricula_en_proceso'],
                            'dni_validado'=>$row['dni_validado'],
                            'dni_sin_validar'=>$row['dni_sin_validar'],
                            'registrado_sin_dni'=>$row['registrado_sin_dni'],
                            'total_grados'=>$row['total_grados'],
                            'total_secciones'=>$row['total_secciones'],
                            'nominas_generadas'=>$row['nominas_generadas'],
                            'nominas_aprobadas'=>$row['nominas_aprobadas'],
                            'nominas_por_rectificar'=>$row['nominas_por_rectificar'],
                            'cero_nivel_hombre'=>$row['cero_anios_hombre'],
                            'cero_nivel_mujer'=>$row['cero_anios_mujer'],
                            'primer_nivel_hombre'=>$row['uno_anios_hombre'],
                            'primer_nivel_mujer'=>$row['uno_anios_mujer'],
                            'segundo_nivel_hombre'=>$row['dos_anios_hombre'],
                            'segundo_nivel_mujer'=>$row['dos_anios_mujer'],
                            'tercero_nivel_hombre'=>$row['tres_anios_hombre'],
                            'tercero_nivel_mujer'=>$row['tres_anios_mujer'],
                            'cuarto_nivel_hombre'=>$row['cuatro_anios_hombre'],
                            'cuarto_nivel_mujer'=>$row['cuatro_anios_mujer'],
                            'quinto_nivel_hombre'=>$row['cinco_anios_hombre'],
                            'quinto_nivel_mujer'=>$row['cinco_anios_mujer'],
                            'sexto_nivel_hombre'=>$row['masde_cinco_anios_hombre'],
                            'sexto_nivel_mujer'=>$row['masde_cinco_anios_mujer']
            
                        ]);
                    }
                    
                }
            }
        }catch (Exception $e) {            
             $creacionExitosa = 0;            
        }
       
        return $creacionExitosa;
    }

    public function guardar_primaria($array,$matricula_id)
    {
        $creacionExitosa = 1;

        try{
            foreach ($array as $key => $value) {
                foreach ($value as $row) {
                   
                    $institucion_educativa = InstitucionEducativaRepositorio::InstitucionEducativa_porCodModular($row['cod_mod'])->first();
                    if($institucion_educativa!=null)
                    {
                        $MatriculaDetalle = MatriculaDetalle::Create([
                      
                            'matricula_id'=>$matricula_id,                        
                            'institucioneducativa_id'=>$institucion_educativa->id,
                            'nivel'=>'P',
                            'total_estudiantes_matriculados'=>$row['total_estudiantes_matriculados_primaria'],
                            'matricula_definitiva'=>$row['matricula_definitiva'],
                            'matricula_en_proceso'=>$row['matricula_en_proceso'],
                            'dni_validado'=>$row['dni_validado'],
                            'dni_sin_validar'=>$row['dni_sin_validar'],
                            'registrado_sin_dni'=>$row['registrado_sin_dni'],
                            'total_grados'=>$row['total_grados'],
                            'total_secciones'=>$row['total_secciones'],
                            'nominas_generadas'=>$row['nominas_generadas'],
                            'nominas_aprobadas'=>$row['nominas_aprobadas'],
                            'nominas_por_rectificar'=>$row['nominas_por_rectificar'],                            
                            'primer_nivel_hombre'=>$row['primer_grado_hombre'],
                            'primer_nivel_mujer'=>$row['primer_grado_mujer'],
                            'segundo_nivel_hombre'=>$row['segundo_grado_hombre'],
                            'segundo_nivel_mujer'=>$row['segundo_grado_mujer'],
                            'tercero_nivel_hombre'=>$row['tercer_grado_hombre'],
                            'tercero_nivel_mujer'=>$row['tercer_grado_mujer'],
                            'cuarto_nivel_hombre'=>$row['cuarto_grado_hombre'],
                            'cuarto_nivel_mujer'=>$row['cuarto_grado_mujer'],
                            'quinto_nivel_hombre'=>$row['quinto_grado_hombre'],
                            'quinto_nivel_mujer'=>$row['quinto_grado_mujer'],
                            'sexto_nivel_hombre'=>$row['sexto_grado_hombre'],
                            'sexto_nivel_mujer'=>$row['sexto_grado_mujer']
                        ]);
                    }
                    
                }
            }
        }catch (Exception $e) {            
             $creacionExitosa = 0;            
        }
       
        return $creacionExitosa;
    }

    public function guardar_secundaria($array,$matricula_id)
    {
        $creacionExitosa = 1;

        try{
            foreach ($array as $key => $value) {
                foreach ($value as $row) {
                   
                    $institucion_educativa = InstitucionEducativaRepositorio::InstitucionEducativa_porCodModular($row['cod_mod'])->first();
                    if($institucion_educativa!=null)
                    {
                        $MatriculaDetalle = MatriculaDetalle::Create([
                      
                            'matricula_id'=>$matricula_id,                        
                            'institucioneducativa_id'=>$institucion_educativa->id,
                            'nivel'=>'S',
                            'total_estudiantes_matriculados'=>$row['total_estudiantes_matriculados_secundaria'],
                            'matricula_definitiva'=>$row['matricula_definitiva'],
                            'matricula_en_proceso'=>$row['matricula_en_proceso'],
                            'dni_validado'=>$row['dni_validado'],
                            'dni_sin_validar'=>$row['dni_sin_validar'],
                            'registrado_sin_dni'=>$row['registrado_sin_dni'],
                            'total_grados'=>$row['total_grados'],
                            'total_secciones'=>$row['total_secciones'],
                            'nominas_generadas'=>$row['nominas_generadas'],
                            'nominas_aprobadas'=>$row['nominas_aprobadas'],
                            'nominas_por_rectificar'=>$row['nominas_por_rectificar'],                            
                            'primer_nivel_hombre'=>$row['primer_grado_hombre'],
                            'primer_nivel_mujer'=>$row['primer_grado_mujer'],
                            'segundo_nivel_hombre'=>$row['segundo_grado_hombre'],
                            'segundo_nivel_mujer'=>$row['segundo_grado_mujer'],
                            'tercero_nivel_hombre'=>$row['tercer_grado_hombre'],
                            'tercero_nivel_mujer'=>$row['tercer_grado_mujer'],
                            'cuarto_nivel_hombre'=>$row['cuarto_grado_hombre'],
                            'cuarto_nivel_mujer'=>$row['cuarto_grado_mujer'],
                            'quinto_nivel_hombre'=>$row['quinto_grado_hombre'],
                            'quinto_nivel_mujer'=>$row['quinto_grado_mujer']                            
                        ]);
                    }
                    
                }
            }
        }catch (Exception $e) {            
             $creacionExitosa = 0;            
        }
       
        return $creacionExitosa;
    }

    public function guardar_EBE($array,$matricula_id)
    {
        $creacionExitosa = 1;

        try{
            foreach ($array as $key => $value) {
                foreach ($value as $row) {
                   
                    $institucion_educativa = InstitucionEducativaRepositorio::InstitucionEducativa_porCodModular($row['cod_mod'])->first();
                    if($institucion_educativa!=null)
                    {
                        $MatriculaDetalle = MatriculaDetalle::Create([
                      
                            'matricula_id'=>$matricula_id,                        
                            'institucioneducativa_id'=>$institucion_educativa->id,
                            'nivel'=>'E',
                            'total_estudiantes_matriculados'=>$row['total_estudiantes_matriculados_ebe'],
                            'matricula_definitiva'=>$row['matricula_definitiva'],
                            'matricula_en_proceso'=>$row['matricula_en_proceso'],
                            'dni_validado'=>$row['dni_validado'],
                            'dni_sin_validar'=>$row['dni_sin_validar'],
                            'registrado_sin_dni'=>$row['registrado_sin_dni'],
                            'total_grados'=>$row['total_grados'],
                            'total_secciones'=>$row['total_secciones'],
                            'nominas_generadas'=>$row['nominas_generadas'],
                            'nominas_aprobadas'=>$row['nominas_aprobadas'],
                            'nominas_por_rectificar'=>$row['nominas_por_rectificar'],  

                            'primer_nivel_hombre'=>$row['primer_grado_hombre'],
                            'primer_nivel_mujer'=>$row['primer_grado_mujer'],
                            'segundo_nivel_hombre'=>$row['segundo_grado_hombre'],
                            'segundo_nivel_mujer'=>$row['segundo_grado_mujer'],
                            'tercero_nivel_hombre'=>$row['tercer_grado_hombre'],
                            'tercero_nivel_mujer'=>$row['tercer_grado_mujer'],
                            'cuarto_nivel_hombre'=>$row['cuarto_grado_hombre'],
                            'cuarto_nivel_mujer'=>$row['cuarto_grado_mujer'],
                            'quinto_nivel_hombre'=>$row['quinto_grado_hombre'],
                            'quinto_nivel_mujer'=>$row['quinto_grado_mujer'],
                            'sexto_nivel_hombre'=>$row['sexto_grado_hombre'],
                            'sexto_nivel_mujer'=>$row['sexto_grado_mujer'],
                            
                            'tres_anios_hombre_ebe'=>$row['tres_anios_hombre'],
                            'tres_anios_mujer_ebe'=>$row['tres_anios_mujer'],
                            'cuatro_anios_hombre_ebe'=>$row['cuatro_anios_hombre'],
                            'cuatro_anios_mujer_ebe'=>$row['cuatro_anios_mujer'],
                            'cinco_anios_hombre_ebe'=>$row['cinco_anios_hombre'],
                            'cinco_anios_mujer_ebe'=>$row['cinco_anios_mujer'],
                    
                        ]);
                    }
                    
                }
            }
        }catch (Exception $e) {            
             $creacionExitosa = 0;            
        }
       
        return $creacionExitosa;
    }

    public function ListaImportada_DataTable($importacion_id)
    {
        // $Lista = CensoRepositorio::Listar_Por_Importacion_id($importacion_id);
                
        // return  datatables()->of($Lista)->toJson();;
    }
    
    public function ListaImportada($importacion_id)
    {
        $datos_matricula_importada = $this->datos_matricula_importada($importacion_id);  
        return view('Educacion.Matricula.ListaImportada',compact('importacion_id','datos_matricula_importada'));
    }

    public function aprobar($importacion_id)
    {
        $importacion = ImportacionRepositorio::ImportacionPor_Id($importacion_id);        
        $datos_matricula_importada = $this->datos_matricula_importada($importacion_id);

        return view('educacion.Matricula.Aprobar',compact('importacion_id','importacion','datos_matricula_importada'));
    } 

    public function datos_matricula_importada($importacion_id)
    {
        $matricula = MatriculaRepositorio::matricula_porImportacion($importacion_id);        
        return $datos_matricula_importada = MatriculaRepositorio::datos_matricula_importada($matricula->first()->id);
    }

    public function procesar($importacion_id)
    {
        $importacion  = Importacion::find($importacion_id);

        $importacion->estado = 'PR';    
        $importacion->usuarioId_Aprueba = auth()->user()->id;    
        $importacion->save();

        $this->elimina_mismaFecha($importacion->fechaActualizacion,$importacion->fuenteImportacion_id,$importacion_id);

        $matricula = MatriculaRepositorio :: matricula_porImportacion($importacion_id)->first();
        $matricula->estado = 'PR';
        $matricula->save();

        return view('correcto');
    }


    public function elimina_mismaFecha($fechaActualizacion,$fuenteImportacion_id,$importacion_id)
    {
        $importacion  = ImportacionRepositorio::Importacion_mismaFecha($fechaActualizacion,$fuenteImportacion_id,$importacion_id);

        if($importacion!=null)
        {
            $importacion->estado = 'EL';
            $importacion->save();
        }
        
    }    

    //**************************************************************************************** */
    public function principal()
    {
        $matricula = MatriculaRepositorio :: matricula_mas_actual()->first();
        $anios =  MatriculaRepositorio ::matriculas_anio( );

        $fechas_matriculas = MatriculaRepositorio ::fechas_matriculas_anio($anios->first()->id);

        

       
        return view('educacion.Matricula.Principal',compact('matricula','anios','fechas_matriculas'));     
    }
    
    public function reporteUgel($anio_id,$matricula_id)
    {
        $lista_total_matricula_EBR = MatriculaRepositorio::total_matricula_EBR($matricula_id);

        $lista_matricula = MatriculaRepositorio::total_matricula_por_Nivel($matricula_id);               
        $lista_total_matricula_Inicial = $lista_matricula->where('nivel', 'I')->all();    
        $lista_total_matricula_Primaria = $lista_matricula->where('nivel', 'P')->all();  
        $lista_total_matricula_Secundaria = $lista_matricula->where('nivel', 'S')->all();
        $lista_total_matricula_EBE = $lista_matricula->where('nivel', 'E')->all();

        $puntos = [];        
        $total = 0;

        foreach ($lista_total_matricula_EBR as $key => $lista) {
            $total = $total  + $lista->hombres  + $lista->mujeres;
        }
        //->sortByDesc('hombres') solo para dar una variacion a los colores del grafico
        foreach ($lista_total_matricula_EBR->sortByDesc('hombres') as $key => $lista) {
            $puntos[] = ['name'=>$lista->nombre, 'y'=>floatval(($lista->hombres  + $lista->mujeres)*100/$total)];
        }

        $contenedor = 'resumen_por_ugel';//nombre del contenedor para el grafico          
        $fecha_Matricula_texto = $this->fecha_texto($matricula_id);        
        $titulo_grafico = 'Total Matricula EBR al '.$fecha_Matricula_texto;  

        return view('educacion.Matricula.ReporteUgel',["data"=> json_encode($puntos)],compact('lista_total_matricula_EBR','lista_total_matricula_Secundaria',
                    'lista_total_matricula_Primaria','lista_total_matricula_Inicial','lista_total_matricula_EBE','contenedor','titulo_grafico','fecha_Matricula_texto'));
    }

    public function reporteDistrito($anio_id,$matricula_id)
    {     
        $lista_total_matricula_EBR = MatriculaRepositorio::total_matricula_EBR_Provincia($matricula_id);

        $lista_matricula = MatriculaRepositorio::total_matricula_por_Nivel_Distrito($matricula_id);    
        $lista_total_matricula_Inicial = $lista_matricula->where('nivel', 'I')->all();    
        $lista_total_matricula_Primaria = $lista_matricula->where('nivel', 'P')->all();  
        $lista_total_matricula_Secundaria = $lista_matricula->where('nivel', 'S')->all();       

        // cabeceras y/o totales en las tablas
        $lista_total_matricula = MatriculaRepositorio::total_matricula_por_Nivel_Provincia($matricula_id);
        $lista_matricula_Inicial_cabecera =  $lista_total_matricula->where('nivel', 'I')->all();  
        $lista_matricula_Primaria_cabecera =  $lista_total_matricula->where('nivel', 'P')->all();
        $lista_matricula_Secundaria_cabecera =  $lista_total_matricula->where('nivel', 'S')->all();

        $puntos = [];
        $total = 0;
        foreach ($lista_total_matricula_EBR as $key => $lista) {
            $total = $total  + $lista->hombres  + $lista->mujeres;
        }
        //->sortByDesc('hombres') solo para dar una variacion a los colores del grafico
        foreach ($lista_total_matricula_EBR->sortByDesc('hombres') as $key => $lista) {
            $puntos[] = ['name'=>$lista->provincia, 'y'=>floatval(($lista->hombres  + $lista->mujeres)*100/$total)];
        }

        $fecha_Matricula_texto = $this->fecha_texto($matricula_id);
        $contenedor = 'resumen_por_distrito';
        $titulo_grafico = 'Total Matricula EBR al '.$fecha_Matricula_texto;  

        return view('educacion.Matricula.ReporteDistrito',["data"=> json_encode($puntos)],compact('lista_total_matricula_EBR','lista_total_matricula_Inicial','lista_total_matricula_Primaria',
        'lista_total_matricula_Secundaria','fecha_Matricula_texto','lista_matricula_Inicial_cabecera','lista_matricula_Primaria_cabecera',
        'lista_matricula_Secundaria_cabecera','contenedor','titulo_grafico'));
    }

    public function GraficoBarrasPrincipal($anio_id)
    {     
        $total_matricula_anual = MatriculaRepositorio:: total_matricula_anual($anio_id);
        
        $categoria1 = [];
        $categoria2 = [];
        $categoria3 = [];
        $categoria4 = [];
        $categoria_nombres=[];
       
        // array_merge concatena los valores del arreglo, mientras recorre el foreach
        foreach ($total_matricula_anual as $key => $lista) {
            $categoria1 = array_merge($categoria1,[intval($lista->ugel10)]);
            $categoria2 = array_merge($categoria2,[intval($lista->ugel11)]);
            $categoria3 = array_merge($categoria3,[intval($lista->ugel12)]);
            $categoria4 = array_merge($categoria4,[intval($lista->ugel13)]);
            $categoria_nombres[] = Utilitario::fecha_formato_texto_diayMes($lista->fechaactualizacion);      
        } 

        $puntos[] = [ 'name'=>'Coronel Portillo' ,'data'=>  $categoria1];
        $puntos[] = [ 'name'=>'Atalaya', 'data'=> $categoria2];
        $puntos[] = [ 'name'=>'Padre Abad' ,'data'=>  $categoria3];
        $puntos[] = [ 'name'=>'Purus', 'data'=> $categoria4];

        $nombreAnio = Anio::find($anio_id)->anio;

        $titulo = 'Matriculas EBR '.$nombreAnio;
        $subTitulo = 'Fuente SIAGIE - MINEDU';
        $titulo_y = 'Numero de matriculados';

        

        return view('graficos.Barra',["data"=> json_encode($puntos),"categoria_nombres"=> json_encode($categoria_nombres)],compact( 'titulo_y','titulo','subTitulo'));
    }

    public function fecha_texto($matricula_id)
    {
        $fecha_Matricula_texto = '--'; 
        $datosMatricula = MatriculaRepositorio::datos_matricula($matricula_id);

        if($datosMatricula->first()!=null)
            $fecha_Matricula_texto = Utilitario::fecha_formato_texto_completo($datosMatricula->first()->fechaactualizacion ); 
            
        return $fecha_Matricula_texto;
    }

    public function Fechas($anio_id)
    {
        $fechas_matriculas = MatriculaRepositorio ::fechas_matriculas_anio($anio_id);      
        return response()->json(compact('fechas_matriculas'));
    }

    
    
}
