<?php

namespace App\Http\Controllers\Educacion;
use App\Http\Controllers\Controller;
use App\Repositories\Educacion\InstEducativaRepositorio;
use Illuminate\Database\Eloquent\Collection;

class InstEducativaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function principal()
    {     
        $lista_resumen_porDistrito = InstEducativaRepositorio::resumen_porDistrito();
        $sumatoria_Provincia  = $this->sumatoria_Provincia($lista_resumen_porDistrito);

        
        //return $sumatoria_Provincia;
        
        return view('educacion.InstEducativa.ReporteDistrito',compact('lista_resumen_porDistrito','sumatoria_Provincia'));  
            
        //return view('educacion.InstEducativa.Principal');     
    }

    // public function reporteDistrito()
    // {
    //     $lista_resumen_porDistrito = InstEducativaRepositorio::resumen_porDistrito();
    //     $sumatoria_Provincia = $this->sumatoria_Provincia($lista_resumen_porDistrito);

        
    //     return view('educacion.InstEducativa.ReporteDistrito',compact('lista_resumen_porDistrito','sumatoria_Provincia'));   
    // }

    public function sumatoria_Provincia($lista_resumen_porDistrito)
    {  
        $lista_provincias = $lista_resumen_porDistrito->unique('provincia');

        $sumatoria_Provincia = [];        
        
        foreach($lista_provincias as $key => $item)
        {
            $suma_activas = 0;
            $suma_inactivas = 0;

            foreach($lista_resumen_porDistrito as $key => $item2)
            {      
                if($item->provincia == $item2->provincia )    
                {
                    $suma_activas += $item2 -> activas;
                    $suma_inactivas += $item2 -> inactivas;
                }
            }

            $sumatoria_Provincia[] = ( [ 'provincia'=> $item->provincia ,'suma_activas'=>  $suma_activas,'suma_inactivas'=>  $suma_inactivas]);
        }

        return $sumatoria_Provincia ;
    }
}
