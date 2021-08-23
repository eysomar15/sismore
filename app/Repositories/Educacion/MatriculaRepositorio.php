<?php

namespace App\Repositories\Educacion;

use App\Models\Educacion\Matricula;
use Illuminate\Support\Facades\DB;

class MatriculaRepositorio
{
    public static function datos_matricula_importada($matricula_id)
    {         
        $data = DB::table("edu_matricula_detalle")               
                ->where("matricula_id", "=", $matricula_id)
                ->orderBy('nivel', 'asc')
                ->groupBy("nivel")               
                ->get([                       
                    DB::raw('(case when nivel="I" then "1. INICIAL" 
                                   when nivel="P" then "2. PRIMARIA"
                                   when nivel="S" then "3. SECUNDARIA"  else "4. EBE" end) as nivel') ,              
                    DB::raw('count(*) as numeroFilas')        
                ])
                ;

        return $data;
    }

    public static function matricula_porImportacion($importacion_id)
    {         
        $data = Matricula::select('id')                
                ->where("importacion_id", "=", $importacion_id)
                ->get();

        return $data;
    } 

   
}