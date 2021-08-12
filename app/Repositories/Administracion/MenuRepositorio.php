<?php

namespace App\Repositories\Administracion;

use App\Models\Administracion\Menu;

class MenuRepositorio
{
  public static function Listar_Nivel01_porUsuario_Sistema($usuario_id,$sistema_id)
  { 
      $data = Menu::select('adm_menu.id','adm_menu.dependencia','adm_menu.nombre','adm_menu.url','adm_menu.posicion','adm_menu.icono')
              ->join('adm_menu_perfil as menPer', 'adm_menu.id', '=', 'menPer.menu_id')
              ->join('adm_perfil as per', 'menPer.perfil_id', '=', 'per.id')
              ->join('adm_usuario_perfil as usuPer', 'per.id', '=', 'usuPer.perfil_id')
              ->where("usuPer.usuario_id", "=",$usuario_id )
              ->where("adm_menu.sistema_id", "=",$sistema_id )
              ->where("adm_menu.estado", "=", 1)
              ->where("adm_menu.dependencia", "=", null)
              ->orderBy('adm_menu.dependencia','asc')
              ->orderBy('adm_menu.posicion','asc')
              ->get();

      return $data;
  }

  public static function Listar_Nivel02_porUsuario_Sistema($usuario_id,$sistema_id)
  { 
      $data = Menu::select('adm_menu.id','adm_menu.dependencia','adm_menu.nombre','adm_menu.url','adm_menu.posicion','adm_menu.icono')
              ->join('adm_menu_perfil as menPer', 'adm_menu.id', '=', 'menPer.menu_id')
              ->join('adm_perfil as per', 'menPer.perfil_id', '=', 'per.id')
              ->join('adm_usuario_perfil as usuPer', 'per.id', '=', 'usuPer.perfil_id')
              ->where("usuPer.usuario_id", "=",$usuario_id )
              ->where("adm_menu.sistema_id", "=",$sistema_id )
              ->where("adm_menu.estado", "=", 1)
              ->where("adm_menu.dependencia", "!=", null)
              ->orderBy('adm_menu.dependencia','asc')
              ->orderBy('adm_menu.posicion','asc')
              ->get();

      return $data;
  }
}
