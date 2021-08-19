<?php

namespace App\Http\Controllers\Educacion;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\tablaXImport;
use App\Models\Educacion\Importacion;
use App\Models\Educacion\InstitucionEducativa;
use App\Models\Educacion\MatriculaInicial;
use App\Models\Educacion\MatriculaPrimaria;
use App\Models\Parametro\Anio;
use App\Repositories\Educacion\InstitucionEducativaRepositorio;
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
        $anios = Anio::all();
        
        return view('Educacion.Matricula.Importar',compact('mensaje','anios'));
    } 
    
    public function guardar(Request $request)
    {  
        $this->validate($request,['file' => 'required|mimes:xls,xlsx']);    
        $archivo = $request->file('file');
        $array = (new tablaXImport )-> toArray($archivo);    
        

        switch ($request['nivel']) {
            case '1':  return $this->guardar_inicial($request,$array);
            case '2':  return $this->guardar_primaria($request, $array);
        }       
    }

    public function guardar_inicial(Request $request, $array)
    {   
        $i = 0;
        $cadena ='';
        $id = 0;
        $anios = Anio::all();

        try{
             foreach ($array as $key => $value) {
                 foreach ($value as $row) {
                    if(++$i > 1) break;
                    $cadena =  $cadena
                    .$row['dre'].$row['ugel'].$row['departamento'].$row['provincia'].$row['distrito'].$row['centropoblado']
                    .$row['cod_mod'].$row['anexo'].$row['nombre_ie'].$row['nivel'].$row['modalidad'].$row['tipo_ie']
                    .$row['total_estudiantes_matriculados']                    
                    .$row['matricula_definitiva'].$row['matricula_en_proceso'].$row['dni_validado']
                    .$row['dni_sin_validar'].$row['registrado_sin_dni'].$row['total_grados'].$row['total_secciones']
                    .$row['nominas_generadas'].$row['nominas_aprobadas'].$row['nominas_por_rectificar']                    
                    .$row['cero_anios_hombre'].$row['cero_anios_mujer']
                    .$row['uno_anios_hombre'].$row['uno_anios_mujer'].$row['dos_anios_hombre'].$row['dos_anios_mujer']
                    .$row['tres_anios_hombre'].$row['tres_anios_mujer'].$row['cuatro_anios_hombre'].$row['cuatro_anios_mujer']
                    .$row['cinco_anios_hombre'].$row['cinco_anios_mujer'].$row['masde_cinco_anios_hombre'].$row['masde_cinco_anios_mujer'];              }
             }
        }catch (Exception $e) {
            $mensaje = "Formato de archivo no reconocido, porfavor verifique si el formato es el correcto y vuelva a importar";           
            return view('Educacion.Matricula.Importar',compact('mensaje','anios'));            
        }       
       
        try{
            $importacion = Importacion::Create([
                'fuenteImportacion_id'=>8, // valor predeterminado
                'usuarioId_Crea'=> auth()->user()->id,
                'usuarioId_Aprueba'=>null,
                'fechaActualizacion'=>$request['fechaActualizacion'],
                'comentario'=>$request['comentario'],
                'estado'=>'PE'
              ]); 

            foreach ($array as $key => $value) {
                foreach ($value as $row) {

                    $institucion_educativa = InstitucionEducativaRepositorio::InstitucionEducativa_porCodModular($row['cod_mod'])->first();

                    if($institucion_educativa!=null)
                    {
                        $MatriculaInicial = MatriculaInicial::Create([
                      
                            'importacion_id'=>$importacion->id,
                            'anio_id'=>$request['anio'],
                            'institucioneducativa_id'=>$institucion_educativa->id,
                            'total_estudiantes_matriculados'=>$row['total_estudiantes_matriculados'],
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
                            'cero_anios_hombre'=>$row['cero_anios_hombre'],
                            'cero_anios_mujer'=>$row['cero_anios_mujer'],
                            'uno_anios_hombre'=>$row['uno_anios_hombre'],
                            'uno_anios_mujer'=>$row['uno_anios_mujer'],
                            'dos_anios_hombre'=>$row['dos_anios_hombre'],
                            'dos_anios_mujer'=>$row['dos_anios_mujer'],
                            'tres_anios_hombre'=>$row['tres_anios_hombre'],
                            'tres_anios_mujer'=>$row['tres_anios_mujer'],
                            'cuatro_anios_hombre'=>$row['cuatro_anios_hombre'],
                            'cuatro_anios_mujer'=>$row['cuatro_anios_mujer'],
                            'cinco_anios_hombre'=>$row['cinco_anios_hombre'],
                            'cinco_anios_mujer'=>$row['cinco_anios_mujer'],
                            'masde_cinco_anios_hombre'=>$row['masde_cinco_anios_hombre'],
                            'masde_cinco_anios_mujer'=>$row['masde_cinco_anios_mujer']
            
                        ]);
                    }
                    
                }
            }
        }catch (Exception $e) {            
            $importacion->estado = 'EL';
            $importacion->save();
            
            $mensaje = "Error en la carga de datos, verifique los datos de su archivo y/o comuniquese con el administrador del sistema";          
            return view('Educacion.Matricula.Importar',compact('mensaje','anios'));            
        }
       
        return 'ok inicial';
        
    }

    public function guardar_primaria(Request $request, $array)
    {
        $i = 0;
        $cadena ='';
        $id = 0;
        $anios = Anio::all();

        try{
             foreach ($array as $key => $value) {
                 foreach ($value as $row) {
                    if(++$i > 1) break;
                    $cadena =  $cadena
                    .$row['dre'].$row['ugel'].$row['departamento'].$row['provincia'].$row['distrito'].$row['centropoblado']
                    .$row['cod_mod'].$row['anexo'].$row['nombre_ie'].$row['nivel'].$row['modalidad'].$row['tipo_ie']
                    .$row['total_estudiantes_matriculados'].$row['matricula_definitiva'].$row['matricula_en_proceso']
                    .$row['dni_validado'].$row['dni_sin_validar'].$row['registrado_sin_dni'].$row['total_grados']
                    .$row['total_secciones'].$row['nominas_generadas'].$row['nominas_aprobadas'].$row['nominas_por_rectificar']
                    .$row['primer_grado_hombre'].$row['primer_grado_mujer'].$row['segundo_grado_hombre'].$row['segundo_grado_mujer']
                    .$row['tercer_grado_hombre'].$row['tercer_grado_mujer'].$row['cuarto_grado_hombre'].$row['cuarto_grado_mujer']
                    .$row['quinto_grado_hombre'].$row['quinto_grado_mujer'].$row['sexto_grado_hombre'].$row['sexto_grado_mujer'];             
                }
             }
        }catch (Exception $e) {
            $mensaje = "Formato de archivo no reconocido, porfavor verifique si el formato es el correcto y vuelva a importar";           
            return view('Educacion.Matricula.Importar',compact('mensaje','anios'));            
        }       
       
        try{
            $importacion = Importacion::Create([
                'fuenteImportacion_id'=>9, // valor predeterminado
                'usuarioId_Crea'=> auth()->user()->id,
                'usuarioId_Aprueba'=>null,
                'fechaActualizacion'=>$request['fechaActualizacion'],
                'comentario'=>$request['comentario'],
                'estado'=>'PE'
              ]); 

            foreach ($array as $key => $value) {
                foreach ($value as $row) {

                    $institucion_educativa = InstitucionEducativaRepositorio::InstitucionEducativa_porCodModular($row['cod_mod'])->first();

                    if($institucion_educativa!=null)
                    {
                        $MatriculaPrimaria = MatriculaPrimaria::Create([
                      
                            'importacion_id'=>$importacion->id,
                            'anio_id'=>$request['anio'],
                            'institucioneducativa_id'=>$institucion_educativa->id,
                            'total_estudiantes_matriculados'=>$row['total_estudiantes_matriculados'],
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
                            'primer_grado_hombre'=>$row['primer_grado_hombre'],
                            'primer_grado_mujer'=>$row['primer_grado_mujer'],
                            'segundo_grado_hombre'=>$row['segundo_grado_hombre'],
                            'segundo_grado_mujer'=>$row['segundo_grado_mujer'],
                            'tercer_grado_hombre'=>$row['tercer_grado_hombre'],
                            'tercer_grado_mujer'=>$row['tercer_grado_mujer'],
                            'cuarto_grado_hombre'=>$row['cuarto_grado_hombre'],
                            'cuarto_grado_mujer'=>$row['cuarto_grado_mujer'],
                            'quinto_grado_hombre'=>$row['quinto_grado_hombre'],
                            'quinto_grado_mujer'=>$row['quinto_grado_mujer'],
                            'sexto_grado_hombre'=>$row['sexto_grado_hombre'],
                            'sexto_grado_mujer'=>$row['sexto_grado_mujer']          
                        ]);
                    }                    
                }
            }
        }catch (Exception $e) { 
            $importacion->estado = 'EL';
            $importacion->save();
            
            $mensaje = "Error en la carga de datos, verifique los datos de su archivo y/o comuniquese con el administrador del sistema";           
            return view('Educacion.Matricula.Importar',compact('mensaje','anios'));            
        }
       
        return 'ok primaria';
    }
    public function ListaImportada($importacion_id)
    {
        // return view('Educacion.Censo.ListaImportada',compact('importacion_id'));
    }

    public function ListaImportada_DataTable($importacion_id)
    {
        // $Lista = CensoRepositorio::Listar_Por_Importacion_id($importacion_id);
                
        // return  datatables()->of($Lista)->toJson();;
    }
    
    public function aprobar($importacion_id)
    {
        // $importacion = ImportacionRepositorio::ImportacionPor_Id($importacion_id);
        // $anioCenso = CensoRepositorio :: censo_Por_Importacion_id($importacion_id)->first()->anio;

        return view('educacion.Censo.Aprobar',compact('importacion_id','importacion','anioCenso'));
    } 

    public function procesar($importacion_id)
    {

        return view('correcto');
    }
    
}
