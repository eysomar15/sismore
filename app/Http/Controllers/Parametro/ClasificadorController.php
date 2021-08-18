<?php

namespace App\Http\Controllers\Parametro;

use App\Http\Controllers\Controller;
use App\Repositories\Parametro\ClasificadorRepositorio;


class ClasificadorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function menu_porClase($clase_codigo)
    {  
        $listaIndicadores = ClasificadorRepositorio::Listar_menu_porClasificador($clase_codigo,session('sistema_id'));
        $listaNivel3_deClasificador = ClasificadorRepositorio::Listar_nivel3_porClasificador($clase_codigo,session('sistema_id'));

        $nombre_niv1 ='';
        $nombre_niv2 ='';

        if(sizeof($listaIndicadores)>0)
        {
            $nombre_niv1 = $listaIndicadores->first()->nombre_niv1;
            $nombre_niv2 = $listaIndicadores->first()->nombre_niv2;       
        } 
        
        return  view('parametro.MenuIndicador',compact('nombre_niv1','nombre_niv2','listaIndicadores','listaNivel3_deClasificador','clase_codigo'));
    } 
}
