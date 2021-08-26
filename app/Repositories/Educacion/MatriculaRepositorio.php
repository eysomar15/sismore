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
        $data = Matricula::select('id','estado')                
                ->where("importacion_id", "=", $importacion_id)
                ->get();

        return $data;
    } 

    public static function matricula_mas_actual()
    { 
        $data = DB::table('par_importacion as imp')           
                ->join('edu_matricula as mat', 'imp.id', '=', 'mat.importacion_id')
                ->join('par_anio as vanio', 'mat.anio_id', '=', 'vanio.id')         
                ->where('imp.estado','=', 'PR')
                ->where('mat.estado','=', 'PR')
                ->orderBy('vanio.anio', 'desc')
                ->orderBy('imp.fechaActualizacion', 'desc')
                ->select('mat.id','imp.fechaActualizacion')
                ->limit(1)
                ->get();

        return $data;
    }

    public static function total_matricula_EBR($matricula_id)
    { 
        $data = DB::table('edu_matricula as mat')           
                ->join('edu_matricula_detalle as matDet', 'mat.id', '=', 'matDet.matricula_id')
                ->join('edu_institucioneducativa as inst', 'matDet.institucioneducativa_id', '=', 'inst.id')  
                ->join('edu_ugel as ugel', 'inst.Ugel_id', '=', 'ugel.id')         
                ->where('mat.id','=', $matricula_id)
                ->where('matDet.nivel','!=','E')
                ->groupBy('ugel.nombre')                
                ->get([  
                    DB::raw('ugel.nombre'),                         
                    DB::raw('sum(           
                                ifnull(cero_nivel_hombre,0) + ifnull(primer_nivel_hombre,0) + ifnull(segundo_nivel_hombre,0) + 
                                ifnull(tercero_nivel_hombre,0) + ifnull(cuarto_nivel_hombre,0) + ifnull(quinto_nivel_hombre,0) +
                                ifnull(sexto_nivel_hombre,0) + ifnull(tres_anios_hombre_ebe,0) + ifnull(cuatro_anios_hombre_ebe,0) +
                                ifnull(cinco_anios_hombre_ebe,0)
                                ) as hombres'),  
                    DB::raw('sum(           
                                ifnull(cero_nivel_mujer,0) + ifnull(primer_nivel_mujer,0) + ifnull(segundo_nivel_mujer,0) + 
                                ifnull(tercero_nivel_mujer,0) + ifnull(cuarto_nivel_mujer,0) + ifnull(quinto_nivel_mujer,0) + 
                                ifnull(sexto_nivel_mujer,0) + ifnull(tres_anios_mujer_ebe,0) + 
                                ifnull(cuatro_anios_mujer_ebe,0) + ifnull(cinco_anios_mujer_ebe,0)
                                ) as mujeres'), 
                    
                ]);

        return $data;

    }
   
   
}