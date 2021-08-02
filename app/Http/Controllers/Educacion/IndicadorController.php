<?php

namespace App\Http\Controllers\Educacion;

use App\Http\Controllers\Controller;
use App\Models\Parametro\Clasificador;
use App\Models\Educacion\Indicador;
use App\Models\Ubigeo;
use App\Repositories\Educacion\EceRepositorio;
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
        $limit = 100;
        $labels = '[';
        $datas = '[';
        foreach ($inds as $key => $item) {
            $labels .= $item->anio . ',';
            $datas .= floatval($item->resultado) . ',';
            $limit = intval($item->resultado) < 100 ? intval($item->resultado) : $limit;
        }
        $labels .= ']';
        $datas .= ']';
        $info = ['labels' => $labels, 'datas' => $datas];
        $limit = ($limit < 25 ? 25 : ($limit < 50 ? 50 : ($limit < 75 ? 75 : 100)));
        return view('educacion.indicador.educat1', compact('title', 'nivel', 'inds',  'info', 'limit'));
    }
    public function indicadorEducacion2()
    {
        $indicadorx = Indicador::find(2);
        $title = $indicadorx->nombre;
        $nivel = 38;
        $inds = IndicadorRepositorio::listar_indicador1('2');
        $limit = 100;
        $labels = '[';
        $datas = '[';
        foreach ($inds as $key => $item) {
            $labels .= $item->anio . ',';
            $datas .= $item->resultado . ',';
            $limit = intval($item->resultado) < 100 ? intval($item->resultado) : $limit;
        }
        $labels .= ']';
        $datas .= ']';
        $info = ['labels' => $labels, 'datas' => $datas];
        $limit = ($limit < 25 ? 25 : ($limit < 50 ? 50 : ($limit < 75 ? 75 : 100)));
        return view('educacion.indicador.educat1', compact('title', 'nivel', 'inds',   'info', 'limit'));
    }
    public function indicadorEducacion3()
    {
        $indicadorx = Indicador::find(3);
        $title = $indicadorx->nombre;
        $nivel = 0; // ES MUY VARIBLE
        $inds = IndicadorRepositorio::listar_indicador1('3');
        $limit = 100;
        $labels = '[';
        $datas = '[';
        foreach ($inds as $key => $item) {
            $labels .= $item->anio . ',';
            $datas .= $item->resultado . ',';
            $limit = intval($item->resultado) < 100 ? intval($item->resultado) : $limit;
        }
        $labels .= ']';
        $datas .= ']';
        $info = ['labels' => $labels, 'datas' => $datas];
        $limit = ($limit < 25 ? 25 : ($limit < 50 ? 50 : ($limit < 75 ? 75 : 100)));
        return view('educacion.indicador.educat1', compact('title', 'nivel', 'inds', 'info', 'limit'));
    }
    /******* */
    public function indicadorEducacion8()
    {
        $indicadorx = Indicador::find(8);
        $title = $indicadorx->nombre;
        $nivel = 1;
        $inds = IndicadorRepositorio::listar_indicador1('8');
        $limit = 100;
        $labels = '[';
        $datas = '[';
        foreach ($inds as $key => $item) {
            $labels .= $item->anio . ',';
            $datas .= floatval($item->resultado) . ',';
            $limit = intval($item->resultado) < 100 ? intval($item->resultado) : $limit;
        }
        $labels .= ']';
        $datas .= ']';
        $info = ['labels' => $labels, 'datas' => $datas];
        $limit = ($limit < 25 ? 25 : ($limit < 50 ? 50 : ($limit < 75 ? 75 : 100)));
        return view('educacion.indicador.educat1', compact('title', 'nivel', 'inds',  'info', 'limit'));
    }
    public function indicadorEducacion9()
    {
        $indicadorx = Indicador::find(9);
        $title = $indicadorx->nombre;
        $nivel = 37;
        $inds = IndicadorRepositorio::listar_indicador1('9');
        $limit = 100;
        $labels = '[';
        $datas = '[';
        foreach ($inds as $key => $item) {
            $labels .= $item->anio . ',';
            $datas .= floatval($item->resultado) . ',';
            $limit = intval($item->resultado) < 100 ? intval($item->resultado) : $limit;
        }
        $labels .= ']';
        $datas .= ']';
        $info = ['labels' => $labels, 'datas' => $datas];
        $limit = ($limit < 25 ? 25 : ($limit < 50 ? 50 : ($limit < 75 ? 75 : 100)));
        return view('educacion.indicador.educat1', compact('title', 'nivel', 'inds',  'info', 'limit'));
    }
    public function indicadorEducacion10()
    {
        $indicadorx = Indicador::find(10);
        $title = $indicadorx->nombre;
        $nivel = 38;
        $inds = IndicadorRepositorio::listar_indicador1('10');
        $limit = 100;
        $labels = '[';
        $datas = '[';
        foreach ($inds as $key => $item) {
            $labels .= $item->anio . ',';
            $datas .= floatval($item->resultado) . ',';
            $limit = intval($item->resultado) < 100 ? intval($item->resultado) : $limit;
        }
        $labels .= ']';
        $datas .= ']';
        $info = ['labels' => $labels, 'datas' => $datas];
        $limit = ($limit < 25 ? 25 : ($limit < 50 ? 50 : ($limit < 75 ? 75 : 100)));
        return view('educacion.indicador.educat1', compact('title', 'nivel', 'inds',  'info', 'limit'));
    }
    //****** */
    public function indicadorEducacion11()
    {
        $indicadorx = Indicador::find(11);
        $title = $indicadorx->nombre;
        $nivel = 31; //31

        $inds = IndicadorRepositorio::listar_profesorestitulados($nivel);
        $total = 0;
        foreach ($inds as $key => $value) {
            $total += $value->suma;
            if ($value->titulado == 0) {
                $value->titulado = 'NO TITULADO';
            } else $value->titulado = 'TITULADO';
        }
        $labels = '[';
        $datas = '[';
        foreach ($inds as $key => $value) {
            $labels .= '"' . $value->titulado . '",';
            $datas .= round($value->suma * 100 / $total, 2) . ',';
        }
        $labels .= ']';
        $datas .= ']';
        $graf1 = ['labels' => $labels, 'datas' => $datas];

        $indu = IndicadorRepositorio::listar_profesorestituladougel($nivel, '1');
        foreach ($indu as $key => $value) {
            $indutt = IndicadorRepositorio::listar_profesorestituladougel($nivel);
            $value->total = $indutt[0]->total;
        }
        $labels = '[';
        $datas = '[';
        foreach ($indu as $key => $value) {
            $labels .= '"' . $value->nombre . '",';
            $datas .= round($value->titulado * 100 / $total, 2) . ',';
        }
        $labels .= ']';
        $datas .= ']';
        $graf2 = ['labels' => $labels, 'datas' => $datas];
        return view('educacion.indicador.educat4', compact('title', 'nivel', 'inds', 'total', 'graf1', 'indu', 'graf2'));
    }
    public function indicadorEducacion12()
    {
        $indicadorx = Indicador::find(12);
        $title = $indicadorx->nombre;
        $nivel = 37;
        $inds = IndicadorRepositorio::listar_profesorestitulados($nivel);
        $total = 0;
        foreach ($inds as $key => $value) {
            $total += $value->suma;
            if ($value->titulado == 0) {
                $value->titulado = 'NO TITULADO';
            } else $value->titulado = 'TITULADO';
        }
        $labels = '[';
        $datas = '[';
        foreach ($inds as $key => $value) {
            $labels .= '"' . $value->titulado . '",';
            $datas .= round($value->suma * 100 / $total, 2) . ',';
        }
        $labels .= ']';
        $datas .= ']';
        $graf1 = ['labels' => $labels, 'datas' => $datas];

        $indu = IndicadorRepositorio::listar_profesorestituladougel($nivel, '1');
        foreach ($indu as $key => $value) {
            $indutt = IndicadorRepositorio::listar_profesorestituladougel($nivel);
            $value->total = $indutt[0]->total;
        }
        $labels = '[';
        $datas = '[';
        foreach ($indu as $key => $value) {
            $labels .= '"' . $value->nombre . '",';
            $datas .= round($value->titulado * 100 / $total, 2) . ',';
        }
        $labels .= ']';
        $datas .= ']';
        $graf2 = ['labels' => $labels, 'datas' => $datas];
        return view('educacion.indicador.educat4', compact('title', 'nivel', 'inds', 'total', 'graf1', 'indu', 'graf2'));
    }
    public function indicadorEducacion13()
    {
        $indicadorx = Indicador::find(13);
        $title = $indicadorx->nombre;
        $nivel = 38;
        $inds = IndicadorRepositorio::listar_profesorestitulados($nivel);
        $total = 0;
        foreach ($inds as $key => $value) {
            $total += $value->suma;
            if ($value->titulado == 0) {
                $value->titulado = 'NO TITULADO';
            } else $value->titulado = 'TITULADO';
        }
        $labels = '[';
        $datas = '[';
        foreach ($inds as $key => $value) {
            $labels .= '"' . $value->titulado . '",';
            $datas .= round($value->suma * 100 / $total, 2) . ',';
        }
        $labels .= ']';
        $datas .= ']';
        $graf1 = ['labels' => $labels, 'datas' => $datas];

        $indu = IndicadorRepositorio::listar_profesorestituladougel($nivel, '1');
        foreach ($indu as $key => $value) {
            $indutt = IndicadorRepositorio::listar_profesorestituladougel($nivel);
            $value->total = $indutt[0]->total;
        }
        $labels = '[';
        $datas = '[';
        foreach ($indu as $key => $value) {
            $labels .= '"' . $value->nombre . '",';
            $datas .= round($value->titulado * 100 / $total, 2) . ',';
        }
        $labels .= ']';
        $datas .= ']';
        $graf2 = ['labels' => $labels, 'datas' => $datas];
        return view('educacion.indicador.educat4', compact('title', 'nivel', 'inds', 'total', 'graf1', 'indu', 'graf2'));
    }
    public function indicadorPDRC1()
    {
        $provincias = Ubigeo::whereRaw('LENGTH(codigo)=4')->get();
        $indicadorx = Indicador::find(14);
        $title = $indicadorx->nombre;
        $grado = 2;
        $tipo = 0;
        $materia=1;
        $ruta = 'ece.indicador.vista';
        $anios = EceRepositorio::buscar_anios1($grado, $tipo);
        $sinaprobar = EceRepositorio::listar_importacionsinaprobar1($grado, $tipo);
        $info1 = EceRepositorio::buscar_materia2('2019', $grado, $tipo,$materia);
        foreach ($info1 as $key => $value) {
            $value->indicador = EceRepositorio::listar_indicadoranio(date('Y'), $grado, $tipo, $value->id, 'asc');
        }
        return view('educacion.indicador.pdrc1', compact('provincias', 'title', 'grado', 'tipo', 'ruta', 'anios', 'sinaprobar', 'info1'));
    }
    public function indicadorPDRC2()
    {
        $provincias = Ubigeo::whereRaw('LENGTH(codigo)=4')->get();
        $indicadorx = Indicador::find(15);
        $title = $indicadorx->nombre;
        $grado = 2;
        $tipo = 0;
        $materia=2;
        $ruta = 'ece.indicador.vista';
        $anios = EceRepositorio::buscar_anios1($grado, $tipo);
        $sinaprobar = EceRepositorio::listar_importacionsinaprobar1($grado, $tipo);
        $info1 = EceRepositorio::buscar_materia2('2019', $grado, $tipo,$materia);
        foreach ($info1 as $key => $value) {
            $value->indicador = EceRepositorio::listar_indicadoranio(date('Y'), $grado, $tipo, $value->id, 'asc');
        }
        //return $info1;
        return view('educacion.indicador.pdrc1', compact('provincias', 'title', 'grado', 'tipo', 'ruta', 'anios', 'sinaprobar', 'info1'));
    }
    public function indicadorPDRC3()
    {
        $indicadorx = Indicador::find(16);
        $title = $indicadorx->nombre;
        $nivel = 38;
        $inds = IndicadorRepositorio::listar_profesorestitulados($nivel);
        $total = 0;
        foreach ($inds as $key => $value) {
            $total += $value->suma;
            if ($value->titulado == 0) {
                $value->titulado = 'NO TITULADO';
            } else $value->titulado = 'TITULADO';
        }
        $labels = '[';
        $datas = '[';
        foreach ($inds as $key => $value) {
            $labels .= '"' . $value->titulado . '",';
            $datas .= round($value->suma * 100 / $total, 2) . ',';
        }
        $labels .= ']';
        $datas .= ']';
        $graf1 = ['labels' => $labels, 'datas' => $datas];

        $indu = IndicadorRepositorio::listar_profesorestituladougel($nivel, '1');
        foreach ($indu as $key => $value) {
            $indutt = IndicadorRepositorio::listar_profesorestituladougel($nivel);
            $value->total = $indutt[0]->total;
        }
        $labels = '[';
        $datas = '[';
        foreach ($indu as $key => $value) {
            $labels .= '"' . $value->nombre . '",';
            $datas .= round($value->titulado * 100 / $total, 2) . ',';
        }
        $labels .= ']';
        $datas .= ']';
        $graf2 = ['labels' => $labels, 'datas' => $datas];
        return view('educacion.indicador.educat4', compact('title', 'nivel', 'inds', 'total', 'graf1', 'indu', 'graf2'));
    }
    public function indicadorPDRC4()
    {
        $indicadorx = Indicador::find(17);
        $title = $indicadorx->nombre;
        $nivel = 38;
        $inds = IndicadorRepositorio::listar_profesorestitulados($nivel);
        $total = 0;
        foreach ($inds as $key => $value) {
            $total += $value->suma;
            if ($value->titulado == 0) {
                $value->titulado = 'NO TITULADO';
            } else $value->titulado = 'TITULADO';
        }
        $labels = '[';
        $datas = '[';
        foreach ($inds as $key => $value) {
            $labels .= '"' . $value->titulado . '",';
            $datas .= round($value->suma * 100 / $total, 2) . ',';
        }
        $labels .= ']';
        $datas .= ']';
        $graf1 = ['labels' => $labels, 'datas' => $datas];

        $indu = IndicadorRepositorio::listar_profesorestituladougel($nivel, '1');
        foreach ($indu as $key => $value) {
            $indutt = IndicadorRepositorio::listar_profesorestituladougel($nivel);
            $value->total = $indutt[0]->total;
        }
        $labels = '[';
        $datas = '[';
        foreach ($indu as $key => $value) {
            $labels .= '"' . $value->nombre . '",';
            $datas .= round($value->titulado * 100 / $total, 2) . ',';
        }
        $labels .= ']';
        $datas .= ']';
        $graf2 = ['labels' => $labels, 'datas' => $datas];
        return view('educacion.indicador.educat4', compact('title', 'nivel', 'inds', 'total', 'graf1', 'indu', 'graf2'));
    }
}
