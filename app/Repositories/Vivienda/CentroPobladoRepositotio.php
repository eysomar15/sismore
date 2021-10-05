<?php

namespace App\Repositories\Vivienda;

use App\Models\Vivienda\Datass;
use Illuminate\Support\Facades\DB;

class CentroPobladoRepositotio
{
    public static function anios()
    { 
        $data = DB::table(
                    DB::raw("(
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
                    DB::raw("(
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
                ->where('cenPob.importacion_id','=', $importacion_id)
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
 
}