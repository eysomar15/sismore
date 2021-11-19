<?php

namespace App\Repositories\Administracion;

use App\Models\Administracion\Usuario;
use App\Models\Administracion\UsuarioSistema;
use Illuminate\Support\Facades\DB;
use PHPUnit\TextUI\XmlConfiguration\Group;

class UsuarioRepositorio
{
    public static function Listar_Usuarios()
    {
        /*$data = Usuario::select('adm_usuario.id', 'adm_usuario.usuario', 'adm_usuario.email')
            ->join('adm_usuario_sistema as v2', 'v2.usuario_id', '=', 'adm_usuario.id', 'left')
            ->where("adm_usuario.estado", "=", 1)
            ->groupBy('adm_usuario.id', 'adm_usuario.usuario', 'adm_usuario.email')
            // ->join('adm_usuario', 'adm_usuario.id', '=', 'par_importacion.usuarioId_crea')
            // ->join('par_fuenteimportacion', 'par_fuenteimportacion.id', '=', 'par_importacion.fuenteImportacion_id')
            // ->where("par_fuenteimportacion.sistema_id", "=", $sistema_id)
            // ->orderBy('par_importacion.id', 'desc')
            ->get();*/

        /* $data = Usuario::select('adm_usuario.id', 'adm_usuario.usuario', 'adm_usuario.email', 'adm_usuario.nombre', 'adm_usuario.apellidos', 'adm_usuario.dni', 'adm_usuario.celular')
            ->join('adm_usuario_sistema as v2', 'v2.usuario_id', '=', 'adm_usuario.id', 'left')
            ->where("adm_usuario.estado", "=", 1)
            ->where(function ($q) {
                $q->whereIn("v2.sistema_id", UsuarioSistema::select('sistema_id')->where('usuario_id', session()->get('usuario_id'))->get())
                    ->orWhere(DB::raw('v2.sistemas_id is null'));//DB::raw('v2.sistemas_id is null')
            })
            ->groupBy('adm_usuario.id', 'adm_usuario.usuario', 'adm_usuario.email', 'adm_usuario.nombre', 'adm_usuario.apellidos', 'adm_usuario.dni', 'adm_usuario.celular')
            ->get(); */
        $data = DB::table(DB::raw('(select DISTINCT v1.id, v1.usuario, v1.email, v1.nombre, v1.apellidos, v1.dni, v1.celular,v1.estado,v1.usuariotipo_id 
            from adm_usuario as v1 
            left join adm_usuario_sistema as v2 on v2.usuario_id = v1.id 
            where ( 
                v2.sistema_id in (select sistema_id from adm_usuario_sistema where usuario_id=' . session()->get('usuario_id') . ') 
                OR 
                v2.sistema_id is null )
            order by v1.id desc) as usuario'))->get();/* v1.estado = 1  and  */

        return $data;
    }
}
