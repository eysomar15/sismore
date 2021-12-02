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
        $dato['pde'] = CentroPobladoDatassRepositorio::poblacion_disposicion_excretas($request->fecha, $request->provincia, $request->distrito);
        $dato['vsa'] = CentroPobladoDatassRepositorio::viviendas_servicio_agua($request->fecha, $request->provincia, $request->distrito);
        $dato['vde'] = CentroPobladoDatassRepositorio::viviendas_disposicion_excretas($request->fecha, $request->provincia, $request->distrito);
        return response()->json(compact('dato'));
    }
    public function DTsaneamiento($provincia, $distrito, $importacion_id)
    {
        $data = CentroPobladoDatassRepositorio::listar_porubigeo($provincia, $distrito, $importacion_id);

        return  datatables()::of($data)
            /*->editColumn('icono', '<i class="{{$icono}}"></i>')
            ->editColumn('estado', function ($data) {
               return '';
            })*/
            //->rawColumns(['action', 'icono', 'estado'])
            ->make(true);
    }

    public function infraestructurasanitaria()
    {
        $ingresos = ImportacionRepositorio::Listar_deCentroPobladoDatass();
        $provincias = CentroPobladoDatassRepositorio::listar_provincia();
        //$provincias=CentroPobladoDatassRepositorio::listar_distrito(35);
        return view('vivienda.CentroPobladoDatass.InfraestructuraSanitaria', compact('ingresos', 'provincias'));
    }
    public function datoInfraestructuraSanitaria(Request $request)
    {
        $dato['psa'] = CentroPobladoDatassRepositorio::poblacion_servicio_agua($request->fecha, $request->provincia, $request->distrito);
        $dato['pde'] = CentroPobladoDatassRepositorio::poblacion_disposicion_excretas($request->fecha, $request->provincia, $request->distrito);
        $dato['vsa'] = CentroPobladoDatassRepositorio::viviendas_servicio_agua($request->fecha, $request->provincia, $request->distrito);
        $dato['vde'] = CentroPobladoDatassRepositorio::viviendas_disposicion_excretas($request->fecha, $request->provincia, $request->distrito);
        return response()->json(compact('dato'));
    }
    public function prestadorservicio()
    {
        $ingresos = ImportacionRepositorio::Listar_deCentroPobladoDatass();
        $provincias = CentroPobladoDatassRepositorio::listar_provincia();
        //$provincias=CentroPobladoDatassRepositorio::listar_distrito(35);
        return view('vivienda.CentroPobladoDatass.Saneamiento', compact('ingresos', 'provincias'));
    }
    public function calidadservicio()
    {
        $ingresos = ImportacionRepositorio::Listar_deCentroPobladoDatass();
        $provincias = CentroPobladoDatassRepositorio::listar_provincia();
        //$provincias=CentroPobladoDatassRepositorio::listar_distrito(35);
        return view('vivienda.CentroPobladoDatass.Saneamiento', compact('ingresos', 'provincias'));
    }
}
