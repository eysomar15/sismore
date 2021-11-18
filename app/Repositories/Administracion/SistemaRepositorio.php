<?php

namespace App\Repositories\Administracion;

use App\Models\Administracion\Sistema;
use Illuminate\Support\Facades\DB;

class SistemaRepositorio
{
  public static function Listar_porUsuario($usuario_id)
  {
    $data = Sistema::select('adm_sistema.id as sistema_id', 'adm_sistema.nombre', 'adm_sistema.icono')
      ->join('adm_perfil', 'adm_perfil.sistema_id', '=', 'adm_sistema.id')
      ->join('adm_usuario_perfil', 'adm_usuario_perfil.perfil_id', '=', 'adm_perfil.id')
      ->where("adm_usuario_perfil.usuario_id", "=", $usuario_id)
      ->where("adm_perfil.estado", "=", 1)
      ->orderBy('adm_sistema.nombre')
      ->get();

    return $data;
  }

  public static function listar_porusuariosistema($usuario_id)
  {
    $query = Sistema::select('adm_sistema.id', 'adm_sistema.nombre')
      ->join('adm_usuario_sistema as v2', 'v2.sistema_id', '=', 'adm_sistema.id')
      ->where('v2.usuario_id', $usuario_id) //session()->get('usuario_id')
      ->where('adm_sistema.estado', '1')
      ->orderBy('adm_sistema.nombre')
      ->get();
    return $query;
  }

  public static function listar_porusuariosistemachecked($usuario_id)
  {
    $query = Sistema::select(
      'adm_sistema.id',
      'adm_sistema.nombre',
      DB::raw('ifnull((select "checked" from adm_usuario_sistema where usuario_id=' . $usuario_id . ' and sistema_id=adm_sistema.id),"") as elegido')
    )
      ->join('adm_usuario_sistema as v2', 'v2.sistema_id', '=', 'adm_sistema.id')
      ->where('v2.usuario_id', session()->get('usuario_id'))
      ->orderBy('adm_sistema.nombre')->get();
    return $query;
  }
  public static function listar_sistemasconusuarios($usuario_id)
  {
    $query = DB::table('adm_sistema as v1')
      ->join('adm_usuario_sistema as v2', 'v2.sistema_id', '=', 'v1.id', 'inner')
      ->select('v1.id', 'v1.nombre', 'v1.icono', DB::raw('COUNT(v1.id) as nrousuario'))
      ->where('v1.estado','1')
      ->groupBy('v1.id')
      ->groupBy('v1.nombre')->groupBy('v1.icono')->orderBy('v1.nombre')
      ->get();
    return $query;
  }
}
