<?php

namespace App\Http\Controllers\Educacion;

use App\Http\Controllers\Controller;
use App\Imports\IndicadoresImport;
use App\Models\Educacion\Ece;
use App\Models\Educacion\EceResultado;
use App\Models\Educacion\Grado;
use App\Models\Educacion\Importacion;
use App\Models\Educacion\InstitucionEducativa;
use App\Models\Educacion\Materia;
use App\Models\Ubigeo;
use App\Repositories\Educacion\EceRepositorio;
use App\Repositories\Educacion\ImportacionRepositorio;
use Hamcrest\Type\IsNumeric;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\isNull;

class EceController extends Controller
{
    public function importar()
    {
        $fuentes = DB::table('par_fuenteimportacion')->get();
        $materias = Materia::all();
        $nivels = EceRepositorio::buscar_nivel1();
        return view('educacion.Ece.importar', compact('nivels', 'materias', 'fuentes'));
    }
    public function importarAprobar($importacion_id)
    {
        $importacion = ImportacionRepositorio::ImportacionPor_Id($importacion_id);
        $ece = EceRepositorio::buscar_ece1($importacion_id);
        $resultados = EceRepositorio::listar_eceresultado1($ece->id);
        return view('educacion.Ece.Aprobar', compact('importacion', 'ece', 'resultados', 'importacion_id'));
    }
    public function importarAprobarGuardar(Importacion $importacion)
    {
        $importacion->estado = 'PR';
        $importacion->save();
        return back()->with('message', 'Importacion Aprobada Correctamente');
    }
    public function importarGuardar(Request $request)
    {
        $this->validate($request, ['file' => 'required|mimes:xls,xlsx',]);
        $archivo = $request->file('file');
        $array = (new IndicadoresImport)->toArray($archivo);

        $errores['tipo'] = '1';
        $errores['msn'] = 'Importacion Exitosa';
        /*Buscar colegios no agregados*/
        $noagregados = [];
        foreach ($array as $key => $value) {
            foreach ($value as $key2 => $row) {
                $insedu = InstitucionEducativa::where('codModular', $row['codigo_modular'])->where('estado', 'AC')->first();
                if (!$insedu) {
                    $noagregados[] = $row['codigo_modular'];
                }
            }
        }
        if (count($noagregados) > 0) {
            $errores['tipo'] = '0';
            $errores['msn'] = 'ERROR EN LA IMPORTACION';
            return view('educacion.Ece.Error1', compact('noagregados', 'errores'));
        }

        /** agregar excel al sistema */
        if (count($array) > 0) {
            $importacion = Importacion::Create([
                'fuenteImportacion_id' => $request->fuenteImportacion, // valor predeterminado
                'usuarioId_Crea' => auth()->user()->id,
                'usuarioId_Aprueba' => null,
                'fechaActualizacion' => $request->fechaActualizacion,
                'comentario' => $request->comentario,
                'estado' => 'PE'
            ]);
            $ece = Ece::Create([
                'anio' => $request->anio,
                'tipo' => $request->tipo,
                'grado_id' => $request->grado,
                'importacion_id' => $importacion->id,
                'estado' => 'PE',
            ]);
            foreach ($array as $key => $value) {
                foreach ($value as $key2 => $row) {
                    $insedu = InstitucionEducativa::where('codModular', $row['codigo_modular'])->first();
                    if ($request->tipo == 0) {
                        $eceresultado = EceResultado::Create([
                            'ece_id' => $ece->id,
                            'institucioneducativa_id' => $insedu->id,
                            'materia_id' => $row['materia'],
                            'programados' => $row['programados'],
                            'evaluados' => $row['evaluados'],
                            'previo' => $row['previo'],
                            'inicio' => $row['inicio'],
                            'proceso' => $row['proceso'],
                            'mediapromedio' => $row['media_promedio'],
                            'satisfactorio' => $row['satisfactorio'],
                        ]);
                    } else {
                        if ($row['programados'] != null)
                            if ($row['programados'] != '') {
                                $eceresultado = EceResultado::Create([
                                    'ece_id' => $ece->id,
                                    'institucioneducativa_id' => $insedu->id,
                                    'materia_id' => $row['materia'],
                                    'lengua' => $row['lengua_evaluada'],
                                    'programados' => $row['programados'],
                                    'evaluados' => $row['evaluados'],
                                    'inicio' => $row['inicio'],
                                    'proceso' => $row['proceso'],
                                    'mediapromedio' => $row['media_promedio'],
                                    'satisfactorio' => $row['satisfactorio'],
                                ]);
                            }
                    }
                }
            }
        }
        return back()->with('message', 'IMPORTACION EXITOSA');
    }
    public function importarMenu()
    {
        return view('educacion.menu');
    }
    public function indicador1()
    {
        return view('educacion.ece.indicador1');
    }
    public function indicadorx()
    {
        $grado = DB::table('edu_grado as v1')->select('v1.*', 'v2.nombre')
            ->join('edu_nivelmodalidad as v2', 'v2.id', '=', 'v1.nivelmodalidad_id')
            ->where('v1.descripcion', '2do')
            ->where('v2.nombre', 'Secundaria')->first();
        //->where('v2.nombre','Primaria')->first();
        $materias = DB::table('edu_materia as v1')
            ->select('v1.*')
            ->join('edu_eceresultado as v2', 'v2.materia_id', '=', 'v1.id')
            ->join('edu_ece as v3', 'v3.id', '=', 'v2.ece_id')
            ->where('v3.grado_id', $grado->id)
            ->distinct()->get();
        $distritos = DB::table('par_ubigeo as v1')
            ->select('v1.*')
            ->join('centropoblado as v2', 'v2.Ubigeo_id', '=', 'v1.id')
            ->join('edu_institucioneducativa as v3', 'v3.CentroPoblado_id', '=', 'v2.id')
            ->join('edu_eceresultado as v4', 'v4.institucioneducativa_id', '=', 'v3.id')
            ->join('edu_ece as v5', 'v5.id', '=', 'v4.ece_id')
            ->where('v5.grado_id', $grado->id)
            ->distinct()->get();
        $provincias2 = DB::table('par_ubigeo as v1')
            ->select('v1.*')
            ->join('centropoblado as v2', 'v2.Ubigeo_id', '=', 'v1.id')
            ->join('edu_institucioneducativa as v3', 'v3.CentroPoblado_id', '=', 'v2.id')
            ->join('edu_eceresultado as v4', 'v4.institucioneducativa_id', '=', 'v3.id')
            ->join('edu_ece as v5', 'v5.id', '=', 'v4.ece_id')
            ->where('v5.grado_id', $grado->id)
            ->where('v1.codigo', 'like', '2501' . '%')
            ->distinct()->get();
        $provincias = Ubigeo::whereRaw('LENGTH(codigo)=4')->get();
        $departamentos = DB::table('par_ubigeo as v1')
            ->select('v1.*')
            ->join('centropoblado as v2', 'v2.Ubigeo_id', '=', 'v1.id')
            ->join('edu_institucioneducativa as v3', 'v3.CentroPoblado_id', '=', 'v2.id')
            ->join('edu_eceresultado as v4', 'v4.institucioneducativa_id', '=', 'v3.id')
            ->join('edu_ece as v5', 'v5.id', '=', 'v4.ece_id')
            ->where('v5.grado_id', $grado->id)
            ->where('v1.codigo', 'like', '25' . '%')
            ->distinct()->get();
        $tabla = '<table class="table mb-0">';
        $tabla .= '<thead><tr><th></th>';
        foreach ($materias as $key => $value) {
            $tabla .= '<th>' . $value->descripcion . '</th>';
        }
        $tabla .= '</tr></thead><tbody>';
        //oreach ($distritos as $distrito) {
        $tabla .= '<tr><td>TODOS</td>';
        foreach ($materias as $materia) {
            $resultado = DB::table('edu_eceresultado as v1')
                ->join('edu_ece as v2', 'v2.id', '=', 'v1.ece_id')
                ->where('v2.grado_id', $grado->id)
                ->where('v2.anio', '2018')
                ->where('v1.materia_id', $materia->id)
                ->get([
                    DB::raw('sum(v1.programados) as programados'),
                    DB::raw('sum(v1.evaluados) as evaluados'),
                    DB::raw('sum(v1.satisfactorio) as satisfactorio')
                ]);
            $indicador = $resultado[0]->satisfactorio * 100 / $resultado[0]->evaluados;
            $tabla .= '<td>' . round($indicador, 2) . '</td>';
        }
        $tabla .= '</tr>';

        //}

        $tabla .= '</tbody></table>';
        return view('educacion.ece.indicadorlogro', compact('grado', 'materias', 'provincias', 'tabla'));
    }
    public function indicador4()
    {
        $provincias = Ubigeo::whereRaw('LENGTH(codigo)=4')->get();
        $title = 'Alumnos que logran los aprendizajes del grado (% de alumnos de 2° grado de primaria participantes en evaluaciones censal)';
        $grado = 2; //'2do';
        $tipo = 0;
        $ruta = 'ece.indicador.vista';
        $anios = EceRepositorio::buscar_anios1($grado,$tipo);
        return view('educacion.ece.indicadorlogro', compact('provincias', 'title', 'grado','tipo', 'ruta', 'anios'));
    }
    public function indicador5()
    {
        $provincias = Ubigeo::whereRaw('LENGTH(codigo)=4')->get();
        $title = 'Alumnos que logran los aprendizajes del grado (% de alumnos de 2° grado de secundaria participantes en evaluación censal)';
        $grado = 8; // '2do';
        $tipo = 0;
        $ruta = 'ece.indicador.vista';
        $anios = EceRepositorio::buscar_anios1($grado,$tipo);
        return view('educacion.ece.indicadorlogro', compact('provincias', 'title', 'grado',  'tipo', 'ruta', 'anios'));
    }
    public function indicador6()
    {
        $provincias = Ubigeo::whereRaw('LENGTH(codigo)=4')->get();
        $title = 'Alumnos que logran los aprendizajes del grado (% de alumnos de 4° grado de primaria participantes en evaluación censal)';
        $grado = 4; //'4to';
        $tipo = 0;
        $ruta = 'ece.indicador.vista';
        $anios = EceRepositorio::buscar_anios1($grado,$tipo);
        return view('educacion.ece.indicadorlogro', compact('provincias', 'title', 'grado', 'tipo', 'ruta', 'anios'));
    }
    public function indicador7()
    {
        $provincias = Ubigeo::whereRaw('LENGTH(codigo)=4')->get();
        $title = 'Alumnos de EIB que logran los aprendizajes del 4° grado en lengua materna y en castellano como segunda lengua.';
        $grado = 4; //'4to';
        $tipo = 1;//EIB
        $ruta = 'ece.indicador.vista';
        $anios = EceRepositorio::buscar_anios1($grado,$tipo);
        return view('educacion.ece.indicadorlogro', compact('provincias', 'title', 'grado', 'tipo', 'ruta', 'anios'));
    }
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
        $materias = EceRepositorio::buscar_materia1($request->grado, $request->tipo);
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
}
