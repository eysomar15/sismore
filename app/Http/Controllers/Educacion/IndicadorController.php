<?php

namespace App\Http\Controllers\Educacion;

use App\Http\Controllers\Controller;
use App\Models\Educacion\Indicador;
use Illuminate\Http\Request;

class IndicadorController extends Controller
{
    public function indicadorMenu($calificador){
        $inds=Indicador::where('calificador_id',$calificador)->get();
        return view('educacion.menu',compact('inds'));
    }
}
