<?php

namespace App\Models\Educacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grado extends Model
{
    use HasFactory;

    protected $table='edu_grado';

    protected $fillable=[
        'nivelmodalidad_id',
        'descripcion',
    ];
}
