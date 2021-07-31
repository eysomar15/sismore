<?php

namespace App\Repositories\Administracion;

use App\Models\Administracion\Sistema;

class SistemaRepositorio
{
  public static function Listar_porUsuario($usuario_id)
  { 
      $data = Sistema::select('adm_sistema.id','adm_sistema.nombre','adm_sistema.icono')
              ->join('adm_perfil', 'adm_perfil.sistema_id', '=', 'adm_sistema.id')
              ->join('adm_usuario_perfil', 'adm_usuario_perfil.perfil_id', '=', 'adm_perfil.id')
              ->where("adm_usuario_perfil.usuario_id", "=",$usuario_id )
              ->where("adm_perfil.estado", "=", 1)
              ->get();

      return $data;
  }
}
