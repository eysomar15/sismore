<?php

namespace App\Models\Educacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Eceresultado extends Model
{
    use HasFactory;

    protected $table='edu_eceresultado';

    protected $fillable=[
        'ece_id',
        'institucioneducativa_id',
        'materia_id',
        'programados',
        'evaluados',
        'inicio',
        'proceso',
        'mediapromedio',
        'satisfactorio',

    ];
}
