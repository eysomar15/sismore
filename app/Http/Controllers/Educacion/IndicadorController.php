<?php

namespace App\Http\Controllers\Educacion;

use App\Http\Controllers\Controller;
use App\Models\Educacion\Clasificador;
use App\Models\Educacion\Indicador;
use Illuminate\Http\Request;

class IndicadorController extends Controller
{
    public function indicadorMenu($clasificador){
        $clas=Clasificador::where('dependencia',$clasificador)->first();
        $clas=Clasificador::where('dependencia',$clas->id)->get();
        //$inds=Indicador::where('clasificador_id',$clas->id)->get();
        //return $inds;
        return view('educacion.indicador.menu',compact('clas'));
    }
}
