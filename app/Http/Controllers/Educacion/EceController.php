<?php

namespace App\Http\Controllers\Educacion;

use App\Http\Controllers\Controller;
use App\Imports\IndicadoresImport;
use App\Models\Educacion\Ece;
use App\Models\Educacion\EceResultado;
use App\Models\Educacion\Grado;
use App\Models\Educacion\InstitucionEducativa;
use App\Models\Educacion\Materia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EceController extends Controller
{
    public function importar(){
        $materias=Materia::all();
        $grados=DB::table('edu_grado as v1')->select('v1.*','v2.nombre')
                    ->join('edu_nivelmodalidad as v2','v2.id','=','v1.nivelmodalidad_id')
                    ->whereIn('v1.nivelmodalidad_id',['37','38'])->get();
        return view('educacion.ece.importar',compact('grados','materias'));
    }
    public function importarStore(Request $request){
        $this->validate($request,['file'=>'required|mimes:xls,xlsx',]);
        $archivo=$request->file('file');
        $array=(new IndicadoresImport)->toArray($archivo);
        $errores['tipo']='1';
        $errores['msn']='Importacion Exitosa';
        /*Buscar colegios no agregados*/
        $noagregados=[];
        foreach ($array as $key => $value) {
            foreach ($value as $key2 => $row) {
                $insedu=InstitucionEducativa::where('codModular',$row['codigo_modular'])->first();
                if(!$insedu){
                    $noagregados[]=$row['codigo_modular'];
                }
            }            
        }
        if(count($noagregados)>0){
            $errores['tipo']='0';
            $errores['msn']='ERROR EN LA IMPORTACION';
            return view('educacion.Ece.Error1',compact('noagregados','errores'));
        }
        
        /** agregar excel al sistema */
        if(count($array)>0){
            $ece=Ece::where('anio',$request->anio)
                    ->where('tipo',$request->tipo)
                    ->where('grado_id',$request->grado)->first();
            if(!$ece){
                $ece=Ece::Create([
                    'anio'=>$request->anio,
                    'tipo'=>$request->tipo,
                    'grado_id'=>$request->grado,
                ]);
            }        
            foreach ($array as $key => $value) {
                foreach ($value as $key2 => $row) {
                    $insedu=InstitucionEducativa::where('codModular',$row['codigo_modular'])->first();
                        $eceresultado=EceResultado::Create([
                            'ece_id'=>$ece->id,
                            'institucioneducativa_id'=>$insedu->id,
                            'materia_id'=>$request->materia,
                            'programados'=>$row['programados'],
                            'evaluados'=>$row['evaluados'],
                            'previo'=>$row['previo'],
                            'inicio'=>$row['inicio'],
                            'proceso'=>$row['proceso'],
                            'mediapromedio'=>$row['media_promedio'],
                            'satisfactorio'=>$row['satisfactorio'],                            
                        ]);                      
                }
                
            }
        }  
        return back()->with('message','IMPORTACION EXITOSA');
    }
    public function importarMenu(){
        return view('educacion.ece.menu');
    }    
    public function primerIndicador(){
        return 'jajaja te la creiste';
    }
}
