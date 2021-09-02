<?php

namespace App\Repositories\Educacion;

use App\Models\Educacion\Grado;
use App\Models\Educacion\NivelModalidad;
use App\Models\Ubigeo;
use Illuminate\Support\Facades\DB;

class IndicadorRepositorio
{
    public static function buscar_nivel1()
    {
        $query = NivelModalidad::whereIn('id', ['37', '38'])->get();
        return $query;
    }
    public static function buscar_grado1($grado)
    {
        $query = DB::table('edu_grado as v1')->join('edu_nivelmodalidad as v2', 'v2.id', '=', 'v1.nivelmodalidad_id')->select('v1.id', 'v1.descripcion as grado', 'v2.nombre as nivel')->where('v1.id', $grado)->get();
        return $query;
    }
    public static function buscar_grados1($nivel)
    {
        $query = Grado::where('nivelmodalidad_id', $nivel)->get();
        return $query;
    }
    public static function buscar_materia1($anio, $grado, $tipo)
    {
        $query = DB::table('edu_materia as v1')
            ->select('v1.*')
            ->join('edu_eceresultado as v2', 'v2.materia_id', '=', 'v1.id')
            ->join('edu_ece as v3', 'v3.id', '=', 'v2.ece_id')
            ->where('v3.grado_id', $grado)
            ->where('v3.tipo', $tipo)
            ->where('v3.anio', $anio)
            ->orderBy('v1.id', 'asc')
            ->distinct()->get();
        return $query;
    }
    public static function buscar_materia2($grado, $tipo, $materia = null)
    {
        $query1 = DB::table('edu_ece as v1')
            ->join('par_importacion as v2', 'v2.id', '=', 'v1.importacion_id')
            ->where('v1.grado_id', $grado)
            ->where('v1.tipo', $tipo)
            ->where('v2.estado', 'PR')
            ->get([DB::raw('max(v1.anio) as anio')]);
        if ($materia) {
            $query = DB::table('edu_materia as v1')
                ->select('v1.*')
                ->join('edu_eceresultado as v2', 'v2.materia_id', '=', 'v1.id')
                ->join('edu_ece as v3', 'v3.id', '=', 'v2.ece_id')
                ->where('v1.id', $materia)
                ->where('v3.grado_id', $grado)
                ->where('v3.tipo', $tipo)
                ->where('v3.anio', '=', $query1[0]->anio)
                ->orderBy('v1.id', 'asc')
                ->distinct()->get();
        } else {
            $query = DB::table('edu_materia as v1')
                ->select('v1.*')
                ->join('edu_eceresultado as v2', 'v2.materia_id', '=', 'v1.id')
                ->join('edu_ece as v3', 'v3.id', '=', 'v2.ece_id')
                ->where('v3.grado_id', $grado)
                ->where('v3.tipo', $tipo)
                ->where('v3.anio', '=', $query1[0]->anio)
                ->orderBy('v1.id', 'asc')
                ->distinct()->get();
        }
        return $query;
    }
    public static function buscar_materia3($grado, $tipo, $materia = null)
    {
        if ($materia) {
            $query = DB::table('edu_materia as v1')
                ->select('v1.*')
                ->join('edu_eceresultado as v2', 'v2.materia_id', '=', 'v1.id')
                ->join('edu_ece as v3', 'v3.id', '=', 'v2.ece_id')
                ->join('par_importacion as v4', 'v4.id', '=', 'v3.importacion_id')
                ->where('v1.id', $materia)
                ->where('v3.grado_id', $grado)
                ->where('v3.tipo', $tipo)
                ->where('v4.estado', 'PR')
                ->orderBy('v1.id', 'asc')
                ->distinct()->get();
        } else {
            $query = DB::table('edu_materia as v1')
                ->select('v1.*')
                ->join('edu_eceresultado as v2', 'v2.materia_id', '=', 'v1.id')
                ->join('edu_ece as v3', 'v3.id', '=', 'v2.ece_id')
                ->join('par_importacion as v4', 'v4.id', '=', 'v3.importacion_id')
                ->where('v3.grado_id', $grado)
                ->where('v3.tipo', $tipo)
                ->where('v4.estado', 'PR')
                ->orderBy('v1.id', 'asc')
                ->distinct()->get();
        }
        return $query;
    }
    public static function buscar_provincia1()
    {
        $query = Ubigeo::whereRaw('LENGTH(codigo)=4')->get();
        return $query;
    }
    public static function buscar_distrito1($provincia)
    {
        $query = Ubigeo::where('dependencia', $provincia)->get();
        return $query;
    }
    public static function buscar_resultado1($anio, $grado, $tipo, $materia, $provincia)
    {
        $query = DB::table('edu_eceresultado as v1')
            ->join('edu_ece as v2', 'v2.id', '=', 'v1.ece_id')
            ->join('edu_institucioneducativa as v3', 'v3.id', '=', 'v1.institucioneducativa_id')
            ->join('par_centropoblado as v4', 'v4.id', '=', 'v3.CentroPoblado_id')
            ->join('par_ubigeo as v5', 'v5.id', '=', 'v4.Ubigeo_id')
            ->where('v2.grado_id', $grado)
            ->where('v2.anio', $anio)
            ->where('v2.tipo', $tipo)
            ->where('v1.materia_id', $materia)
            ->where('v5.dependencia', $provincia)
            ->get([
                DB::raw('sum(v1.programados) as programados'),
                DB::raw('sum(v1.evaluados) as evaluados'),
                DB::raw('sum(v1.satisfactorio) as satisfactorio')
            ]);
        return $query;
    }
    public static function buscar_resultado2($anio, $grado, $tipo, $materia)
    {
        $query = DB::table('edu_eceresultado as v1')
            ->join('edu_ece as v2', 'v2.id', '=', 'v1.ece_id')
            ->where('v2.grado_id', $grado)
            ->where('v2.anio', $anio)
            ->where('v2.tipo', $tipo)
            ->where('v1.materia_id', $materia)
            ->get([
                DB::raw('sum(v1.programados) as programados'),
                DB::raw('sum(v1.evaluados) as evaluados'),
                DB::raw('sum(v1.satisfactorio) as satisfactorio')
            ]);
        return $query;
    }
    public static function buscar_resultado3($anio, $grado, $tipo, $materia, $distrito)
    {
        $query = DB::table('edu_eceresultado as v1')
            ->join('edu_ece as v2', 'v2.id', '=', 'v1.ece_id')
            ->join('edu_institucioneducativa as v3', 'v3.id', '=', 'v1.institucioneducativa_id')
            ->join('par_centropoblado as v4', 'v4.id', '=', 'v3.CentroPoblado_id')
            ->join('par_ubigeo as v5', 'v5.id', '=', 'v4.Ubigeo_id')
            ->where('v2.grado_id', $grado)
            ->where('v2.anio', $anio)
            ->where('v2.tipo', $tipo)
            ->where('v1.materia_id', $materia)
            ->where('v5.id', $distrito)
            ->get([
                DB::raw('sum(v1.programados) as programados'),
                DB::raw('sum(v1.evaluados) as evaluados'),
                DB::raw('sum(v1.satisfactorio) as satisfactorio')
            ]);
        return $query;
    }
    public static function buscar_ece1($importacion_id)
    {
        $query = DB::table('edu_ece as v1')
            ->join('edu_grado as v2', 'v2.id', '=', 'v1.grado_id')
            ->join('edu_nivelmodalidad as v3', 'v3.id', '=', 'v2.nivelmodalidad_id')
            ->where('v1.importacion_id', $importacion_id)
            ->select('v1.*', 'v2.descripcion as grado', 'v3.nombre as nivel')
            ->first();
        return $query;
    }
    public static function buscar_anios1($grado, $tipo)
    {
        $query = DB::table('edu_ece as v1')
            ->join('par_importacion as v2', 'v2.id', '=', 'v1.importacion_id')
            ->where('v1.grado_id', $grado)
            ->where('v1.tipo', $tipo)
            ->where('v2.estado', 'PR')
            ->select('v1.anio')
            ->distinct('v1.anio')
            ->orderBy('v1.anio', 'desc')
            ->get();
        return $query;
    }
    public static function buscar_anios2($grado, $tipo)
    {
        $query = DB::table('edu_ece as v1')
            ->join('par_importacion as v2', 'v2.id', '=', 'v1.importacion_id')
            ->where('v1.grado_id', $grado)
            ->where('v1.tipo', $tipo)
            ->where('v2.estado', 'PR')
            ->select('v1.anio')
            ->orderBy('v1.anio', 'desc')
            ->get(['max(v1.anio)']);
        return $query;
    }
    public static function listar_eceresultado1($ece)
    {
        $query = DB::table('edu_eceresultado as v1')
            ->join('edu_institucioneducativa as v2', 'v2.id', '=', 'v1.institucioneducativa_id')
            ->join('edu_materia as v3', 'v3.id', '=', 'v1.materia_id')
            ->where('v1.ece_id', $ece)
            ->select('v1.*', 'v2.codModular as codigo_modular', 'v3.descripcion as materia')
            ->get();
        return $query;
    }
    public static function listar_indicadorsatisfactorio1($anio, $grado, $tipo, $materia) //no usado
    {
        $query = DB::table('edu_eceresultado as v1')
            ->join('edu_ece as v2', 'v2.id', '=', 'v1.ece_id')
            ->join('edu_materia as v3', 'v3.id', '=', 'v1.materia_id')
            ->where('v2.grado_id', $grado)
            ->where('v2.anio', $anio)
            ->where('v2.tipo', $tipo)
            ->where('v1.materia_id', $materia)
            ->groupBy('v1.materia_id')
            ->groupBy('v3.descripcion')
            ->get([
                'v1.materia_id',
                'v3.descripcion as materia',
                DB::raw('sum(evaluados)     as evaluados'),
                DB::raw('sum(previo)        as previo'),
                DB::raw('sum(inicio)        as inicio'),
                DB::raw('sum(proceso)       as proceso'),
                DB::raw('sum(satisfactorio) as satisfactorio'),
            ]);
        return $query;
    }
    public static function listar_indicadorsatisfactorio($anio, $grado, $tipo) //esta por ver 
    {
        $query = DB::table('edu_eceresultado as v1')
            ->join('edu_ece as v2', 'v2.id', '=', 'v1.ece_id')
            ->join('edu_materia as v3', 'v3.id', '=', 'v1.materia_id')
            ->where('v2.grado_id', $grado)
            ->where('v2.anio', $anio)
            ->where('v2.tipo', $tipo)
            ->orderBy('v1.id', 'asc')
            ->groupBy('v3.descripcion')
            ->get([
                'v3.descripcion as materia',
                DB::raw('sum(evaluados) as evaluados'),
                DB::raw('sum(previo)'),
                DB::raw('sum(inicio)'),
                DB::raw('sum(proceso)'),
                DB::raw('sum(satisfactorio) as satisfactorio'),
            ]);
        return $query;
    }
    public static function listar_indicadoranio($anio, $grado, $tipo, $materia, $order)
    {
        $query = DB::table('edu_eceresultado as v1')
            ->join('edu_ece as v2', 'v2.id', '=', 'v1.ece_id')
            ->join('par_importacion as v3', 'v3.id', '=', 'v2.importacion_id')
            ->where('v2.grado_id', $grado)
            ->where('v2.anio', '<=', $anio)
            ->where('v2.tipo', $tipo)
            ->where('v1.materia_id', $materia)
            ->where('v3.estado', 'PR')
            ->orderBy('v2.anio', $order)
            ->groupBy('v2.anio')
            ->get([
                'v2.anio',
                DB::raw('sum(evaluados) as evaluados'),
                DB::raw('sum(previo) as previo'),
                DB::raw('sum(inicio) as inicio'),
                DB::raw('sum(proceso) as proceso'),
                DB::raw('sum(satisfactorio) as satisfactorio'),
            ]);
        return $query;
    }
    public static function listar_indicadorugel($anio, $grado, $tipo, $materia)
    {
        $query = DB::table('edu_eceresultado as v1')
            ->join('edu_ece as v2', 'v2.id', '=', 'v1.ece_id')
            ->join('edu_institucioneducativa as v3', 'v3.id', '=', 'v1.institucioneducativa_id')
            ->join('edu_ugel as v4', 'v4.id', '=', 'v3.Ugel_id')
            ->join('par_importacion as v5', 'v5.id', '=', 'v2.importacion_id')
            ->where('v2.grado_id', $grado)
            ->where('v2.anio', $anio)
            ->where('v2.tipo', $tipo)
            ->where('v1.materia_id', $materia)
            ->where('v5.estado', 'PR')
            ->orderBy('v4.id', 'asc')
            ->groupBy('v4.nombre')
            ->groupBy('v4.id')
            ->get([
                'v4.id',
                'v4.nombre as ugel',
                DB::raw('sum(evaluados) as evaluados'),
                DB::raw('sum(previo) as previo'),
                DB::raw('sum(inicio) as inicio'),
                DB::raw('sum(proceso) as proceso'),
                DB::raw('sum(satisfactorio) as satisfactorio'),
            ]);
        return $query;
    }
    public static function listar_indicadordistrito($anio, $grado, $tipo, $materia, $provincia, $id = null)
    {
        if ($id) {
            $query = DB::table('edu_eceresultado as v1')
                ->join('edu_ece as v2', 'v2.id', '=', 'v1.ece_id')
                ->join('edu_institucioneducativa as v3', 'v3.id', '=', 'v1.institucioneducativa_id')
                ->join('par_centropoblado as v4', 'v4.id', '=', 'v3.CentroPoblado_id')
                ->join('par_ubigeo as v5', 'v5.id', '=', 'v4.Ubigeo_id')
                ->where('v2.grado_id', $grado)
                ->where('v2.anio', $anio)
                ->where('v2.tipo', $tipo)
                ->where('v1.materia_id', $materia)
                ->where('v5.dependencia', $provincia)
                ->where('v5.id', $id)
                ->groupBy('v5.id')
                ->get([
                    'v5.id',
                    'v5.id as distrito',
                    DB::raw('sum(evaluados) as evaluados'),
                    DB::raw('sum(previo) as previo'),
                    DB::raw('sum(inicio) as inicio'),
                    DB::raw('sum(proceso) as proceso'),
                    DB::raw('sum(satisfactorio) as satisfactorio'),
                ]);
        } else {
            $query = DB::table('edu_eceresultado as v1')
                ->join('edu_ece as v2', 'v2.id', '=', 'v1.ece_id')
                ->join('edu_institucioneducativa as v3', 'v3.id', '=', 'v1.institucioneducativa_id')
                ->join('par_centropoblado as v4', 'v4.id', '=', 'v3.CentroPoblado_id')
                ->join('par_ubigeo as v5', 'v5.id', '=', 'v4.Ubigeo_id')
                ->where('v2.grado_id', $grado)
                ->where('v2.anio', $anio)
                ->where('v2.tipo', $tipo)
                ->where('v1.materia_id', $materia)
                ->where('v5.dependencia', $provincia)
                ->groupBy('v5.id')
                ->get([
                    'v5.id',
                    'v5.id as distrito',
                    DB::raw('sum(evaluados) as evaluados'),
                    DB::raw('sum(previo) as previo'),
                    DB::raw('sum(inicio) as inicio'),
                    DB::raw('sum(proceso) as proceso'),
                    DB::raw('sum(satisfactorio) as satisfactorio'),
                ]);
        }

        //$provs = Ubigeo::where('dependencia', $id)->get();
        foreach ($query as $key => $value) {
            $prov = Ubigeo::find($value->id);
            $value->distrito = $prov->nombre;
        }
        return $query;
    }
    public static function listar_indicadorprovincia($anio, $grado, $tipo, $materia, $dependencia = null)
    {
        if ($dependencia) {
            $query = DB::table('edu_eceresultado as v1')
                ->join('edu_ece as v2', 'v2.id', '=', 'v1.ece_id')
                ->join('edu_institucioneducativa as v3', 'v3.id', '=', 'v1.institucioneducativa_id')
                ->join('par_centropoblado as v4', 'v4.id', '=', 'v3.CentroPoblado_id')
                ->join('par_ubigeo as v5', 'v5.id', '=', 'v4.Ubigeo_id')
                ->where('v2.grado_id', $grado)
                ->where('v2.anio', $anio)
                ->where('v2.tipo', $tipo)
                ->where('v1.materia_id', $materia)
                ->where('v5.dependencia', $dependencia)
                ->groupBy('v5.dependencia')
                ->get([
                    'v5.dependencia as id',
                    'v5.dependencia as provincia',
                    DB::raw('sum(evaluados) as evaluados'),
                    DB::raw('sum(previo) as previo'),
                    DB::raw('sum(inicio) as inicio'),
                    DB::raw('sum(proceso) as proceso'),
                    DB::raw('sum(satisfactorio) as satisfactorio'),
                ]);
        } else {
            $query = DB::table('edu_eceresultado as v1')
                ->join('edu_ece as v2', 'v2.id', '=', 'v1.ece_id')
                ->join('edu_institucioneducativa as v3', 'v3.id', '=', 'v1.institucioneducativa_id')
                ->join('par_centropoblado as v4', 'v4.id', '=', 'v3.CentroPoblado_id')
                ->join('par_ubigeo as v5', 'v5.id', '=', 'v4.Ubigeo_id')
                ->where('v2.grado_id', $grado)
                ->where('v2.anio', $anio)
                ->where('v2.tipo', $tipo)
                ->where('v1.materia_id', $materia)

                ->groupBy('v5.dependencia')
                ->get([
                    'v5.dependencia as id',
                    'v5.dependencia as provincia',
                    DB::raw('sum(evaluados) as evaluados'),
                    DB::raw('sum(previo) as previo'),
                    DB::raw('sum(inicio) as inicio'),
                    DB::raw('sum(proceso) as proceso'),
                    DB::raw('sum(satisfactorio) as satisfactorio'),
                ]);
        }
        //$provs = Ubigeo::where('dependencia', $id)->get();
        foreach ($query as $key => $value) {
            $prov = Ubigeo::find($value->id);
            $value->provincia = $prov->nombre;
        }
        return $query;
    }
    public static function listar_indicadordepartamento($anio, $grado, $tipo, $materia)
    {
        $query = DB::table('edu_eceresultado as v1')
            ->join('edu_ece as v2', 'v2.id', '=', 'v1.ece_id')
            ->join('edu_institucioneducativa as v3', 'v3.id', '=', 'v1.institucioneducativa_id')
            ->join('par_centropoblado as v4', 'v4.id', '=', 'v3.CentroPoblado_id')
            ->join('par_ubigeo as v5', 'v5.id', '=', 'v4.Ubigeo_id')
            ->where('v2.grado_id', $grado)
            ->where('v2.anio', $anio)
            ->where('v2.tipo', $tipo)
            ->where('v1.materia_id', $materia)
            ->get([
                DB::raw('sum(evaluados) as evaluados'),
                DB::raw('sum(previo) as previo'),
                DB::raw('sum(inicio) as inicio'),
                DB::raw('sum(proceso) as proceso'),
                DB::raw('sum(satisfactorio) as satisfactorio'),
            ]);
        return $query;
    }
    public static function listar_importacionsinaprobar1($grado, $tipo)
    {
        $query = DB::table('par_importacion as v1')
            ->join('edu_ece as v2', 'v2.importacion_id', '=', 'v1.id')
            ->where('v2.grado_id', $grado)
            ->where('v2.tipo', $tipo)
            ->where('v1.estado', 'PE')
            ->orderBy('v1.id', 'desc')
            ->select('v1.*')
            ->get();
        return $query;
    }
    public static function listar_gestion1($grado, $tipo)
    {
        $query = DB::table('edu_eceresultado as v1')
            ->join('edu_ece as v2', 'v2.id', '=', 'v1.ece_id')
            ->join('edu_institucioneducativa as v3', 'v3.id', '=', 'v1.institucioneducativa_id')
            ->join('edu_tipogestion as v4', 'v4.id', '=', 'v3.TipoGestion_id')
            ->join('par_importacion as v5', 'v5.id', '=', 'v2.importacion_id')
            ->where('v2.grado_id', $grado)
            ->where('v2.tipo', $tipo)
            ->where('v4.estado', 'AC')
            ->where('v5.estado', 'PR')
            ->select('v4.*')
            ->distinct()
            ->get();
        return $query;
    }
    public static function listar_indicadorGestion($anio, $grado, $tipo, $materia, $gestion = null)
    {
        $query = DB::table('edu_eceresultado as v1')
            ->join('edu_ece as v2', 'v2.id', '=', 'v1.ece_id')
            ->join('edu_institucioneducativa as v3', 'v3.id', '=', 'v1.institucioneducativa_id')
            ->join('edu_tipogestion as v4', 'v4.id', '=', 'v3.TipoGestion_id')
            //->join('par_centropoblado as v4', 'v4.id', '=', 'v3.CentroPoblado_id')
            //->join('par_ubigeo as v5', 'v5.id', '=', 'v4.Ubigeo_id')
            ->where('v1.materia_id', $materia)
            ->where('v2.grado_id', $grado)
            ->where('v2.anio', $anio)
            ->where('v2.tipo', $tipo)
            //->where('v3.TipoGestion_id', $gestion)
            ->groupBy('v4.id')
            ->groupBy('v4.nombre')
            ->get([
                'v4.id',
                'v4.nombre',
                DB::raw('sum(evaluados) as evaluados'),
                DB::raw('sum(previo) as previo'),
                DB::raw('sum(inicio) as inicio'),
                DB::raw('sum(proceso) as proceso'),
                DB::raw('sum(satisfactorio) as satisfactorio'),
            ]);
        return $query;
    }
    public static function listar_indicadorArea($anio, $grado, $tipo, $materia, $area = null)
    {
        $query = DB::table('edu_eceresultado as v1')
            ->join('edu_ece as v2', 'v2.id', '=', 'v1.ece_id')
            ->join('edu_institucioneducativa as v3', 'v3.id', '=', 'v1.institucioneducativa_id')
            ->join('edu_area as v4', 'v4.id', '=', 'v3.Area_id')
            ->where('v1.materia_id', $materia)
            ->where('v2.grado_id', $grado)
            ->where('v2.anio', $anio)
            ->where('v2.tipo', $tipo)
            ->groupBy('v4.id')
            ->groupBy('v4.nombre')
            ->get([
                'v4.id',
                'v4.nombre',
                DB::raw('sum(evaluados) as evaluados'),
                DB::raw('sum(previo) as previo'),
                DB::raw('sum(inicio) as inicio'),
                DB::raw('sum(proceso) as proceso'),
                DB::raw('sum(satisfactorio) as satisfactorio'),
            ]);
        return $query;
    }
    public static function listar_indicadorInstitucion($anio, $grado, $tipo, $materia, $gestion, $area)
    {
        if ($gestion > 0 && $area > 0) {
            $query = DB::table('edu_eceresultado as v1')
                ->join('edu_ece as v2', 'v2.id', '=', 'v1.ece_id')
                ->join('edu_institucioneducativa as v3', 'v3.id', '=', 'v1.institucioneducativa_id')
                ->where('v1.materia_id', $materia)
                ->where('v2.grado_id', $grado)
                ->where('v2.anio', $anio)
                ->where('v2.tipo', $tipo)
                ->where('v3.TipoGestion_id', $gestion)
                ->where('v3.Area_id', $area)
                ->orderBy('v3.nombreInstEduc')
                ->groupBy('v3.id')
                ->groupBy('v3.nombreInstEduc')
                ->get([
                    'v3.id',
                    'v3.nombreInstEduc as nombre',
                    DB::raw('sum(evaluados) as evaluados'),
                    DB::raw('sum(previo) as previo'),
                    DB::raw('sum(inicio) as inicio'),
                    DB::raw('sum(proceso) as proceso'),
                    DB::raw('sum(satisfactorio) as satisfactorio'),
                ]);
        } else if ($gestion > 0 && $area == 0) {
            $query = DB::table('edu_eceresultado as v1')
                ->join('edu_ece as v2', 'v2.id', '=', 'v1.ece_id')
                ->join('edu_institucioneducativa as v3', 'v3.id', '=', 'v1.institucioneducativa_id')
                ->where('v1.materia_id', $materia)
                ->where('v2.grado_id', $grado)
                ->where('v2.anio', $anio)
                ->where('v2.tipo', $tipo)
                ->where('v3.TipoGestion_id', $gestion)
                ->orderBy('v3.nombreInstEduc')
                ->groupBy('v3.id')
                ->groupBy('v3.nombreInstEduc')
                ->get([
                    'v3.id',
                    'v3.nombreInstEduc as nombre',
                    DB::raw('sum(evaluados) as evaluados'),
                    DB::raw('sum(previo) as previo'),
                    DB::raw('sum(inicio) as inicio'),
                    DB::raw('sum(proceso) as proceso'),
                    DB::raw('sum(satisfactorio) as satisfactorio'),
                ]);
        } else if ($gestion == 0 && $area > 0) {
            $query = DB::table('edu_eceresultado as v1')
                ->join('edu_ece as v2', 'v2.id', '=', 'v1.ece_id')
                ->join('edu_institucioneducativa as v3', 'v3.id', '=', 'v1.institucioneducativa_id')
                ->where('v1.materia_id', $materia)
                ->where('v2.grado_id', $grado)
                ->where('v2.anio', $anio)
                ->where('v2.tipo', $tipo)
                ->where('v3.Area_id', $area)
                ->orderBy('v3.nombreInstEduc')
                ->groupBy('v3.id')
                ->groupBy('v3.nombreInstEduc')
                ->get([
                    'v3.id',
                    'v3.nombreInstEduc as nombre',
                    DB::raw('sum(evaluados) as evaluados'),
                    DB::raw('sum(previo) as previo'),
                    DB::raw('sum(inicio) as inicio'),
                    DB::raw('sum(proceso) as proceso'),
                    DB::raw('sum(satisfactorio) as satisfactorio'),
                ]);
        } else {
            $query = DB::table('edu_eceresultado as v1')
                ->join('edu_ece as v2', 'v2.id', '=', 'v1.ece_id')
                ->join('edu_institucioneducativa as v3', 'v3.id', '=', 'v1.institucioneducativa_id')
                ->where('v1.materia_id', $materia)
                ->where('v2.grado_id', $grado)
                ->where('v2.anio', $anio)
                ->where('v2.tipo', $tipo)
                ->orderBy('v3.nombreInstEduc')
                ->groupBy('v3.id')
                ->groupBy('v3.nombreInstEduc')
                ->get([
                    'v3.id',
                    'v3.nombreInstEduc as nombre',
                    DB::raw('sum(evaluados) as evaluados'),
                    DB::raw('sum(previo) as previo'),
                    DB::raw('sum(inicio) as inicio'),
                    DB::raw('sum(proceso) as proceso'),
                    DB::raw('sum(satisfactorio) as satisfactorio'),
                ]);
        }

        return $query;
    }
    public static function listar_indicador1($id)
    {
        $query =  DB::table('par_indicador_resultado as v1')
            ->join('par_ubigeo as v2', 'v2.id', '=', 'v1.ubigeo_id')
            ->join('par_anio as v3', 'v3.id', '=', 'v1.anio_id')
            ->select('v1.resultado', 'v1.nota', 'v2.nombre as departamento', 'v3.anio')
            ->where('v1.indicador_id', $id)->get();
        return $query;
    }
    public static function listar_profesorestitulados($nivel)
    {
        $query =  DB::table('edu_plaza')
            ->where('nivelModalidad_id', $nivel)
            ->groupBy('esTitulado')
            ->orderBy('esTitulado', 'desc')
            ->get([
                'esTitulado as titulado',
                DB::raw('count(esTitulado) as suma')
            ]);
        return $query;
    }
    public static function listar_profesorestituladougel($nivel, $titulado = null)
    {
        if ($titulado) {
            $query = DB::table('edu_plaza as v1')
                ->join('edu_ugel as v2', 'v2.id', '=', 'v1.ugel_id')
                ->where('v1.nivelModalidad_id', $nivel)
                ->where('v1.esTitulado', $titulado)
                ->groupBy('v2.nombre')
                ->groupBy('v2.id')
                ->get([
                    'v2.id',
                    'v2.nombre',
                    'v2.id as total',
                    DB::raw('count(esTitulado) as titulado')
                ]);
        } else {
            $query = DB::table('edu_plaza as v1')
                ->join('edu_ugel as v2', 'v2.id', '=', 'v1.ugel_id')
                ->where('v1.nivelModalidad_id', $nivel)
                ->groupBy('v2.nombre')
                ->get(['v2.nombre', DB::raw('count(esTitulado) as total')]);
        }
        return $query;
    }
    public static function listar_profesorestituladougel2($nivel, $ugel)
    {
        $query = DB::table('edu_plaza as v1')
            ->join('edu_ugel as v2', 'v2.id', '=', 'v1.ugel_id')
            ->where('v1.nivelModalidad_id', $nivel)
            ->where('v2.id', $ugel)
            ->groupBy('v2.nombre')
            ->groupBy('v2.id')
            ->get([
                'v2.id',
                'v2.nombre',
                'v2.id as total',
                DB::raw('count(esTitulado) as total')
            ]);

        return $query;
    }
    public static function cabecera1()
    {
        $cp = DB::table('viv_datass as v1')
            ->get([
                DB::raw('count(id) as centros_poblados'),
                DB::raw('sum(total_poblacion) as poblacion_total'),
                DB::raw('sum(total_viviendas) as total_viviendas'),
            ]);
        $query['centros_poblados'] = $cp[0]->centros_poblados;
        $query['poblacion_total'] = $cp[0]->poblacion_total;
        $query['total_viviendas'] = $cp[0]->total_viviendas;
        $cp = DB::table('viv_datass as v1')->where('tiene_establecimiento_salud', 'SI')
            ->get([DB::raw('count(tiene_establecimiento_salud) as centro_salud')]);
        $query['centro_salud'] = $cp[0]->centro_salud;
        $cp = DB::table('viv_datass as v1')->where('tiene_energia_electrica', 'SI')
            ->get([DB::raw('count(tiene_energia_electrica) as energia_electrica')]);
        $query['energia_electrica'] = $cp[0]->energia_electrica;
        $cp = DB::table('viv_datass as v1')->where('tiene_internet', 'SI')
            ->get([DB::raw('count(tiene_internet) as internet')]);
        $query['internet'] = $cp[0]->internet;
        return $query;
    }
    public static function cabecera2($provincia, $distrito, $indicador_id)
    {
        if ($provincia > 0 && $distrito > 0) {
            $prov = Ubigeo::find($distrito);
            $cp = DB::table('viv_datass as v1')
                ->where('Ubigeo_CP', 'like', $prov->codigo . '%')
                ->get([
                    DB::raw('count(id) as centros_poblados'),
                    DB::raw('sum(total_poblacion) as poblacion_total'),
                    DB::raw('sum(total_viviendas) as total_viviendas'),
                ]);
            $query['centros_poblados'] = $cp[0]->centros_poblados;
            $query['poblacion_total'] = $cp[0]->poblacion_total;
            $query['total_viviendas'] = $cp[0]->total_viviendas;
            $cp = DB::table('viv_datass as v1')
                ->where('tiene_establecimiento_salud', 'SI')
                ->where('Ubigeo_CP', 'like', $prov->codigo . '%')
                ->get([DB::raw('count(tiene_establecimiento_salud) as centro_salud')]);
            $query['centro_salud'] = $cp[0]->centro_salud;
            $cp = DB::table('viv_datass as v1')
                ->where('tiene_energia_electrica', 'SI')
                ->where('Ubigeo_CP', 'like', $prov->codigo . '%')
                ->get([DB::raw('count(tiene_energia_electrica) as energia_electrica')]);
            $query['energia_electrica'] = $cp[0]->energia_electrica;
            $cp = DB::table('viv_datass as v1')
                ->where('tiene_internet', 'SI')
                ->where('Ubigeo_CP', 'like', $prov->codigo . '%')
                ->get([DB::raw('count(tiene_internet) as internet')]);
            $query['internet'] = $cp[0]->internet;
            switch ($indicador_id) {
                case 20:
                    $query['indicador'] = DB::table('viv_datass as v1')
                        ->where('Ubigeo_CP', 'like', $prov->codigo . '%')
                        ->groupBy('sistema_agua')
                        ->get(['sistema_agua as name', DB::raw('count(sistema_agua) as y')]);
                    break;
                case 21:
                    $query['indicador'] = DB::table('viv_datass as v1')
                        ->whereIn('sistema_cloracion', ['SI', 'NO'])
                        ->where('Ubigeo_CP', 'like', $prov->codigo . '%')
                        ->groupBy('sistema_cloracion')->get([
                            'sistema_cloracion as name',
                            DB::raw('count(sistema_cloracion) as y')
                        ]);
                    break;
                case 22:
                    $query['indicador'] =  DB::table('viv_datass as v1')
                        ->where('Ubigeo_CP', 'like', $prov->codigo . '%')
                        ->whereIn('sistema_cloracion', ['SI', 'NO'])
                        ->groupBy('servicio_agua_continuo')
                        ->get([
                            'servicio_agua_continuo as name',
                            DB::raw('count(servicio_agua_continuo) as y')
                        ]);
                    break;
                case 23:
                    $query['indicador'] = DB::table('viv_datass as v1')
                        ->where('Ubigeo_CP', 'like', $prov->codigo . '%')
                        ->groupBy('sistema_disposicion_excretas')
                        ->get([
                            'sistema_disposicion_excretas as name',
                            DB::raw('count(sistema_disposicion_excretas) as y')
                        ]);
                    break;
                case 24:
                    break;
                case 25:
                    break;
                case 26:
                    $query['indicador'] = DB::table('viv_datass as v1')
                        ->where('Ubigeo_CP', 'like', $prov->codigo . '%')
                        ->whereIn('sistema_cloracion', ['SI', 'NO'])
                        ->groupBy('realiza_cloracion_agua')
                        ->get([
                            'realiza_cloracion_agua as name',
                            DB::raw('count(realiza_cloracion_agua) as y')
                        ]);
                    break;

                default:
                    break;
            }
        } else if ($provincia > 0 && $distrito == 0) {
            $prov = Ubigeo::find($provincia);
            $cp = DB::table('viv_datass as v1')
                ->where('Ubigeo_CP', 'like', $prov->codigo . '%')
                ->get([
                    DB::raw('count(id) as centros_poblados'),
                    DB::raw('sum(total_poblacion) as poblacion_total'),
                    DB::raw('sum(total_viviendas) as total_viviendas'),
                ]);
            $query['centros_poblados'] = $cp[0]->centros_poblados;
            $query['poblacion_total'] = $cp[0]->poblacion_total;
            $query['total_viviendas'] = $cp[0]->total_viviendas;
            $cp = DB::table('viv_datass as v1')
                ->where('tiene_establecimiento_salud', 'SI')
                ->where('Ubigeo_CP', 'like', $prov->codigo . '%')
                ->get([DB::raw('count(tiene_establecimiento_salud) as centro_salud')]);
            $query['centro_salud'] = $cp[0]->centro_salud;
            $cp = DB::table('viv_datass as v1')
                ->where('tiene_energia_electrica', 'SI')
                ->where('Ubigeo_CP', 'like', $prov->codigo . '%')
                ->get([DB::raw('count(tiene_energia_electrica) as energia_electrica')]);
            $query['energia_electrica'] = $cp[0]->energia_electrica;
            $cp = DB::table('viv_datass as v1')
                ->where('tiene_internet', 'SI')
                ->where('Ubigeo_CP', 'like', $prov->codigo . '%')
                ->get([DB::raw('count(tiene_internet) as internet')]);
            $query['internet'] = $cp[0]->internet;

            switch ($indicador_id) {
                case 20:
                    $query['indicador'] = DB::table('viv_datass as v1')
                        ->where('Ubigeo_CP', 'like', $prov->codigo . '%')
                        ->groupBy('sistema_agua')
                        ->get(['sistema_agua as name', DB::raw('count(sistema_agua) as y')]);
                    break;
                case 21:
                    $query['indicador'] = DB::table('viv_datass as v1')
                        ->whereIn('sistema_cloracion', ['SI', 'NO'])
                        ->where('Ubigeo_CP', 'like', $prov->codigo . '%')
                        ->groupBy('sistema_cloracion')->get([
                            'sistema_cloracion as name',
                            DB::raw('count(sistema_cloracion) as y')
                        ]);
                    break;
                case 22:
                    $query['indicador'] =  DB::table('viv_datass as v1')
                        ->where('Ubigeo_CP', 'like', $prov->codigo . '%')
                        ->whereIn('sistema_cloracion', ['SI', 'NO'])
                        ->groupBy('servicio_agua_continuo')
                        ->get([
                            'servicio_agua_continuo as name',
                            DB::raw('count(servicio_agua_continuo) as y')
                        ]);
                    break;
                case 23:
                    $query['indicador'] = DB::table('viv_datass as v1')
                        ->where('Ubigeo_CP', 'like', $prov->codigo . '%')
                        ->groupBy('sistema_disposicion_excretas')
                        ->get([
                            'sistema_disposicion_excretas as name',
                            DB::raw('count(sistema_disposicion_excretas) as y')
                        ]);
                    break;
                case 24:
                    break;
                case 25:
                    break;
                case 26:
                    $query['indicador'] = DB::table('viv_datass as v1')
                        ->where('Ubigeo_CP', 'like', $prov->codigo . '%')
                        ->whereIn('sistema_cloracion', ['SI', 'NO'])
                        ->groupBy('realiza_cloracion_agua')
                        ->get([
                            'realiza_cloracion_agua as name',
                            DB::raw('count(realiza_cloracion_agua) as y')
                        ]);
                    break;

                default:
                    break;
            }
        } else {
            $cp = DB::table('viv_datass as v1')
                ->get([
                    DB::raw('count(id) as centros_poblados'),
                    DB::raw('sum(total_poblacion) as poblacion_total'),
                    DB::raw('sum(total_viviendas) as total_viviendas'),
                ]);
            $query['centros_poblados'] = $cp[0]->centros_poblados;
            $query['poblacion_total'] = $cp[0]->poblacion_total;
            $query['total_viviendas'] = $cp[0]->total_viviendas;
            $cp = DB::table('viv_datass as v1')->where('tiene_establecimiento_salud', 'SI')
                ->get([DB::raw('count(tiene_establecimiento_salud) as centro_salud')]);
            $query['centro_salud'] = $cp[0]->centro_salud;
            $cp = DB::table('viv_datass as v1')->where('tiene_energia_electrica', 'SI')
                ->get([DB::raw('count(tiene_energia_electrica) as energia_electrica')]);
            $query['energia_electrica'] = $cp[0]->energia_electrica;
            $cp = DB::table('viv_datass as v1')->where('tiene_internet', 'SI')
                ->get([DB::raw('count(tiene_internet) as internet')]);
            $query['internet'] = $cp[0]->internet;
            switch ($indicador_id) {
                case 20:
                    $query['indicador'] = DB::table('viv_datass as v1')->groupBy('sistema_agua')->get([
                        'sistema_agua as name',
                        DB::raw('count(sistema_agua) as y')
                    ]);
                    break;
                case 21:
                    $query['indicador'] = DB::table('viv_datass as v1')
                        ->whereIn('sistema_cloracion', ['SI', 'NO'])
                        ->groupBy('sistema_cloracion')->get([
                            'sistema_cloracion as name',
                            DB::raw('count(sistema_cloracion) as y')
                        ]);
                    break;
                case 22:
                    $query['indicador'] =  DB::table('viv_datass as v1')
                        ->whereIn('sistema_cloracion', ['SI', 'NO'])
                        ->groupBy('servicio_agua_continuo')
                        ->get([
                            'servicio_agua_continuo as name',
                            DB::raw('count(servicio_agua_continuo) as y')
                        ]);
                    break;
                case 23:
                    $query['indicador'] = DB::table('viv_datass as v1')
                        ->groupBy('sistema_disposicion_excretas')
                        ->get([
                            'sistema_disposicion_excretas as name',
                            DB::raw('count(sistema_disposicion_excretas) as y')
                        ]);
                    break;
                case 24:
                    $query['indicador'] = null;
                    break;
                case 25:
                    $query['indicador'] = null;
                    break;
                case 26:
                    $query['indicador'] = DB::table('viv_datass as v1')
                        ->whereIn('sistema_cloracion', ['SI', 'NO'])
                        ->groupBy('realiza_cloracion_agua')
                        ->get([
                            'realiza_cloracion_agua as name',
                            DB::raw('count(realiza_cloracion_agua) as y')
                        ]);
                    break;

                default:
                    break;
            }
        }

        return $query;
    }
}
