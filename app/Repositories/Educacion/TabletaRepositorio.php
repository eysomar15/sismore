<?php

namespace App\Repositories\Educacion;

use Illuminate\Support\Facades\DB;

class TabletaRepositorio
{

    public static function tableta_mas_actual()
    { 
             $data = DB::table('par_importacion as imp')           
             ->join('edu_tableta as tab', 'imp.id', '=', 'tab.importacion_id')
             ->join('par_anio as vanio', 'tab.anio_id', '=', 'vanio.id')         
             ->where('imp.estado','=', 'PR')
             ->orderBy('vanio.anio', 'desc')
             ->orderBy('imp.fechaActualizacion', 'desc')
             ->select('tab.id','imp.fechaActualizacion')
             ->limit(1)
             ->get();

        return $data;
    }

    public static function tableta_anio()
    { 
             $data = DB::table('par_importacion as imp')           
             ->join('edu_tableta as tab', 'imp.id', '=', 'tab.importacion_id')
             ->join('par_anio as vanio', 'tab.anio_id', '=', 'vanio.id')        
             ->where('imp.estado','=', 'PR')              
             ->orderBy('vanio.anio', 'desc')
             ->select('vanio.id','vanio.anio')   
             ->distinct()  
             ->get();

        return $data;
    }

    public static function fechas_tabletas_anio($anio_id)
    { 
              $data = DB::table('par_importacion as imp')           
              ->join('edu_tableta as tab', 'imp.id', '=', 'tab.importacion_id')
              ->join('par_anio as vanio', 'tab.anio_id', '=', 'vanio.id')   
              ->where('vanio.id','=', $anio_id)      
              ->where('imp.estado','=', 'PR')              
              ->orderBy('imp.fechaActualizacion', 'desc')
              ->select('tab.id as tableta_id','imp.fechaActualizacion','vanio.id','vanio.anio')     
              ->get();

         return $data;
    }
}