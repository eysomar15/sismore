<?php

namespace App\Http\Controllers\Administracion;

use App\Http\Controllers\Controller;
use App\Models\Administracion\Sistema;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SistemaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function principal()
    {
        return view('administracion.Sistema.Principal');
    }

    public function listarDT()
    {
        $data = Sistema::orderBy('id','desc')->get();

        return  datatables()::of($data)
            ->addColumn('action', function ($data) {
                $acciones = '<a href="#" class="btn btn-info btn-sm" onclick="edit(' . $data->id . ')"> <i class="fa fa-pen"></i> </a>';
                $acciones .= '&nbsp;<a href="#" class="btn btn-danger btn-sm" onclick="borrar(' . $data->id . ')"> <i class="fa fa-trash"></i> </a>';
                return $acciones;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function ajax_edit($sistema_id)
    {
        $sistema = Sistema::find($sistema_id);

        return response()->json(compact('sistema'));
    }

    private function _validate($request)
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

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
        $perfil = Sistema::Create([
            'nombre' => $request->nombre,
            'icono' => $request->icono,
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
        $sistema = Sistema::find($request->id);
        $sistema->nombre = $request->nombre;
        $sistema->icono = $request->icono;
        $sistema->save();

        return response()->json(array('status' => true, 'update' => $request));
    }
    public function ajax_delete($sistema_id)
    {
        $sistema = Sistema::find($sistema_id);
        $sistema->delete();
        return response()->json(array('status' => true, 'sistema' => $sistema));
    }
}
