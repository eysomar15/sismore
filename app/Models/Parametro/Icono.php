<?php

namespace App\Models\Parametro;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Icono extends Model
{
    use HasFactory;
    protected $table = "par_icono";

    protected $fillable = [
        'nombre'
    ];
}
