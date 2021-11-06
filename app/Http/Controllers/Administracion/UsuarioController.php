<?php

namespace App\Http\Controllers\Administracion;

use App\Http\Controllers\Controller;
use App\Models\Administracion\Perfil;
use App\Models\Administracion\Sistema;
use App\Models\Administracion\Usuario;
use App\Models\Administracion\UsuarioPerfil;
use App\Repositories\Administracion\UsuarioRepositorio;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function principal()
    {
        $sistemas = Sistema::orderBy('nombre', 'asc')->get();
        return view('administracion.Usuario.Principal', compact('sistemas'));
    }
    public function Lista_DataTable()
    {
        $data = UsuarioRepositorio::Listar_Usuarios();

        return  datatables()::of($data)
            ->addColumn('action', function ($data) {
                $acciones = '<a href="Editar/' . $data->id . '"   class="btn btn-info btn-sm" title="MODIFICAR"> <i class="fa fa-pen"></i> </a>';
                $acciones .= '&nbsp<a href="#" class="btn btn-warning btn-sm" onclick="perfil(' . $data->id . ')" title="AGREGAR PERFIL"> <i class="fa fa-list"></i> </a>';
                $acciones .= '&nbsp<button type="button" name="delete" id = "' . $data->id . '" class="delete btn btn-danger btn-sm" title="ELIMINAR"> <i class="fa fa-trash"></i>  </button>';
                return $acciones;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    public function registrar()
    {
        return view('administracion.Usuario.Registrar');
    }
    public function guardar(Request $request)
    {
        $request->validate([
            'usuario' => ['required', 'string', 'max:255', 'unique:adm_usuario'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:adm_usuario'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        Usuario::create([
            'usuario' => $request['usuario'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);



        return redirect()->route('Usuario.principal')->with('success', 'Registro creado correctamente');
    }
    public function editar(Usuario $usuario)
    {

        return view('administracion.Usuario.Editar', compact('usuario'));
    }
    public function actualizar(Request $request, $id)
    {
        $entidad = Usuario::find($id);

        $entidad->usuario = $request['usuario'];
        $entidad->email = $request['email'];
        $entidad->password = Hash::make($request['password']);
        $entidad->save();

        return redirect()->route('Usuario.principal')->with('success', 'Registro modificado correctamente');
    }
    public function eliminar($id)
    {
        $entidad = Usuario::find($id);

        $entidad->estado = 0;
        $entidad->save();

        return back();
    }

    public function cargarPerfil($sistema_id, $usuario_id)
    {
        $perfil = Perfil::where('sistema_id', $sistema_id)->where('estado', '1')->select('id', 'nombre')->get();
        $usuarioperfil = UsuarioPerfil::where('adm_usuario_perfil.usuario_id', $usuario_id)
            ->select('adm_usuario_perfil.perfil_id')
            ->join('adm_perfil as v2', 'v2.id', '=', 'adm_usuario_perfil.perfil_id')
            ->where('v2.sistema_id', $sistema_id)
            ->get();
        return response()->json(compact('perfil', 'usuarioperfil'));
    }
    public function ajax_add_perfil(Request $request)
    {
        $perfiles = Perfil::where('sistema_id', $request->sistema_id)->get();
        foreach ($perfiles as $perfil) {
            if ($request->perfil) {
                $seleccionado = FALSE;
                foreach ($request->perfil as $li) {
                    if ($li == $perfil->id) {
                        $seleccionado = TRUE;
                        $usuarioperfil = UsuarioPerfil::where('usuario_id', $request->usuario_id)->where('perfil_id', $perfil->id)->first();
                        if (!$usuarioperfil) {
                            UsuarioPerfil::Create(['usuario_id' => $request->usuario_id, 'perfil_id' => $perfil->id]);
                        }
                        break;
                    }
                }
                if ($seleccionado == FALSE) {
                    UsuarioPerfil::where('usuario_id', $request->usuario_id)->where('perfil_id', $perfil->id)->delete();
                }
            } else {
                UsuarioPerfil::where('usuario_id', $request->usuario_id)->where('perfil_id', $perfil->id)->delete();
            }
        } 
        return response()->json(array('status' => true, 'modulos' => $perfiles));
    }
}
