<?php

namespace App\Repositories\Educacion;

use Illuminate\Support\Facades\DB;

class PlazaRepositorio
{ 
    public static function listar_profesorestitulados($nivel)
    {
        $query =  DB::table('edu_plaza')
            ->where('nivelModalidad_id', $nivel)
            ->where('tipoTrabajador_id', 13)
            ->groupBy('esTitulado')
            ->orderBy('esTitulado', 'desc')
            ->get([
                'esTitulado as name',
                DB::raw('(select count(esTitulado) from `edu_plaza` where `nivelModalidad_id` = ' . $nivel . ') as total'),
                DB::raw('count(esTitulado) as y')
            ]);
        foreach ($query as $key => $item) {
            $item->name = ($item->name == '0' ? 'NO' : 'SI');
        }
        return $query;
    }
    public static function listar_profesorestituladougel($nivel, $titulado = null)
    {
        if ($titulado) {
            $query = DB::table('edu_plaza as v1')
                ->join('edu_ugel as v2', 'v2.id', '=', 'v1.ugel_id')
                ->where('v1.nivelModalidad_id', $nivel)
                ->where('v1.esTitulado', $titulado)
                ->where('v1.tipoTrabajador_id', 13)
                ->groupBy('v2.nombre')
                ->groupBy('v2.id')
                ->get([
                    'v2.id',
                    'v2.nombre as name',
                    'v2.id as total',
                    DB::raw('count(v1.esTitulado) as si'),
                    DB::raw('count(v1.esTitulado) as y')
                ]);
            foreach ($query as $value) {
                $indutt = PlazaRepositorio::listar_profesorestituladougel2($nivel, $value->id);
                $value->total = $indutt->first()->total;
                $value->name = str_replace('UGEL', '', $value->name);
                $value->y = round(100 * $value->y / $value->total, 2);
            }
        } else {
            $query = DB::table('edu_plaza as v1')
                ->join('edu_ugel as v2', 'v2.id', '=', 'v1.ugel_id')
                ->where('v1.nivelModalidad_id', $nivel)
                ->where('v1.tipoTrabajador_id', 13)
                ->groupBy('v2.nombre')
                ->get(['v2.nombre as name', DB::raw('count(esTitulado) as y')]);
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
}
