<?php

namespace App\Repositories\Educacion;

use App\Models\Educacion\CuadroAsigPersonal;

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
}