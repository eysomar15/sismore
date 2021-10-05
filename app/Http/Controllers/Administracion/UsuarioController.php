<?php

namespace App\Http\Controllers\Administracion;
use App\Http\Controllers\Controller;
use App\Repositories\Administracion\UsuarioRepositorio;

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
        // $padronWebLista = Importacion::select('id','comentario','fechaActualizacion','estado')
        //  ->get();

        // $data = ImportacionRepositorio::Listar_Importaciones(session('sistema_id'));
       
        return  datatables()::of($data)
            ->addColumn('action', function ($data) {

                // switch ($data->codigo) {
                //     case('COD01'):  $acciones = '<a href="PadronWeb/Aprobar/' . $data->id . '"   class="btn btn-info btn-sm"> Aprobar </a>';break;
                //     case('COD02'): $acciones = '<a href="CuadroAsigPersonal/Aprobar/' . $data->id . '"   class="btn btn-info btn-sm"> Aprobar </a>';break;
                //     case('COD03'): $acciones = '<a href="ECE/Importar/Aprobar/' . $data->id . '"   class="btn btn-info btn-sm"> Aprobar </a>';break;                    
                //     case('COD06'): $acciones = '<a href="Censo/Aprobar/' . $data->id . '"   class="btn btn-info btn-sm"> Aprobar </a>';break; 
                //     case('COD07'): $acciones = '<a href="Datass/Aprobar/' . $data->id . '"   class="btn btn-info btn-sm"> Aprobar </a>';break; 
                //     case('COD08'): $acciones = '<a href="Matricula/Aprobar/' . $data->id . '"   class="btn btn-info btn-sm"> Aprobar </a>';break; 
                //     case('COD09'): $acciones = '<a href="Tableta/Aprobar/' . $data->id . '"   class="btn btn-info btn-sm"> Aprobar </a>';break;

                //     default: $acciones = '<a href="PadronWeb/AprobarNN/' . $data->id . '"   class="btn btn-info btn-sm"> Aprobar </a>';break;
                // }                
                $acciones = '<a href="Tableta/Aprobar/' . $data->id . '"   class="btn btn-info btn-sm"> Actualizar </a>';
                $acciones .= '&nbsp<button type="button" name="delete" id = "' . $data->id . '" class="delete btn btn-danger btn-sm"> Eliminar </button>';
                return $acciones;
            })
            ->rawColumns(['action'])
            ->make(true);
        // ->toJson();
    }
}