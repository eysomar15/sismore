<?php

namespace App\Repositories\Educacion;

use App\Models\Educacion\Plaza;
use Illuminate\Support\Facades\DB;

class PlazaRepositorio
{
    public static function listar_provincia()
    {
        $query = Plaza::select('v3.id', 'v3.nombre')
            ->join('par_ubigeo as v2', 'v2.id', '=', 'edu_plaza.ubigeo_id')
            ->join('par_ubigeo as v3', 'v3.id', '=', 'v2.dependencia')
            ->groupBy('v3.id')->groupBy('v3.nombre')
            ->get();
        return $query;
    }
    public static function listar_distrito($provincia)
    {
        $query = Plaza::select('v2.id', 'v2.nombre')
            ->join('par_ubigeo as v2', 'v2.id', '=', 'edu_plaza.ubigeo_id')
            /*->join('par_ubigeo as v3', 'v3.id', '=', 'v2.dependencia')*/
            ->where('v2.dependencia', $provincia)
            ->groupBy('v2.id')->groupBy('v2.nombre')
            ->get();
        return $query;
    }

    public static function listar_profesorestitulados($importacion_id, $nivel, $provincia, $distrito)
    {
        $nivelxx = $nivel == 31 ? '1,31,30' : '' . $nivel;
        $ubicacion = '';
        if ($provincia > 0 && $distrito > 0) $ubicacion = ' and v4.id=' . $distrito;
        else if ($provincia > 0 && $distrito == 0) $ubicacion = ' and v4.dependencia=' . $provincia;
        $query =  DB::table(DB::raw('(select if(v1.esTitulado=1,"SI","NO") as titulado,count(v1.esTitulado) as conteo from edu_plaza as v1
        inner join par_importacion as v2 on v2.id=v1.importacion_id 
        inner join edu_tipotrabajador as v3 on v3.id=v1.tipoTrabajador_id 
        inner join par_ubigeo as v4 on v4.id=v1.ubigeo_id 
        where tipoTrabajador_id in (13,6) and v1.situacion="AC" and v1.importacion_id=' . $importacion_id . ' and v1.nivelModalidad_id in (' . $nivelxx . ')' . $ubicacion . ' 
        group by v1.esTitulado) as tb'))
            ->select('titulado as name', 'conteo as y')
            ->orderBy('titulado','desc')
            ->get();

        /* $query =  DB::table('edu_plaza')
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
        } */
        return $query;
    }
    public static function listar_profesorestituladougel($nivel, $titulado = null)
    {
        $nivelxx = $nivel == 31 ? '1,31,30' : '' . $nivel;
        $query = DB::table(DB::raw('(select v5.nombre as ugel,count(v5.nombre) as conteo from edu_plaza as v1
        inner join par_importacion as v2 on v2.id=v1.importacion_id 
        inner join edu_tipotrabajador as v3 on v3.id=v1.tipoTrabajador_id 
        inner join par_ubigeo as v4 on v4.id=v1.ubigeo_id 
        inner join edu_ugel as v5 on v5.id=v1.ugel_id 
        where tipoTrabajador_id in (13,6) and v1.situacion="AC" and v1.esTitulado=' . $titulado . ' and 
              v1.importacion_id=337 and v1.nivelModalidad_id in (' . $nivelxx . ')
        group by v5.nombre) as tb'))
            ->select('ugel as name', 'conteo as y')
            ->get();
        /*if ($titulado) {
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
        }*/
        return $query;
    }
    /* public static function listar_profesorestituladougel2($nivel, $ugel)
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
    } */
}
