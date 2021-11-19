<?php

namespace App\Models\Administracion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsuarioTipo extends Model
{
    use HasFactory;
    protected $table = "adm_usuariotipo";

    protected $fillable = [
        'nombre',
        'estado',
    ];
}
