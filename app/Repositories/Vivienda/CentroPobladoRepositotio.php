<?php

namespace App\Repositories\Vivienda;

use App\Models\Vivienda\Datass;
use Illuminate\Support\Facades\DB;

class CentroPobladoRepositotio
{
    public static $servicios = [
        20 => 'sistema_agua',
        21 => 'sistema_cloracion',
        22 => 'servicio_agua_continuo',
        23 => 'sistema_disposicion_excretas',
        26 => 'realiza_cloracion_agua'
    ];

    public static function anios()
    {
        $data = DB::table(
            DB::raw(
                "(
                                select distinct anio.id,anio.anio from viv_centropoblado_datass cenPo
                                inner join par_importacion imp on cenPo.importacion_id = imp.id
                                inner join par_anio anio on year(imp.fechaActualizacion) = anio.anio
                                where imp.estado = 'PR'   
                                order by anio.anio desc
                        ) as datos"
            )
        )
            ->get();

        return $data;
    }

    public static function fechasPor_anio($anio_id)
    {
        $data = DB::table(
            DB::raw(
                "(
                                select distinct imp.id,fechaActualizacion from viv_centropoblado_datass cenPo
                                inner join par_importacion imp on cenPo.importacion_id = imp.id
                                inner join par_anio anio on year(imp.fechaActualizacion) = anio.anio
                                where imp.estado = 'PR' and anio.id = $anio_id
                                order by fechaActualizacion desc
                        ) as datos"
            )
        )
            ->get();

        return $data;
    }

    public static function listaPor_Provincia_Distrito($importacion_id)
    {
        $data = DB::table('viv_centropoblado_datass as cenPob')
            ->join('par_ubigeo as dist', 'cenPob.ubigeo_id', '=', 'dist.id')
            ->join('par_ubigeo as prov', 'dist.dependencia', '=', 'prov.id')
            ->where('cenPob.importacion_id', '=', $importacion_id)
            ->orderBy('prov.codigo', 'asc')
            ->orderBy('dist.codigo', 'asc')
            ->groupBy('prov.nombre')
            ->groupBy('dist.nombre')
            ->get([
                DB::raw('prov.nombre as provincia'),
                DB::raw('dist.nombre as distrito'),
                DB::raw('count(*) as total_cenPob'),
                DB::raw('sum(total_viviendas) as total_viviendas'),
                DB::raw('sum(case when tiene_energia_electrica="SI" then 1 else 0 end) as  tiene_energia_electrica'),
                DB::raw('sum(case when tiene_establecimiento_salud="SI" then 1 else 0 end) as  tiene_establecimiento_salud'),
                DB::raw('sum(case when sistema_agua="SI" then 1 else 0 end) as  sistema_agua'),
                DB::raw('sum(case when sistema_disposicion_excretas="SI" then 1 else 0 end) as  sistema_disposicion_excretas'),
                DB::raw('sum(case when sistema_cloracion = "SI" then 1 else 0 end) as  sistema_cloracion')
            ]);

        return $data;
    }
    public static function ListarSINO_porIndicador($provincia, $distrito, $indicador_id, $importacion_id)
    {
        $ubicacion = '';
        if ($provincia > 0 && $distrito > 0) $ubicacion = ' and v2.id=' . $distrito;
        else if ($provincia > 0 && $distrito == 0) $ubicacion = ' and v2.dependencia=' . $provincia;
        switch ($indicador_id) {
            case 20: //1
                $query['indicador'] = DB::table(DB::raw(
                    '(select IF(v1.sistema_agua="SI","SI","NO") as servicio, count(v1.id) as conteo 
                    from `viv_centropoblado_datass` as `v1` 
                    inner join `par_ubigeo` as `v2` on `v2`.`id` = `v1`.`ubigeo_id` 
                    where `v1`.`importacion_id` = ' . $importacion_id . $ubicacion . ' 
                    group by `v1`.`sistema_agua`) as xx'
                ))
                    ->select(DB::raw('xx.servicio as name'), DB::raw('cast(SUM(xx.conteo) as SIGNED) as y'))
                    ->groupBy('xx.servicio')
                    ->orderBy('xx.servicio', 'desc')
                    ->get();
                break;
            case 21: //2
                $query['indicador'] = DB::table(DB::raw(
                    '(select IF(v1.sistema_cloracion="SI","SI","NO") as servicio, count(v1.id) as conteo 
                    from `viv_centropoblado_datass` as `v1` 
                    inner join `par_ubigeo` as `v2` on `v2`.`id` = `v1`.`ubigeo_id` 
                    where `v1`.`importacion_id` = ' . $importacion_id . $ubicacion . ' 
                    group by `v1`.`sistema_cloracion`) as xx'
                ))
                    ->select(DB::raw('xx.servicio as name'), DB::raw('cast(SUM(xx.conteo) as SIGNED) as y'))
                    ->groupBy('xx.servicio')
                    ->orderBy('xx.servicio', 'desc')
                    ->get();
                break;
            case 22: //3
                $query['indicador'] = DB::table(DB::raw(
                    '(select IF(v1.servicio_agua_continuo="SI","SI","NO") as servicio, cast(SUM(v1.total_viviendas)as SIGNED) as conteo 
                from `viv_centropoblado_datass` as `v1` 
                inner join `par_ubigeo` as `v2` on `v2`.`id` = `v1`.`ubigeo_id` 
                where `v1`.`importacion_id` = ' . $importacion_id . $ubicacion . ' 
                group by `v1`.`servicio_agua_continuo`) as xx'
                ))
                    ->select(DB::raw('xx.servicio as name'), DB::raw('cast(SUM(xx.conteo) as SIGNED) as y'))
                    ->groupBy('xx.servicio')
                    ->orderBy('xx.servicio', 'desc')
                    ->get();
                break;
            case 23: //4
                $query['indicador'] = DB::table(DB::raw(
                    '(select IF(v1.sistema_disposicion_excretas="SI","SI","NO") as servicio, cast(SUM(v1.total_viviendas)as SIGNED) as conteo 
                from `viv_centropoblado_datass` as `v1` 
                inner join `par_ubigeo` as `v2` on `v2`.`id` = `v1`.`ubigeo_id` 
                where `v1`.`importacion_id` = ' . $importacion_id . $ubicacion . ' 
                group by `v1`.`sistema_disposicion_excretas`) as xx'
                ))
                    ->select(DB::raw('xx.servicio as name'), DB::raw('cast(SUM(xx.conteo) as SIGNED) as y'))
                    ->groupBy('xx.servicio')
                    ->orderBy('xx.servicio', 'desc')
                    ->get();
                break;
            case 24:
                break;
            case 25:
                break;
            case 26: //5
                $query['indicador'] = DB::table(DB::raw(
                    '(select IF(v1.realiza_cloracion_agua="SI","SI","NO") as servicio, cast(SUM(v1.total_viviendas)as SIGNED) as conteo 
                from `viv_centropoblado_datass` as `v1` 
                inner join `par_ubigeo` as `v2` on `v2`.`id` = `v1`.`ubigeo_id` 
                where `v1`.`importacion_id` = ' . $importacion_id . $ubicacion . ' 
                group by `v1`.`realiza_cloracion_agua`) as xx'
                ))
                    ->select(DB::raw('xx.servicio as name'), DB::raw('cast(SUM(xx.conteo) as SIGNED) as y'))
                    ->groupBy('xx.servicio')
                    ->orderBy('xx.servicio', 'desc')
                    ->get();
                break;

            default:
                break;
        }
        return $query;
    }
    /**
    public static function ListarSINO_porIndicador($provincia, $distrito, $indicador_id, $importacion_id)
    {
        switch ($indicador_id) {
            case 20://1
                $queryx =  DB::table('viv_centropoblado_datass as v1')
                    ->join('par_ubigeo as v2', 'v2.id', '=', 'v1.ubigeo_id')
                    ->where('v1.importacion_id', $importacion_id)
                    ->groupBy('v1.sistema_agua')
                    ->select(DB::raw('v1.sistema_agua as name'), DB::raw('count(v1.id) as y'));
                if ($provincia > 0 && $distrito > 0) $queryx = $queryx->where('v2.id', $distrito);
                else if ($provincia > 0 && $distrito == 0) $queryx = $queryx->where('v2.dependencia', $provincia);
                $queryx = $queryx->get();
                break;
            case 21://2
                $queryx =  DB::table('viv_centropoblado_datass as v1')
                    ->join('par_ubigeo as v2', 'v2.id', '=', 'v1.ubigeo_id')
                    ->where('v1.importacion_id', $importacion_id)
                    ->groupBy('v1.sistema_cloracion')
                    ->select(DB::raw('v1.sistema_cloracion as name'), DB::raw('count(v1.id) as y'));
                if ($provincia > 0 && $distrito > 0) $queryx = $queryx->where('v2.id', $distrito);
                else if ($provincia > 0 && $distrito == 0) $queryx = $queryx->where('v2.dependencia', $provincia);
                $queryx = $queryx->get();
                break;
            case 22://3
                $queryx =   DB::table('viv_centropoblado_datassc as v1')
                    ->join('par_ubigeo as v2', 'v2.id', '=', 'v1.ubigeo_id')
                    ->where('v1.importacion_id', $importacion_id)
                    ->groupBy('v1.servicio_agua_continuo')
                    ->select(DB::raw('v1.servicio_agua_continuo as name'), DB::raw('cast(SUM(v1.total_viviendas)as SIGNED) as y'));
                if ($provincia > 0 && $distrito > 0) $queryx = $queryx->where('v2.id', $distrito);
                else if ($provincia > 0 && $distrito == 0) $queryx = $queryx->where('v2.dependencia', $provincia);
                $queryx = $queryx->get();
                break;
            case 23://4
                $queryx =  DB::table('viv_centropoblado_datass as v1')
                    ->join('par_ubigeo as v2', 'v2.id', '=', 'v1.ubigeo_id')
                    ->where('v1.importacion_id', $importacion_id)
                    ->groupBy('v1.sistema_disposicion_excretas')
                    ->select(DB::raw('v1.sistema_disposicion_excretas as name'), DB::raw('cast(SUM(v1.total_viviendas)as SIGNED) as y'));
                if ($provincia > 0 && $distrito > 0) $queryx = $queryx->where('v2.id', $distrito);
                else if ($provincia > 0 && $distrito == 0) $queryx = $queryx->where('v2.dependencia', $provincia);
                $queryx = $queryx->get();
                break;
            case 24:
                break;
            case 25:
                break;
            case 26://5
                $queryx =  DB::table('viv_centropoblado_datass as v1')
                    ->join('par_ubigeo as v2', 'v2.id', '=', 'v1.ubigeo_id')
                    ->where('v1.importacion_id', $importacion_id)
                    ->groupBy('v1.realiza_cloracion_agua')
                    ->select(DB::raw('v1.realiza_cloracion_agua as name'), DB::raw('cast(SUM(v1.total_viviendas)as SIGNED) as y'));
                if ($provincia > 0 && $distrito > 0) $queryx = $queryx->where('v2.id', $distrito);
                else if ($provincia > 0 && $distrito == 0) $queryx = $queryx->where('v2.dependencia', $provincia);
                $queryx = $queryx->get();
                break;

            default:
                break;
        }
        $coor = [['name' => 'SI', 'y' => 0], ['name' => 'NO', 'y' => 0]];
        foreach ($queryx as $item) {
            if ($item->name == 'SI') $coor[0]['y'] += $item->y;
            else $coor[1]['y'] += $item->y;
        }
        $query['indicador'] = $queryx;

        return $query;
    }    
     */
    public static function listar_porProvinciaDistrito($provincia, $distrito, $importacion_id, $indicador_id)
    {
        $buscar = CentroPobladoRepositotio::$servicios[$indicador_id];
        $query = DB::table('viv_centropoblado_datass as v1')
            ->select('v1.id', 'v1.nombre as cp', 'v1.total_poblacion', 'v3.nombre as provincia', 'v2.nombre as distrito', DB::raw('if(' . $buscar . '="SI",' . $buscar . ',"NO") as servicio'))
            ->join('par_ubigeo as v2', 'v2.id', '=', 'v1.ubigeo_id')
            ->join('par_ubigeo as v3', 'v3.id', '=', 'v2.dependencia')
            ->where('v1.importacion_id', $importacion_id);
        if ($provincia > 0 && $distrito > 0) {
            $query = $query->where('v2.id', $distrito);
        } else if ($provincia > 0 && $distrito == 0) {
            $query = $query->where('v3.id', $provincia);
        } else {
        }
        $query = $query->orderBy('v3.nombre')->orderBy('v2.nombre')->orderBy('v1.nombre');
        $query = $query->get();
        return $query;
    }
}
