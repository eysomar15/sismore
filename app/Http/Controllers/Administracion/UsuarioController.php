<?php

namespace App\Http\Controllers\Administracion;

use App\Http\Controllers\Controller;
use App\Models\Administracion\Perfil;
use App\Models\Administracion\Sistema;
use App\Models\Administracion\Usuario;
use App\Models\Administracion\UsuarioPerfil;
use App\Models\Administracion\UsuarioTipo;
use App\Repositories\Administracion\SistemaRepositorio;
use App\Repositories\Administracion\UsuarioPerfilRepositorio;
use App\Repositories\Administracion\UsuarioRepositorio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function principal()
    {
        //return filter_var('asdsad@hot', FILTER_VALIDATE_EMAIL);
        $sistemas2 = Sistema::where('estado', '1')->orderBy('nombre')->get();
        return view('administracion.Usuario.Principal', compact('sistemas2'));
    }
    public function Lista_DataTable()
    {
        //$data = UsuarioRepositorio::Listar_porperfil(session('perfil_id'));
        $data = UsuarioRepositorio::Listar_porperfil(session('perfil_id'));
        return  datatables()::of($data)
            ->addColumn('nombrecompleto', '{{$apellidos}}, {{$nombre}}')
            ->editColumn('estado', function ($data) {
                if ($data->estado == 0) return '<span class="badge badge-danger">DESABILITADO</span>';
                else return '<span class="badge badge-success">ACTIVO</span>';
            })
            ->addColumn('sistemas', function ($data) {
                return '';
            })
            ->addColumn('perfiles', function ($data) {
                $perfiles = UsuarioPerfilRepositorio::ListarPerfilSistema($data->id);
                $datos = '';
                if ($perfiles)
                    foreach ($perfiles as $item) {
                        $datos .= '<span class="badge badge-dark"><i class="' . $item->icono . '"></i> SISTEMA ' . $item->sistema . '</span> 
                        <span class="badge badge-secondary"> ' . $item->perfil . '</span><br/>';
                    }
                return $datos;
            })
            ->addColumn('action', function ($data) { // '.auth()->user()->usuario.'
                $acciones = '';

                $acciones = '<a href="#" class="btn btn-info btn-sm" onclick="edit(' . $data->id . ')"  title="MODIFICAR"> <i class="fa fa-pen"></i></a>';
                $acciones .= '&nbsp;<a href="#" class="btn btn-warning btn-sm" onclick="perfil(' . $data->id . ')" title="AGREGAR PERFIL"> <i class="fa fa-list"></i> </a>';

                if ($data->estado == '1') {
                    $acciones .= '&nbsp;<a class="btn btn-sm btn-dark" href="javascript:void(0)" title="Desactivar" onclick="estadoUsuario(' . $data->id . ',' . $data->estado . ')"><i class="fa fa-power-off"></i></a> ';
                } else {
                    $acciones .= '&nbsp;<a class="btn btn-sm btn-default"  title="Activar" onclick="estadoUsuario(' . $data->id . ',' . $data->estado . ')"><i class="fa fa-check"></i></a> ';
                }

                //$acciones = '<a href="Editar/' . $data->id . '"   class="btn btn-info btn-sm" title="MODIFICAR"> <i class="fa fa-pen"></i> </a>';
                //$acciones .= '&nbsp<button type="button" name="delete" id = "' . $data->id . '" class="delete btn btn-danger btn-sm" title="ELIMINAR"> <i class="fa fa-trash"></i>  </button>';
                //$acciones .= '&nbsp<a href="#" class="btn btn-danger btn-sm" onclick="borrar(' . $data->id . ')" title="BORRAR"> <i class="fa fa-trash"></i> </a>';
                return $acciones;
            })
            ->rawColumns(['action', 'nombrecompleto', 'sistemas', 'perfiles', 'estado'])
            ->make(true);
    }
    public function listarSistemasAsignados($usuario_id)
    {
        $data = UsuarioPerfilRepositorio::ListarPerfilSistema($usuario_id);
        //return response()->json($usuario_id);
        return  datatables()::of($data)
            ->addColumn('accion', function ($data) {
                $acciones = '<a href="#" class="btn btn-danger btn-sm" onclick="borrarperfil(' . $data->usuario_id . ',' . $data->perfil_id . ')"  title="ELIMINAR"> <i class="fa fa-trash"></i></a>';
                return $acciones;
            })
            ->rawColumns(['accion'])
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
            //'sistemas[]' => ['required'],
        ]);

        Usuario::create([
            'usuario' => $request['usuario'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'estado' => '1'
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
        if ($request['password'] != '')
            $entidad->password = Hash::make($request['password']);
        $entidad->save();
        return redirect()->route('Usuario.principal')->with('success', 'Registro modificado correctamente' . count($request->sistemas));
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
    private function _validateperfil($request)
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if ($request->sistema_id == '') {
            $data['inputerror'][] = 'sistema_id';
            $data['error_string'][] = 'Este campo es obligatorio.';
            $data['status'] = FALSE;
        }

        return $data;
    }
    public function ajax_add_perfil(Request $request)
    {
        $val = $this->_validateperfil($request);
        /* $val['sis'] = $request->sistema_id; */
        if ($val['status'] === FALSE) {
            return response()->json($val);
        }
        $perfiles = Perfil::where('sistema_id', $request->sistema_id)->get();
        foreach ($perfiles as $perfil) {
            if ($request->perfil) {
                if ($request->perfil == $perfil->id) {
                    $usuarioperfil = UsuarioPerfil::where('usuario_id', $request->usuario_id)->where('perfil_id', $perfil->id)->first();
                    if (!$usuarioperfil) UsuarioPerfil::Create(['usuario_id' => $request->usuario_id, 'perfil_id' => $perfil->id]);
                } else UsuarioPerfil::where('usuario_id', $request->usuario_id)->where('perfil_id', $perfil->id)->delete();
            } else UsuarioPerfil::where('usuario_id', $request->usuario_id)->where('perfil_id', $perfil->id)->delete();
        }
        return response()->json(array('status' => true, 'modulos' => $perfiles));
    }
    public function ajax_delete_perfil($usuario_id,$perfil_id) //elimina deverdad *o*
    {
        UsuarioPerfil::where('usuario_id', $usuario_id)->where('perfil_id', $perfil_id)->delete();
        return response()->json(array('status' => true));
    }
    private function _validate($request)
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
        $usuarioxx = Usuario::where('dni', $request->dni)->first();

        if ($request->dni == '') {
            $data['inputerror'][] = 'dni';
            $data['error_string'][] = 'Este campo es obligatorio.';
            $data['status'] = FALSE;
        } else if (strlen($request->dni) < 8) {
            $data['inputerror'][] = 'dni';
            $data['error_string'][] = 'Este campo necesita 8 digitos.';
            $data['status'] = FALSE;
        } else if ($usuarioxx && $request->id == '') {
            $data['inputerror'][] = 'dni';
            $data['error_string'][] = 'DNI ingresado ya existe.';
            $data['status'] = FALSE;
        }

        if ($request->nombre == '') {
            $data['inputerror'][] = 'nombre';
            $data['error_string'][] = 'Este campo es obligatorio.';
            $data['status'] = FALSE;
        }
        if ($request->apellidos == '') {
            $data['inputerror'][] = 'apellidos';
            $data['error_string'][] = 'Este campo es obligatorio.';
            $data['status'] = FALSE;
        }
        if ($request->sexo == '') {
            $data['inputerror'][] = 'sexo';
            $data['error_string'][] = 'Este campo es obligatorio.';
            $data['status'] = FALSE;
        }
        /* if ($request->celular == '') {
            $data['inputerror'][] = 'celular';
            $data['error_string'][] = 'Este campo es obligatorio.';
            $data['status'] = FALSE;
        } */
        /* if ($request->entidad == '') {
            $data['inputerror'][] = 'entidad';
            $data['error_string'][] = 'Este campo es obligatorio.';
            $data['status'] = FALSE;
        }
        if ($request->oficina == '') {
            $data['inputerror'][] = 'oficina';
            $data['error_string'][] = 'Este campo es obligatorio.';
            $data['status'] = FALSE;
        }
        if ($request->cargo == '') {
            $data['inputerror'][] = 'cargo';
            $data['error_string'][] = 'Este campo es obligatorio.';
            $data['status'] = FALSE;
        } */
        if ($request->email == '') {
            $data['inputerror'][] = 'email';
            $data['error_string'][] = 'Este campo es obligatorio.';
            $data['status'] = FALSE;
        } else if (filter_var($request->email, FILTER_VALIDATE_EMAIL) == '') {
            $data['inputerror'][] = 'email';
            $data['error_string'][] = 'Correo electronico incorrecto.';
            $data['status'] = FALSE;
        }

        /* if ($request->sistemas == '') {
            $data['inputerror'][] = 'sistemas';
            $data['error_string'][] = 'Es necesario seleccionar 1 sistema como minimo.';
            $data['status'] = FALSE;
        } */
        $usuarioyy = Usuario::where('usuario', $request->usuario)->first();
        if ($request->usuario == '') {
            $data['inputerror'][] = 'usuario';
            $data['error_string'][] = 'Este campo es obligatorio.';
            $data['status'] = FALSE;
        } else if ($usuarioyy && $request->id == '') {
            $data['inputerror'][] = 'usuario';
            $data['error_string'][] = 'USUARIO ingresado ya existe.';
            $data['status'] = FALSE;
        } else if ($usuarioyy && $request->id != $usuarioyy->id) {
            $data['inputerror'][] = 'usuario';
            $data['error_string'][] = 'USUARIO ingresado ya existe.';
            $data['status'] = FALSE;
        }

        if ($request->id == '') {
            if ($request->password == '') {
                $data['inputerror'][] = 'password';
                $data['error_string'][] = 'Este campo es obligatorio.';
                $data['status'] = FALSE;
            }
            if ($request->password2 == '') {
                $data['inputerror'][] = 'password2';
                $data['error_string'][] = 'Este campo es obligatorio.';
                $data['status'] = FALSE;
            }
            if ($request->password != '' && $request->password2 != '') {
                if ($request->password != $request->password2) {
                    $data['inputerror'][] = 'password2';
                    $data['error_string'][] = 'Confirmar Password distinto.';
                    $data['status'] = FALSE;
                }
            }
        } else {
            if ($request->password != '' || $request->password2 != '') {
                if ($request->password != $request->password2) {
                    $data['inputerror'][] = 'password2';
                    $data['error_string'][] = 'Confirmar Password distinto.';
                    $data['status'] = FALSE;
                }
            }
        }
        return $data;
    }
    public function ajax_add(Request $request)
    {
        $val = $this->_validate($request);
        if ($val['status'] === FALSE) {
            return response()->json($val);
        }
        $usuario = Usuario::Create([
            'usuario' => $request->usuario,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'dni' => $request->dni,
            'nombre' => $request->nombre,
            'apellidos' => $request->apellidos,
            'sexo' => $request->sexo,
            'celular' => $request->celular,
            'tipo' => '0',
            //'entidad' => $request->entidad,
            'estado' => '1',
        ]);
        return response()->json(array('status' => true));
    }
    public function ajax_update(Request $request)
    {
        $val = $this->_validate($request);
        if ($val['status'] === FALSE) {
            return response()->json($val);
        }
        $usuario = Usuario::find($request->id);
        $usuario->usuario = $request->usuario;
        $usuario->email = $request->email;
        $usuario->dni = $request->dni;
        $usuario->nombre = $request->nombre;
        $usuario->apellidos = $request->apellidos;
        $usuario->sexo = $request->sexo;
        $usuario->celular = $request->celular;
        $usuario->tipo='0';
        //$usuario->entidad = $request->email;
        if ($request->password != '')
            $usuario->password = Hash::make($request->password);
        $usuario->save();

        return response()->json(array('status' => true/* , 'update' => $request->sistemas */));
    }
    public function ajax_edit($usuario_id)
    {
        $usuario = Usuario::find($usuario_id);
        return response()->json(compact('usuario'));
    }
    public function ajax_delete($usuario_id) //elimina deverdad *o*
    {
        UsuarioPerfil::where('usuario_id', $usuario_id)->delete();
        $usuario = Usuario::find($usuario_id);
        $usuario->delete();
        return response()->json(array('status' => true, 'usuario' => $usuario));
    }
    public function ajax_estadoUsuario($usuario_id)
    {
        $usuario = Usuario::find($usuario_id);
        $usuario->estado = $usuario->estado == 1 ? 0 : 1;
        $usuario->save();
        return response()->json(array('status' => true, 'estado' => $usuario->estado));
    }
}
