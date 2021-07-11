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

class IndicadorController extends Controller
{
    public function importar(){
        $materias=Materia::all();
        $grados=DB::table('edu_grado as v1')->select('v1.*','v2.nombre')
                    ->join('edu_nivelmodalidad as v2','v2.id','=','v1.nivelmodalidad_id')
                    ->whereIn('v1.nivelmodalidad_id',['37','38'])->get();
        return view('educacion.indicadores.importar',compact('grados','materias'));
    }
    public function importarStore(Request $request){
        $this->validate($request,['file'=>'required|mimes:xls,xlsx',]);
        $archivo=$request->file('file');
        $array=(new IndicadoresImport)->toArray($archivo);

        if(count($array)>0){
            foreach ($array as $key => $value) {
                foreach ($value as $row) {
                    $ece=DB::table('edu_ece as v1')->select('v1.*')
                    ->join('edu_institucioneducativa as v2','v2.id','=','v1.institucioneducativa_id')
                    ->where('v2.codModular',intval($row['codigo_modular']))->first();
                    if(!$ece){
                        $insedu=InstitucionEducativa::where('codModular',intval($row['codigo_modular']))->first();
                        $ece=Ece::Create([
                            'institucioneducativa_id'=>$insedu->id,
                            'anio'=>$request->anio,
                            'tipo'=>$request->tipo,
                            'grado_id'=>$request->grado,
                        ]);
                    }
                    $eceresultado=EceResultado::Create([
                        'ece_id'=>$ece->id,
                        'programados'=>$row['programados'],
                        'evaluados'=>$row['evaluados'],
                        'cobertura'=>$row['cobertura'],
                        'previo'=>$row['previo'],
                        'inicio'=>$row['inicio'],
                        'proceso'=>$row['proceso'],
                        'satisfactorio'=>$row['satisfactorio'],
                        'materia'=>$request->materia,
                    ]);
                }
                
            }
        }  
        return $array;
    }
    public function primerIndicador(){
        return 'jajaja te la creiste';
    }
}
