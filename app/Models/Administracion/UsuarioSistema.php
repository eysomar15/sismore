<?php

namespace App\Models\Administracion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsuarioSistema extends Model
{
    use HasFactory;
    protected $table = "adm_usuario_sistema";

    protected $fillable = [
        'usuario_id',
        'sistema_id',
    ];
}
