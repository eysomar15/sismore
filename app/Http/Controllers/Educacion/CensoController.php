<?php

namespace App\Http\Controllers\Educacion;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\tablaXImport;
use App\Models\Educacion\Censo;
use App\Models\Educacion\CensoResultado;
use App\Models\Educacion\Importacion;
use App\Models\Parametro\Anio;
use Exception;

class CensoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function importar()
    {  
        $mensaje = "";
        $anios = Anio::all();
        
        return view('Educacion.Censo.Importar',compact('mensaje','anios'));
    } 
    public function guardarb(Request $request)
    {
      return $request['anio'];
    }  
    public function guardar(Request $request)
    {  
        $this->validate($request,['file' => 'required|mimes:xls,xlsx']);      
        $archivo = $request->file('file');
        $array = (new tablaXImport )-> toArray($archivo);    
        $anios = Anio::all();    

        $i = 0;
        $cadena ='';

        try{
             foreach ($array as $key => $value) {
                 foreach ($value as $row) {
                    if(++$i > 1) break;
                    $cadena =  $cadena
                    .$row['codlocal'].$row['codigosmodulares'].$row['nombreinstitucion'].$row['codigogestion']
                    .$row['descripciongestion'].$row['codigoorganointer'].$row['nombredre_ugel'].$row['codigoubigeo']
                    .$row['departamento'].$row['provincia'].$row['distrito'].$row['centopoblado'].$row['direccion']
                    .$row['areageo'].$row['estadocenso'].$row['totalaulas'].$row['aulasbuenas'].$row['aulasregulares']
                    .$row['aulasmalas'].$row['nopuedeprecisarestadoaulas'].$row['ellocales'].$row['propietariolocal']
                    .$row['compuescri_operativos'].$row['compuescri_inoperativos'].$row['compuporta_operativos']
                    .$row['compuporta_inoperativos'].$row['lapto_operativos'].$row['lapto_inoperativos'].$row['tieneinternet']
                    .$row['tipoconexion'].$row['fuenteenergiaelectrica'].$row['empresaenergiaelect'].$row['tieneenergiaelecttododia']
                    .$row['fuenteagua'].$row['empresaagua'].$row['tieneaguapottododia'].$row['desagueinfo'];     
                    }
             }
        }catch (Exception $e) {
            $mensaje = "Formato de archivo no reconocido, porfavor verifique si el formato es el correcto y vuelva a importar";           
            return view('Educacion.Censo.Importar',compact('mensaje','anios'));            
        }
       
        try{
            $importacion = Importacion::Create([
                'fuenteImportacion_id'=>6, // valor predeterminado
                'usuarioId_Crea'=> auth()->user()->id,
                'usuarioId_Aprueba'=>null,
                'fechaActualizacion'=>$request['fechaActualizacion'],
                'comentario'=>$request['comentario'],
                'estado'=>'PE'
              ]); 

            $censo = Censo::Create([
                'importacion_id'=>$importacion->id, // valor predeterminado
                'anio_id'=> $request['anio'],
                'estado'=>'PE'
              ]); 

            foreach ($array as $key => $value) {
                foreach ($value as $row) {
                    // echo $row['cen_edu'].'<br>';
                    $CensoResultado = CensoResultado::Create([
                        'censo_id'=>$censo->id,
                        'codLocal'=>$row['codlocal'],
                        'codigosModulares'=>$row['codigosmodulares'],
                        'nombreInstitucion'=>$row['nombreinstitucion'],
                        'codigoGestion'=>$row['codigogestion'],
                        'descripcionGestion'=>$row['descripciongestion'],
                        'codigoOrganoInter'=>$row['codigoorganointer'],
                        'nombreDre_Ugel'=>$row['nombredre_ugel'],
                        'codigoUbigeo'=>$row['codigoubigeo'],
                        'Departamento'=>$row['departamento'],
                        'Provincia'=>$row['provincia'],
                        'Distrito'=>$row['distrito'],
                        'centoPoblado'=>$row['centopoblado'],
                        'direccion'=>$row['direccion'],
                        'areaGeo'=>$row['areageo'],
                        'estadoCenso'=>$row['estadocenso'],
                        'totalAulas'=>$row['totalaulas'],
                        'aulasBuenas'=>$row['aulasbuenas'],
                        'aulasRegulares'=>$row['aulasregulares'],
                        'aulasMalas'=>$row['aulasmalas'],
                        'noPuedePrecisarEstadoAulas'=>$row['nopuedeprecisarestadoaulas'],
                        'elLocalEs'=>$row['ellocales'],
                        'propietarioLocal'=>$row['propietariolocal'],
                        'compuEscri_operativos'=>$row['compuescri_operativos'],
                        'compuEscri_inoperativos'=>$row['compuescri_inoperativos'],
                        'compuPorta_operativos'=>$row['compuporta_operativos'],
                        'compuPorta_inoperativos'=>$row['compuporta_inoperativos'],
                        'lapto_operativos'=>$row['lapto_operativos'],
                        'lapto_inoperativos'=>$row['lapto_inoperativos'],
                        'tieneInternet'=>$row['tieneinternet'],
                        'tipoConexion'=>$row['tipoconexion'],
                        'fuenteEnergiaElectrica'=>$row['fuenteenergiaelectrica'],
                        'empresaEnergiaElect'=>$row['empresaenergiaelect'],
                        'tieneEnergiaElectTodoDia'=>$row['tieneenergiaelecteododia'],
                        'fuenteAgua'=>$row['fuenteagua'],
                        'empresaAgua'=>$row['empresaagua'],
                        'tieneAguaPotTodoDia'=>$row['tieneaguapottododia'],
                        'desagueInfo'=>$row['desagueinfo']             
                    ]);
                }
            }
        }catch (Exception $e) {
            $importacion->delete();// elimina la importacion creada
            $censo->delete(); 
            $mensaje = "Error en la carga de datos, comuniquese con el administrador del sistema";           
            return view('Educacion.Censo.Importar',compact('mensaje','anios'));            
        }

        return 1;
        //return redirect()->route('CuadroAsigPersonal.CuadroAsigPersonal_Lista',$importacion->id);
    }

    public function ListaImportada($importacion_id)
    {
        return view('Educacion.CuadroAsigPersonal.ListaImportada',compact('importacion_id'));
    }

    // public function ListaImportada_DataTable($importacion_id)
    // {
    //     $Lista = CuadroAsigPersonalRepositorio::Listar_Por_Importacion_id($importacion_id);
                
    //     return  datatables()->of($Lista)->toJson();;
    // }
    
    // public function aprobar($importacion_id)
    // {
    //     $importacion = ImportacionRepositorio::ImportacionPor_Id($importacion_id);

    //     return view('educacion.CuadroAsigPersonal.Aprobar',compact('importacion_id','importacion'));
    // } 

    // public function procesar($importacion_id)
    // {
    //     $procesar = DB::select('call edu_pa_procesarCuadroAsigPersonal(?)', [$importacion_id]);
    //     return  $importacion_id;
    // }
    
}
