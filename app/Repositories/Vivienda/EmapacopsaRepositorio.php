<?php

namespace App\Repositories\Vivienda;

use App\Models\Vivienda\Emapacopsa;
use Illuminate\Support\Facades\DB;

class EmapacopsaRepositorio
{
    public static function ListarSINO_porIndicador($provincia, $distrito, $importacion_id, $estado_conexion_id, $indicador_id)
    {
        $query['indicador'] = DB::table('viv_emapacopsa as v1')
            ->join('viv_tipo_servicio as v2', 'v2.id', '=', 'v1.tipo_servicio_id')
            ->join('viv_estado_conexion as v3', 'v3.id', '=', 'v1.estado_conexion_id')
            ->join('viv_manzana as v4', 'v4.id', '=', 'v1.manzana_id')
            ->join('viv_sector as v5', 'v5.id', '=', 'v4.sector_id')
            ->join('par_ubigeo as v6', 'v6.id', '=', 'v5.ubigeo_id')
            ->groupBy('v2.nombre')
            ->select(DB::raw('v2.nombre as name'), DB::raw('count(v1.id) as y'));

        if ($estado_conexion_id != 0)
            $query['indicador'] = $query['indicador']->where('v1.estado_conexion_id', $estado_conexion_id);

        if ($provincia > 0 && $distrito > 0) {
            $query['indicador'] = $query['indicador']->where('v6.id', $distrito);
        } else if ($provincia > 0 && $distrito == 0) {
            $query['indicador'] = $query['indicador']->where('v6.dependencia', $provincia);
        }
        $query['indicador'] = $query['indicador']->get();
        return $query;
    }
}
