<?php

namespace App\Http\Controllers\Educacion;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\tablaXImport;
use App\Models\Educacion\Importacion;
use App\Models\Educacion\InstitucionEducativa;
use App\Models\Educacion\Matricula;
use App\Models\Educacion\MatriculaDetalle;
use App\Models\Educacion\MatriculaEBE;
use App\Models\Educacion\MatriculaInicial;
use App\Models\Educacion\MatriculaPrimaria;
use App\Models\Educacion\MatriculaSecundaria;
use App\Models\Parametro\Anio;
use App\Repositories\Educacion\ImportacionRepositorio;
use App\Repositories\Educacion\InstitucionEducativaRepositorio;
use App\Repositories\Educacion\MatriculaRepositorio;
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

        //$mensaje = "CREACION EXITOSA";
        //return view('Educacion.Matricula.Importar',compact('mensaje','anios'));;

        //return redirect()->route('Educacion.Matricula_Lista',$importacion->id);

        return redirect()->route('Matricula.Matricula_Lista',$importacion->id);
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
                            
                            'tres_anios_hombre_ebe'=>$row['primer_grado_hombre'],
                            'tres_anios_mujer_ebe'=>$row['primer_grado_mujer'],
                            'cuatro_anios_hombre_ebe'=>$row['segundo_grado_hombre'],
                            'cuatro_anios_mujer_ebe'=>$row['segundo_grado_mujer'],
                            'cinco_anios_hombre_ebe'=>$row['tercer_grado_hombre'],
                            'cinco_anios_mujer_ebe'=>$row['tercer_grado_mujer'],
                    
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
        $importacion->save();

        $matricula = MatriculaRepositorio :: matricula_porImportacion($importacion_id)->first();
        $matricula->estado = 'PR';
        $matricula->save();

        return view('correcto');
    }

    //**************************************************************************************** */
    public function principal()
    {
        $matricula = MatriculaRepositorio :: matricula_mas_actual()->first();
        $anios = Anio::orderBy('anio', 'desc')->get();

        $lista_total_matricula_EBR = MatriculaRepositorio::total_matricula_EBR($matricula->id);    

       
        return view('educacion.Matricula.Principal',compact('lista_total_matricula_EBR','matricula','anios'));
    }
    
    public function prueba($aniox)
    {
        $matricula = MatriculaRepositorio :: matricula_mas_actual()->first();
        $anios = Anio::orderBy('anio', 'desc')->get();
      
        $nombre = '';
         if($aniox==6)
         {
            $lista_total_matricula_EBR = MatriculaRepositorio::total_matricula_EBR($matricula->id);
            $nombre = 'gambini';
         }            
         else
         {
            $lista_total_matricula_EBR = MatriculaRepositorio::total_matricula_EBR($matricula->id);
            $nombre = 'eysomar';
         }
            

        $diaActual = \Carbon\Carbon::now();

        $puntos = [];

        foreach ($lista_total_matricula_EBR as $key => $lista) {
            $puntos[] = ['name'=>$nombre, 'y'=>floatval(25)];
        }

        $contenedor = 'container22';

        return view('educacion.Matricula.pruebita',["data"=> json_encode($puntos)],compact('diaActual','lista_total_matricula_EBR','contenedor'));
    }

    public function prueba2($aniox)
    {
        $matricula = MatriculaRepositorio :: matricula_mas_actual()->first();
        $anios = Anio::orderBy('anio', 'desc')->get();
      
        $nombre = '';
         if($aniox==6)
         {
            $lista_total_matricula_EBR = MatriculaRepositorio::total_matricula_EBR($matricula->id);
            $nombre = 'cuadro b';
         }            
         else
         {
            $lista_total_matricula_EBR = MatriculaRepositorio::total_matricula_EBR($matricula->id);
            $nombre = 'cuadro a';
         }
            

        $diaActual = \Carbon\Carbon::now();

        $puntos = [];

        foreach ($lista_total_matricula_EBR as $key => $lista) {
            $puntos[] = ['name'=>$nombre, 'y'=>floatval(25)];
        }

        $contenedor = 'container223';

        return view('educacion.Matricula.pruebita',["data"=> json_encode($puntos)],compact('diaActual','lista_total_matricula_EBR','contenedor'));
    }
}
