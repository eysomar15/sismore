<?php

namespace App\Repositories\Vivienda;

use App\Models\Vivienda\Emapacopsa;
use Illuminate\Support\Facades\DB;

class EmapacopsaRepositorio
{
    public static function ListarSINO_porIndicador($provincia, $distrito, $indicador_id, $importacion_id)
    {
        switch ($indicador_id) {
            case 24:
                /*$query['indicador'] = DB::table('viv_emapacopsa as v1')
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
        $query['indicador'] = $query['indicador']->get();//*/
                $estadoconexion = '';
                $ubicacion = '';
                //if ($estado_conexion_id != 0) $estadoconexion = ' and v1.estado_conexion_id=' . $estado_conexion_id;
                if ($provincia > 0 && $distrito > 0) $ubicacion = ' and v6.id=' . $distrito;
                else if ($provincia > 0 && $distrito == 0) $ubicacion = ' and v6.dependencia=' . $provincia;

                $query['indicador'] = DB::table(DB::raw('(select IF(v2.nombre="DESAGUE","SIN AGUA","CON AGUA") AS servicio,count(v1.id) as conteo  from `viv_emapacopsa` as `v1` 
        inner join `viv_tipo_servicio` as `v2` on `v2`.`id` = `v1`.`tipo_servicio_id` 
        inner join `viv_estado_conexion` as `v3` on `v3`.`id` = `v1`.`estado_conexion_id` 
        inner join `viv_manzana` as `v4` on `v4`.`id` = `v1`.`manzana_id` 
        inner join `viv_sector` as `v5` on `v5`.`id` = `v4`.`sector_id` 
        inner join `par_ubigeo` as `v6` on `v6`.`id` = `v5`.`ubigeo_id`  
        where 1 and v1.importacion_id=' . $importacion_id  . $ubicacion . '
        group by `v2`.`nombre`) as xx'))
                    ->select(DB::raw('xx.servicio as name'), DB::raw('cast(SUM(xx.conteo) as SIGNED) as y'))
                    ->groupBy('xx.servicio')
                    ->get();
                $query['categoriaconagua'] = DB::table(DB::raw('(select v7.nombre as categoria, count(v1.id) as "con_agua",cast(SUM(v1.unid_uso) as SIGNED) as "unid_uso"
                from `viv_emapacopsa` as `v1` 
                inner join `viv_tipo_servicio` as `v2` on `v2`.`id` = `v1`.`tipo_servicio_id`         
                inner join `viv_estado_conexion` as `v3` on `v3`.`id` = `v1`.`estado_conexion_id`   
                inner join `viv_manzana` as `v4` on `v4`.`id` = `v1`.`manzana_id`  
                inner join `viv_sector` as `v5` on `v5`.`id` = `v4`.`sector_id` 
                inner join `par_ubigeo` as `v6` on `v6`.`id` = `v5`.`ubigeo_id` 
                inner join `viv_sub_categoria` as `v7` on `v7`.`id` = `v1`.`sub_categoria_id`    
                WHERE `v1`.`importacion_id`=' . $importacion_id . ' and `v1`.`tipo_servicio_id` in(1,2) 
                group by `v7`.`nombre`) as xx'))->get();

                $query['categoriasinagua'] = DB::table(DB::raw('(select v7.nombre as categoria, count(v1.id) as "sin_agua",cast(SUM(v1.unid_uso) as SIGNED) as "unid_uso"
                from `viv_emapacopsa` as `v1` 
                inner join `viv_tipo_servicio` as `v2` on `v2`.`id` = `v1`.`tipo_servicio_id`         
                inner join `viv_estado_conexion` as `v3` on `v3`.`id` = `v1`.`estado_conexion_id`   
                inner join `viv_manzana` as `v4` on `v4`.`id` = `v1`.`manzana_id`  
                inner join `viv_sector` as `v5` on `v5`.`id` = `v4`.`sector_id` 
                inner join `par_ubigeo` as `v6` on `v6`.`id` = `v5`.`ubigeo_id` 
                inner join `viv_sub_categoria` as `v7` on `v7`.`id` = `v1`.`sub_categoria_id`    
                WHERE `v1`.`importacion_id`=' . $importacion_id . ' and `v1`.`tipo_servicio_id` in(3)
                group by `v7`.`nombre`) as xx'))->get();
                return $query;
            case 25:
                $estadoconexion = '';
                $ubicacion = '';
                //if ($estado_conexion_id != 0) $estadoconexion = ' and v1.estado_conexion_id=' . $estado_conexion_id;
                if ($provincia > 0 && $distrito > 0) $ubicacion = ' and v6.id=' . $distrito;
                else if ($provincia > 0 && $distrito == 0) $ubicacion = ' and v6.dependencia=' . $provincia;

                $query['indicador'] = DB::table(DB::raw('(select IF(v2.nombre="AGUA","SIN DESAGUE","CON DESAGUE") AS servicio,count(v1.id) as conteo  from `viv_emapacopsa` as `v1` 
        inner join `viv_tipo_servicio` as `v2` on `v2`.`id` = `v1`.`tipo_servicio_id` 
        inner join `viv_estado_conexion` as `v3` on `v3`.`id` = `v1`.`estado_conexion_id` 
        inner join `viv_manzana` as `v4` on `v4`.`id` = `v1`.`manzana_id` 
        inner join `viv_sector` as `v5` on `v5`.`id` = `v4`.`sector_id` 
        inner join `par_ubigeo` as `v6` on `v6`.`id` = `v5`.`ubigeo_id`  
        where 1 and v1.importacion_id=' . $importacion_id  . $ubicacion . '
        group by `v2`.`nombre`) as xx'))
                    ->select(DB::raw('xx.servicio as name'), DB::raw('cast(SUM(xx.conteo) as SIGNED) as y'))
                    ->groupBy('xx.servicio')
                    //->orderBy('xx.servicio','desc')
                    ->get();
                $query['categoriaconagua'] = DB::table(DB::raw('(select v7.nombre as categoria, count(v1.id) as "con_agua",cast(SUM(v1.unid_uso) as SIGNED) as "unid_uso"
                from `viv_emapacopsa` as `v1` 
                inner join `viv_tipo_servicio` as `v2` on `v2`.`id` = `v1`.`tipo_servicio_id`         
                inner join `viv_estado_conexion` as `v3` on `v3`.`id` = `v1`.`estado_conexion_id`   
                inner join `viv_manzana` as `v4` on `v4`.`id` = `v1`.`manzana_id`  
                inner join `viv_sector` as `v5` on `v5`.`id` = `v4`.`sector_id` 
                inner join `par_ubigeo` as `v6` on `v6`.`id` = `v5`.`ubigeo_id` 
                inner join `viv_sub_categoria` as `v7` on `v7`.`id` = `v1`.`sub_categoria_id`    
                WHERE `v1`.`importacion_id`=' . $importacion_id . ' and `v1`.`tipo_servicio_id` in(2,3) 
                group by `v7`.`nombre`) as xx'))->get();

                $query['categoriasinagua'] = DB::table(DB::raw('(select v7.nombre as categoria, count(v1.id) as "sin_agua",cast(SUM(v1.unid_uso) as SIGNED) as "unid_uso"
                from `viv_emapacopsa` as `v1` 
                inner join `viv_tipo_servicio` as `v2` on `v2`.`id` = `v1`.`tipo_servicio_id`         
                inner join `viv_estado_conexion` as `v3` on `v3`.`id` = `v1`.`estado_conexion_id`   
                inner join `viv_manzana` as `v4` on `v4`.`id` = `v1`.`manzana_id`  
                inner join `viv_sector` as `v5` on `v5`.`id` = `v4`.`sector_id` 
                inner join `par_ubigeo` as `v6` on `v6`.`id` = `v5`.`ubigeo_id` 
                inner join `viv_sub_categoria` as `v7` on `v7`.`id` = `v1`.`sub_categoria_id`    
                WHERE `v1`.`importacion_id`=' . $importacion_id . ' and `v1`.`tipo_servicio_id` in(1)
                group by `v7`.`nombre`) as xx'))->get();
                return $query;

            default:
                return null;
        }
    }
}
