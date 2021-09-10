<?php

namespace App\Http\Controllers\Educacion;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\tablaXImport;
use App\Models\Educacion\Importacion;
use App\Models\Educacion\Tableta;
use App\Models\Educacion\TabletaDetalle;
use App\Models\Parametro\Anio;
use App\Repositories\Educacion\ImportacionRepositorio;
use App\Repositories\Educacion\InstitucionEducativaRepositorio;
use App\Repositories\Educacion\TabletaRepositorio;
use App\Utilities\Utilitario;
use Exception;
use PhpParser\Node\Stmt\Return_;

class TabletaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function importar()
    {  
        $mensaje = "";
        $anios = Anio::orderBy('anio', 'desc')->get();
        
        return view('Educacion.Tableta.Importar',compact('mensaje','anios'));
    } 
    
    public function guardar(Request $request)
    {
        $this->validate($request,['file' => 'required|mimes:xls,xlsx']);      
        $archivo = $request->file('file');
        $array = (new tablaXImport )-> toArray($archivo);    
        $anios = Anio::orderBy('anio', 'desc')->get();

        $i = 0;
        $cadena ='';

        // VALIDACION DE LOS FORMATOS DE LOS 04 NIVELES
         try{
         foreach ($array as $key => $value) {
             foreach ($value as $row) {
                if(++$i > 1) break;
                $cadena =  $cadena
                .$row['region'].$row['ugel'].$row['departamento'].$row['provincia'].$row['distritos'].$row['codlocal']
                .$row['codigo_modular'].$row['anexo'].$row['institucion_educativa'].$row['nivel']
                .$row['tabletas_estudiantes_adistribuir'].$row['tabletas_docentes_adistribuir']
                .$row['total_tabletas_adistribuir'].$row['tabletas_estudiantes_despacho']
                .$row['tabletas_docentes_despacho'].$row['total_tabletas_despacho'].$row['tabletas_estudiantes_recepcion']
                .$row['tabletas_docentes_recepcion'].$row['total_tabletas_recepcion'].$row['tabletas_estudiantes_asignacion']
                .$row['tabletas_docentes_asignacion'].$row['total_tabletas_asignacion'];              }
             }
         }catch (Exception $e) {
            $mensaje = "Formato de archivo no reconocido, porfavor verifique si el formato es el correcto y vuelva a importar";           
            return view('Educacion.Tableta.Importar',compact('mensaje','anios'));            
         }   

         $existeMismaFecha = ImportacionRepositorio :: Importacion_PE($request['fechaActualizacion'],9);

         if( $existeMismaFecha != null)
         {
             $mensaje = "Error, Ya existe archivos prendientes de aprobar para la fecha de versión ingresada";          
             return view('Educacion.Tableta.Importar',compact('mensaje','anios'));            
         }
 
         else
         {
               try{
                   $importacion = Importacion::Create([
                       'fuenteImportacion_id'=>9, // valor predeterminado
                       'usuarioId_Crea'=> auth()->user()->id,
                       'usuarioId_Aprueba'=>null,
                       'fechaActualizacion'=>$request['fechaActualizacion'],
                       'comentario'=>$request['comentario'],
                       'estado'=>'PE'
                   ]); 

                   $Tableta = Tableta::Create([
                    'importacion_id'=>$importacion->id, // valor predeterminado
                    'anio_id'=> $request['anio'],
                   ]); 

                   foreach ($array as $key => $value) {
                       foreach ($value as $row) {
                           // echo $row['cen_edu'].'<br>';

                           $institucion_educativa = InstitucionEducativaRepositorio::InstitucionEducativa_porCodModular($row['codigo_modular'])->first();

                           if($institucion_educativa!=null)                    
                           {
                              $TabletaDetalle = TabletaDetalle::Create([
                               'tableta_id'=>$Tableta->id, // valor predeterminado                                                             
                               'institucioneducativa_id'=>$institucion_educativa->id,
                               'nivel_educativo_dato_adic'=>$row['nivel'],
                               'codModular_dato_adic'=>$row['codigo_modular'],
                               'codLocal_dato_adic'=>$row['codlocal'],
                               'aDistribuir_estudiantes'=>$row['tabletas_estudiantes_adistribuir'],
                               'aDistribuir_docentes'=>$row['tabletas_docentes_adistribuir'],
                               'despachadas_estudiantes'=>$row['tabletas_estudiantes_despacho'],
                               'despachadas_docentes'=>$row['tabletas_docentes_despacho'],
                               'recepcionadas_estudiantes'=>$row['tabletas_estudiantes_recepcion'],
                               'recepcionadas_docentes'=>$row['tabletas_docentes_recepcion'],
                               'asignadas_estudiantes'=>$row['tabletas_estudiantes_asignacion'],
                               'asignadas_docentes'=>$row['tabletas_docentes_asignacion']
                                  
                              ]);
                           }                           
                       }
                   }
                  }catch (Exception $e) {
                      $importacion->estado = 'EL';
                      $importacion->save();
                      
                      $mensaje = "Error en la carga de datos, verifique los datos de su archivo y/o comuniquese con el administrador del sistema";        
                      return view('Educacion.Tableta.Importar',compact('mensaje','anios'));            
                  }
         }

         return 'CARGA EXITOSA';

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
        

        return view('educacion.Tableta.Aprobar',compact('importacion_id','importacion'));
    } 

    // public function datos_matricula_importada($importacion_id)
    // {
    //     $matricula = MatriculaRepositorio::matricula_porImportacion($importacion_id);        
    //     return $datos_matricula_importada = MatriculaRepositorio::datos_matricula_importada($matricula->first()->id);
    // }

    public function procesar($importacion_id)
    {
        $importacion  = Importacion::find($importacion_id);

        $importacion->estado = 'PR';    
        $importacion->usuarioId_Aprueba = auth()->user()->id;    
        $importacion->save();

        $this->elimina_mismaFecha($importacion->fechaActualizacion,$importacion->fuenteImportacion_id,$importacion_id);

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
        $tableta = TabletaRepositorio :: tableta_mas_actual()->first();
        $anios =  TabletaRepositorio ::tableta_anio( );

        $fechas_tabletas = TabletaRepositorio ::fechas_tabletas_anio($anios->first()->id);


        $resumen_tabletas_anio = TabletaRepositorio ::resumen_tabletas_anio(6);
        

        foreach ($resumen_tabletas_anio as $key => $lista) {
           
            $puntos[] = intval( $lista->total_aDistribuir);
            $puntos2[] = intval( $lista->total_Despachado);
            $puntos3[] = intval( $lista->total_Recepcionadas);
            $puntos4[] = intval( $lista->total_Asignadas);
            $puntos5[] = Utilitario::fecha_formato_texto_diayMes($lista->fechaActualizacion);
            
        }

       
        return view('educacion.Tableta.Principal',
        ["data"=> json_encode($puntos),"data2"=> json_encode($puntos2),"data3"=> json_encode($puntos3),"data4"=> json_encode($puntos4),"data5"=> json_encode($puntos5)],
        compact('tableta','anios','fechas_tabletas')); 
        
        // $tabletas = TabletaRepositorio ::resumen_tabletas_anio(6); 
       // return $dato;
       //return $resumen_tabletas_anio;
    }

    public function reporteUgel($anio_id,$tableta_id)
    {
        $resumen_tabletas_ugel = TabletaRepositorio ::resumen_tabletas_ugel($tableta_id); 
        
        $fecha_texto = $this->fecha_texto($tableta_id);  

       
        return view('educacion.Tableta.ReporteUgel',compact('resumen_tabletas_ugel','fecha_texto'));
    }

    public function fecha_texto($id)
    {
        $fecha_texto = '--'; 
        $datos = TabletaRepositorio::datos_tableta($id);

        if($datos->first()!=null)
            $fecha_texto = Utilitario::fecha_formato_texto_completo($datos->first()->fechaactualizacion ); 
            
        return $fecha_texto;
    }

    public function Fechas($anio_id)
    {
        $fechas_tabletas = TabletaRepositorio ::fechas_tabletas_anio($anio_id);      
        return response()->json(compact('fechas_tabletas'));
    }

    
}
