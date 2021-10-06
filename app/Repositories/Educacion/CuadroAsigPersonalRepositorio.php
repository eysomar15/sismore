<?php

namespace App\Repositories\Educacion;

use App\Models\Educacion\CuadroAsigPersonal;
use Illuminate\Support\Facades\DB;

class CuadroAsigPersonalRepositorio
{
    public static function Listar_Por_Importacion_id($importacion_id)
    {         
        $Lista = CuadroAsigPersonal::select('id','region','unidad_ejecutora','organo_intermedio','provincia','distrito',
                'tipo_ie','gestion','zona','codmod_ie','codigo_local','clave8','nivel_educativo','institucion_educativa',
                'codigo_plaza','tipo_trabajador','sub_tipo_trabajador','cargo','situacion_laboral','motivo_vacante',
                'documento_identidad','codigo_modular','apellido_paterno','apellido_materno','nombres','fecha_ingreso',
                'categoria_remunerativa','jornada_laboral','estado','fecha_nacimiento','fecha_inicio','fecha_termino',
                'tipo_registro','ley','preventiva','referencia_preventiva','especialidad','tipo_estudios','estado_estudios',
                'grado','mencion','especialidad_profesional','fecha_resolucion',
                'numero_resolucion','centro_estudios','celular','email',
                )
        ->where("importacion_id", "=", $importacion_id)
        ->get();

        return $Lista;
    } 

    public static function cuadro_ugel()
    {         
        $data = DB::table("edu_plaza as pla")     
                ->join('edu_ugel as ugel', 'pla.ugel_id', '=', 'ugel.id')                
                ->orderBy('ugel.codigo', 'asc')         
                ->groupBy("ugel.nombre")               
                        ->get([ 
                            DB::raw('ugel.nombre as ugel'),              
                            DB::raw('count(*) as cantidad')        
                        ])
                ;

        return $data;
    }

    public static function cuadro_ugel_nivel()
    {         
        $data = DB::table("edu_plaza as pla")     
                ->join('edu_ugel as ugel', 'pla.ugel_id', '=', 'ugel.id')   
                ->leftjoin('edu_nivelmodalidad as niv', 'pla.nivelModalidad_id', '=', 'niv.id')                
                ->orderBy('ugel.codigo', 'asc')    
                ->orderBy('niv.codigo', 'asc')      
                ->groupBy("ugel.nombre")                  
                ->groupBy("nivel_educativo_dato_adic")
                ->groupBy("niv.codigo")               
                        ->get([                    
                            DB::raw('ugel.nombre as ugel'), 
                            DB::raw('nivel_educativo_dato_adic as nivel'),
                            // DB::raw('case when nivel_educativo_dato_adic is null then "ssss" else niv.codigo end  as nivel'),              
                            DB::raw('count(*) as cantidad')        
                        ])
                ;

        return $data;
    }

    public static function cuadro_ugel_tipoTrab()
    {         
        $data = DB::table("edu_plaza as pla")     
                ->join('edu_ugel as ugel', 'pla.ugel_id', '=', 'ugel.id')   
                ->join('edu_tipotrabajador as subTipTra', 'pla.tipoTrabajador_id', '=', 'subTipTra.id')
                ->join('edu_tipotrabajador as tipTra', 'subTipTra.dependencia', '=', 'tipTra.id')            
                ->orderBy('ugel.codigo', 'asc')
                ->groupBy("ugel.nombre") 
                ->groupBy("tipTra.nombre")
                        ->get([                    
                            DB::raw('ugel.nombre as ugel'),
                            DB::raw('tipTra.nombre as tipoTrab'),
                            DB::raw('count(*) as cantidad')        
                        ])
                ;

        return $data;
    }
    
    

    public static function docentes_ugel()
    {         
        $data = DB::table("edu_plaza as pla")     
                ->join('edu_ugel as ugel', 'pla.ugel_id', '=', 'ugel.id')
                ->join('edu_nivelmodalidad as nivMod', 'pla.nivelModalidad_id', '=', 'nivMod.id')
                ->join('edu_tipotrabajador as subTipTra', 'pla.tipoTrabajador_id', '=', 'subTipTra.id')
                ->join('edu_tipotrabajador as tipTra', 'subTipTra.dependencia', '=', 'tipTra.id')
                ->where("tipTra.id", "=", 1)//solo docentes
                ->orderBy('ugel.codigo', 'asc')
                ->groupBy("ugel.codigo") 
                ->groupBy("ugel.nombre")               
                        ->get([                       
                            DB::raw('ugel.codigo'), 
                            DB::raw('ugel.nombre as ugel'),              
                            DB::raw('count(*) as cantidad')        
                        ])
                ;

        return $data;
    }

    public static function docentes_ugel_nivel()
    {         
        $data = DB::table("edu_plaza as pla")     
                ->join('edu_ugel as ugel', 'pla.ugel_id', '=', 'ugel.id')
                ->join('edu_nivelmodalidad as nivMod', 'pla.nivelModalidad_id', '=', 'nivMod.id')
                ->join('edu_tipotrabajador as subTipTra', 'pla.tipoTrabajador_id', '=', 'subTipTra.id')
                ->join('edu_tipotrabajador as tipTra', 'subTipTra.dependencia', '=', 'tipTra.id')
                ->where("tipTra.id", "=", 1)//solo docentes
                ->orderBy('ugel.codigo', 'asc')
                ->groupBy("ugel.codigo") 
                ->groupBy("ugel.nombre")     
                ->groupBy("nivMod.nombre")          
                        ->get([                       
                            DB::raw('ugel.codigo'), 
                            DB::raw('ugel.nombre as ugel'), 
                            DB::raw('nivMod.nombre as nivel'),               
                            DB::raw('count(*) as cantidad')        
                        ])
                ;

        return $data;
    }

    public static function docentes_pedagogico($nivel_educativo)
    { 
        $data = DB::table(
                        DB::raw("(
                                    select 
                                    row_number() OVER (partition BY ugel.nombre   ORDER BY imp.fechaActualizacion DESC) AS item, ugel.nombre as ugel, 
                                    imp.fechaActualizacion,
                                    sum(case when estEst.id = 2  and esTitulado = 1 then 1 else 0 end) as pedagogico, 
                                    sum(1) as total
                                    from edu_plaza pla
                                    inner join edu_estadoestudio estEst on pla.estadoEstudio_id = estEst.id
                                    inner join edu_tipotrabajador subTipTra on pla.tipoTrabajador_id = subTipTra.id
                                    inner join edu_tipotrabajador tipTra on subTipTra.dependencia = tipTra.id
                                    inner join edu_ugel ugel on pla.ugel_id = ugel.id
                                    inner join par_importacion imp on pla.importacion_id = imp.id
                                    where  tipTra.id = 1 and nivel_educativo_dato_adic = '$nivel_educativo'
                                    group by imp.fechaActualizacion,ugel.nombre                            
                                ) as datos"
                        )
                    )
                // ->orderBy('codigo', 'asc')                 
                // ->groupBy('provincia')  
                // ->groupBy('nivel')       
                ->get([
                    DB::raw('item'),    
                    DB::raw('ugel'),   
                    DB::raw('fechaActualizacion'),    
                    DB::raw('pedagogico'),    
                    DB::raw('total'),
                    DB::raw('pedagogico*100/total as porcentaje'),
                ]);

        return $data;

    }

    public static function docentes_bilingues()
    { 
        $data = DB::table(
                        DB::raw("(
                                    select 
                                    row_number() OVER (partition BY ugel.nombre ORDER BY imp.fechaActualizacion DESC) AS item,
                                    imp.fechaActualizacion,ugel.nombre as ugel,
                                    sum( case when right(ltrim(rtrim(nombreInstEduc)),2) = '-B' then 1 else 0 end) as Bilingue,
                                    sum(1) as total
                                    from edu_institucioneducativa inst
                                    inner join  edu_plaza pla on inst.id = pla.institucionEducativa_id
                                    inner join edu_tipotrabajador subTipTra on pla.tipoTrabajador_id = subTipTra.id
                                    inner join edu_tipotrabajador tipTra on subTipTra.dependencia = tipTra.id
                                    inner join edu_ugel ugel on pla.ugel_id = ugel.id
                                    inner join par_importacion imp on pla.importacion_id = imp.id
                                    where tipTra.id = 1
                                    group by imp.fechaActualizacion,ugel.nombre
                                    having sum( case when right(ltrim(rtrim(nombreInstEduc)),2) = '-B' then 1 else 0 end) > 0
                                    order by ugel.codigo                        
                                ) as datos"
                        )
                    )
     
                ->get([
                    DB::raw('item'),    
                    DB::raw('ugel'),   
                    DB::raw('fechaActualizacion'),
                    DB::raw('Bilingue'),
                    DB::raw('total'),
                    DB::raw('Bilingue*100/total as porcentaje'),
                ]);

        return $data;

    }

    public static function docentes_bilingues_ugel()
    { 
        $data = DB::table(
                        DB::raw("(
                                    select 
                                    row_number() OVER (partition BY ugel.nombre,nivel_educativo_dato_adic ORDER BY imp.fechaActualizacion DESC) AS item,
                                    imp.fechaActualizacion,ugel.nombre as ugel,nivel_educativo_dato_adic as nivel_educativo,
                                    sum( case when right(ltrim(rtrim(nombreInstEduc)),2) = '-B' then 1 else 0 end) as Bilingue,
                                    sum(1) as total
                                    from edu_institucioneducativa inst
                                    inner join  edu_plaza pla on inst.id = pla.institucionEducativa_id
                                    inner join edu_tipotrabajador subTipTra on pla.tipoTrabajador_id = subTipTra.id
                                    inner join edu_tipotrabajador tipTra on subTipTra.dependencia = tipTra.id
                                    inner join edu_ugel ugel on pla.ugel_id = ugel.id
                                    inner join par_importacion imp on pla.importacion_id = imp.id
                                    where tipTra.id = 1
                                    group by imp.fechaActualizacion,ugel.nombre,nivel_educativo_dato_adic
                                    having sum( case when right(ltrim(rtrim(nombreInstEduc)),2) = '-B' then 1 else 0 end) > 0
                                    order by ugel.codigo,nivel_educativo_dato_adic                        
                                ) as datos"
                            )
                        )
        
                    ->get([
                        DB::raw('item'),    
                        DB::raw('ugel'),   
                        DB::raw('fechaActualizacion'),    
                        DB::raw('nivel_educativo'),    
                        DB::raw('Bilingue'),
                        DB::raw('total'),
                        DB::raw('Bilingue*100/total as porcentaje'),
                    ]);

        return $data;

    }
   
}