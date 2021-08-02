<?php

namespace App\Http\Controllers;

use App\Repositories\Administracion\SistemaRepositorio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $sistemas = SistemaRepositorio::Listar_porUsuario(auth()->user()->id);

        if($sistemas->count()==1)
            return $this->sistema_acceder(1);

        return view('Access',compact(('sistemas')));
    }
    
    public function sistema_acceder($sistema_id)
    {     
        $data = DB::select('call edu_pa_dashboard()');

        $instituciones_activas =0;
        $instituciones_inactivas =0;
        $titulados_inicial = 0;
        $titulados_primaria = 0;
        $titulados_secundaria = 0;
        $titulados_sum = 0;
        $noTitulados = 0;
        $porcentajeTitulados = 0;
        $porcentajeInstituciones_activas = 0;

        foreach ($data as $key => $item)
        {
            $instituciones_activas  = $item->instituciones_activas;
            $instituciones_inactivas  = $item->instituciones_inactivas;
            
            $titulados_inicial = $item->titulados_inicial;
            $titulados_primaria = $item->titulados_primaria;
            $titulados_secundaria = $item->titulados_secundaria;
            $titulados_sum = $titulados_inicial + $titulados_primaria + $titulados_secundaria;
            $noTitulados = $item->noTitulados;

            $porcentajeTitulados = round(($titulados_sum*100/($titulados_sum + $noTitulados)),2);

            $porcentajeInstituciones_activas = round(($instituciones_activas*100/($instituciones_activas + $instituciones_inactivas)),2);
        }
         
        return view('home',compact('sistema_id','instituciones_activas','titulados_inicial','titulados_primaria',
        'titulados_secundaria','titulados_sum','porcentajeTitulados','porcentajeInstituciones_activas'));  
    }
   
}
