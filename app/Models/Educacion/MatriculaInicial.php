<?php

namespace App\Models\Educacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatriculaInicial extends Model
{
    use HasFactory;

    protected $table='edu_matricula_inicial';
    public $timestamps = false;

    protected $fillable=[
                    'importacion_id',
                    'anio_id',
                    'institucioneducativa_id',
                    'total_estudiantes_matriculados',
                    'matricula_definitiva',
                    'matricula_en_proceso',
                    'dni_validado',
                    'dni_sin_validar',
                    'registrado_sin_dni',
                    'total_grados',
                    'total_secciones',
                    'nominas_generadas',
                    'nominas_aprobadas',
                    'nominas_por_rectificar',
                    'cero_anios_hombre',
                    'cero_anios_mujer',
                    'uno_anios_hombre',
                    'uno_anios_mujer',
                    'dos_anios_hombre',
                    'dos_anios_mujer',
                    'tres_anios_hombre',
                    'tres_anios_mujer',
                    'cuatro_anios_hombre',
                    'cuatro_anios_mujer',
                    'cinco_anios_hombre',
                    'cinco_anios_mujer',
                    'masde_cinco_anios_hombre',
                    'masde_cinco_anios_mujer'
    ];
}
