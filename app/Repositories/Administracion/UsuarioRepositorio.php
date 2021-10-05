<?php

namespace App\Repositories\Administracion;

use App\Models\Administracion\Usuario;

class UsuarioRepositorio
{
     public static function Listar_Usuarios()
     {
         $data = Usuario::select(
                  'adm_usuario.usuario','adm_usuario.email'
              )
             // ->join('adm_usuario', 'adm_usuario.id', '=', 'par_importacion.usuarioId_crea')
             // ->join('par_fuenteimportacion', 'par_fuenteimportacion.id', '=', 'par_importacion.fuenteImportacion_id')
             // ->where("par_importacion.estado", "=", "PE")
             // ->where("par_fuenteimportacion.sistema_id", "=", $sistema_id)
             // ->orderBy('par_importacion.id', 'desc')
             ->get();

         return $data;
      }
}