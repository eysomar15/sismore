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
        $data = SistemaRepositorio::Listar_porUsuario(auth()->user()->id);

        if($data->count()==1)
            return view('home');

        return $data->count();
        //return view('home');
    }
   
}
