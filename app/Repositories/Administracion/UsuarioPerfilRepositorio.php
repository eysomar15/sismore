<?php

namespace App\Repositories\Administracion;

use App\Models\Administracion\Usuario;
use App\Models\Administracion\UsuarioPerfil;
use App\Models\Administracion\UsuarioSistema;
use Illuminate\Support\Facades\DB;
use PHPUnit\TextUI\XmlConfiguration\Group;

class UsuarioPerfilRepositorio
{
    public static function ListarPerfilSistema($usuario_id)
    {
        //if ($usuario_id)
        $data =  UsuarioPerfil::select('v3.nombre as sistema', 'v2.nombre as perfil')
            ->join('adm_perfil as v2', 'v2.id', '=', 'adm_usuario_perfil.perfil_id')
            ->join('adm_sistema as v3', 'v3.id', '=', 'v2.sistema_id')
            ->where('adm_usuario_perfil.usuario_id', $usuario_id)
            ->orderBy('v3.nombre')
            ->get();

        return $data;
    }
}
