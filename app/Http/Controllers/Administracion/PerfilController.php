<?php

namespace App\Http\Controllers\Administracion;

use App\Http\Controllers\Controller;
use App\Models\Administracion\Menu;
use App\Models\Administracion\Menuperfil;
use App\Models\Administracion\Perfil;
use App\Models\Administracion\Sistema;
use App\Repositories\Administracion\MenuRepositorio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PerfilController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function principal()
    {
        $sistemas = Sistema::where('estado', '1')->orderBy('nombre')->get();
        return view('administracion.Perfil.Principal', compact('sistemas'));
    }

    public function listarDT($sistema_id)
    {
        $data = Perfil::where('sistema_id', $sistema_id)->get();

        return  datatables()::of($data)
            ->addColumn('action', function ($data) {
                $acciones = '<a href="#" class="btn btn-info btn-sm" onclick="edit(' . $data->id . ')"> <i class="fa fa-pen"></i> </a>';
                $acciones .= '&nbsp;<a href="#" class="btn btn-warning btn-sm" onclick="menu(' . $data->id . ')"> <i class="fa fa-list-ul"></i> </a>';
                $acciones .= '&nbsp;<a href="#" class="btn btn-danger btn-sm" onclick="borrar(' . $data->id . ')"> <i class="fa fa-trash"></i> </a>';
                return $acciones;
            })
            ->editColumn('estado', function ($data) {
                if ($data->estado == 0) return '<span class="badge badge-danger">DESABILITADO</span>';
                else return '<span class="badge badge-success">ACTIVO</span>';
            })
            ->rawColumns(['action','estado'])
            ->make(true);
    }

    public function ajax_edit($perfil_id)
    {
        $menu = Perfil::find($perfil_id);

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
        if ($request->nombre == '') {
            $data['inputerror'][] = 'nombre';
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
        $perfil = Perfil::Create([
            'sistema_id' => $request->sistema_id,
            'nombre' => $request->nombre,
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
        $perfil = Perfil::find($request->id);
        $perfil->sistema_id = $request->sistema_id;
        $perfil->nombre = $request->nombre;
        $perfil->save();

        return response()->json(array('status' => true, 'update' => $request, 'perfil' => $perfil));
    }
    public function ajax_delete($perfil_id)
    {
        $perfil = Perfil::find($perfil_id);
        $perfil->delete();
        return response()->json(array('status' => true, 'perfil' => $perfil));
    }

    public function listarmenu($perfil_id, $sistema_id)
    {
        $datas = MenuRepositorio::getMenu($sistema_id);
        $ticket = '';
        $ticket .= '<input type="hidden" class="form-control" name="perfil" id="perfil" value="' . $perfil_id . '">';
        $ticket .= '<ul class="checktree">';
        foreach ($datas as $value) {
            $perfilmenu = Menuperfil::where('perfil_id', $perfil_id)->where('menu_id', $value->id)->first();
            $menus = Menu::where('dependencia', $value->id)->get();
            $ticket .= '<li><label>';
            $ticket .= '<input id="menu" name="menu[]" type="checkbox" value="' . $value->id . '" ' . (isset($perfilmenu->id) ? 'checked' : '') . '> ' . $value->nombre;
            $ticket .= '</label><ul>';
            foreach ($menus as $menu) {
                $perfilmenus = Menuperfil::where('perfil_id', $perfil_id)->where('menu_id', $value->id)->first();
                $ticket .= '<li><label>';
                $ticket .= '<input id="menu" name="menu[]" type="checkbox" value="' . $menu->id . '" ' . (isset($perfilmenus->id) ? 'checked' : '') . '> ' . $menu->nombre;
                $ticket .= '</label></li>';
            }
            $ticket .= '</ul></li>';
        }
        $ticket .= '</ul>';
        return  $ticket;
    }
    public function ajax_add_menu(Request $request)
    {
        $modulos = Menu::where('sistema_id',$request->msistema_id)->get();
        foreach ($modulos as $modulo) {
            if ($request->menu) {
                $encontrado = false;
                foreach ($request->menu as $menu) {
                    if ($menu == $modulo->id) {
                        $encontrado = true;
                        $menuperfil = Menuperfil::where('perfil_id',$request->perfil)->where('menu_id',$menu)->first();
                        if (!$menuperfil) {
                            $menus = Menu::find($menu);
                            $data['perfil_id'] =$request->perfil;
                            $data['menu_id'] = $menu;
                            if ($menus->dependencia > 0) {
                                $menuperfils = Menuperfil::where('perfil_id',$request->perfil)->where('menu_id',$menu)->first();
                                if ($menuperfils) {
                                } else {
                                    $prince['perfil_id'] = $request->perfil;
                                    $prince['menu_id'] = $menus->id;
                                    Menuperfil::Create($prince);
                                }
                            } else {
                            }
                            Menuperfil::Create($data);
                        }
                        break;
                    }
                }
                if ($encontrado == false) {
                    Menuperfil::where('perfil_id',$request->perfil)->where('menu_id',$modulo->id)->delete();
                }
            } else {
                Menuperfil::where('perfil_id',$request->perfil)->where('menu_id',$modulo->id)->delete();
            }
        }
        return response()->json(array('status' => true, 'modulos' => $menuperfil,'sis'=>$request->perfil));
    }
}
