<?php

namespace App\Repositories\Educacion;

use App\Models\Educacion\Ece;
use App\Models\Educacion\Grado;
use App\Models\Educacion\Materia;
use App\Models\Educacion\NivelModalidad;
use App\Models\Ubigeo;
use Illuminate\Support\Facades\DB;

class EceRepositorio
{
    public static function buscar_nivel1()
    {
        $query = NivelModalidad::whereIn('id', ['37', '38'])->get();
        return $query;
    }
    public static function buscar_grado1($grado, $nivel) //no usado todavia
    {
        $query = Grado::where('id', $grado)->where('nivelmodalidad_id', $nivel)->first();
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

    public static function buscar_materia2($anio, $grado, $tipo)
    {
        $query1 = DB::table('edu_ece as v1')
            ->join('par_importacion as v2', 'v2.id', '=', 'v1.importacion_id')
            ->where('v1.grado_id', $grado)
            ->where('v1.tipo', $tipo)
            ->where('v2.estado', 'PR')
            ->get([DB::raw('max(v1.anio) as anio')]);
        
        $query = DB::table('edu_materia as v1')
            ->select('v1.*')
            ->join('edu_eceresultado as v2', 'v2.materia_id', '=', 'v1.id')
            ->join('edu_ece as v3', 'v3.id', '=', 'v2.ece_id')
            ->where('v3.grado_id', $grado)
            ->where('v3.tipo', $tipo)
            ->where('v3.anio','=', $query1[0]->anio)
            ->orderBy('v1.id', 'asc')
            ->distinct()->get();
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
            ->where('v2.grado_id', $grado)
            ->where('v2.anio', $anio)
            ->where('v2.tipo', $tipo)
            ->where('v1.materia_id', $materia)
            ->groupBy('v1.materia_id')
            ->get([
                'v1.materia_id',
                DB::raw('sum(evaluados)'),
                DB::raw('sum(previo)'),
                DB::raw('sum(inicio)'),
                DB::raw('sum(proceso)'),
                DB::raw('sum(satisfactorio)'),
            ]);
        return $query;
    }
    public static function listar_indicadorsatisfactorio($anio, $grado, $tipo)
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
    public static function listar_indicadoranio($anio, $grado, $tipo, $materia)
    {
        $query = DB::table('edu_eceresultado as v1')
            ->join('edu_ece as v2', 'v2.id', '=', 'v1.ece_id')
            ->where('v2.grado_id', $grado)
            ->where('v2.anio', '<=', $anio)
            ->where('v2.tipo', $tipo)
            ->where('v1.materia_id', $materia)
            ->orderBy('v2.anio', 'desc')
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
            ->where('v2.grado_id', $grado)
            ->where('v2.anio', $anio)
            ->where('v2.tipo', $tipo)
            ->where('v1.materia_id', $materia)
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
}
