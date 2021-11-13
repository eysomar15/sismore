<?php

namespace App\Repositories\Administracion;

use App\Models\Administracion\Usuario;
use App\Models\Administracion\UsuarioSistema;
use Illuminate\Support\Facades\DB;
use PHPUnit\TextUI\XmlConfiguration\Group;

class UsuarioSistemaRepositorio
{
    public static function ListarSistemas($usuario_id)
    {
        $data =  UsuarioSistema::select('v2.*')
            ->join('adm_sistema as v2', 'v2.id', '=', 'adm_usuario_sistema.sistema_id')
            ->where('adm_usuario_sistema.usuario_id', $usuario_id)
            ->orderBy('v2.nombre')->get();

        return $data;
    }

}
