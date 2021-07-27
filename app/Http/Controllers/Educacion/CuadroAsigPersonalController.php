<?php

namespace App\Http\Controllers\Educacion;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\tablaXImport;
use App\Models\Educacion\CuadroAsigPersonal;
use App\Models\Educacion\Importacion;
use App\Repositories\Educacion\CuadroAsigPersonalRepositorio;
use App\Utilities\Utilitario;
use Exception;

class CuadroAsigPersonalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function importar()
    {  
        $mensaje = "";
        return view('Educacion.CuadroAsigPersonal.Importar',compact('mensaje'));
    } 
         
    public function guardar(Request $request)
    {  
        $this->validate($request,['file' => 'required|mimes:xls,xlsx']);      
        $archivo = $request->file('file');
        $array = (new tablaXImport )-> toArray($archivo);        

        $i = 0;
        $cadena ='';

        try{
             foreach ($array as $key => $value) {
                 foreach ($value as $row) {
                    if(++$i > 1) break;
                    $cadena =  $cadena.$row['region']
                    .$row['unidad_ejecutora'].$row['organo_intermedio'].$row['provincia'].$row['distrito'].$row['tipo_ie'].$row['gestion']
                    .$row['zona'].$row['codmod_ie'].$row['codigo_local'].$row['clave8'].$row['nivel_educativo'].$row['institucion_educativa']
                    .$row['codigo_plaza'].$row['tipo_trabajador'].$row['sub_tipo_trabajador'].$row['cargo'].$row['situacion_laboral'].$row['motivo_vacante']
                    .$row['documento_identidad'].$row['codigo_modular'].$row['apellido_paterno'].$row['apellido_materno'].$row['nombres'].$row['fecha_ingreso']
                    .$row['categoria_remunerativa'].$row['jornada_laboral'].$row['estado'].$row['fecha_nacimiento'].$row['fecha_inicio'].$row['fecha_termino']
                    .$row['tipo_registro'].$row['ley'].$row['preventiva'].$row['referencia_preventiva'].$row['especialidad'].$row['tipo_estudios']
                    .$row['estado_estudios'].$row['grado'].$row['mencion'].$row['especialidad_profesional'].$row['fecha_resolucion']
                    .$row['numero_resolucion'].$row['centro_estudios'].$row['celular'].$row['email'];               
                    }
             }
        }catch (Exception $e) {
            $mensaje = "Formato de archivo no reconocido, porfavor verifique si el formato es el correcto y vuelva a importar";           
            return view('Educacion.CuadroAsigPersonal.Importar',compact('mensaje'));            
        }
           
        try{
            $importacion = Importacion::Create([
                'fuenteImportacion_id'=>2, // valor predeterminado
                'usuarioId_Crea'=> auth()->user()->id,
                'usuarioId_Aprueba'=>null,
                'fechaActualizacion'=>$request['fechaActualizacion'],
                'comentario'=>$request['comentario'],
                'estado'=>'PE'
            ]); 

            foreach ($array as $key => $value) {
                foreach ($value as $row) {
                    // echo $row['cen_edu'].'<br>';
                    $CuadroAsigPersonal = CuadroAsigPersonal::Create([
                        'importacion_id'=>$importacion->id,
                        'region'=>$row['region'],
                        'unidad_ejecutora'=>$row['unidad_ejecutora'],
                        'organo_intermedio'=>$row['organo_intermedio'],
                        'provincia'=>$row['provincia'],
                        'distrito'=>$row['distrito'],
                        'tipo_ie'=>$row['tipo_ie'],
                        'gestion'=>$row['gestion'],
                        'zona'=>$row['zona'],
                        'codmod_ie'=>$row['codmod_ie'],
                        'codigo_local'=>$row['codigo_local'],
                        'clave8'=>$row['clave8'],
                        'nivel_educativo'=>$row['nivel_educativo'],
                        'institucion_educativa'=>$row['institucion_educativa'],
                        'codigo_plaza'=>$row['codigo_plaza'],
                        'tipo_trabajador'=>$row['tipo_trabajador'],
                        'sub_tipo_trabajador'=>$row['sub_tipo_trabajador'],
                        'cargo'=>$row['cargo'],
                        'situacion_laboral'=>$row['situacion_laboral'],
                        'motivo_vacante'=>$row['motivo_vacante'],
                        'documento_identidad'=>$row['documento_identidad'],
                        'codigo_modular'=>$row['codigo_modular'],
                        'apellido_paterno'=>$row['apellido_paterno'],
                        'apellido_materno'=>$row['apellido_materno'],
                        'nombres'=>$row['nombres'],
                        'fecha_ingreso'=>$row['fecha_ingreso'],
                        'categoria_remunerativa'=>$row['categoria_remunerativa'],
                        'jornada_laboral'=>$row['jornada_laboral'],
                        'estado'=>$row['estado'],
                        'fecha_nacimiento'=>$row['fecha_nacimiento'],
                        'fecha_inicio'=>$row['fecha_inicio'],
                        'fecha_termino'=>$row['fecha_termino'],
                        'tipo_registro'=>$row['tipo_registro'],
                        'ley'=>$row['ley'],
                        'preventiva'=>$row['preventiva'],
                        'referencia_preventiva'=>$row['referencia_preventiva'],
                        'especialidad'=>$row['especialidad'],
                        'tipo_estudios'=>$row['tipo_estudios'],
                        'estado_estudios'=>$row['estado_estudios'],
                        'grado'=>$row['grado'],
                        'mencion'=>$row['mencion'],
                        'especialidad_profesional'=>$row['especialidad_profesional'],
                        'fecha_resolucion'=>$row['fecha_resolucion'],
                        'numero_resolucion'=>$row['numero_resolucion'],
                        'centro_estudios'=>$row['centro_estudios'],
                        'celular'=>$row['celular'],
                        'email'=>$row['email'],
                        
                    ]);
                }
            }
        }catch (Exception $e) {
            $mensaje = "Error en la carga de datos, comuniquese con el administrador del sistema";           
            return view('Educacion.CuadroAsigPersonal.Importar',compact('mensaje'));            
        }

        return redirect()->route('CuadroAsigPersonal.CuadroAsigPersonal_Lista',$importacion->id);
        
       
    }

    public function ListaImportada($importacion_id)
    {
        return view('Educacion.CuadroAsigPersonal.ListaImportada',compact('importacion_id'));
    }

    public function ListaImportada_DataTable($importacion_id)
    {
        $Lista = CuadroAsigPersonalRepositorio::Listar_Por_Importacion_id($importacion_id);
                
        return  datatables()->of($Lista)->toJson();;
    }
    
    
}
