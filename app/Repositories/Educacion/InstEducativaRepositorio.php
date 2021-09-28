<?php

namespace App\Repositories\Educacion;

use Illuminate\Support\Facades\DB;

class InstEducativaRepositorio
{
    public static function resumen_porDistrito()
    { 
                  $data = DB::table('edu_institucioneducativa as inst')           
                  ->join('edu_estadoinsedu as est', 'inst.EstadoInsEdu_id', '=', 'est.id')
                  ->join('par_centropoblado as cenPo', 'inst.CentroPoblado_id', '=', 'cenPo.id') 
                  ->join('par_ubigeo as distrito', 'cenPo.Ubigeo_id', '=', 'distrito.id') 
                  ->join('par_ubigeo as provincia', 'distrito.dependencia', '=', 'provincia.id') 
                  ->where('inst.estado','=', 'ac')
                  ->orderBy('provincia.codigo', 'asc')
                  ->orderBy('distrito.codigo', 'asc')
                  ->groupBy('provincia.nombre')  
                  ->groupBy('distrito.nombre')   
                  ->get([  
                          DB::raw('provincia.nombre as provincia'), 
                          DB::raw('distrito.nombre as distrito'),                            
                          DB::raw('sum( case when est.codigo = 1 then 1 else 0 end ) as activas'), 
                          DB::raw('sum( case when est.codigo = 2 then 1 else 0 end ) as inactivas'),
                          DB::raw('sum( 1 ) as total')
                        ]);

             return $data;
     }

     public static function resumen_porProvincia()
     { 
                  $data = DB::table('edu_institucioneducativa as inst')           
                  ->join('edu_estadoinsedu as est', 'inst.EstadoInsEdu_id', '=', 'est.id')
                  ->join('par_centropoblado as cenPo', 'inst.CentroPoblado_id', '=', 'cenPo.id') 
                  ->join('par_ubigeo as distrito', 'cenPo.Ubigeo_id', '=', 'distrito.id') 
                  ->join('par_ubigeo as provincia', 'distrito.dependencia', '=', 'provincia.id') 
                  ->join('par_ubigeo as region', 'provincia.dependencia', '=', 'region.id') 
                  ->where('inst.estado','=', 'ac')
                  ->orderBy('provincia.codigo', 'asc')
                  ->groupBy('region.nombre')  
                  ->groupBy('provincia.nombre')  
                  ->get([  
                          DB::raw('region.nombre as region'),     
                          DB::raw('provincia.nombre as provincia'),                                                  
                          DB::raw('sum( case when est.codigo = 1 then 1 else 0 end ) as activas'), 
                          DB::raw('sum( case when est.codigo = 2 then 1 else 0 end ) as inactivas'),
                          DB::raw('sum( 1 ) as total')
                        ]);

             return $data;
     }

     public static function resumen_porRegion()
     { 
                  $data = DB::table('edu_institucioneducativa as inst')           
                  ->join('edu_estadoinsedu as est', 'inst.EstadoInsEdu_id', '=', 'est.id')
                  ->join('par_centropoblado as cenPo', 'inst.CentroPoblado_id', '=', 'cenPo.id') 
                  ->join('par_ubigeo as distrito', 'cenPo.Ubigeo_id', '=', 'distrito.id') 
                  ->join('par_ubigeo as provincia', 'distrito.dependencia', '=', 'provincia.id') 
                  ->join('par_ubigeo as region', 'provincia.dependencia', '=', 'region.id') 
                  ->where('inst.estado','=', 'ac')                  
                  ->groupBy('region.nombre')  
                  ->get([  
                          DB::raw('region.nombre as region'),  
                          DB::raw('sum( case when est.codigo = 1 then 1 else 0 end ) as activas'), 
                          DB::raw('sum( case when est.codigo = 2 then 1 else 0 end ) as inactivas'),
                          DB::raw('sum( 1 ) as total')
                        ]);

             return $data;
     }
}