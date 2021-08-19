<?php

namespace App\Models\Educacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatriculaDetalle extends Model
{
    use HasFactory;

    protected $table='edu_matricula_detalle';
    public $timestamps = false;

    protected $fillable=[
                    'matricula_id',                    
                    'institucioneducativa_id',
                    'nivel',
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

                    'cero_nivel_hombre',
                    'cero_nivel_mujer',
                    'primer_nivel_hombre',
                    'primer_nivel_mujer',
                    'segundo_nivel_hombre',
                    'segundo_nivel_mujer',
                    'tercero_nivel_hombre',
                    'tercero_nivel_mujer',
                    'cuarto_nivel_hombre',
                    'cuarto_nivel_mujer',
                    'quinto_nivel_hombre',
                    'quinto_nivel_mujer',
                    'sexto_nivel_hombre',
                    'sexto_nivel_mujer',

                    'tres_anios_hombre_ebe',
                    'tres_anios_mujer_ebe',
                    'cuatro_anios_hombre_ebe',
                    'cuatro_anios_mujer_ebe',
                    'cinco_anios_hombre_ebe',
                    'cinco_anios_mujer_ebe'
    ];
}
