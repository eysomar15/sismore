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

    public static function datos_matricula($matricula_id)
    {         
        $data = Matricula::select('imp.fechaactualizacion')       
                ->join('par_importacion as imp', 'edu_matricula.importacion_id', '=', 'imp.id')         
                ->where("edu_matricula.id", "=", $matricula_id)
                ->get();

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

    public static function fechas_matriculas_anio($anio_id)
    { 
        $data = DB::table('par_importacion as imp')           
                ->join('edu_matricula as mat', 'imp.id', '=', 'mat.importacion_id')
                ->join('par_anio as vanio', 'mat.anio_id', '=', 'vanio.id')   
                ->where('vanio.id','=', $anio_id)      
                ->where('imp.estado','=', 'PR')
                ->where('mat.estado','=', 'PR')      
                ->orderBy('imp.fechaActualizacion', 'desc')
                ->select('mat.id as matricula_id','imp.fechaActualizacion')     
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

    public static function total_matricula_por_Nivel($matricula_id,$nivel)
    { 
        $data = DB::table('edu_matricula as mat')           
                ->join('edu_matricula_detalle as matDet', 'mat.id', '=', 'matDet.matricula_id')
                ->join('edu_institucioneducativa as inst', 'matDet.institucioneducativa_id', '=', 'inst.id')  
                ->join('edu_ugel as ugel', 'inst.Ugel_id', '=', 'ugel.id')         
                ->where('mat.id','=', $matricula_id)
                ->where('matDet.nivel','=',$nivel)             
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

                    DB::raw('sum( ifnull(cero_nivel_hombre,0) ) as cero_nivel_hombre'),
                    DB::raw('sum( ifnull(primer_nivel_hombre,0) ) as primer_nivel_hombre'),
                    DB::raw('sum( ifnull(segundo_nivel_hombre,0) ) as segundo_nivel_hombre'),
                    DB::raw('sum( ifnull(tercero_nivel_hombre,0) ) as tercero_nivel_hombre'),
                    DB::raw('sum( ifnull(cuarto_nivel_hombre,0) ) as cuarto_nivel_hombre'),
                    DB::raw('sum( ifnull(quinto_nivel_hombre,0) ) as quinto_nivel_hombre'),
                    DB::raw('sum( ifnull(sexto_nivel_hombre,0) ) as sexto_nivel_hombre'),

                    DB::raw('sum( ifnull(tres_anios_hombre_ebe,0) ) as tres_anios_hombre_ebe'),
                    DB::raw('sum( ifnull(cuatro_anios_hombre_ebe,0) ) as cuatro_anios_hombre_ebe'),
                    DB::raw('sum( ifnull(cinco_anios_hombre_ebe,0) ) as cinco_anios_hombre_ebe'),

                    DB::raw('sum( ifnull(cero_nivel_mujer,0) ) as cero_nivel_mujer'),
                    DB::raw('sum( ifnull(primer_nivel_mujer,0) ) as primer_nivel_mujer'),
                    DB::raw('sum( ifnull(segundo_nivel_mujer,0) ) as segundo_nivel_mujer'),
                    DB::raw('sum( ifnull(tercero_nivel_mujer,0) ) as tercero_nivel_mujer'),
                    DB::raw('sum( ifnull(cuarto_nivel_mujer,0) ) as cuarto_nivel_mujer'),
                    DB::raw('sum( ifnull(quinto_nivel_mujer,0) ) as quinto_nivel_mujer'),
                    DB::raw('sum( ifnull(sexto_nivel_mujer,0) ) as sexto_nivel_mujer'),

                    DB::raw('sum( ifnull(tres_anios_mujer_ebe,0) ) as tres_anios_mujer_ebe'),
                    DB::raw('sum( ifnull(cuatro_anios_mujer_ebe,0) ) as cuatro_anios_mujer_ebe'),
                    DB::raw('sum( ifnull(cinco_anios_mujer_ebe,0) ) as cinco_anios_mujer_ebe'),
                    
                ]);

        return $data;

    }

    public static function total_matricula_por_Nivel_Distrito($matricula_id,$nivel)
    { 
        $data = DB::table('edu_matricula as mat')           
                ->join('edu_matricula_detalle as matDet', 'mat.id', '=', 'matDet.matricula_id')
                ->join('edu_institucioneducativa as inst', 'matDet.institucioneducativa_id', '=', 'inst.id')  
                ->join('par_centropoblado as cenPo', 'inst.CentroPoblado_id', '=', 'cenPo.id')
                
                ->join('par_ubigeo as dist', 'cenPo.ubigeo_id', '=', 'dist.id')
                ->join('par_ubigeo as prov', 'cenPo.dependencia', '=', 'prov.id')

                ->where('mat.id','=', $matricula_id)
                ->where('matDet.nivel','=',$nivel)             
                ->groupBy('prov.nombre')   
                ->groupBy('dist.nombre')                
                ->get([  
                    DB::raw('prov.nombre as provincia'), 
                    DB::raw('dist.nombre as distrito'),                             
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

                    DB::raw('sum( ifnull(cero_nivel_hombre,0) ) as cero_nivel_hombre'),
                    DB::raw('sum( ifnull(primer_nivel_hombre,0) ) as primer_nivel_hombre'),
                    DB::raw('sum( ifnull(segundo_nivel_hombre,0) ) as segundo_nivel_hombre'),
                    DB::raw('sum( ifnull(tercero_nivel_hombre,0) ) as tercero_nivel_hombre'),
                    DB::raw('sum( ifnull(cuarto_nivel_hombre,0) ) as cuarto_nivel_hombre'),
                    DB::raw('sum( ifnull(quinto_nivel_hombre,0) ) as quinto_nivel_hombre'),
                    DB::raw('sum( ifnull(sexto_nivel_hombre,0) ) as sexto_nivel_hombre'),

                    DB::raw('sum( ifnull(tres_anios_hombre_ebe,0) ) as tres_anios_hombre_ebe'),
                    DB::raw('sum( ifnull(cuatro_anios_hombre_ebe,0) ) as cuatro_anios_hombre_ebe'),
                    DB::raw('sum( ifnull(cinco_anios_hombre_ebe,0) ) as cinco_anios_hombre_ebe'),

                    DB::raw('sum( ifnull(cero_nivel_mujer,0) ) as cero_nivel_mujer'),
                    DB::raw('sum( ifnull(primer_nivel_mujer,0) ) as primer_nivel_mujer'),
                    DB::raw('sum( ifnull(segundo_nivel_mujer,0) ) as segundo_nivel_mujer'),
                    DB::raw('sum( ifnull(tercero_nivel_mujer,0) ) as tercero_nivel_mujer'),
                    DB::raw('sum( ifnull(cuarto_nivel_mujer,0) ) as cuarto_nivel_mujer'),
                    DB::raw('sum( ifnull(quinto_nivel_mujer,0) ) as quinto_nivel_mujer'),
                    DB::raw('sum( ifnull(sexto_nivel_mujer,0) ) as sexto_nivel_mujer'),

                    DB::raw('sum( ifnull(tres_anios_mujer_ebe,0) ) as tres_anios_mujer_ebe'),
                    DB::raw('sum( ifnull(cuatro_anios_mujer_ebe,0) ) as cuatro_anios_mujer_ebe'),
                    DB::raw('sum( ifnull(cinco_anios_mujer_ebe,0) ) as cinco_anios_mujer_ebe'),
                    
                ]);

        return $data;

    }
   
   
}