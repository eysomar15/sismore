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

        $total_instituciones =0;

        foreach ($data as $key => $item)
        {
            $total_instituciones  = $item->total_instituciones;
        }
         
        return view('home',compact('sistema_id','total_instituciones'));  
    }

    public function dashboard()
    {      
        $data = DB::select('call edu_pa_dashboard()');

        $total_instituciones =0;

        foreach ($data as $key => $item)
        {
            $total_instituciones  = $item->total_instituciones;
        }
        


        return view('home',compact(('total_instituciones')));  
    }

    
   
}
