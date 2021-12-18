<?php

namespace App\Http\Controllers\Educacion;

use App\Http\Controllers\Controller;
use App\Repositories\Educacion\PlazaRepositorio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PLazaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function cargardistritos($provincia)
    {
        $distritos = PlazaRepositorio::listar_distrito($provincia);
        return response()->json(compact('distritos'));
    }

    public function datoIndicadorPLaza(Request $request)
    {
        $dato['tt'] = PlazaRepositorio::listar_profesorestitulados($request->fecha,$request->nivel,$request->provincia,$request->distrito);
        $dato['tu'] = PlazaRepositorio::listar_profesorestituladougel($request->nivel,'AC');
        /*$dato['cde'] = CentroPobladoDatassRepositorio::centropoplado_porDisposicionExcretas($request->fecha, $request->provincia, $request->distrito);
        $dato['cts'] = CentroPobladoDatassRepositorio::centropoplado_porTipoServicioAgua($request->fecha, $request->provincia, $request->distrito);
        $dato['cad'] = CentroPobladoDatassRepositorio::centropoplado_porServicioAguaSINO($request->fecha, $request->provincia, $request->distrito);*/
        return response()->json(compact('dato'));
    }
}
