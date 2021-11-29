<?php

namespace App\Repositories\Vivienda;

use App\Models\Vivienda\CentroPobladoDatass;
use App\Models\Vivienda\Datass;
use Illuminate\Support\Facades\DB;

class CentroPobladoDatassRepositorio
{
    public static function listar_provincia()
    {
        $query = CentroPobladoDatass::select('v3.id', 'v3.nombre')
            ->join('par_ubigeo as v2', 'v2.id', '=', 'viv_centropoblado_datass.ubigeo_id')
            ->join('par_ubigeo as v3', 'v3.id', '=', 'v2.dependencia')
            ->groupBy('v3.id')->groupBy('v3.nombre')
            ->get();
        return $query;
    }

    public static function listar_distrito($provincia)
    {
        $query = CentroPobladoDatass::select('v2.id', 'v2.nombre')
            ->join('par_ubigeo as v2', 'v2.id', '=', 'viv_centropoblado_datass.ubigeo_id')
            ->where('v2.dependencia', $provincia)
            ->groupBy('v2.id')->groupBy('v2.nombre')
            ->get();
        return $query;
    }

    public static function querysPIndicador($importacion_id, $campo, $ubicacion)
    {
        $query = '(select servicio as name,SUM(conteo) as y from (
            select IF(v1.' . $campo . '="SI","SI","NO") as servicio, SUM(v1.total_poblacion) as conteo 
            from `viv_centropoblado_datass` as `v1` 
            inner join `par_ubigeo` as `v2` on `v2`.`id` = `v1`.`ubigeo_id` 
            where `v1`.`importacion_id` = ' . $importacion_id . $ubicacion . ' 
            group by `v1`.`' . $campo . '`
            ) nueva 
            group by servicio 
            order by servicio desc) xxx';
        return $query;
    }

    public static function poblacion_servicio_agua($importacion_id, $provincia, $distrito)
    {
        $ubicacion = '';
        if ($provincia > 0 && $distrito > 0) $ubicacion = ' and v2.id=' . $distrito;
        else if ($provincia > 0 && $distrito == 0) $ubicacion = ' and v2.dependencia=' . $provincia;
        $query = DB::table(DB::raw('(SELECT 
                                    SUM(total_poblacion) as total,
                                    "Poblacion Servicio Agua" AS servicio,
                                    SUM(poblacion_servicio_agua) as conteo,
                                    ROUND(SUM(poblacion_servicio_agua)*100/SUM(total_poblacion),2) as porcentaje 
                                    FROM viv_centropoblado_datass as v1 
                                    INNER JOIN par_ubigeo as v2 ON v2.id=v1.ubigeo_id 
                                    WHERE v1.importacion_id='.$importacion_id.$ubicacion.' 
                                    UNION ALL 
                                    SELECT 
                                    SUM(total_poblacion) as total,
                                    "Poblacion Sin Servicio Agua" AS servicio,
                                    SUM(total_poblacion-poblacion_servicio_agua) as conteo ,
                                    ROUND((SUM(total_poblacion)-SUM(poblacion_servicio_agua))*100/SUM(total_poblacion),2) as porcentaje 
                                    FROM viv_centropoblado_datass as v1 
                                    INNER JOIN par_ubigeo as v2 ON v2.id=v1.ubigeo_id 
                                    WHERE v1.importacion_id='.$importacion_id.$ubicacion.') as datass'))
        ->select(DB::raw('FORMAT(cast(conteo as SIGNED),0) as conteo'),DB::raw('servicio as name'),DB::raw('cast(porcentaje as double) as y'))
            ->get();
        return $query; 
    }

    public static function poblacion_disposicion_excretas($importacion_id, $provincia, $distrito)
    {
        $ubicacion = '';
        if ($provincia > 0 && $distrito > 0) $ubicacion = ' and v2.id=' . $distrito;
        else if ($provincia > 0 && $distrito == 0) $ubicacion = ' and v2.dependencia=' . $provincia;
        $query = DB::table(DB::raw('(SELECT 
                                    SUM(total_poblacion) as total,
                                    "Poblacion Servicio Agua" AS servicio,
                                    SUM(poblacion_servicio_agua) as conteo,
                                    ROUND(SUM(poblacion_servicio_agua)*100/SUM(total_poblacion),2) as porcentaje 
                                    FROM viv_centropoblado_datass as v1 
                                    INNER JOIN par_ubigeo as v2 ON v2.id=v1.ubigeo_id 
                                    WHERE v1.importacion_id='.$importacion_id.$ubicacion.' 
                                    UNION ALL 
                                    SELECT 
                                    SUM(total_poblacion) as total,
                                    "Poblacion Sin Servicio Agua" AS servicio,
                                    SUM(total_poblacion-poblacion_servicio_agua) as conteo ,
                                    ROUND((SUM(total_poblacion)-SUM(poblacion_servicio_agua))*100/SUM(total_poblacion),2) as porcentaje 
                                    FROM viv_centropoblado_datass as v1 
                                    INNER JOIN par_ubigeo as v2 ON v2.id=v1.ubigeo_id 
                                    WHERE v1.importacion_id='.$importacion_id.$ubicacion.') as datass'))
        ->select(DB::raw('FORMAT(cast(conteo as SIGNED),0) as conteo'),DB::raw('servicio as name'),DB::raw('cast(porcentaje as double) as y'))
            ->get();
        return $query; 
    }
    public static function viviendas_servicio_agua($importacion_id, $provincia, $distrito)
    {
        $ubicacion = '';
        if ($provincia > 0 && $distrito > 0) $ubicacion = ' and v2.id=' . $distrito;
        else if ($provincia > 0 && $distrito == 0) $ubicacion = ' and v2.dependencia=' . $provincia;
        $query = DB::table(DB::raw('(SELECT 
                                    SUM(viviendas_habitadas) as total,
                                    "Poblacion Servicio Agua" AS servicio,
                                    SUM(viviendas_conexion) as conteo,
                                    ROUND(SUM(viviendas_conexion)*100/SUM(viviendas_habitadas),2) as porcentaje 
                                    FROM viv_centropoblado_datass as v1 
                                    INNER JOIN par_ubigeo as v2 ON v2.id=v1.ubigeo_id 
                                    WHERE v1.importacion_id='.$importacion_id.$ubicacion.' 
                                    UNION ALL 
                                    SELECT 
                                    SUM(viviendas_habitadas) as total,
                                    "Poblacion Sin Servicio Agua" AS servicio,
                                    SUM(viviendas_habitadas-viviendas_conexion) as conteo ,
                                    ROUND((SUM(viviendas_habitadas)-SUM(viviendas_conexion))*100/SUM(viviendas_habitadas),2) as porcentaje 
                                    FROM viv_centropoblado_datass as v1 
                                    INNER JOIN par_ubigeo as v2 ON v2.id=v1.ubigeo_id 
                                    WHERE v1.importacion_id='.$importacion_id.$ubicacion.') as datass'))
        ->select(DB::raw('FORMAT(cast(conteo as SIGNED),0) as conteo'),DB::raw('servicio as name'),DB::raw('cast(porcentaje as double) as y'))
            ->get();
        return $query; 
    }
}
