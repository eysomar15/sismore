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
   
}