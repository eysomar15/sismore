<?php

namespace App\Http\Controllers\Vivienda;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\tablaXImport;
use App\Models\Educacion\Importacion;
use App\Models\Vivienda\Datass;
use App\Repositories\Educacion\ImportacionRepositorio;
use App\Repositories\Vivienda\DatassRepositorio;
use Exception;

use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DatassController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function importar()
    {  
        $mensaje = "";
        return view('Vivienda.Datass.Importar',compact('mensaje'));
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
                    $cadena =  $cadena.$row['departamento'].$row['provincia'].$row['distrito'].$row['ubigeo_cp']
                    .$row['centro_poblado'].$row['total_viviendas'].$row['viviendas_habitadas'].$row['total_poblacion']
                    .$row['predomina_primera_lengua'].$row['tiene_energia_electrica'].$row['tiene_internet']
                    .$row['tiene_establecimiento_salud'].$row['pronoei'].$row['primaria'].$row['secundaria']
                    .$row['sistema_agua'].$row['sistema_disposicion_excretas'].$row['prestador_codigo']
                    .$row['prestador_de_servicio_agua'].$row['tipo_organizacion_comunal'].$row['cuota_familiar']
                    .$row['servicio_agua_continuo'].$row['sistema_cloracion'].$row['realiza_cloracion_agua']
                    .$row['tipo_sistema_agua'];                   
                               
                    }
             }
        }catch (Exception $e) {
            $mensaje = "Formato de archivo no reconocido, porfavor verifique si el formato es el correcto y vuelva a importar";           
            return view('Vivienda.Datass.Importar',compact('mensaje'));            
        }
           
        try{
            $importacion = Importacion::Create([
                'fuenteImportacion_id'=>7, // valor predeterminado
                'usuarioId_Crea'=> auth()->user()->id,
                'usuarioId_Aprueba'=>null,
                'fechaActualizacion'=>$request['fechaActualizacion'],
                'comentario'=>$request['comentario'],
                'estado'=>'PE'
            ]); 

            foreach ($array as $key => $value) {
                foreach ($value as $row) {
                    // echo $row['cen_edu'].'<br>';
                    $Datass= Datass::Create([
                        'importacion_id'=>$importacion->id,                   
                        'departamento'=>$row['departamento'],
                        'provincia'=>$row['provincia'],
                        'distrito'=>$row['distrito'],
                        'ubigeo_cp'=>$row['ubigeo_cp'],
                        'centro_poblado'=>$row['centro_poblado'],
                        'total_viviendas'=>$row['total_viviendas'],
                        'viviendas_habitadas'=>$row['viviendas_habitadas'],
                        'total_poblacion'=>$row['total_poblacion'],
                        'predomina_primera_lengua'=>$row['predomina_primera_lengua'],
                        'tiene_energia_electrica'=>$row['tiene_energia_electrica'],
                        'tiene_internet'=>$row['tiene_internet'],
                        'tiene_establecimiento_salud'=>$row['tiene_establecimiento_salud'],
                        'pronoei'=>$row['pronoei'],
                        'primaria'=>$row['primaria'],
                        'secundaria'=>$row['secundaria'],
                        'sistema_agua'=>$row['sistema_agua'],
                        'sistema_disposicion_excretas'=>$row['sistema_disposicion_excretas'],
                        'prestador_codigo'=>$row['prestador_codigo'],
                        'prestador_de_servicio_agua'=>$row['prestador_de_servicio_agua'],
                        'tipo_organizacion_comunal'=>$row['tipo_organizacion_comunal'],
                        'cuota_familiar'=>$row['cuota_familiar'],
                        'servicio_agua_continuo'=>$row['servicio_agua_continuo'],
                        'sistema_cloracion'=>$row['sistema_cloracion'],
                        'realiza_cloracion_agua'=>$row['realiza_cloracion_agua'],
                        'tipo_sistema_agua'=>$row['tipo_sistema_agua'],
                        
                    ]);
                }
            }
        }catch (Exception $e) {
            $importacion->delete(); // elimina la importacion creada
            $mensaje = "Error en la carga de datos, comuniquese con el administrador del sistema";           
            return view('Vivienda.Datass.Importar',compact('mensaje'));            
        }

        //return 'ok';
        return redirect()->route('Datass.Datass_Lista',$importacion->id);
    }

    public function ListaImportada($importacion_id)
    {        
        return view('Vivienda.Datass.ListaImportada',compact('importacion_id'));
    }

    public function ListaImportada_DataTable($importacion_id)
    {
        $Lista = DatassRepositorio::Listar_Por_Importacion_id($importacion_id);
                
        return  datatables()->of($Lista)->toJson();;
    }
    
    public function aprobar($importacion_id)
    {
        $importacion = ImportacionRepositorio::ImportacionPor_Id($importacion_id);

        //$view = View::make('Vivienda.Datass.Aprobar')->nest('content', 'ListaImportada', $importacion_id);

       //$view = view('Vivienda.Datass.Aprobar')->nest('content', 'ListaImportada', $importacion_id);

        return  view('Vivienda.Datass.Aprobar',compact('importacion_id','importacion'));
    } 

    public function procesar($importacion_id)
    {
        $procesar = DB::select('call edu_pa_procesarCuadroAsigPersonal(?)', [$importacion_id]);
        return view('correcto');
    }
    
}
