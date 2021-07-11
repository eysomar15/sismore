<?php

namespace App\Models\Educacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EceResultado extends Model
{
    use HasFactory;

    protected $table='edu_eceresultado';

    protected $fillable=[
        'institucioneducativa_id',
        'ece_id',        
        'materia_id',
        'programados',
        'evaluados',
        'inicio',
        'proceso',
        'mediapromedio',
        'satisfactorio',
    ];
}
