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
                ->get([
                    'v2.nombre',
                    'v2.nombre as total',
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
}
