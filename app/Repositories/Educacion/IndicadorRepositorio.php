<?php

namespace App\Repositories\Educacion;

use Illuminate\Support\Facades\DB;

class IndicadorRepositorio
{
    public static function listar_indicador1($id)
    {
        $query =  DB::table('par_indicador_resultado as v1')
        ->join('par_ubigeo as v2', 'v2.id', '=', 'v1.ubigeo_id')
        ->join('par_anio as v3', 'v3.id', '=', 'v1.anio_id')
        ->select('v1.resultado', 'v1.nota', 'v2.nombre as departamento', 'v3.anio')
        ->where('v1.indicador_id', $id)->get();
        return $query;
    }
}
