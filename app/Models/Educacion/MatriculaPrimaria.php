<?php

namespace App\Models\Educacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatriculaPrimaria extends Model
{
    use HasFactory;

    protected $table='edu_matricula_primaria';
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
                'primer_grado_hombre',
                'primer_grado_mujer',
                'segundo_grado_hombre',
                'segundo_grado_mujer',
                'tercer_grado_hombre',
                'tercer_grado_mujer',
                'cuarto_grado_hombre',
                'cuarto_grado_mujer',
                'quinto_grado_hombre',
                'quinto_grado_mujer',
                'sexto_grado_hombre',
                'sexto_grado_mujer'
    ];
}
