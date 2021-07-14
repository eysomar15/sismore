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
    public function indicador1(){

        return view('educacion.ece.indicador1');
    }
    public function indicador5(){
        $grado=DB::table('edu_grado as v1')->select('v1.*','v2.nombre')
                    ->join('edu_nivelmodalidad as v2','v2.id','=','v1.nivelmodalidad_id')
                    ->where('v1.descripcion','2do')
                    ->where('v2.nombre','Secundaria')->first();
                    //->where('v2.nombre','Primaria')->first();
        $materias=DB::table('edu_materia as v1')
                    ->select('v1.*')
                    ->join('edu_eceresultado as v2','v2.materia_id','=','v1.id')
                    ->join('edu_ece as v3','v3.id','=','v2.ece_id')
                    ->where('v3.grado_id',$grado->id)
                    ->distinct()->get();
        $distritos=DB::table('par_ubigeo as v1')
                    ->select('v1.*')
                    ->join('centropoblado as v2','v2.Ubigeo_id','=','v1.id')
                    ->join('edu_institucioneducativa as v3','v3.CentroPoblado_id','=','v2.id')
                    ->join('edu_eceresultado as v4','v4.institucioneducativa_id','=','v3.id')
                    ->join('edu_ece as v5','v5.id','=','v4.ece_id')
                    ->where('v5.grado_id',$grado->id)
                    ->distinct()->get();
        $tabla='<table class="table mb-0">';
        $tabla.='<thead><tr><th></th>';
        foreach ($materias as $key => $value) {
            $tabla.='<th>'.$value->descripcion.'</th>';
        }
        $tabla.='</tr></thead><tbody>';
        foreach ($distritos as $distrito) {
            $tabla.='<tr><td>'.$distrito->nombre.'</td>';
            foreach ($materias as $materia) {
                
                $tabla.='<td></td>';
            }
            $tabla.='</tr>';
        
        }
                    
        $tabla.='</tbody></table>';
        //$tabla=['cc'=>$tabla];
        //return $tabla;
        return view('educacion.ece.indicador5',compact('grado','materias','distritos','tabla'));
    }
}
