<?php

namespace App\Repositories\Educacion;

use App\Models\Educacion\Grado;
use App\Models\Educacion\NivelModalidad;
use Illuminate\Support\Facades\DB;

class EceRepositorio
{
    public static function listar_importaciones()
    {
        $query = DB::table('edu_ece as v1')
            ->join('par_importacion as v2', 'v2.id', '=', 'v1.importacion_id')
            ->join('edu_grado as v3', 'v3.id', '=', 'v1.grado_id')
            ->join('edu_nivelmodalidad as v4', 'v4.id', '=', 'v3.nivelmodalidad_id')
            ->select('v1.id','v1.importacion_id','v1.anio','v1.tipo','v2.fechaActualizacion as fecha','v3.descripcion as grado','v4.nombre as nivel','v2.estado')
            ->orderBy('v1.id','desc')
            ->get();
        return $query;
    }
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
}
