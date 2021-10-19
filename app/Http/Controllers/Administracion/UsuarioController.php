<?php

namespace App\Http\Controllers\Administracion;
use App\Http\Controllers\Controller;
use App\Models\Administracion\Usuario;
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
        return view('administracion.Usuario.Principal'); 
    }

    public function Lista_DataTable()
    {
        $data = UsuarioRepositorio::Listar_Usuarios();
       
        return  datatables()::of($data)
            ->addColumn('action', function ($data) {
               
                $acciones = '<a href="Editar/' .$data->id. '"   class="btn btn-info btn-sm"> Actualizar </a>';
                $acciones .= '&nbsp<button type="button" name="delete" id = "' . $data->id . '" class="delete btn btn-danger btn-sm"> Eliminar </button>';
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

        return redirect()->route('Usuario.principal')->with('success','Registro creado correctamente'); 
    }

    public function editar(Usuario $usuario)
    {     
       
       return view('administracion.Usuario.Editar',compact('usuario'));
    }

    public function actualizar(Request $request,$id)
    { 
        $entidad = Usuario::find($id);

        $entidad->usuario = $request['usuario'] ;
        $entidad->email = $request['email'] ;
        $entidad->password = Hash::make($request['password']);
        $entidad->save();

       return redirect()->route('Usuario.principal')->with('success','Registro modificado correctamente'); 
    }

    public function eliminar($id)
    {
        $entidad = Usuario::find($id);

        $entidad->estado = 0;
        $entidad->save();

        return back();
    }
}