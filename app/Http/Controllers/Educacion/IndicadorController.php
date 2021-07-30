<?php

namespace App\Http\Controllers\Educacion;

use App\Http\Controllers\Controller;
use App\Models\Educacion\Clasificador;
use App\Models\Educacion\Indicador;
use App\Models\Ubigeo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IndicadorController extends Controller
{
    public function indicadorEducacionMenu($clasificador)
    {
        $clas = Clasificador::where('dependencia', $clasificador)->first();
        $clas = Clasificador::where('dependencia', $clas->id)->get();
        return view('educacion.indicador.menu', compact('clas'));
    }

    public function indicadorEducacion1()
    {
        $indicadorx = Indicador::find(1);
        $title = $indicadorx->nombre; 
        $nivel = 37;
        $inds = DB::table('par_indicador_resultado as v1')
            ->join('par_ubigeo as v2', 'v2.id', '=', 'v1.ubigeo_id')
            ->join('par_anio as v3', 'v3.id', '=', 'v1.anio_id')
            ->select('v1.resultado', 'v1.nota', 'v2.nombre as departamento', 'v3.anio')
            ->where('v1.indicador_id', '1')->get();
        $minds = '[';
        foreach ($inds as $key => $item) {
            $minds .= '[' . $item->anio . ',' . floatval($item->resultado) . '],';
        }
        $minds .= ']';
        $labels = '[';
        $datas = '[';
        foreach ($inds as $key => $item) {
            $labels .= $item->anio . ',';
            $datas .= $item->resultado . ',';
        }
        $labels .= ']';
        $datas .= ']';
        $info = ['labels' => $labels, 'datas' => $datas];
        return view('educacion.indicador.contenedor', compact('title', 'nivel', 'inds', 'minds', 'info'));
    }
    public function indicadorEducacion2()
    {
        $indicadorx = Indicador::find(2);
        $title = $indicadorx->nombre; 
        $nivel = 38;
        $inds = DB::table('par_indicador_resultado as v1')
            ->join('par_ubigeo as v2', 'v2.id', '=', 'v1.ubigeo_id')
            ->join('par_anio as v3', 'v3.id', '=', 'v1.anio_id')
            ->select('v1.resultado', 'v1.nota', 'v2.nombre as departamento', 'v3.anio')
            ->where('v1.indicador_id', '2')->get();
        $minds = '[';
        foreach ($inds as $key => $item) {
            $minds .= '[' . $item->anio . ',' . floatval($item->resultado) . '],';
        }
        $minds .= ']';
        $labels = '[';
        $datas = '[';
        foreach ($inds as $key => $item) {
            $labels .= $item->anio . ',';
            $datas .= $item->resultado . ',';
        }
        $labels .= ']';
        $datas .= ']';
        $info = ['labels' => $labels, 'datas' => $datas];
        return view('educacion.indicador.contenedor', compact('title', 'nivel', 'inds', 'minds', 'info'));
    }
    public function indicadorEducacion3()
    {
        $indicadorx = Indicador::find(3);
        $title = $indicadorx->nombre; 
        $nivel = 0;// ES MUY VARIBLE
        $inds = DB::table('par_indicador_resultado as v1')
            ->join('par_ubigeo as v2', 'v2.id', '=', 'v1.ubigeo_id')
            ->join('par_anio as v3', 'v3.id', '=', 'v1.anio_id')
            ->select('v1.resultado', 'v1.nota', 'v2.nombre as departamento', 'v3.anio')
            ->where('v1.indicador_id', '3')->get();
        $minds = '[';
        foreach ($inds as $key => $item) {
            $minds .= '[' . $item->anio . ',' . floatval($item->resultado) . '],';
        }
        $minds .= ']';
        $labels = '[';
        $datas = '[';
        foreach ($inds as $key => $item) {
            $labels .= $item->anio . ',';
            $datas .= $item->resultado . ',';
        }
        $labels .= ']';
        $datas .= ']';
        $info = ['labels' => $labels, 'datas' => $datas];
        return view('educacion.indicador.contenedor', compact('title', 'nivel', 'inds', 'minds', 'info'));
    }
/******* */
    public function indicadorEducacion8()
    {
        $indicadorx = Indicador::find(8);
        $title = $indicadorx->nombre; 
        $nivel = 1;
        return 'sin informacion 8';
    }
    public function indicadorEducacion9()
    {
        $indicadorx = Indicador::find(9);
        $title = $indicadorx->nombre; 
        $nivel = 37;
        return 'sin informacion 9';
    }
    public function indicadorEducacion10()
    {
        $indicadorx = Indicador::find(10);
        $title = $indicadorx->nombre; 
        $nivel = 38;
        return 'sin informacion 10';
    }
    //****** */
    public function indicadorEducacion11()
    {
        $indicadorx = Indicador::find(11);
        $title = $indicadorx->nombre; 
        $nivel = 1;
        return 'sin informacion 11';
    }
    public function indicadorEducacion12()
    {
        $indicadorx = Indicador::find(12);
        $title = $indicadorx->nombre; 
        $nivel = 37;
        return 'sin informacion 12';
    }
    public function indicadorEducacion13()
    {
        $indicadorx = Indicador::find(13);
        $title = $indicadorx->nombre; 
        $nivel = 38;
        return 'sin informacion 13';
    }
}
