<?php

namespace App\Http\Controllers\Educacion;

use App\Http\Controllers\Controller;
use App\Models\Parametro\Clasificador;
use App\Models\Educacion\Indicador;
use App\Models\Educacion\Materia;
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
    public function indicadorEducacion($indicador_id)
    {
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
                return view('educacion.indicador.educat1', compact('title', 'nivel', 'inds',  'info', 'limit'));

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
                return view('educacion.indicador.educat1', compact('title', 'nivel', 'inds',   'info', 'limit'));
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
                return view('educacion.indicador.educat1', compact('title', 'nivel', 'inds', 'info', 'limit'));
            case '4': //LOGROS  
                $indicador = Indicador::find($indicador_id);
                $title = $indicador->nombre;
                $grado = 2;
                $tipo = 0;
                $sinaprobar = EceRepositorio::listar_importacionsinaprobar1($grado, $tipo);
                return $this->vistaEducacionCat2($indicador_id, $title, $grado, $tipo, $sinaprobar);
            case '5': //LOGROS 
                $indicador = Indicador::find($indicador_id);
                $title = $indicador->nombre;
                $grado = 8;
                $tipo = 0;
                $sinaprobar = EceRepositorio::listar_importacionsinaprobar1($grado, $tipo);
                return $this->vistaEducacionCat2($indicador_id, $title, $grado, $tipo, $sinaprobar);
            case '6': //LOGROS 
                $indicador = Indicador::find($indicador_id);
                $title = $indicador->nombre;
                $grado = 4;
                $tipo = 0;
                $sinaprobar = EceRepositorio::listar_importacionsinaprobar1($grado, $tipo);
                return $this->vistaEducacionCat2($indicador_id, $title, $grado, $tipo, $sinaprobar);
            case '7': //LOGROS 
                $indicador = Indicador::find($indicador_id);
                $title = $indicador->nombre;
                $grado = 4;
                $tipo = 1; //EIB
                $sinaprobar = EceRepositorio::listar_importacionsinaprobar1($grado, $tipo);
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
                return view('educacion.indicador.educat3', compact('title', 'nivel', 'inds',  'info', 'limit'));
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
                return view('educacion.indicador.educat3', compact('title', 'nivel', 'inds',  'info', 'limit'));
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
                return view('educacion.indicador.educat3', compact('title', 'nivel', 'inds',  'info', 'limit'));
            case '11': //PROFESORES   
                $indicador = Indicador::find($indicador_id);
                $title = $indicador->nombre;
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
                    $indutt = IndicadorRepositorio::listar_profesorestituladougel2($nivel, $value->id);
                    $value->total = $indutt[0]->total;
                }
                $labels = '[';
                $datas = '[';
                foreach ($indu as $key => $value) {
                    $labels .= '"' . $value->nombre . '",';
                    $datas .= round($value->titulado * 100 / $value->total, 2) . ',';
                }
                $labels .= ']';
                $datas .= ']';
                $graf2 = ['labels' => $labels, 'datas' => $datas];
                return view('educacion.indicador.educat4', compact('title', 'nivel', 'inds', 'total', 'graf1', 'indu', 'graf2'));
            case '12': //PROFESORES  
                $indicador = Indicador::find($indicador_id);
                $title = $indicador->nombre;
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
                    $indutt = IndicadorRepositorio::listar_profesorestituladougel2($nivel, $value->id);
                    $value->total = $indutt[0]->total;
                }
                $labels = '[';
                $datas = '[';
                foreach ($indu as $key => $value) {
                    $labels .= '"' . $value->nombre . '",';
                    $datas .= round($value->titulado * 100 / $value->total, 2) . ',';
                }
                $labels .= ']';
                $datas .= ']';
                $graf2 = ['labels' => $labels, 'datas' => $datas];
                return view('educacion.indicador.educat4', compact('title', 'nivel', 'inds', 'total', 'graf1', 'indu', 'graf2'));
            case 13: //PROFESORES  
                $indicador = Indicador::find($indicador_id);
                $title = $indicador->nombre;
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
                    $indutt = IndicadorRepositorio::listar_profesorestituladougel2($nivel, $value->id);
                    $value->total = $indutt[0]->total;
                }
                $labels = '[';
                $datas = '[';
                foreach ($indu as $key => $value) {
                    $labels .= '"' . $value->nombre . '",';
                    $datas .= round($value->titulado * 100 / $value->total, 2) . ',';
                }
                $labels .= ']';
                $datas .= ']';
                $graf2 = ['labels' => $labels, 'datas' => $datas];
                return view('educacion.indicador.educat4', compact('title', 'nivel', 'inds', 'total', 'graf1', 'indu', 'graf2'));
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
        $materias = EceRepositorio::buscar_materia3($grado, $tipo);
        foreach ($materias as $key => $materia) {
            $materia->indicador = EceRepositorio::listar_indicadoranio(date('Y'), $grado, $tipo, $materia->id, 'asc');
        }
        return view('educacion.indicador.educat2', compact('indicador_id', 'title', 'grado', 'tipo', 'sinaprobar', 'materias'));
    }
    public function indDetEdu($indicador_id, $grado, $tipo, $materia)
    {
        $indicador = Indicador::find($indicador_id);
        $title = $indicador->nombre;
        $anios=EceRepositorio::buscar_anios1($grado, $tipo);
        /*$aniog=[];
        foreach ($anios as $key => $anio) {
            $aniog[]=['anio'=>$anio->anio,'indicador'=>EceRepositorio::listar_indicadorugel($anio->anio, $grado, $tipo, $materia)];
        }*/
        foreach ($anios as $anio) {
            $anio->indicador=EceRepositorio::listar_indicadorugel($anio->anio, $grado, $tipo, $materia);
            foreach ($anio->indicador as $indicador) {
                $indicador->ugel=str_replace('UGEL','',$indicador->ugel);
            }
        }
        //return response()->json(compact('anios'));
        return view('educacion.indicador.educat2detalle', compact('title', 'grado', 'tipo', 'materia','anios'));
    }
    public function vistaEducacionCat3($title, $grado, $tipo, $sinaprobar)
    {
        return 'sin informacion';
    }
    public function vistaEducacionCat4($title, $grado, $tipo, $sinaprobar)
    {
        return 'sin informacion';
    }
    /****** */
    public function indicadorPDRC($indicador_id)
    {
        switch ($indicador_id) {
            case 14:
                $indicador = Indicador::find($indicador_id);
                $title = $indicador->nombre;
                $grado = 2;
                $tipo = 0;
                $materia = 1;
                $sinaprobar = EceRepositorio::listar_importacionsinaprobar1($grado, $tipo);
                $info1 = EceRepositorio::buscar_materia3($grado, $tipo, $materia);
                foreach ($info1 as $key => $value) {
                    $value->indicador = EceRepositorio::listar_indicadoranio(date('Y'), $grado, $tipo, $value->id, 'asc');
                }
                return view('educacion.indicador.pdrc1', compact('title', 'grado', 'tipo', 'sinaprobar', 'info1'));
            case 15:
                $indicador = Indicador::find($indicador_id);
                $title = $indicador->nombre;
                $grado = 2;
                $tipo = 0;
                $materia = 2;
                $sinaprobar = EceRepositorio::listar_importacionsinaprobar1($grado, $tipo);
                $info1 = EceRepositorio::buscar_materia3($grado, $tipo, $materia);
                foreach ($info1 as $key => $value) {
                    $value->indicador = EceRepositorio::listar_indicadoranio(date('Y'), $grado, $tipo, $value->id, 'asc');
                }
                return view('educacion.indicador.pdrc1', compact('title', 'grado', 'tipo', 'sinaprobar', 'info1'));
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
                return view('educacion.indicador.educat1', compact('title', 'nivel', 'inds',  'info', 'limit'));
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
                return view('educacion.indicador.educat1', compact('title', 'nivel', 'inds',  'info', 'limit'));

            default:
                return 'sin informacion';
                break;
        }
    }
    /****** */
    public function indicadorOEI($indicador_id)
    {
        switch ($indicador_id) {
            case 18:
                $indicador = Indicador::find($indicador_id);
                $title = $indicador->nombre;
                $grado = 2;
                $tipo = 0;
                $materia = 1;
                $sinaprobar = EceRepositorio::listar_importacionsinaprobar1($grado, $tipo);
                $info1 = EceRepositorio::buscar_materia3($grado, $tipo, $materia);
                foreach ($info1 as $key => $value) {
                    $value->indicador = EceRepositorio::listar_indicadoranio(date('Y'), $grado, $tipo, $value->id, 'asc');
                }
                return view('educacion.indicador.oei1', compact('title', 'grado', 'tipo', 'sinaprobar', 'info1'));
            case 19:
                $indicador = Indicador::find($indicador_id);
                $title = $indicador->nombre;
                $grado = 2;
                $tipo = 0;
                $materia = 2;
                $sinaprobar = EceRepositorio::listar_importacionsinaprobar1($grado, $tipo);
                $info1 = EceRepositorio::buscar_materia3($grado, $tipo, $materia);
                foreach ($info1 as $key => $value) {
                    $value->indicador = EceRepositorio::listar_indicadoranio(date('Y'), $grado, $tipo, $value->id, 'asc');
                }
                return view('educacion.indicador.oei1', compact('title', 'grado', 'tipo', 'sinaprobar', 'info1'));
            default:
                return 'sin informacion';
                break;
        }
    }
    /*****OTRAS OPCIONES */
    public function cargarprovincias()
    {
        $provincias = EceRepositorio::buscar_provincia1();
        return response()->json($provincias);
    }
    public function cargardistritos($provincia)
    {
        //$distritos = Ubigeo::where('codigo', 'like', $provincia . '%')->whereRaw('LENGTH(codigo)=6')->get();
        $distritos = EceRepositorio::buscar_distrito1($provincia);
        return response()->json(compact('distritos'));
    }
    public function cargargrados(Request $request)
    {
        $grados = EceRepositorio::buscar_grados1($request->nivel);
        return response()->json(compact('grados'));
    }
    public function indicadorLOGROS(Request $request)
    {
        $materias = EceRepositorio::buscar_materia1($request->anio, $request->grado, $request->tipo);
        $tabla = '<table class="table mb-0">';
        $tabla .= '<thead><tr><th></th>';
        foreach ($materias as $key => $value) {
            $tabla .= '<th>' . $value->descripcion . '</th>';
        }
        $tabla .= '</tr></thead><tbody>';
        if ($request->provincia == 0 && $request->distrito == 0) {
            $provincias = EceRepositorio::buscar_provincia1();
            foreach ($provincias as $provincia) {
                $tabla .= '<tr><td>' . $provincia->nombre . '</td>';
                foreach ($materias as $materia) {
                    $resultado = EceRepositorio::buscar_resultado1($request->anio, $request->grado, $request->tipo, $materia->id, $provincia->id);
                    if ($resultado[0]->evaluados) {
                        $indicador = $resultado[0]->satisfactorio * 100 / $resultado[0]->evaluados;
                    } else $indicador = 0.0;
                    $tabla .= '<td>' . round($indicador, 2) . '</td>';
                }
                $tabla .= '</tr>';
            }
            $tabla .= '<tr><td>TOTAL</td>';
            foreach ($materias as $materia) {
                $resultado = EceRepositorio::buscar_resultado2($request->anio, $request->grado, $request->tipo, $materia->id);
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
                    $resultado = EceRepositorio::buscar_resultado3($request->anio, $request->grado, $request->tipo, $materia->id, $distrito->id);
                    if ($resultado[0]->evaluados) {
                        $indicador = $resultado[0]->satisfactorio * 100 / $resultado[0]->evaluados;
                    } else $indicador = 0.0;
                    $tabla .= '<td>' . round($indicador, 2) . '</td>';
                }
                $tabla .= '</tr>';
            }
            $tabla .= '<tr><td>' . $provincia->nombre . '</td>';
            foreach ($materias as $materia) {
                $resultado = EceRepositorio::buscar_resultado1($request->anio, $request->grado, $request->tipo, $materia->id, $provincia->id);
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
                $resultado = EceRepositorio::buscar_resultado3($request->anio, $request->grado, $request->tipo, $materia->id, $distrito->id);
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
    public function indicadorSatisfactorio(Request $request)//puede eliminar
    {
        $inds = EceRepositorio::listar_indicadorsatisfactorio($request->anio, $request->grado, $request->tipo);
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
        $inds = EceRepositorio::listar_indicadorsatisfactorio1($request->anio, $request->grado, $request->tipo, $request->materia);
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
        $materias = EceRepositorio::buscar_materia1($request->anio, $request->grado, $request->tipo);
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
            $inds = EceRepositorio::listar_indicadoranio($request->anio, $request->grado, $request->tipo, $materia->id, 'desc');
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
    public function indicadorUgel(Request $request)//observador si se usa
    {
        $card = '';
        $materias = EceRepositorio::buscar_materia1($request->anio, $request->grado, $request->tipo);
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
            $inds = EceRepositorio::listar_indicadorugel($request->anio, $request->grado, $request->tipo, $materia->id);
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
        //return response()->json(compact('materia'));
        //$materias = EceRepositorio::buscar_materia1($request->anio, $request->grado, $request->tipo);
        //foreach ($materias as $key => $materia) {

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
            $inds = EceRepositorio::listar_indicadorugel($request->aniox, $request->grado, $request->tipo, $materia->id);
            //return response()->json(compact('inds'));
            foreach ($inds as $ind) {
                $card .= '<tr>
                            <td class="text-primary"><span>' . str_replace('UGEL',"",$ind->ugel) . '</span></td>
                            <td class="text-secondary">' . ($ind->previo) . '</td>
                            <td class="text-secondary">' . round($ind->previo * 100 / $ind->evaluados, 2) . '%</td>
                            <td class="text-danger">' . ($ind->inicio) . '</td>
                            <td class="text-danger">' . round( $ind->inicio * 100 / $ind->evaluados, 2) . '%</td>
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
        $materias = EceRepositorio::buscar_materia1($request->anio, $request->grado, $request->tipo);
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
            $inds = EceRepositorio::listar_indicadorprovincia($request->anio, $request->grado, $request->tipo, $materia->id);
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

        $materias = EceRepositorio::buscar_materia1($request->anio, $request->grado, $request->tipo);
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
                                            <th class="text-danger">INICIO</th>
                                            <th class="text-warning">PROCESO</th>
                                            <th class="text-success">SATISFACTORIO</th>
                                        </tr>
                                    </thead>
                                    <tbody>';
            if ($request->provincia == 0) {
                $inds = EceRepositorio::listar_indicadorprovincia($request->anio, $request->grado, $request->tipo, $materia->id);
                foreach ($inds as $ind) {
                    $card .= '<tr>
                            <td><span>' . $ind->provincia . '</span></td>
                            <!--td class="text-secondary">' . round($ind->previo * 100 / $ind->evaluados, 1) . '%</td-->
                            <td class="text-danger">' . round(($ind->previo + $ind->inicio) * 100 / $ind->evaluados, 1) . '%</td>
                            <td class="text-warning">' . round($ind->proceso * 100 / $ind->evaluados, 1) . '%</td>
                            <td class="text-success">' . round($ind->satisfactorio * 100 / $ind->evaluados, 1) . '%</td>
                        </tr>';
                }
                $inds = EceRepositorio::listar_indicadordepartamento($request->anio, $request->grado, $request->tipo, $materia->id);
                foreach ($inds as $ind) {
                    $card .= '<tr class="table-success">
                                <td><span>TODOS(UCAYALI)</span></td>
                                <!--td class="text-secondary">' . round($ind->previo * 100 / $ind->evaluados, 1) . '%</td-->
                                <td class="text-danger">' . round(($ind->previo + $ind->inicio) * 100 / $ind->evaluados, 1) . '%</td>
                                <td class="text-warning">' . round($ind->proceso * 100 / $ind->evaluados, 1) . '%</td>
                                <td class="text-success">' . round($ind->satisfactorio * 100 / $ind->evaluados, 1) . '%</td>
                            </tr>';
                }
            } else {
                if ($request->distrito == 0) {
                    $inds = EceRepositorio::listar_indicadordistrito($request->anio, $request->grado, $request->tipo, $materia->id, $request->provincia);
                    foreach ($inds as $ind) {
                        $card .= '<tr>
                            <td><span>' . $ind->distrito . '</span></td>
                            <!--td class="text-secondary">' . round($ind->previo * 100 / $ind->evaluados, 1) . '%</td-->
                            <td class="text-danger">' . round(($ind->previo + $ind->inicio) * 100 / $ind->evaluados, 1) . '%</td>
                            <td class="text-warning">' . round($ind->proceso * 100 / $ind->evaluados, 1) . '%</td>
                            <td class="text-success">' . round($ind->satisfactorio * 100 / $ind->evaluados, 1) . '%</td>
                        </tr>';
                    }
                    $inds = EceRepositorio::listar_indicadorprovincia($request->anio, $request->grado, $request->tipo, $materia->id, $request->provincia);
                    foreach ($inds as $ind) {
                        $card .= '<tr class="table-success">
                            <td><span\>' . $ind->provincia . '</span></td>
                            <!--td class="text-secondary">' . round($ind->previo * 100 / $ind->evaluados, 1) . '%</td-->
                            <td class="text-danger">' . round(($ind->previo + $ind->inicio) * 100 / $ind->evaluados, 1) . '%</td>
                            <td class="text-warning">' . round($ind->proceso * 100 / $ind->evaluados, 1) . '%</td>
                            <td class="text-success">' . round($ind->satisfactorio * 100 / $ind->evaluados, 1) . '%</td>
                        </tr>';
                    }
                } else {
                    $inds = EceRepositorio::listar_indicadordistrito($request->anio, $request->grado, $request->tipo, $materia->id, $request->provincia, $request->distrito);
                    //return $inds;
                    foreach ($inds as $ind) {
                        $card .= '<tr class="table-success">
                            <td><span>' . $ind->distrito . '</span></td>
                            <!--td class="text-secondary">' . round($ind->previo * 100 / $ind->evaluados, 1) . '%</td-->
                            <td class="text-danger">' . round(($ind->previo + $ind->inicio) * 100 / $ind->evaluados, 1) . '%</td>
                            <td class="text-warning">' . round($ind->proceso * 100 / $ind->evaluados, 1) . '%</td>
                            <td class="text-success">' . round($ind->satisfactorio * 100 / $ind->evaluados, 1) . '%</td>
                        </tr>';
                    }
                }
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
}
