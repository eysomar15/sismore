<?php

namespace App\Http\Controllers\Educacion;

use App\Http\Controllers\Controller;
use App\Models\Parametro\Clasificador;
use App\Models\Educacion\Indicador;
use App\Models\Ubigeo;
use App\Repositories\Educacion\IndicadorRepositorio;
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
        $inds = IndicadorRepositorio::listar_indicador1('1');
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
        return view('educacion.indicador.educat1', compact('title', 'nivel', 'inds', 'minds', 'info'));
    }
    public function indicadorEducacion2()
    {
        $indicadorx = Indicador::find(2);
        $title = $indicadorx->nombre; 
        $nivel = 38;
        $inds = IndicadorRepositorio::listar_indicador1('2');
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
        return view('educacion.indicador.educat1', compact('title', 'nivel', 'inds', 'minds', 'info'));
    }
    public function indicadorEducacion3()
    {
        $indicadorx = Indicador::find(3);
        $title = $indicadorx->nombre; 
        $nivel = 0;// ES MUY VARIBLE
        $inds = IndicadorRepositorio::listar_indicador1('3');
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
        return view('educacion.indicador.educat1', compact('title', 'nivel', 'inds', 'minds', 'info'));
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
        
        return view('educacion.indicador.educat4', compact('title', 'nivel'));
    }
    public function indicadorEducacion12()
    {
        $indicadorx = Indicador::find(12);
        $title = $indicadorx->nombre; 
        $nivel = 37;
        return view('educacion.indicador.educat4', compact('title', 'nivel'));
    }
    public function indicadorEducacion13()
    {
        $indicadorx = Indicador::find(13);
        $title = $indicadorx->nombre; 
        $nivel = 38;

        return view('educacion.indicador.educat4', compact('title', 'nivel'));
    }
}
