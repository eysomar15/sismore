<?php

namespace App\Http\Controllers\Educacion;

use App\Http\Controllers\Controller;
use App\Imports\IndicadoresImport;
use Illuminate\Http\Request;

class IndicadorController extends Controller
{
    public function importar(){
        return view('educacion.indicadores.importar');
    }
    public function importarStore(Request $request){
        $this->validate($request,['file'=>'required|mimes:xls,xlsx',]);
        $archivo=$request->file('file');
        $array=(new IndicadoresImport)->toArray($archivo);

        return $array;
    }
    public function primerIndicador(){
        return 'jajaja te la creiste';
    }
}
