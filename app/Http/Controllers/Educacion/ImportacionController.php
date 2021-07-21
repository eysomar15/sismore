<?php

namespace App\Http\Controllers\Educacion;

use App\Http\Controllers\Controller;
use App\Models\Educacion\Importacion;
use App\Repositories\Educacion\ImportacionRepositorio;
use Illuminate\Support\Facades\DB;

class ImportacionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function inicio()
    {
        return view('educacion.Importacion.Inicio');
    }

    public function importacionesLista_DataTable()
    {
        // $padronWebLista = Importacion::select('id','comentario','fechaActualizacion','estado')
        //  ->get();

        $data = ImportacionRepositorio::Listar_Importaciones();

        return  datatables()::of($data)
            ->addColumn('action', function ($data) {
                if ($data->nombre == 'ECE')
                    $acciones = '<a href="ECE/Importar/Aprobar/' . $data->id . '"   class="btn btn-info btn-sm"> Aprobar </a>';
                else
                    $acciones = '<a href="PadronWeb/Aprobar/' . $data->id . '"   class="btn btn-info btn-sm"> Aprobar </a>';
                $acciones .= '&nbsp<button type="button" name="delete" id = "' . $data->id . '" class="delete btn btn-danger btn-sm"> Eliminar </button>';
                return $acciones;
            })
            ->rawColumns(['action'])
            ->make(true);
        // ->toJson();
    }

    public function eliminar($id)
    {

        $entidad = Importacion::find($id);

        $entidad->estado = 'EL';
        $entidad->save();

        return back();
    }

   
}
