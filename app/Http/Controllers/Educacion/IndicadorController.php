<?php

namespace App\Http\Controllers\Educacion;

use App\Http\Controllers\Controller;
use App\Models\Educacion\Area;
use App\Models\Parametro\Clasificador;
use App\Models\Educacion\Indicador;
use App\Models\Educacion\Materia;
use App\Models\Educacion\NivelModalidad;
use App\Models\Educacion\TipoGestion;
use App\Models\Ubigeo;
//use App\Repositories\Educacion\EceRepositorio;
use App\Repositories\Educacion\IndicadorRepositorio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IndicadorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function indicadorEducacionMenu($clasificador)
    {
        $clas = Clasificador::where('dependencia', $clasificador)->first();
        $clas = Clasificador::where('dependencia', $clas->id)->get();
        return view('parametro.indicador.menu', compact('clas'));
    }
    public function indicadorEducacion($indicador_id)
    {
        $breadcrumb = [['titulo' => 'Relacion de indicadores', 'url' => route('Clasificador.menu', '01')], ['titulo' => 'Indicadores', 'url' => '']];
        switch ($indicador_id) {
            case '1': //CULMINACION 
                $indicador = Indicador::find($indicador_id);
                $title = $indicador->nombre;
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
                return view('parametro.indicador.educat1', compact('title', 'nivel', 'inds',  'info', 'limit', 'breadcrumb'));

            case '2': //CULMINACION 
                $indicador = Indicador::find($indicador_id);
                $title = $indicador->nombre;
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
                return view('parametro.indicador.educat1', compact('title', 'nivel', 'inds',   'info', 'limit', 'breadcrumb'));
            case '3': //CULMINACION 
                $indicador = Indicador::find($indicador_id);
                $title = $indicador->nombre;
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
                return view('parametro.indicador.educat1', compact('title', 'nivel', 'inds', 'info', 'limit', 'breadcrumb'));
            case '4': //LOGROS  
                $indicador = Indicador::find($indicador_id);
                $title = $indicador->nombre;
                $grado = 2;
                $tipo = 0;
                $sinaprobar = IndicadorRepositorio::listar_importacionsinaprobar1($grado, $tipo);
                return $this->vistaEducacionCat2($indicador_id, $title, $grado, $tipo, $sinaprobar);
            case '5': //LOGROS 
                $indicador = Indicador::find($indicador_id);
                $title = $indicador->nombre;
                $grado = 8;
                $tipo = 0;
                $sinaprobar = IndicadorRepositorio::listar_importacionsinaprobar1($grado, $tipo);
                return $this->vistaEducacionCat2($indicador_id, $title, $grado, $tipo, $sinaprobar);
            case '6': //LOGROS 
                $indicador = Indicador::find($indicador_id);
                $title = $indicador->nombre;
                $grado = 4;
                $tipo = 0;
                $sinaprobar = IndicadorRepositorio::listar_importacionsinaprobar1($grado, $tipo);
                return $this->vistaEducacionCat2($indicador_id, $title, $grado, $tipo, $sinaprobar);
            case '7': //LOGROS 
                $indicador = Indicador::find($indicador_id);
                $title = $indicador->nombre;
                $grado = 4;
                $tipo = 1; //EIB
                $sinaprobar = IndicadorRepositorio::listar_importacionsinaprobar1($grado, $tipo);
                return $this->vistaEducacionCat2($indicador_id, $title, $grado, $tipo, $sinaprobar);
            case '8': //ACCESO  
                $indicador = Indicador::find($indicador_id);
                $title = $indicador->nombre;
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
                return view('parametro.indicador.educat3', compact('title', 'nivel', 'inds',  'info', 'limit', 'breadcrumb'));
            case '9': //ACCESO  
                $indicador = Indicador::find($indicador_id);
                $title = $indicador->nombre;
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
                return view('parametro.indicador.educat3', compact('title', 'nivel', 'inds',  'info', 'limit', 'breadcrumb'));
            case '10': //ACCESO  
                $indicador = Indicador::find($indicador_id);
                $title = $indicador->nombre;
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
                return view('parametro.indicador.educat3', compact('title', 'nivel', 'inds',  'info', 'limit', 'breadcrumb'));
            case '11': //PROFESORES   
                $indicador = Indicador::find($indicador_id);
                $title = $indicador->nombre;
                $nivel = 31; //31
                return $this->vistaEducacionCat4($title, $nivel);
            case '12': //PROFESORES  
                $indicador = Indicador::find($indicador_id);
                $title = $indicador->nombre;
                $nivel = 37;
                return $this->vistaEducacionCat4($title, $nivel);
            case 13: //PROFESORES  
                $indicador = Indicador::find($indicador_id);
                $title = $indicador->nombre;
                $nivel = 38;
                return $this->vistaEducacionCat4($title, $nivel);
            default:
                return 'sin datos';
                break;
        }
    }
    public function vistaEducacionCat1($title, $grado, $tipo, $sinaprobar)
    {
        return 'sin informacion';
    }
    public function vistaEducacionCat2($indicador_id, $title, $grado, $tipo, $sinaprobar)
    {
        $gt = IndicadorRepositorio::buscar_grado1($grado);
        $materias = IndicadorRepositorio::buscar_materia3($grado, $tipo);
        foreach ($materias as $key => $materia) {
            $materia->indicador = IndicadorRepositorio::listar_indicadoranio(date('Y'), $grado, $tipo, $materia->id, 'asc');
        }
        $breadcrumb = [['titulo' => 'Relacion de indicadores', 'url' => route('Clasificador.menu', '01')], ['titulo' => 'Indicadores', 'url' => '']];
        return view('parametro.indicador.educat2', compact('indicador_id', 'title', 'grado', 'tipo', 'sinaprobar', 'materias', 'gt', 'breadcrumb'));
    }
    public function indDetEdu($indicador_id, $grado, $tipo, $materia)
    {
        $gt = IndicadorRepositorio::buscar_grado1($grado);
        $mt = Materia::find($materia);
        $title = 'Estudiantes del ' . $gt[0]->grado . ' grado de ' . $gt[0]->nivel . ' que logran el nivel satisfactorio en ' . $mt->descripcion;
        $anios = IndicadorRepositorio::buscar_anios1($grado, $tipo);
        foreach ($anios as $anio) {
            $anio->indicador = IndicadorRepositorio::listar_indicadorugel($anio->anio, $grado, $tipo, $materia);
            foreach ($anio->indicador as $indicador) {
                $indicador->ugel = str_replace('UGEL', '', $indicador->ugel);
            }
        }
        //return response()->json(compact('anios'));
        $breadcrumb = [['titulo' => 'Relacion de indicadores', 'url' => route('Clasificador.menu', '01')], ['titulo' => 'Indicadores', 'url' => url()->previous()], ['titulo' => 'Detalle', 'url' => '']];
        return view('parametro.indicador.educat2detalle', compact('title', 'grado', 'tipo', 'materia', 'anios', 'breadcrumb'));
    }
    public function indResEdu($indicador_id, $grado, $tipo, $materia)
    {
        $gt = IndicadorRepositorio::buscar_grado1($grado);
        $mt = Materia::find($materia);
        $title = 'Estudiantes del ' . $gt[0]->grado . ' grado de ' . $gt[0]->nivel . ' que logran el nivel satisfactorio en ' . $mt->descripcion;
        $anios = IndicadorRepositorio::buscar_anios1($grado, $tipo);
        $areas = Area::all();
        $gestions = IndicadorRepositorio::listar_gestion1($grado, $tipo);
        $provincias = Ubigeo::whereRaw('LENGTH(codigo)=4')->get();
        $breadcrumb = [['titulo' => 'Relacion de indicadores', 'url' => route('Clasificador.menu', '01')], ['titulo' => 'Indicadores', 'url' => url()->previous()], ['titulo' => 'Resumen', 'url' => '']];
        return view('parametro.indicador.educat2resumen', compact('title', 'grado', 'tipo', 'mt', 'anios', 'areas', 'gestions', 'provincias', 'breadcrumb'));
    }
    public function vistaEducacionCat3($title, $grado, $tipo, $sinaprobar)
    {
        return 'sin informacion';
    }
    public function vistaEducacionCat4($title, $nivel_id)
    {
        $nivel = NivelModalidad::find($nivel_id);
        $inds = IndicadorRepositorio::listar_profesorestitulados($nivel_id);
        $total = 0;
        foreach ($inds as $key => $value) {
            $total += $value->suma;
            if ($value->titulado == 0) {
                $value->titulado = 'NO TITULADO';
            } else $value->titulado = 'TITULADO';
        }
        $gra1['grf'] = $inds;
        $gra1['tot'] = $total;
        $indu = IndicadorRepositorio::listar_profesorestituladougel($nivel_id, '1');
        foreach ($indu as $key => $value) {
            $indutt = IndicadorRepositorio::listar_profesorestituladougel2($nivel_id, $value->id);
            $value->total = $indutt[0]->total;
            $value->nombre = str_replace('UGEL', '', $value->nombre);
        }
        $breadcrumb = [['titulo' => 'Relacion de indicadores', 'url' => route('Clasificador.menu', '01')], ['titulo' => 'Indicadores', 'url' => '']];
        return view('parametro.indicador.educat4', compact('title', 'nivel', 'inds', 'gra1', 'indu', 'breadcrumb'));
    }
    /****** */
    public function indicadorDRVCS($indicador_id)
    {
        switch ($indicador_id) {
            case 20: //PROGRAMA NACIONAL DE SANEAMIENTO RURAL
                $indicador = Indicador::find($indicador_id);
                $title = $indicador->nombre;

                $provincias = Ubigeo::whereRaw('LENGTH(codigo)=4')->get();
                $breadcrumb = [['titulo' => 'Relacion de indicadores', 'url' => route('Clasificador.menu', '02')], ['titulo' => 'Indicadores', 'url' => '']];
                return view('parametro.indicador.vivcat1', compact('title', 'breadcrumb','provincias','indicador_id'));
            case 21: //PROGRAMA NACIONAL DE SANEAMIENTO RURAL
                $indicador = Indicador::find($indicador_id);
                $title = $indicador->nombre;

                $provincias = Ubigeo::whereRaw('LENGTH(codigo)=4')->get();
                $breadcrumb = [['titulo' => 'Relacion de indicadores', 'url' => route('Clasificador.menu', '02')], ['titulo' => 'Indicadores', 'url' => '']];
                return view('parametro.indicador.vivcat1', compact('title', 'breadcrumb','provincias','indicador_id'));
            case 22: //PROGRAMA NACIONAL DE SANEAMIENTO RURAL
                $indicador = Indicador::find($indicador_id);
                $title = $indicador->nombre;

                $provincias = Ubigeo::whereRaw('LENGTH(codigo)=4')->get();
                $breadcrumb = [['titulo' => 'Relacion de indicadores', 'url' => route('Clasificador.menu', '02')], ['titulo' => 'Indicadores', 'url' => '']];
                return view('parametro.indicador.vivcat1', compact('title', 'breadcrumb','provincias','indicador_id'));
            case 23: //PROGRAMA NACIONAL DE SANEAMIENTO RURAL
                $indicador = Indicador::find($indicador_id);
                $title = $indicador->nombre;

                $cp=IndicadorRepositorio::cabecera1();
                $cp = DB::table('viv_datass as v1')->groupBy('sistema_disposicion_excretas')->get([DB::raw('count(sistema_disposicion_excretas)')]);
                $provincias = Ubigeo::whereRaw('LENGTH(codigo)=4')->get();
                $breadcrumb = [['titulo' => 'Relacion de indicadores', 'url' => route('Clasificador.menu', '02')], ['titulo' => 'Indicadores', 'url' => '']];
                return view('parametro.indicador.vivcat1', compact('title', 'breadcrumb','provincias','indicador_id'));
            case 24: //PROGRAMA NACIONAL DE SANEAMIENTO RURAL
                $indicador = Indicador::find($indicador_id);
                $title = $indicador->nombre;

                //$cp=IndicadorRepositorio::cabecera1();
                //$cp = DB::table('viv_datass as v1')->groupBy('servicio_agua_continuo')->get([DB::raw('count(servicio_agua_continuo)')]);                
                //$cp = DB::table('viv_datass as v1')->groupBy('realiza_cloracion_agua')->get([DB::raw('count(realiza_cloracion_agua)')]);
                $provincias = Ubigeo::whereRaw('LENGTH(codigo)=4')->get();
                $breadcrumb = [['titulo' => 'Relacion de indicadores', 'url' => route('Clasificador.menu', '02')], ['titulo' => 'Indicadores', 'url' => '']];
                return view('parametro.indicador.vivcat1', compact('title', 'breadcrumb','provincias','indicador_id'));
            case 25: //PROGRAMA NACIONAL DE SANEAMIENTO RURAL
                $indicador = Indicador::find($indicador_id);
                $title = $indicador->nombre;

                $provincias = Ubigeo::whereRaw('LENGTH(codigo)=4')->get();
                $breadcrumb = [['titulo' => 'Relacion de indicadores', 'url' => route('Clasificador.menu', '02')], ['titulo' => 'Indicadores', 'url' => '']];
                return view('parametro.indicador.vivcat1', compact('title', 'breadcrumb','provincias','indicador_id'));
            case 26: //PROGRAMA NACIONAL DE SANEAMIENTO RURAL
                $indicador = Indicador::find($indicador_id);
                $title = $indicador->nombre;

                $provincias = Ubigeo::whereRaw('LENGTH(codigo)=4')->get();
                $breadcrumb = [['titulo' => 'Relacion de indicadores', 'url' => route('Clasificador.menu', '02')], ['titulo' => 'Indicadores', 'url' => '']];
                return view('parametro.indicador.vivcat1', compact('title', 'breadcrumb','provincias','indicador_id'));
            case 27: //PROGRAMAS DE VIVIENDA
                $indicador = Indicador::find($indicador_id);
                $title = $indicador->nombre;
                $breadcrumb = [['titulo' => 'Relacion de indicadores', 'url' => route('Clasificador.menu', '02')], ['titulo' => 'Indicadores', 'url' => '']];
                return view('parametro.indicador.vivcat1', compact('title', 'breadcrumb'));
            case 28: //PROGRAMAS DE VIVIENDA
                $indicador = Indicador::find($indicador_id);
                $title = $indicador->nombre;
                $breadcrumb = [['titulo' => 'Relacion de indicadores', 'url' => route('Clasificador.menu', '02')], ['titulo' => 'Indicadores', 'url' => '']];
                return view('parametro.indicador.vivcat1', compact('title', 'breadcrumb'));
            case 29: //PROGRAMAS DE VIVIENDA
                $indicador = Indicador::find($indicador_id);
                $title = $indicador->nombre;
                $breadcrumb = [['titulo' => 'Relacion de indicadores', 'url' => route('Clasificador.menu', '02')], ['titulo' => 'Indicadores', 'url' => '']];
                return view('parametro.indicador.vivcat1', compact('title', 'breadcrumb'));
            case 30: //PROGRAMAS DE VIVIENDA
                $indicador = Indicador::find($indicador_id);
                $title = $indicador->nombre;
                $breadcrumb = [['titulo' => 'Relacion de indicadores', 'url' => route('Clasificador.menu', '02')], ['titulo' => 'Indicadores', 'url' => '']];
                return view('parametro.indicador.vivcat1', compact('title', 'breadcrumb'));
            default:
                return 'sin informacion';
                break;
        }
    }
    /****** */
    public function indicadorPDRC($indicador_id)
    {
        $breadcrumb = [['titulo' => 'Relacion de indicadores', 'url' => route('Clasificador.menu', '04')], ['titulo' => 'Indicadores', 'url' => '']];
        switch ($indicador_id) {
            case 14:
                $indicador = Indicador::find($indicador_id);
                $title = $indicador->nombre;
                $grado = 2;
                $tipo = 0;
                $materia = 1;
                $sinaprobar = IndicadorRepositorio::listar_importacionsinaprobar1($grado, $tipo);

                $gt = IndicadorRepositorio::buscar_grado1($grado);
                $info1 = IndicadorRepositorio::buscar_materia3($grado, $tipo, $materia);
                foreach ($info1 as $key => $value) {
                    $value->indicador = IndicadorRepositorio::listar_indicadoranio(date('Y'), $grado, $tipo, $value->id, 'asc');
                }
                return view('parametro.indicador.pdrc1', compact('title', 'grado', 'tipo', 'sinaprobar', 'info1','gt', 'breadcrumb'));
            case 15:
                $indicador = Indicador::find($indicador_id);
                $title = $indicador->nombre;
                $grado = 2;
                $tipo = 0;
                $materia = 2;
                $sinaprobar = IndicadorRepositorio::listar_importacionsinaprobar1($grado, $tipo);

                $gt = IndicadorRepositorio::buscar_grado1($grado);
                $info1 = IndicadorRepositorio::buscar_materia3($grado, $tipo, $materia);
                foreach ($info1 as $key => $value) {
                    $value->indicador = IndicadorRepositorio::listar_indicadoranio(date('Y'), $grado, $tipo, $value->id, 'asc');
                }
                return view('parametro.indicador.pdrc1', compact('title', 'grado', 'tipo', 'sinaprobar', 'info1','gt', 'breadcrumb'));
            case 16:
                $indicador = Indicador::find($indicador_id);
                $title = $indicador->nombre;
                $nivel = 38;
                $inds = IndicadorRepositorio::listar_indicador1('2');
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
                return view('parametro.indicador.educat1', compact('title', 'nivel', 'inds',  'info', 'limit', 'breadcrumb'));
            case 17:
                $indicador = Indicador::find($indicador_id);
                $title = $indicador->nombre;
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
                return view('parametro.indicador.educat1', compact('title', 'nivel', 'inds',  'info', 'limit', 'breadcrumb'));

            default:
                return 'sin informacion';
                break;
        }
    }
    /****** */
    public function indicadorOEI($indicador_id)
    {
        $breadcrumb = [['titulo' => 'Relacion de indicadores', 'url' => route('Clasificador.menu', '05')], ['titulo' => 'Indicadores', 'url' => '']];
        switch ($indicador_id) {
            case 18:
                $indicador = Indicador::find($indicador_id);
                $title = $indicador->nombre;
                $grado = 8;
                $tipo = 0;
                $materia=2;
                $sinaprobar = IndicadorRepositorio::listar_importacionsinaprobar1($grado, $tipo);
                return $this->vistaOEI($indicador_id, $title, $grado, $tipo, $sinaprobar,$materia);
            case 19:
                $indicador = Indicador::find($indicador_id);
                $title = $indicador->nombre;
                $grado = 4;
                $tipo = 1; //EIB
                $materia=5;
                $sinaprobar = IndicadorRepositorio::listar_importacionsinaprobar1($grado, $tipo);
                return $this->vistaOEI($indicador_id, $title, $grado, $tipo, $sinaprobar,$materia);
            default:
                return 'sin informacion';
                break;
        }
    }
    public function vistaOEI($indicador_id, $title, $grado, $tipo, $sinaprobar,$materia)
    {
        $gt = IndicadorRepositorio::buscar_grado1($grado);
        $materias = IndicadorRepositorio::buscar_materia3($grado, $tipo,$materia);
        foreach ($materias as $key => $materia) {
            $materia->indicador = IndicadorRepositorio::listar_indicadoranio(date('Y'), $grado, $tipo, $materia->id, 'asc');
        }
        $breadcrumb = [['titulo' => 'Relacion de indicadores', 'url' => route('Clasificador.menu', '01')], ['titulo' => 'Indicadores', 'url' => '']];
        return view('parametro.indicador.educat2', compact('indicador_id', 'title', 'grado', 'tipo', 'sinaprobar', 'materias', 'gt', 'breadcrumb'));
    }
    /*****OTRAS OPCIONES */
    public function cargarprovincias()
    {
        $provincias = IndicadorRepositorio::buscar_provincia1();
        return response()->json($provincias);
    }
    public function cargardistritos($provincia)
    {
        //$distritos = Ubigeo::where('codigo', 'like', $provincia . '%')->whereRaw('LENGTH(codigo)=6')->get();
        $distritos = IndicadorRepositorio::buscar_distrito1($provincia);
        return response()->json(compact('distritos'));
    }
    public function cargargrados(Request $request)
    {
        $grados = IndicadorRepositorio::buscar_grados1($request->nivel);
        return response()->json(compact('grados'));
    }
    public function indicadorLOGROS(Request $request)
    {
        $materias = IndicadorRepositorio::buscar_materia1($request->anio, $request->grado, $request->tipo);
        $tabla = '<table class="table mb-0">';
        $tabla .= '<thead><tr><th></th>';
        foreach ($materias as $key => $value) {
            $tabla .= '<th>' . $value->descripcion . '</th>';
        }
        $tabla .= '</tr></thead><tbody>';
        if ($request->provincia == 0 && $request->distrito == 0) {
            $provincias = IndicadorRepositorio::buscar_provincia1();
            foreach ($provincias as $provincia) {
                $tabla .= '<tr><td>' . $provincia->nombre . '</td>';
                foreach ($materias as $materia) {
                    $resultado = IndicadorRepositorio::buscar_resultado1($request->anio, $request->grado, $request->tipo, $materia->id, $provincia->id);
                    if ($resultado[0]->evaluados) {
                        $indicador = $resultado[0]->satisfactorio * 100 / $resultado[0]->evaluados;
                    } else $indicador = 0.0;
                    $tabla .= '<td>' . round($indicador, 2) . '</td>';
                }
                $tabla .= '</tr>';
            }
            $tabla .= '<tr><td>TOTAL</td>';
            foreach ($materias as $materia) {
                $resultado = IndicadorRepositorio::buscar_resultado2($request->anio, $request->grado, $request->tipo, $materia->id);
                if ($resultado[0]->evaluados) {
                    $indicador = $resultado[0]->satisfactorio * 100 / $resultado[0]->evaluados;
                } else $indicador = 0.0;
                $tabla .= '<td>' . round($indicador, 2) . '</td>';
            }
            $tabla .= '</tr>';
        } else if ($request->provincia > 0 && $request->distrito == 0) {
            $provincia = Ubigeo::find($request->provincia);

            $distritos = Ubigeo::where('dependencia', $provincia->id)->get();
            foreach ($distritos as  $distrito) {
                $tabla .= '<tr><td>' . $distrito->nombre . '</td>';
                foreach ($materias as $materia) {
                    $resultado = IndicadorRepositorio::buscar_resultado3($request->anio, $request->grado, $request->tipo, $materia->id, $distrito->id);
                    if ($resultado[0]->evaluados) {
                        $indicador = $resultado[0]->satisfactorio * 100 / $resultado[0]->evaluados;
                    } else $indicador = 0.0;
                    $tabla .= '<td>' . round($indicador, 2) . '</td>';
                }
                $tabla .= '</tr>';
            }
            $tabla .= '<tr><td>' . $provincia->nombre . '</td>';
            foreach ($materias as $materia) {
                $resultado = IndicadorRepositorio::buscar_resultado1($request->anio, $request->grado, $request->tipo, $materia->id, $provincia->id);
                if ($resultado[0]->evaluados) {
                    $indicador = $resultado[0]->satisfactorio * 100 / $resultado[0]->evaluados;
                } else $indicador = 0.0;
                $tabla .= '<td>' . round($indicador, 2) . '</td>';
            }
            $tabla .= '</tr>';
        } else if ($request->provincia > 0 && $request->distrito > 0) {
            $distrito = Ubigeo::find($request->distrito);
            $tabla .= '<tr><td>' . $distrito->nombre . '</td>';
            foreach ($materias as $materia) {
                $resultado = IndicadorRepositorio::buscar_resultado3($request->anio, $request->grado, $request->tipo, $materia->id, $distrito->id);
                if ($resultado[0]->evaluados) {
                    $indicador = $resultado[0]->satisfactorio * 100 / $resultado[0]->evaluados;
                } else $indicador = 0.0;
                $tabla .= '<td>' . round($indicador, 2) . '</td>';
            }
            $tabla .= '</tr>';
        } else {
        }
        $tabla .= '</tbody></table>';
        return $tabla;
    }
    public function indicadorSatisfactorio(Request $request) //puede eliminar
    {
        $inds = IndicadorRepositorio::listar_indicadorsatisfactorio($request->anio, $request->grado, $request->tipo);
        $card = '';
        foreach ($inds as $ind) {
            $card .= '<div class="col-md-6 col-xl-' . ($inds->count() == 1 ? '12' : ($inds->count() == 2 ? '6' : ($inds->count() == 3 ? '4' : '6'))) . '">
                <div class="card-box">
                    <div class="media">
                        <div class="avatar-md bg-success rounded-circle mr-2">
                            <i class="ion-md-contacts avatar-title font-26 text-white"></i>
                        </div>
                        <div class="media-body align-self-center">
                            <div class="text-right">
                                <h4 class="my-0 font-weight-bold">(Total:' . $ind->satisfactorio . ') <span data-plugin="counterup">' . round($ind->satisfactorio * 100 / $ind->evaluados, 1) . '</span>%</h4>
                                <p class="mb-0 mt-1 text-truncate">' . $ind->materia . '</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>   ';
        }
        return $card;
    }
    public function indicadorSatisfactorioMateria(Request $request)
    {
        $inds = IndicadorRepositorio::listar_indicadorsatisfactorio1($request->anio, $request->grado, $request->tipo, $request->materia);
        $card = '';
        foreach ($inds as $ind) {
            $card .= '<div class="col-md-6 col-xl-6">
                <div class="card-box">
                    <div class="media">
                        <div class="avatar-md bg-success rounded-circle mr-2">
                            <i class="ion-md-contacts avatar-title font-26 text-white"></i>
                        </div>
                        <div class="media-body align-self-center">
                            <div class="text-right">
                                <h4 class="my-0 font-weight-bold"><span data-plugin="counterup">' . round($ind->satisfactorio * 100 / $ind->evaluados, 1) . '</span>%</h4>
                                <p class="mb-0 mt-1 text-truncate">' . $ind->materia . ' - porcentaje</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>   ';
            $card .= '<div class="col-md-6 col-xl-6">
                <div class="card-box">
                    <div class="media">
                        <div class="avatar-md bg-success rounded-circle mr-2">
                            <i class="ion-md-contacts avatar-title font-26 text-white"></i>
                        </div>
                        <div class="media-body align-self-center">
                            <div class="text-right">
                                <h4 class="my-0 font-weight-bold"><span data-plugin="counterup">' . $ind->satisfactorio . '</span></h4>
                                <p class="mb-0 mt-1 text-truncate">' . $ind->materia . ' - cantidad</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>   ';
        }
        return $card;
    }
    public function indicadorMateria(Request $request)
    {
        $card = '';
        $materias = IndicadorRepositorio::buscar_materia1($request->anio, $request->grado, $request->tipo);
        foreach ($materias as $key => $materia) {

            $card .= '<div class="col-md-6">
            <div class="card card-border">
                <div class="card-header border-primary bg-transparent pb-0">
                    <h3 class="card-title">materia ' . $materia->descripcion . '</h3>
                </div>
                <div class="card-body">
                    <div class="row" >
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table mb-0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th class="text-danger">TOTAL</th>
                                            <th class="text-danger">INICIO</th>
                                            <th class="text-warning">TOTAL</th>
                                            <th class="text-warning">PROCESO</th>
                                            <th class="text-success">TOTAL</th>
                                            <th class="text-success">SATISFACTORIO</th>
                                        </tr>
                                    </thead>
                                    <tbody>';
            $inds = IndicadorRepositorio::listar_indicadoranio($request->anio, $request->grado, $request->tipo, $materia->id, 'desc');
            foreach ($inds as $ind) {
                $card .= '<tr>
                            <td><span class="' . ($ind->anio == $request->anio ? 'bg-info text-white' : 'text-primary') . '">' . $ind->anio . '</span></td>
                            <td class="text-danger">' . ($ind->previo + $ind->inicio)  . '</td>
                            <td class="text-danger">' . round(($ind->previo + $ind->inicio) * 100 / $ind->evaluados, 1) . '%</td>
                            <td class="text-warning">' . $ind->proceso  . '</td>
                            <td class="text-warning">' . round($ind->proceso * 100 / $ind->evaluados, 1) . '%</td>
                            <td class="text-success">' . $ind->satisfactorio  . '</td>
                            <td class="text-success">' . round($ind->satisfactorio * 100 / $ind->evaluados, 1) . '%</td>
                        </tr>';
            }

            $card .= '              </tbody>
                                </table>
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
        </div>';
        }

        return $card;
    }
    public function indicadorUgel(Request $request) //observador si se usa
    {
        $card = '';
        $materias = IndicadorRepositorio::buscar_materia1($request->anio, $request->grado, $request->tipo);
        foreach ($materias as $key => $materia) {

            $card .= '<div class="col-md-6">
            <div class="card card-border">
                <div class="card-header border-primary bg-transparent pb-0">
                    <h3 class="card-title">materia ' . $materia->descripcion . '</h3>
                </div>
                <div class="card-body">
                    <div class="row" >
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table mb-0">
                                    <thead>
                                        <tr>
                                            <th>UGEL</th>
                                            <!--th class="text-secondary">PREVIO</th-->
                                            <th class="text-danger">TOTAL</th>
                                            <th class="text-danger">INICIO</th>
                                            <th class="text-warning">TOTAL</th>
                                            <th class="text-warning">PROCESO</th>
                                            <th class="text-success">TOTAL</th>
                                            <th class="text-success">SATISFACTORIO</th>
                                        </tr>
                                    </thead>
                                    <tbody>';
            $inds = IndicadorRepositorio::listar_indicadorugel($request->anio, $request->grado, $request->tipo, $materia->id);
            foreach ($inds as $ind) {
                $card .= '<tr>
                            <td><span>' . $ind->ugel . '</span></td>
                            <!--td class="text-secondary">' . round($ind->previo * 100 / $ind->evaluados, 1) . '%</td-->
                            <td class="text-danger">' . ($ind->previo + $ind->inicio) . '</td>
                            <td class="text-danger">' . round(($ind->previo + $ind->inicio) * 100 / $ind->evaluados, 1) . '%</td>
                            <td class="text-warning">' . $ind->proceso  . '</td>
                            <td class="text-warning">' . round($ind->proceso * 100 / $ind->evaluados, 1) . '%</td>
                            <td class="text-success">' . $ind->satisfactorio . '</td>
                            <td class="text-success">' . round($ind->satisfactorio * 100 / $ind->evaluados, 1) . '%</td>
                        </tr>';
            }

            $card .= '              </tbody>
                                </table>
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
        </div>';
        }

        return $card;
    }
    public function indicadorUgelMateria(Request $request)
    {
        $card = '';
        $materia = Materia::find($request->materia);
        $card .= '<div class="col-md-12">
            <div class="card card-border">
                <div class="card-header border-primary bg-transparent pb-0">
                    <!--h3 class="card-title">materia ' . $materia->descripcion . '</h3-->
                </div>
                <div class="card-body">
                    <div class="row" >
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-primary">UGEL</th>
                                            <th class="text-secondary">CANTIDAD</th>
                                            <th class="text-secondary">PREVIO</th>
                                            <th class="text-danger">CANTIDAD</th>
                                            <th class="text-danger">INICIO</th>
                                            <th class="text-warning">CANTIDAD</th>
                                            <th class="text-warning">PROCESO</th>
                                            <th class="text-success">CANTIDAD</th>
                                            <th class="text-success">SATISFACTORIO</th>
                                        </tr>
                                    </thead>
                                    <tbody>';
        $inds = IndicadorRepositorio::listar_indicadorugel($request->aniox, $request->grado, $request->tipo, $materia->id);
        foreach ($inds as $ind) {
            $card .= '<tr>
                            <td class="text-primary"><span>' . str_replace('UGEL', "", $ind->ugel) . '</span></td>
                            <td class="text-secondary">' . ($ind->previo) . '</td>
                            <td class="text-secondary">' . round($ind->previo * 100 / $ind->evaluados, 2) . '%</td>
                            <td class="text-danger">' . ($ind->inicio) . '</td>
                            <td class="text-danger">' . round($ind->inicio * 100 / $ind->evaluados, 2) . '%</td>
                            <td class="text-warning">' . $ind->proceso  . '</td>
                            <td class="text-warning">' . round($ind->proceso * 100 / $ind->evaluados, 2) . '%</td>
                            <td class="text-success">' . $ind->satisfactorio . '</td>
                            <td class="text-success">' . round($ind->satisfactorio * 100 / $ind->evaluados, 2) . '%</td>
                        </tr>';
        }

        $card .= '              </tbody>
                                </table>
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
        </div>';
        //}

        return $card;
    }
    public function indicadorProvincia(Request $request)
    {
        $card = '';
        $materias = IndicadorRepositorio::buscar_materia1($request->anio, $request->grado, $request->tipo);
        foreach ($materias as $key => $materia) {

            $card .= '<div class="col-md-6">
            <div class="card card-border">
                <div class="card-header border-primary bg-transparent pb-0">
                    <h3 class="card-title">materia ' . $materia->descripcion . '</h3>
                </div>
                <div class="card-body">
                    <div class="row" >
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table mb-0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <!--th class="text-secondary">PREVIO</th-->
                                            <th class="text-danger">TOTAL</th>
                                            <th class="text-danger">INICIO</th>
                                            <th class="text-warning">TOTAL</th>
                                            <th class="text-warning">PROCESO</th>
                                            <th class="text-success">TOTAL</th>
                                            <th class="text-success">SATISFACTORIO</th>
                                        </tr>
                                    </thead>
                                    <tbody>';
            $inds = IndicadorRepositorio::listar_indicadorprovincia($request->anio, $request->grado, $request->tipo, $materia->id);
            foreach ($inds as $ind) {
                $card .= '<tr>
                            <td><span>' . $ind->provincia . '</span></td>
                            <!--td class="text-secondary">' . round($ind->previo * 100 / $ind->evaluados, 1) . '%</td-->
                            <td class="text-danger">' . ($ind->previo + $ind->inicio)  . '</td>
                            <td class="text-danger">' . round(($ind->previo + $ind->inicio) * 100 / $ind->evaluados, 1) . '%</td>
                            <td class="text-warning">' . $ind->proceso  . '</td>
                            <td class="text-warning">' . round($ind->proceso * 100 / $ind->evaluados, 1) . '%</td>
                            <td class="text-success">' . $ind->satisfactorio   . '</td>
                            <td class="text-success">' . round($ind->satisfactorio * 100 / $ind->evaluados, 1) . '%</td>
                        </tr>';
            }

            $card .= '              </tbody>
                                </table>
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
        </div>';
        }

        return $card;
    }
    public function indicadorDerivados(Request $request)
    {
        $card = '';
        $materia = Materia::find($request->materia);
        $card .= '<div class="col-md-12">
            
                            <div class="table-responsive">
                                <table class="table table-bordered mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-primary">#</th>
                                            <th class="text-secondary text-center">CANTIDAD</th>
                                            <th class="text-secondary text-center">PREVIO</th>
                                            <th class="text-danger text-center">CANTIDAD</th>
                                            <th class="text-danger text-center">INICIO</th>
                                            <th class="text-warning text-center">CANTIDAD</th>
                                            <th class="text-warning text-center">PROCESO</th>
                                            <th class="text-success text-center">CANTIDAD</th>
                                            <th class="text-success text-center">SATISFACTORIO</th>
                                        </tr>
                                    </thead>
                                    <tbody>';
        if ($request->provincia == 0) {
            $inds = IndicadorRepositorio::listar_indicadorprovincia($request->anio, $request->grado, $request->tipo, $materia->id);
            foreach ($inds as $ind) {
                $card .= '<tr>
                            <td class="text-primary"><span>' . $ind->provincia . '</span></td>
                            <td class="text-secondary text-center">' . $ind->previo . '</td>
                            <td class="text-secondary text-center">' . round($ind->previo * 100 / $ind->evaluados, 2) . '%</td>
                            <td class="text-danger text-center">' . $ind->inicio . '</td>
                            <td class="text-danger text-center">' . round($ind->inicio * 100 / $ind->evaluados, 2) . '%</td>
                            <td class="text-warning text-center">' . $ind->proceso . '</td>
                            <td class="text-warning text-center">' . round($ind->proceso * 100 / $ind->evaluados, 2) . '%</td>
                            <td class="text-success text-center">' . $ind->satisfactorio . '</td>
                            <td class="text-success text-center">' . round($ind->satisfactorio * 100 / $ind->evaluados, 2) . '%</td>
                        </tr>';
            }
            $inds = IndicadorRepositorio::listar_indicadordepartamento($request->anio, $request->grado, $request->tipo, $materia->id);
            foreach ($inds as $ind) {
                $card .= '<tr class="table-success">
                                <td class="text-primary"><span>TODOS(UCAYALI)</span></td>
                                <td class="text-secondary text-center">' . $ind->previo . '</td>
                                <td class="text-secondary text-center">' . round($ind->previo * 100 / $ind->evaluados, 2) . '%</td>
                                <td class="text-danger text-center">' . $ind->inicio . '</td>
                                <td class="text-danger text-center">' . round($ind->inicio * 100 / $ind->evaluados, 2) . '%</td>
                                <td class="text-warning text-center">' . $ind->proceso . '</td>
                                <td class="text-warning text-center">' . round($ind->proceso * 100 / $ind->evaluados, 2) . '%</td>
                                <td class="text-success text-center">' . $ind->satisfactorio . '</td>
                                <td class="text-success text-center">' . round($ind->satisfactorio * 100 / $ind->evaluados, 2) . '%</td>
                            </tr>';
            }
        } else {
            if ($request->distrito == 0) {
                $inds = IndicadorRepositorio::listar_indicadordistrito($request->anio, $request->grado, $request->tipo, $materia->id, $request->provincia);
                foreach ($inds as $ind) {
                    $card .= '<tr>
                            <td class="text-primary"><span>' . $ind->distrito . '</span></td>
                            <td class="text-secondary text-center">' . $ind->previo . '</td>
                            <td class="text-secondary text-center">' . round($ind->previo * 100 / $ind->evaluados, 1) . '%</td>
                            <td class="text-danger text-center">' . $ind->inicio . '</td>
                            <td class="text-danger text-center">' . round($ind->inicio * 100 / $ind->evaluados, 1) . '%</td>
                            <td class="text-warning text-center">' . $ind->proceso . '</td>
                            <td class="text-warning text-center">' . round($ind->proceso * 100 / $ind->evaluados, 1) . '%</td>
                            <td class="text-success text-center">' . $ind->satisfactorio . '</td>
                            <td class="text-success text-center">' . round($ind->satisfactorio * 100 / $ind->evaluados, 1) . '%</td>
                        </tr>';
                }
                $inds = IndicadorRepositorio::listar_indicadorprovincia($request->anio, $request->grado, $request->tipo, $materia->id, $request->provincia);
                foreach ($inds as $ind) {
                    $card .= '<tr class="table-success">
                            <td class="text-primary"><span\>' . $ind->provincia . '</span></td>
                            <td class="text-secondary text-center">' . $ind->previo . '</td>
                            <td class="text-secondary text-center">' . round($ind->previo * 100 / $ind->evaluados, 1) . '%</td>
                            <td class="text-danger text-center">' . $ind->inicio . '</td>
                            <td class="text-danger text-center">' . round($ind->inicio * 100 / $ind->evaluados, 1) . '%</td>
                            <td class="text-warning text-center">' . $ind->proceso . '</td>
                            <td class="text-warning text-center">' . round($ind->proceso * 100 / $ind->evaluados, 1) . '%</td>
                            <td class="text-success text-center">' . $ind->satisfactorio . '</td>
                            <td class="text-success text-center">' . round($ind->satisfactorio * 100 / $ind->evaluados, 1) . '%</td>
                        </tr>';
                }
            } else {
                $inds = IndicadorRepositorio::listar_indicadordistrito($request->anio, $request->grado, $request->tipo, $materia->id, $request->provincia, $request->distrito);
                //return $inds;
                foreach ($inds as $ind) {
                    $card .= '<tr class="table-success">
                            <td class="text-primary"><span>' . $ind->distrito . '</span></td>
                            <td class="text-secondary text-center">' . $ind->previo . '</td>
                            <td class="text-secondary text-center">' . round($ind->previo * 100 / $ind->evaluados, 1) . '%</td>
                            <td class="text-danger text-center">' . $ind->inicio . '</td>
                            <td class="text-danger text-center">' . round($ind->inicio * 100 / $ind->evaluados, 1) . '%</td>
                            <td class="text-warning text-center">' . $ind->proceso . '</td>
                            <td class="text-warning text-center">' . round($ind->proceso * 100 / $ind->evaluados, 1) . '%</td>
                            <td class="text-success text-center">' . $ind->satisfactorio . '</td>
                            <td class="text-success text-center">' . round($ind->satisfactorio * 100 / $ind->evaluados, 1) . '%</td>
                        </tr>';
                }
            }
        }
        $card .= '              </tbody>
                                </table>
                            </div>
                       
        </div>';
        return $card;
    }
    public function indicadorDerivados2(Request $request)
    {
        $card = '';
        $materia = Materia::find($request->materia);
        $inds = IndicadorRepositorio::listar_indicadorInstitucion($request->anio, $request->grado, $request->tipo, $materia->id, 0, 0);
        //return response()->json(compact('inds'));
        $card .= '<div class="col-md-12">
            
                            <div class="table-responsive">
                                <table class="table table-bordered mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-primary">IIEE</th>
                                            <th class="text-secondary text-center">CANTIDAD</th>
                                            <th class="text-secondary text-center">PREVIO</th>
                                            <th class="text-danger text-center">CANTIDAD</th>
                                            <th class="text-danger text-center">INICIO</th>
                                            <th class="text-warning text-center">CANTIDAD</th>
                                            <th class="text-warning text-center">PROCESO</th>
                                            <th class="text-success text-center">CANTIDAD</th>
                                            <th class="text-success text-center">SATISFACTORIO</th>
                                        </tr>
                                    </thead>
                                    <tbody>';
        $inds = IndicadorRepositorio::listar_indicadorInstitucion($request->anio, $request->grado, $request->tipo, $materia->id, $request->gestion, $request->area);
        foreach ($inds as $key => $ind) {
            $card .= '<tr>
                            <td class="text-primary"><span>' . $ind->nombre . '</span></td>
                            <td class="text-secondary text-center">' . $ind->previo . '</td>
                            <td class="text-secondary text-center">' . round($ind->previo * 100 / $ind->evaluados, 2) . '%</td>
                            <td class="text-danger text-center">' . $ind->inicio . '</td>
                            <td class="text-danger text-center">' . round($ind->inicio * 100 / $ind->evaluados, 2) . '%</td>
                            <td class="text-warning text-center">' . $ind->proceso . '</td>
                            <td class="text-warning text-center">' . round($ind->proceso * 100 / $ind->evaluados, 2) . '%</td>
                            <td class="text-success text-center">' . $ind->satisfactorio . '</td>
                            <td class="text-success text-center">' . round($ind->satisfactorio * 100 / $ind->evaluados, 2) . '%</td>
                        </tr>';
        }

        $card .= '              </tbody>
                                </table>
                            </div>
        </div>';
        return $card;
    }
    public function indicadorvivpnsrcab($provincia,$distrito,$indicador_id)
    {
        $cp=IndicadorRepositorio::cabecera2($provincia,$distrito,$indicador_id);
        return response()->json($cp);
    }    
}
