<?php

namespace App\Http\Controllers\Administracion;

use App\Http\Controllers\Controller;
use App\Models\Administracion\Menu;
use App\Models\Administracion\Sistema;
use App\Models\Administracion\Usuario;
use App\Repositories\Administracion\MenuRepositorio;
use App\Repositories\Administracion\SistemaRepositorio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MenuController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function principal()
    {
        $sistemas = SistemaRepositorio::listar_porusuariosistema(session()->get('usuario_id'));
        return view('administracion.Menu.Principal', compact('sistemas'));
    }

    public function listarDT($sistema_id)
    {
        $data = MenuRepositorio::listarMenu($sistema_id);

        return  datatables()::of($data)
            ->addColumn('action', function ($data) {
                $acciones = '<a href="#" class="btn btn-info btn-sm" onclick="edit(' . $data->id . ')"  title="MODIFICAR"> <i class="fa fa-pen"></i> </a>';
                $acciones .= '&nbsp;<a href="#" class="btn btn-danger btn-sm" onclick="borrar(' . $data->id . ')"  title="ELIMINAR"> <i class="fa fa-trash"></i> </a>';
                return $acciones;
            })
            ->editColumn('icono', '<i class="{{$icono}}"></i>')
            ->editColumn('estado', function ($data) {
                if ($data->estado == 0) return '<span class="badge badge-danger">DESABILITADO</span>';
                else return '<span class="badge badge-success">ACTIVO</span>';
            })
            ->rawColumns(['action', 'icono', 'estado'])
            ->make(true);
    }

    public function cargarGrupo($sistema_id)
    {
        $grupo = MenuRepositorio::listarGrupo($sistema_id);

        return response()->json(compact('grupo'));
    }

    public function ajax_edit($menu_id)
    {
        $menu = Menu::find($menu_id);
        return response()->json(compact('menu'));
    }

    private function _validate($request)
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
        /*if ($request->dependencia == '') {
            $data['inputerror'][] = 'dependencia';
            $data['error_string'][] = 'Este campo es obligatorio.';
            $data['status'] = FALSE;
        }*/
        if ($request->nombre == '') {
            $data['inputerror'][] = 'nombre';
            $data['error_string'][] = 'Este campo es obligatorio.';
            $data['status'] = FALSE;
        }
        if ($request->url == '') {
            $data['inputerror'][] = 'url';
            $data['error_string'][] = 'Este campo es obligatorio.';
            $data['status'] = FALSE;
        }
        if ($request->posicion == '') {
            $data['inputerror'][] = 'posicion';
            $data['error_string'][] = 'Este campo es obligatorio.';
            $data['status'] = FALSE;
        }
        return $data;
    }

    public function ajax_add(Request $request)
    {
        $val = $this->_validate($request);
        if ($val['status'] === FALSE) {
            return response()->json($val);
        }
        $menu = Menu::Create([
            'sistema_id' => $request->sistema_id,
            'dependencia' => $request->dependencia,
            'nombre' => $request->nombre,
            'url' => $request->url,
            'posicion' => $request->posicion,
            'icono' => $request->icono,
            'parametro' => $request->parametro,
            'estado' => '1',
        ]);

        return response()->json(array('status' => true, 'add' => $val/*, 'menu' => $menu*/));
    }
    public function ajax_update(Request $request)
    {
        $val = $this->_validate($request);
        if ($val['status'] === FALSE) {
            return response()->json($val);
        }
        $menu = Menu::find($request->id);
        $menu->sistema_id = $request->sistema_id;
        $menu->dependencia = $request->dependencia;
        $menu->nombre = $request->nombre;
        $menu->url = $request->url;
        $menu->posicion = $request->posicion;
        $menu->icono = $request->icono;
        $menu->parametro = $request->parametro;
        //$menu->estado = $request->estado;
        $menu->save();

        return response()->json(array('status' => true, 'update' => $request, 'menu' => $menu));
    }
    public function ajax_delete($menu_id)
    {
        $menu = Menu::find($menu_id);
        $menu->delete();
        return response()->json(array('status' => true, 'menu' => $menu));
    }







    /*


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
    }*/
}
