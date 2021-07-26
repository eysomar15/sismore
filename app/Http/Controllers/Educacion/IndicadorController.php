<?php

namespace App\Http\Controllers\Educacion;

use App\Http\Controllers\Controller;
use App\Models\Educacion\Indicador;
use Illuminate\Http\Request;

class IndicadorController extends Controller
{
    public function indicadorMenu($clasificador){
        $inds=Indicador::where('clasificador_id',$clasificador)->get();
        return view('educacion.menu',compact('inds'));
    }
}
