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

    public static function matriculas_anio()
    { 
        $data = DB::table('par_importacion as imp')           
                ->join('edu_matricula as mat', 'imp.id', '=', 'mat.importacion_id')
                ->join('par_anio as vanio', 'mat.anio_id', '=', 'vanio.id')        
                ->where('imp.estado','=', 'PR')
                ->where('mat.estado','=', 'PR')      
                ->orderBy('vanio.anio', 'desc')
                ->select('vanio.id','vanio.anio')   
                ->distinct()  
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
                ->select('mat.id as matricula_id','imp.fechaActualizacion','vanio.id','vanio.anio')     
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
                ->orderBy('ugel.codigo', 'asc')              
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

    
    public static function total_matricula_por_Nivel($matricula_id)
    { 
        $data = DB::table('edu_matricula as mat')           
                ->join('edu_matricula_detalle as matDet', 'mat.id', '=', 'matDet.matricula_id')
                ->join('edu_institucioneducativa as inst', 'matDet.institucioneducativa_id', '=', 'inst.id')  
                ->join('edu_ugel as ugel', 'inst.Ugel_id', '=', 'ugel.id')         
                ->where('mat.id','=', $matricula_id)
                //->where('matDet.nivel','=',$nivel)  
                ->orderBy('ugel.codigo', 'asc')           
                ->groupBy('ugel.nombre')   
                ->groupBy('nivel')               
                ->get([  
                    DB::raw('ugel.nombre'),   
                    DB::raw('nivel'),                       
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

    public static function total_matricula_por_Nivel_Distrito($matricula_id)
    { 
        $data = DB::table('edu_matricula as mat')           
                ->join('edu_matricula_detalle as matDet', 'mat.id', '=', 'matDet.matricula_id')
                ->join('edu_institucioneducativa as inst', 'matDet.institucioneducativa_id', '=', 'inst.id')  
                ->join('par_centropoblado as cenPo', 'inst.CentroPoblado_id', '=', 'cenPo.id')
                
                ->join('par_ubigeo as dist', 'cenPo.ubigeo_id', '=', 'dist.id')
                ->join('par_ubigeo as prov', 'dist.dependencia', '=', 'prov.id')

                ->where('mat.id','=', $matricula_id)
                //->where('matDet.nivel','=',$nivel)  
                ->orderBy('dist.codigo', 'asc')                 
                ->groupBy('prov.nombre')   
                ->groupBy('dist.nombre')  
                ->groupBy('nivel')                
                ->get([  
                    DB::raw('case when dist.nombre = "YURUA" then "CORONEL PORTILLO" else prov.nombre end as provincia'), 
                    DB::raw('dist.nombre as distrito'),  
                    DB::raw('nivel'),                             
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

    public static function total_matricula_por_Nivel_Institucion($matricula_id)
    { 
        $data = DB::table(
                        DB::raw("(
                                select ugel.nombre as ugel,case when dist.nombre = 'yurua' then 'CORONEL PORTILLO' else prov.nombre end as provincia , 
                                dist.nombre as distrito,cenPo.nombre as cenPo,inst.codModular,inst.anexo,inst.nombreInstEduc,tipoGestion.nombre as tipoGestion,
                                tipoGestionCab.nombre as tipoGestionCab,forma.nombre as forma,caracteristica.nombre as caracteristica, areas.nombre as areas,
                                prov.codigo,nivel,
                                cero_nivel_hombre , primer_nivel_hombre ,segundo_nivel_hombre ,
                                tercero_nivel_hombre , cuarto_nivel_hombre , quinto_nivel_hombre ,
                                sexto_nivel_hombre , tres_anios_hombre_ebe,cuatro_anios_hombre_ebe, cinco_anios_hombre_ebe,
                                cero_nivel_mujer , primer_nivel_mujer , segundo_nivel_mujer , tercero_nivel_mujer ,
                                cuarto_nivel_mujer , quinto_nivel_mujer , sexto_nivel_mujer , tres_anios_mujer_ebe , 
                                cuatro_anios_mujer_ebe , cinco_anios_mujer_ebe
                                from edu_matricula mat
                                inner join edu_matricula_detalle matDet on mat.id = matDet.matricula_id
                                inner join edu_institucioneducativa inst on matDet.institucioneducativa_id = inst.id
                                inner join edu_ugel ugel on inst.Ugel_id = ugel.id
                                inner join edu_tipogestion tipoGestion on inst.TipoGestion_id = tipoGestion.id
                                inner join edu_tipogestion tipoGestionCab on tipoGestion.dependencia = tipoGestionCab.id
                                inner join edu_forma forma on inst.Forma_id = forma.id
                                inner join edu_caracteristica caracteristica on inst.Caracteristica_id = caracteristica .id
                                inner join edu_area areas on inst.Area_id = areas.id
                                inner join  par_centropoblado cenPo on inst.CentroPoblado_id = cenPo.id
                                inner join par_ubigeo dist on cenPo.ubigeo_id = dist.id
                                inner join par_ubigeo prov on dist.dependencia = prov.id
                                where mat.id = '$matricula_id'
                            ) as datos"
                        )
                    )           
            
                ->orderBy('nombreInstEduc', 'asc')
                ->get(
                    //[                      
                    // DB::raw('ugel'), 
                    // ]
                );


        return $data;

    }


    public static function total_matricula_por_Nivel_Provincia($matricula_id)
    { 
        $data = DB::table(

                        DB::raw("(
                            select dist.nombre as distrito,prov.codigo,nivel,
                            case when dist.nombre = 'yurua' then 'CORONEL PORTILLO' else prov.nombre end as provincia ,
                            cero_nivel_hombre , primer_nivel_hombre ,segundo_nivel_hombre ,
                            tercero_nivel_hombre , cuarto_nivel_hombre , quinto_nivel_hombre ,
                            sexto_nivel_hombre , tres_anios_hombre_ebe,cuatro_anios_hombre_ebe, cinco_anios_hombre_ebe,
                            cero_nivel_mujer , primer_nivel_mujer , segundo_nivel_mujer , tercero_nivel_mujer ,
                            cuarto_nivel_mujer , quinto_nivel_mujer , sexto_nivel_mujer , tres_anios_mujer_ebe , 
                            cuatro_anios_mujer_ebe , cinco_anios_mujer_ebe
                            from edu_matricula mat
                            inner join edu_matricula_detalle matDet on mat.id = matDet.matricula_id
                            inner join edu_institucioneducativa inst on matDet.institucioneducativa_id = inst.id
                            inner join  par_centropoblado cenPo on inst.CentroPoblado_id = cenPo.id
                            inner join par_ubigeo dist on cenPo.ubigeo_id = dist.id
                            inner join par_ubigeo prov on dist.dependencia = prov.id
                            where mat.id = '$matricula_id'
                        ) as datos"
                        )

                    )           
            
                ->orderBy('codigo', 'asc')                 
                ->groupBy('provincia')  
                ->groupBy('nivel')  
     
                ->get([  
                    
                    DB::raw('provincia'),    
                    DB::raw('nivel'),                                             
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

    public static function total_matricula_EBR_Provincia($matricula_id)
    { 
        //->where('matDet.nivel','!=','E') 

        $data = DB::table(
                        DB::raw("(
                            select dist.nombre as distrito,prov.codigo,nivel,
                            case when dist.nombre = 'yurua' then 'CORONEL PORTILLO' else prov.nombre end as provincia ,
                            cero_nivel_hombre , primer_nivel_hombre ,segundo_nivel_hombre ,
                            tercero_nivel_hombre , cuarto_nivel_hombre , quinto_nivel_hombre ,
                            sexto_nivel_hombre , tres_anios_hombre_ebe,cuatro_anios_hombre_ebe, cinco_anios_hombre_ebe,
                            cero_nivel_mujer , primer_nivel_mujer , segundo_nivel_mujer , tercero_nivel_mujer ,
                            cuarto_nivel_mujer , quinto_nivel_mujer , sexto_nivel_mujer , tres_anios_mujer_ebe , 
                            cuatro_anios_mujer_ebe , cinco_anios_mujer_ebe
                            from edu_matricula mat
                            inner join edu_matricula_detalle matDet on mat.id = matDet.matricula_id
                            inner join edu_institucioneducativa inst on matDet.institucioneducativa_id = inst.id
                            inner join  par_centropoblado cenPo on inst.CentroPoblado_id = cenPo.id
                            inner join par_ubigeo dist on cenPo.ubigeo_id = dist.id
                            inner join par_ubigeo prov on dist.dependencia = prov.id
                            where matDet.nivel != 'E' and  mat.id = '$matricula_id'
                        ) as datos" )
                    ) 
                         
                ->orderBy('codigo', 'asc')                 
                ->groupBy('provincia')
                ->get([                      
                    DB::raw('provincia'),  
                                                        
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


    public static function total_matricula_anual($anio_id)
    { 
        //->where('matDet.nivel','!=','E') 

        $data = DB::table(
                        DB::raw("(
                            select fechaactualizacion,sum(cantidad) as cantTotal ,
                            sum(case when id = 10 then cantidad else 0 end ) as ugel10,
                            sum(case when id = 11 then cantidad else 0 end ) as ugel11,
                            sum(case when id = 12 then cantidad else 0 end ) as ugel12,
                            sum(case when id = 13 then cantidad else 0 end ) as ugel13
                            from (

                                            select 
                                            fechaactualizacion,
                                            ugel.id,
                                            sum(           
                                                                            ifnull(cero_nivel_hombre,0) + ifnull(primer_nivel_hombre,0) + ifnull(segundo_nivel_hombre,0) + 
                                                                            ifnull(tercero_nivel_hombre,0) + ifnull(cuarto_nivel_hombre,0) + ifnull(quinto_nivel_hombre,0) +
                                                                            ifnull(sexto_nivel_hombre,0) + ifnull(tres_anios_hombre_ebe,0) + ifnull(cuatro_anios_hombre_ebe,0) +
                                                                            ifnull(cinco_anios_hombre_ebe,0) + ifnull(cero_nivel_mujer,0) + ifnull(primer_nivel_mujer,0) + ifnull(segundo_nivel_mujer,0) + 
                                                                            ifnull(tercero_nivel_mujer,0) + ifnull(cuarto_nivel_mujer,0) + ifnull(quinto_nivel_mujer,0) + 
                                                                            ifnull(sexto_nivel_mujer,0) + ifnull(tres_anios_mujer_ebe,0) + 
                                                                            ifnull(cuatro_anios_mujer_ebe,0) + ifnull(cinco_anios_mujer_ebe,0)
                                                                            ) as cantidad

                                                                            from par_importacion as imp 
                                            inner join edu_matricula as mat on imp.id = mat.importacion_id
                                            inner join edu_matricula_detalle as matDet on mat.id = matDet.matricula_id
                                            inner join edu_institucioneducativa as inst on matDet.institucioneducativa_id = inst.id
                                            inner join edu_ugel as ugel on inst.Ugel_id = ugel.id
                                            where mat.anio_id = '$anio_id' and matDet.nivel != 'E' and imp.estado = 'PR'
                                            group By fechaactualizacion,ugel.id 
                                
                            ) as dd
                            group by fechaactualizacion
 
                        ) as datos" )
                    ) 
                         
                // ->orderBy('codigo', 'asc')                 
                // ->groupBy('provincia')
                ->get([                      
                    DB::raw('fechaactualizacion'), 
                    DB::raw('ugel10'),
                    DB::raw('ugel11'),
                    DB::raw('ugel12'),
                    DB::raw('ugel13') 
                  
                ]);

        return $data;

    }


    

    
    /**pruebassssss */
    public static function total_matricula_por_Nivel_Provincia2($matricula_id)
    {
        

        $data = DB::table(DB::raw("(select nivel,sum(ifnull(dni_sin_validar,0)) as dni_sin_validar from edu_matricula_detalle group by nivel) as datos"))
        ->select("nivel", "dni_sin_validar")
                // ->groupBy('nivel')  
                // ->get([
                //     DB::raw('nivel'),  
                //     DB::raw('sum(dni_sin_validar) as dd'), 
                    
                // ])
                ->get() ;

        // $data =  DB::table()
        //     ->select("nivel", "sum (dni_sin_validar)")
        //     ->groupBy("nivel")
        //     ->get();
        $id = 45;

        $data = DB::table(DB::raw("(
                                    select dist.nombre as distrito,prov.codigo,
                                    case when dist.nombre = 'yurua' then 'CORONEL PORTILLO' else prov.nombre end as provincia ,
                                    cero_nivel_hombre , primer_nivel_hombre ,segundo_nivel_hombre ,
                                    tercero_nivel_hombre , cuarto_nivel_hombre , quinto_nivel_hombre ,
                                    sexto_nivel_hombre , tres_anios_hombre_ebe,cuatro_anios_hombre_ebe, cinco_anios_hombre_ebe,
                                    cero_nivel_mujer , primer_nivel_mujer , segundo_nivel_mujer , tercero_nivel_mujer ,
                                    cuarto_nivel_mujer , quinto_nivel_mujer , sexto_nivel_mujer , tres_anios_mujer_ebe , 
                                    cuatro_anios_mujer_ebe , cinco_anios_mujer_ebe
                                    from edu_matricula mat
                                    inner join edu_matricula_detalle matDet on mat.id = matDet.matricula_id
                                    inner join edu_institucioneducativa inst on matDet.institucioneducativa_id = inst.id
                                    inner join  par_centropoblado cenPo on inst.CentroPoblado_id = cenPo.id
                                    inner join par_ubigeo dist on cenPo.ubigeo_id = dist.id
                                    inner join par_ubigeo prov on dist.dependencia = prov.id
                                    where mat.id = '$id'
                                ) as datos"
                                )
                            )
        ->select("provincia", "distrito")
                // ->groupBy('nivel')  
                // ->get([
                //     DB::raw('nivel'),  
                //     DB::raw('sum(dni_sin_validar) as dd'), 
                    
                // ])
                ->get() ;

        return $data;
    }
   
}