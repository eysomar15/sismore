<?php

namespace App\Http\Controllers;

use App\Models\Administracion\Sistema;
use App\Repositories\Administracion\MenuRepositorio;
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
        session()->put(['usuario_id'=>auth()->user()->id]);

        if($sistemas->count()==1)
            return $this->sistema_acceder($sistemas->first()->sistema_id);

        return view('Access',compact(('sistemas')));
    }
    
    public function sistema_acceder($sistema_id)
    { 
        session(['sistema_id'=>$sistema_id]);

        $sistema = Sistema::find($sistema_id);
        session(['sistema_nombre'=>$sistema->nombre]);

        $menuNivel01 = MenuRepositorio::Listar_Nivel01_porUsuario_Sistema(auth()->user()->id,$sistema_id);
        session(['menuNivel01'=>$menuNivel01]);

        $menuNivel02 = MenuRepositorio::Listar_Nivel02_porUsuario_Sistema(auth()->user()->id,$sistema_id);
        session(['menuNivel02'=>$menuNivel02]);

        //return  $menuNivel02;

        switch ($sistema_id ) {
            case(1): return $this->educacion($sistema_id);break;
            case(2): return $this->vivienda($sistema_id);break;
            default: return 'Ruta de sistema no establecida';break;
        }  
    }

    public function vivienda($sistema_id)
    {   
        return view('home',compact('sistema_id'));
    }
    public function educacion($sistema_id)
    { 
        $instituciones_activas =0;
        $instituciones_inactivas =0;
        $titulados_inicial = 0;
        $titulados_primaria = 0;
        $titulados_secundaria = 0;
        $titulados_sum = 0;
        $noTitulados = 0;
        $porcentajeTitulados = 0;
        $porcentajeInstituciones_activas = 0;
        $localesEducativos = 0;
        $locales_tieneInternet = 0;
        $porcentajeLocales_tieneInternet = 0;
     
        $data = DB::select('call edu_pa_dashboard()');

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

            $locales_tieneInternet = $item->locales_tieneInternet;
            $localesEducativos = $item->locales_tieneInternet + $item->locales_no_tieneInternet;
            $porcentajeLocales_tieneInternet = round(($locales_tieneInternet*100/$localesEducativos),2);
        
        }       
         
        return view('home',compact('sistema_id','instituciones_activas','titulados_inicial','titulados_primaria',
                    'titulados_secundaria','titulados_sum','porcentajeTitulados','porcentajeInstituciones_activas',
                    'localesEducativos','locales_tieneInternet','porcentajeLocales_tieneInternet'));  

    }

    public function AEI_tempo()
    {     
        $data = DB::select('call edu_pa_indicadorAEI()');
       
        $titulados_inicial = 0;
        $total_inicial = 0;
        $porcentajeTitulados_inicial = 0;

        $bilingues = 0;

        foreach ($data as $key => $item)
        {
            $titulados_inicial  = $item->titulados_inicial;
            $total_inicial =$item->total_inicial;
            
             $porcentajeTitulados_inicial =  round($titulados_inicial*100/( $total_inicial),2);

             $bilingues =$item->bilingues;
   
           
        }
         
        return view('homeAEI',compact('titulados_inicial','porcentajeTitulados_inicial','bilingues'));  
    }
   
}
