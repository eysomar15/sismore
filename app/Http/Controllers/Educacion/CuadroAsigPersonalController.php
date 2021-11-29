<?php

namespace App\Http\Controllers\Educacion;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\tablaXImport;
use App\Models\Educacion\CuadroAsigPersonal;
use App\Models\Educacion\Importacion;
use App\Models\Educacion\Indicador;
use App\Repositories\Educacion\CuadroAsigPersonalRepositorio;
use App\Repositories\Educacion\ImportacionRepositorio;

use App\Utilities\Utilitario;
use Exception;
use Illuminate\Support\Facades\DB;

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
                    $cadena =  
                    // $cadena.$row['region']
                    // $row['unidad_ejecutora'].
                    $row['organo_intermedio'].$row['provincia'].$row['distrito'].$row['tipo_ie'].$row['gestion']
                    .$row['zona'].$row['codmod_ie'].$row['codigo_local'].$row['clave8'].$row['nivel_educativo'].$row['institucion_educativa']
                    .$row['codigo_plaza'].$row['tipo_trabajador'].$row['sub_tipo_trabajador'].$row['cargo'].$row['situacion_laboral'].$row['motivo_vacante']
                    .$row['documento'].$row['codigo_modular'].$row['apellido_paterno'].$row['apellido_materno'].$row['nombres'].$row['fecha_ingreso']
                    .$row['categoria_remunerativa'].$row['jornada_laboral'].$row['estado'].$row['fecha_nacimiento'].$row['fecha_inicio'].$row['fecha_termino']
                    .$row['tipo_registro'].$row['ley'].$row['preventiva'].
                    // $row['referencia_preventiva'].
                    $row['especialidad'].$row['tipo_estudios']
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
                        'region'=>'UCAYALI',
                        // 'unidad_ejecutora'=>$row['unidad_ejecutora'],
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
                        'documento_identidad'=>$row['documento'],
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
                        // 'referencia_preventiva'=>$row['referencia_preventiva'],
                        'especialidad'=>$row['especialidad'],
                        'tipo_estudios'=>$row['tipo_estudios'],
                        'estado_estudios'=>$row['estado_estudios'],
                        'grado'=>$row['grado'],
                        'mencion'=>trim($row['mencion']),
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
            $importacion->estado = 'EL';
            $importacion->save();
            
            $mensaje = "Error en la carga de datos, verifique los datos de su archivo y/o comuniquese con el administrador del sistema";        
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
    
    public function aprobar($importacion_id)
    {
        $importacion = ImportacionRepositorio::ImportacionPor_Id($importacion_id);

        return view('educacion.CuadroAsigPersonal.Aprobar',compact('importacion_id','importacion'));
    } 

    public function procesar($importacion_id)
    {
        $procesar = DB::select('call edu_pa_procesarCuadroAsigPersonal(?,?)', [$importacion_id,auth()->user()->id]);
        return view('correcto');
    }

    
    //**************************************************************************************** */
    public function Principal()
    {
        
        return view('educacion.CuadroAsigPersonal.Principal');

    }

    public function reporteUgel()
    {
        $lista_principal = CuadroAsigPersonalRepositorio::cuadro_ugel();
        $lista_ugel_nivel = CuadroAsigPersonalRepositorio::cuadro_ugel_nivel();
        $lista_ugel_tipoTrab = CuadroAsigPersonalRepositorio::cuadro_ugel_tipoTrab();

        
        return view('educacion.CuadroAsigPersonal.ReporteUgel',compact('lista_principal','lista_ugel_nivel','lista_ugel_tipoTrab'));
    }

    public function reporteDistrito()
    {
    }

    public function reportePedagogico()
    {    
        $indicador = Indicador::find(35);
        $title = $indicador->nombre;

        $Lista = CuadroAsigPersonalRepositorio:: docentes_pedagogico('Primaria');

        
        $sumaPedagogico= 0; 
        $sumaTotal= 0;
        $puntos = [];   

        //->sortByDesc('hombres') solo para dar una variacion a los colores del grafico
        foreach ($Lista as $key => $item) {
            $sumaPedagogico+= $item->pedagogico; 
            $sumaTotal+= $item->total;             
        }

        $puntos[] = ['name'=>'Pedagógico', 'y'=>floatval($sumaPedagogico*100/$sumaTotal)];
        $puntos[] = ['name'=>'No Pedagógico', 'y'=>floatval(($sumaTotal - $sumaPedagogico)*100/$sumaTotal)];

        $contenedor = 'resumen_por_ugel';//nombre del contenedor para el grafico     
        $titulo_grafico = 'Docentes Título Pedagógico - Nivel Primaria';  

        return  view('educacion.CuadroAsigPersonal.ReportePedagogico',["dataCircular"=> json_encode($puntos)],compact('Lista','title','contenedor','titulo_grafico'));
    }

    public function reporteBilingues()
    {    
        $indicador = Indicador::find(37);
        $title = $indicador->nombre;

        $lista = CuadroAsigPersonalRepositorio:: docentes_bilingues_ugel();
        $ultima_Plaza = CuadroAsigPersonalRepositorio:: ultima_importacion_dePlaza();
        $docentes_bilingues_nivel = CuadroAsigPersonalRepositorio:: docentes_bilingues_nivel();

        if($ultima_Plaza->first()!=null)
            $fecha_texto = Utilitario::fecha_formato_texto_completo($ultima_Plaza->first()->fechaActualizacion );

        $fecha_version = 'Ultima actualización: '.$fecha_texto;
      
        $dataCabecera = CuadroAsigPersonalRepositorio:: docentes_bilingues();
        
        /************* GRAFICO TORTA*******************/
        $sumaBilingue= 0; 
        $sumaTotal= 0;
        $puntos = [];   

        //->sortByDesc('hombres') solo para dar una variacion a los colores del grafico
        foreach ($lista as $key => $item) {
            $sumaBilingue+= $item->Bilingue; 
            $sumaTotal+= $item->total;             
        }

        $puntos[] = ['name'=>'Bilingue', 'y'=>floatval($sumaBilingue*100/$sumaTotal)];
        $puntos[] = ['name'=>'No Bilingue', 'y'=>floatval(($sumaTotal - $sumaBilingue)*100/$sumaTotal)];

        $contenedor = 'resumen_bilingue';//nombre del contenedor para el grafico     
        $titulo_grafico = 'Docentes Bilingues';  

        /************* GRAFICO BARRAS*******************/
               
     
        $categoria_nombres=[];        
        $recorre = 1;            
        $data = [];                                                      

        foreach ($docentes_bilingues_nivel as $key => $lista2) {
            
            $data = array_merge($data,[intval($lista2->Bilingue)]);

            $puntos2[] = [ 'name'=> $lista2->nivel_educativo ,'data'=>  $data]; 
            $categoria_nombres[] = $lista2->nivel_educativo;        
        }

        $titulo = 'TOTAL ESTUDIANTES ';
        $subTitulo = 'Fuente SIAGIE - MINEDU';
        $titulo_y = 'Numero de Matriculados';

        /********* FIN GRAFICO A *************/



        return  view('educacion.CuadroAsigPersonal.ReporteBilingues',
                ["dataCircular"=> json_encode($puntos),"data"=> json_encode($puntos2),"categoria_nombres"=> json_encode($categoria_nombres)],          
                compact('lista','dataCabecera','title','contenedor','titulo_grafico','fecha_version','titulo','subTitulo','titulo_y'));
    }

    public function filtro_gestion($gestion)
    {
        $filtro = "";

        if($gestion==1)
            $filtro = "NOT( tipo_ie LIKE '%xyz%')";//este filtro hace que la consulta traiga los datos de publicas y privadas
        else
        {
            if($gestion==2)
                $filtro = "NOT( tipo_ie LIKE '%particular%' or tipo_ie LIKE '%privada%')";
            else
                $filtro = "( tipo_ie LIKE '%particular%' or tipo_ie LIKE '%privada%')";
        }

        return  $filtro;
    }

    
}
