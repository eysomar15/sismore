<?php

namespace App\Http\Controllers;

use App\Repositories\Administracion\SistemaRepositorio;
use Illuminate\Http\Request;

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
        return view('home',compact(('sistema_id')));  
    }
   
}
