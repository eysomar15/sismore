<?php

namespace App\Http\Controllers\Educacion;

use App\Http\Controllers\Controller;
use App\Models\Educacion\Area;
use App\Models\Educacion\CensoResultado;
use App\Models\Parametro\Clasificador;
use App\Models\Educacion\Indicador;
use App\Models\Educacion\Materia;
use App\Models\Educacion\NivelModalidad;
use App\Models\Educacion\TipoGestion;
use App\Models\Ubigeo;
use App\Repositories\Educacion\CensoRepositorio;
use App\Repositories\Educacion\ImportacionRepositorio;
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
                return view('parametro.indicador.educat1', compact('title', 'nivel', 'inds', 'breadcrumb'));
            case '2': //CULMINACION 
                $indicador = Indicador::find($indicador_id);
                $title = $indicador->nombre;
                $nivel = 38;
                $inds = IndicadorRepositorio::listar_indicador1('2');
                return view('parametro.indicador.educat1', compact('title', 'nivel', 'inds', 'breadcrumb'));
            case '3': //CULMINACION 
                $indicador = Indicador::find($indicador_id);
                $title = $indicador->nombre;
                $nivel = 0; // ES MUY VARIBLE
                $inds = IndicadorRepositorio::listar_indicador1('3');
                return view('parametro.indicador.educat1', compact('title', 'nivel', 'inds', 'breadcrumb'));
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
                return view('parametro.indicador.educat3', compact('title', 'nivel', 'inds', 'breadcrumb'));
            case '9': //ACCESO  
                $indicador = Indicador::find($indicador_id);
                $title = $indicador->nombre;
                $nivel = 37;
                $inds = IndicadorRepositorio::listar_indicador1('9');
                return view('parametro.indicador.educat3', compact('title', 'nivel', 'inds', 'breadcrumb'));
            case '10': //ACCESO  
                $indicador = Indicador::find($indicador_id);
                $title = $indicador->nombre;
                $nivel = 38;
                $inds = IndicadorRepositorio::listar_indicador1('10');
                return view('parametro.indicador.educat3', compact('title', 'nivel', 'inds', 'breadcrumb'));
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
            case 31: //SERVICIOS BASICOS  
                $indicador = Indicador::find($indicador_id);
                $title = $indicador->nombre;

                $provincias = Ubigeo::whereRaw('LENGTH(codigo)=4')->get();
                $fechas = CensoRepositorio::listar_anios();
                $breadcrumb = [['titulo' => 'Relacion de indicadores', 'url' => route('Clasificador.menu', '01')], ['titulo' => 'Indicadores', 'url' => '']];
                return view('parametro.indicador.educat5', compact('title', 'breadcrumb', 'provincias', 'fechas', 'indicador_id'));
            case 32: //SERVICIOS BASICOS  
                $indicador = Indicador::find($indicador_id);
                $title = $indicador->nombre;

                $provincias = Ubigeo::whereRaw('LENGTH(codigo)=4')->get();
                $fechas = CensoRepositorio::listar_anios();
                $breadcrumb = [['titulo' => 'Relacion de indicadores', 'url' => route('Clasificador.menu', '01')], ['titulo' => 'Indicadores', 'url' => '']];
                return view('parametro.indicador.educat5', compact('title', 'breadcrumb', 'provincias', 'fechas', 'indicador_id'));
            case 33: //SERVICIOS BASICOS  
                $indicador = Indicador::find($indicador_id);
                $title = $indicador->nombre;

                $provincias = Ubigeo::whereRaw('LENGTH(codigo)=4')->get();
                $fechas = CensoRepositorio::listar_anios();
                $breadcrumb = [['titulo' => 'Relacion de indicadores', 'url' => route('Clasificador.menu', '01')], ['titulo' => 'Indicadores', 'url' => '']];
                return view('parametro.indicador.educat5', compact('title', 'breadcrumb', 'provincias', 'fechas', 'indicador_id'));
            case 34: //SERVICIOS BASICOS  
                $indicador = Indicador::find($indicador_id);
                $title = $indicador->nombre;

                $provincias = Ubigeo::whereRaw('LENGTH(codigo)=4')->get();
                $fechas = CensoRepositorio::listar_anios();
                $breadcrumb = [['titulo' => 'Relacion de indicadores', 'url' => route('Clasificador.menu', '01')], ['titulo' => 'Indicadores', 'url' => '']];
                return view('parametro.indicador.educat5', compact('title', 'breadcrumb', 'provincias', 'fechas', 'indicador_id'));
            case 40: //ACCESO A TIC
                $indicador = Indicador::find($indicador_id);
                $title = $indicador->nombre;
                $nivel_id = '37';
                //$anio = 5;
                //$inds = CensoRepositorio::Listar_IE($anio, $nivel_id);
                //return $inds;

                $provincias = Ubigeo::whereRaw('LENGTH(codigo)=4')->get();
                $fechas = CensoRepositorio::listar_anios();
                $breadcrumb = [['titulo' => 'Relacion de indicadores', 'url' => route('Clasificador.menu', '01')], ['titulo' => 'Indicadores', 'url' => '']];
                return view('parametro.indicador.educat6', compact('title', 'breadcrumb', 'provincias', 'fechas', 'indicador_id'));
            case 41: //ACCESO A TIC
                $indicador = Indicador::find($indicador_id);
                $title = $indicador->nombre;
                $nivel = '38';

                $provincias = Ubigeo::whereRaw('LENGTH(codigo)=4')->get();
                $fechas = CensoRepositorio::listar_anios();
                $breadcrumb = [['titulo' => 'Relacion de indicadores', 'url' => route('Clasificador.menu', '01')], ['titulo' => 'Indicadores', 'url' => '']];
                return view('parametro.indicador.educat6', compact('title', 'breadcrumb', 'provincias', 'fechas', 'indicador_id'));
            case 42: //ACCESO A TIC 
                $indicador = Indicador::find($indicador_id);
                $title = $indicador->nombre;

                $provincias = Ubigeo::whereRaw('LENGTH(codigo)=4')->get();
                $fechas = CensoRepositorio::listar_anios();
                $breadcrumb = [['titulo' => 'Relacion de indicadores', 'url' => route('Clasificador.menu', '01')], ['titulo' => 'Indicadores', 'url' => '']];
                return view('parametro.indicador.educat6', compact('title', 'breadcrumb', 'provincias', 'fechas', 'indicador_id'));
            case 43: //ACCESO A TIC  
                $indicador = Indicador::find($indicador_id);
                $title = $indicador->nombre;

                $provincias = Ubigeo::whereRaw('LENGTH(codigo)=4')->get();
                $fechas = CensoRepositorio::listar_anios();
                $breadcrumb = [['titulo' => 'Relacion de indicadores', 'url' => route('Clasificador.menu', '01')], ['titulo' => 'Indicadores', 'url' => '']];
                return view('parametro.indicador.educat6_2', compact('title', 'breadcrumb', 'provincias', 'fechas', 'indicador_id'));
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
            $materia->previo = 0;
            foreach ($materia->indicador as $item) {
                $materia->previo += $item->previo;
            }
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
            $anio->previo = 0;
            foreach ($anio->indicador as $indicador) {
                $indicador->ugel = str_replace('UGEL', '', $indicador->ugel);
                $anio->previo += $indicador->previo;
            }
        }
        //return $anios;
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
        $indu = IndicadorRepositorio::listar_profesorestituladougel($nivel_id, '1');
        $datas['titulados'] = $inds;
        $datas['ugel'] = $indu;
        //return $datas;
        $breadcrumb = [['titulo' => 'Relacion de indicadores', 'url' => route('Clasificador.menu', '01')], ['titulo' => 'Indicadores', 'url' => '']];
        return view('parametro.indicador.educat4', compact('title', 'nivel', 'datas', 'breadcrumb'));
    }
    public function vistaEducacionCat5($title, $nivel_id)
    {
        $breadcrumb = [['titulo' => 'Relacion de indicadores', 'url' => route('Clasificador.menu', '01')], ['titulo' => 'Indicadores', 'url' => '']];
        return view('parametro.indicador.educat5', compact('title', 'breadcrumb'));
    }
    /****** */
    public function indicadorDRVCS($indicador_id)
    {
        switch ($indicador_id) {
            case 20: //PROGRAMA NACIONAL DE SANEAMIENTO RURAL
            case 21: //PROGRAMA NACIONAL DE SANEAMIENTO RURAL
            case 22: //PROGRAMA NACIONAL DE SANEAMIENTO RURAL
            case 23: //PROGRAMA NACIONAL DE SANEAMIENTO RURAL
            case 24: //PROGRAMA NACIONAL DE SANEAMIENTO RURAL
            case 25: //PROGRAMA NACIONAL DE SANEAMIENTO RURAL
            case 26: //PROGRAMA NACIONAL DE SANEAMIENTO RURAL
            case 27: //PROGRAMAS DE VIVIENDA
            case 28: //PROGRAMAS DE VIVIENDA
            case 29: //PROGRAMAS DE VIVIENDA
            case 30: //PROGRAMAS DE VIVIENDA
                $indicador = Indicador::find($indicador_id);
                $title = $indicador->nombre;

                $provincias = Ubigeo::whereRaw('LENGTH(codigo)=4')->get();
                $ingresos = ImportacionRepositorio::Listar_deDatass();
                //return $ingreso;
                $breadcrumb = [['titulo' => 'Relacion de indicadores', 'url' => route('Clasificador.menu', '02')], ['titulo' => 'Indicadores', 'url' => '']];
                return view('parametro.indicador.vivcat1', compact('title', 'breadcrumb', 'provincias', 'indicador_id', 'ingresos'));
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
                $materias = IndicadorRepositorio::buscar_materia3($grado, $tipo, $materia);
                foreach ($materias as $key => $materia) {
                    $materia->previo = 0;
                    $materia->indicador = IndicadorRepositorio::listar_indicadoranio(date('Y'), $grado, $tipo, $materia->id, 'asc');
                    foreach ($materia->indicador as $item) {
                        $materia->previo += $item->previo;
                    }
                }
                return view('parametro.indicador.pdrc1', compact('title', 'grado', 'tipo', 'sinaprobar', 'materias', 'gt', 'breadcrumb'));
            case 15:
                $indicador = Indicador::find($indicador_id);
                $title = $indicador->nombre;
                $grado = 2;
                $tipo = 0;
                $materia = 2;
                $sinaprobar = IndicadorRepositorio::listar_importacionsinaprobar1($grado, $tipo);

                $gt = IndicadorRepositorio::buscar_grado1($grado);
                $materias = IndicadorRepositorio::buscar_materia3($grado, $tipo, $materia);
                foreach ($materias as $key => $materia) {
                    $materia->previo = 0;
                    $materia->indicador = IndicadorRepositorio::listar_indicadoranio(date('Y'), $grado, $tipo, $materia->id, 'asc');
                    foreach ($materia->indicador as $item) {
                        $materia->previo += $item->previo;
                    }
                }
                return view('parametro.indicador.pdrc1', compact('title', 'grado', 'tipo', 'sinaprobar', 'materias', 'gt', 'breadcrumb'));
            case 16:
                $indicador = Indicador::find($indicador_id);
                $title = $indicador->nombre;
                $nivel = 38;
                $inds = IndicadorRepositorio::listar_indicador1('2');
                return view('parametro.indicador.educat1', compact('title', 'nivel', 'inds', 'breadcrumb'));
            case 17:
                $indicador = Indicador::find($indicador_id);
                $title = $indicador->nombre;
                $nivel = 37;
                $inds = IndicadorRepositorio::listar_indicador1('1');
                return view('parametro.indicador.educat1', compact('title', 'nivel', 'inds', 'breadcrumb'));
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
                $materia = 2;
                $sinaprobar = IndicadorRepositorio::listar_importacionsinaprobar1($grado, $tipo);
                return $this->vistaOEI($indicador_id, $title, $grado, $tipo, $sinaprobar, $materia);
            case 19:
                $indicador = Indicador::find($indicador_id);
                $title = $indicador->nombre;
                $grado = 4;
                $tipo = 1; //EIB
                $materia = 5;
                $sinaprobar = IndicadorRepositorio::listar_importacionsinaprobar1($grado, $tipo);
                return $this->vistaOEI($indicador_id, $title, $grado, $tipo, $sinaprobar, $materia);

            case 35:
                return  redirect()->route('CuadroAsigPersonal.ReportePedagogico');
            case 37:
                return  redirect()->route('CuadroAsigPersonal.Bilingues');
            default:
                return 'sin informacion';
                break;
        }
    }
    public function vistaOEI($indicador_id, $title, $grado, $tipo, $sinaprobar, $materia)
    {
        $gt = IndicadorRepositorio::buscar_grado1($grado);
        //$anios = IndicadorRepositorio::buscar_anios1($grado, $tipo);
        $aniosx = IndicadorRepositorio::buscar_anios1($grado, $tipo);
        $areas = Area::all();
        $gestions = IndicadorRepositorio::listar_gestion1($grado, $tipo);

        $materias = IndicadorRepositorio::buscar_materia3($grado, $tipo, $materia);
        foreach ($materias as $key => $materiax) {
            $materiax->indicador = IndicadorRepositorio::listar_indicadoranio(date('Y'), $grado, $tipo, $materiax->id, 'asc');
            $materiax->previo = 0;
            foreach ($materiax->indicador as $item) {
                $materiax->previo += $item->previo;
            }
        }
        $anios = IndicadorRepositorio::buscar_anios1($grado, $tipo);
        foreach ($anios as $anio) {
            $anio->indicador = IndicadorRepositorio::listar_indicadorugel($anio->anio, $grado, $tipo, $materia);
            $anio->previo = 0;
            foreach ($anio->indicador as $indicador) {
                $indicador->ugel = str_replace('UGEL', '', $indicador->ugel);
                $anio->previo += $indicador->previo;
            }
        }
        //return $anios;
        $breadcrumb = [['titulo' => 'Relacion de indicadores', 'url' => route('Clasificador.menu', '05')], ['titulo' => 'Indicadores', 'url' => '']];
        return view('parametro.indicador.oei1', compact('indicador_id', 'title', 'grado', 'tipo', 'materia', 'sinaprobar', 'materias', 'gt', 'anios', 'aniosx', 'areas', 'gestions', 'breadcrumb'));
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
    public function reporteSatisfactorioMateria(Request $request)
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
    public function reporteUbigeoAjax(Request $request)
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
    /*public function indicadorDerivados2(Request $request)
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
    }*/
    public function reporteGestionAreaDT($anio, $grado, $tipo, $materia, $gestion, $area)
    {
        $inds = IndicadorRepositorio::listar_indicadorInstitucion($anio, $grado, $tipo, $materia, $gestion, $area);
        //return response()->json(compact('anio','grado','tipo','materia','gestion','area'));
        return  datatables()->of($inds)
            ->editColumn('nombre', '<div class="text-primary">{{$nombre}}</div>')
            ->editColumn('previo', '<div class="text-secondary text-center">{{$previo}}</div>')
            ->editColumn('p1', '<div class="text-secondary text-center">{{$p1}}</div>')
            ->editColumn('inicio', '<div class="text-danger text-center">{{$inicio}}</div>')
            ->editColumn('p2', '<div class="text-danger text-center">{{$p2}}</div>')
            ->editColumn('proceso', '<div class="text-warning text-center">{{$proceso}}</div>')
            ->editColumn('p3', '<div class="text-warning text-center">{{$p3}}</div>')
            ->editColumn('satisfactorio', '<div class="text-success text-center">{{$satisfactorio}}</div>')
            ->editColumn('p4', '<div class="text-success text-center">{{$p4}}</div>')
            ->rawColumns(['nombre', 'previo', 'p1', 'inicio', 'p2', 'proceso', 'p3', 'satisfactorio', 'p4',])
            ->toJson();
    }
    public function indicadorvivpnsrcab($provincia, $distrito, $indicador_id, $fecha)
    {
        $cp = IndicadorRepositorio::cabecera2($provincia, $distrito, $indicador_id, $fecha);
        return response()->json($cp);
    }
    public function ajaxEdu5v1($provincia, $distrito, $indicador_id, $anio_id)
    {
        switch ($indicador_id) {
            case 31:
                $cp = CensoRepositorio::listar_conElectricidad($provincia, $distrito, $indicador_id, $anio_id);
                break;
            case 32:
                $cp = CensoRepositorio::listar_conAguaPotable($provincia, $distrito, $indicador_id, $anio_id);
                break;
            case 33:
                $cp = CensoRepositorio::listar_conDesague($provincia, $distrito, $indicador_id, $anio_id);
                break;
            case 34:
                $cp = CensoRepositorio::listar_conServicioBasico($provincia, $distrito, $indicador_id, $anio_id);
                break;
            default:
                return [];
                break;
        }

        return response()->json($cp);
    }
    public function ajaxEdu6v1($provincia, $distrito, $indicador_id, $anio_id)
    {
        switch ($indicador_id) {
            case 40:
                $nivel = '37';
                $cp = CensoRepositorio::Listar_IE_nivel($provincia, $distrito, $indicador_id, $anio_id, $nivel);
                break;
            case 41:
                $nivel = '38';
                $cp = CensoRepositorio::Listar_IE_nivel($provincia, $distrito, $indicador_id, $anio_id, $nivel);
                break;
            case 42:
                $cp = []; //CensoRepositorio::listar_conDesague($provincia, $distrito, $indicador_id, $anio_id);
                break;
            case 43:
                $cp = CensoRepositorio::Listar_IE_computo($provincia, $distrito, $indicador_id, $anio_id);
                break;
            default:
                return [];
                break;
        }

        return response()->json($cp);
    }
}
