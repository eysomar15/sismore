<?php

namespace App\Repositories\Educacion;

use App\Models\Educacion\Ece;
use App\Models\Educacion\Grado;
use App\Models\Educacion\NivelModalidad;
use App\Models\Ubigeo;
use Illuminate\Support\Facades\DB;

class EceRepositorio
{
    public static function buscar_nivel1()
    {
        $query = NivelModalidad::all();
        return $query;
    }
    public static function buscar_grado1($grado, $nivel)
    {
        $query = DB::table('edu_grado as v1')->select('v1.*', 'v2.nombre')
            ->join('edu_nivelmodalidad as v2', 'v2.id', '=', 'v1.nivelmodalidad_id')
            ->where('v1.descripcion', $grado)
            ->where('v2.nombre', $nivel)->first();
        return $query;
    }
    public static function buscar_grados1($nivel)
    {
        $query = Grado::where('nivelmodalidad_id', $nivel)->get();
        return $query;
    }
    public static function buscar_materia1($grado, $tipo)
    {
        $query = DB::table('edu_materia as v1')
            ->select('v1.*')
            ->join('edu_eceresultado as v2', 'v2.materia_id', '=', 'v1.id')
            ->join('edu_ece as v3', 'v3.id', '=', 'v2.ece_id')
            ->where('v3.grado_id', $grado)
            ->where('v3.tipo', $tipo)
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
            ->where('v1.importacion_id',$importacion_id)
            ->select('v1.*','v2.descripcion as grado','v3.nombre as nivel')
            ->first();
        return $query;
    }
    public static function listar_eceresultado1($ece)
    {
        $query = DB::table('edu_eceresultado as v1')
            ->join('edu_institucioneducativa as v2', 'v2.id', '=', 'v1.institucioneducativa_id')
            ->join('edu_materia as v3', 'v3.id', '=', 'v1.materia_id')
            ->where('v1.ece_id',$ece)
            ->select('v1.*','v2.codModular as codigo_modular','v3.descripcion as materia')
            ->get();
        return $query;
    }
}
