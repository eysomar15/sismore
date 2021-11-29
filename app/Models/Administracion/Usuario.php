<?php

namespace App\Models\Administracion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;
    protected $table = "adm_usuario";

    protected $fillable = [
        'usuario',
        'email',
        'password',
        'remember_token',
        'estado',
        'dni',
        'dependencia',
        'nombre',
        'apellidos',
        'sexo',
        'celular',
        'unidadejecutora_id ',
    ];
}
