<?php

namespace App\Http\Controllers\Vivienda;

use App\Http\Controllers\Controller;
use App\Repositories\Educacion\ImportacionRepositorio;
use App\Repositories\Vivienda\CentroPobladoDatassRepositorio;
use Illuminate\Http\Request;

class CentroPobladoDatassController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function saneamiento()
    {
        $ingresos = ImportacionRepositorio::Listar_deCentroPobladoDatass();
        $provincias = CentroPobladoDatassRepositorio::listar_provincia();
        //$provincias=CentroPobladoDatassRepositorio::listar_distrito(35);
        return view('vivienda.CentroPobladoDatass.Saneamiento', compact('ingresos', 'provincias'));
    }
    public function cargardistrito($provincia)
    {
        $distritos = CentroPobladoDatassRepositorio::listar_distrito($provincia);
        return response()->json(compact('distritos'));
    }
    public function datosSaneamiento(Request $request)
    {
        
        $dato['psa'] = CentroPobladoDatassRepositorio::poblacion_servicio_agua($request->fecha, $request->provincia, $request->distrito);
        $dato['pde'] = '';
        $dato['vsa'] = CentroPobladoDatassRepositorio::viviendas_servicio_agua($request->fecha, $request->provincia, $request->distrito);
        $dato['vde'] = '';
        return response()->json(compact('dato'));
    }
}
