<?php

namespace App\Http\Controllers;

use App\Models\Administracion\Sistema;
use App\Models\Administracion\UsuarioPerfil;
use App\Models\Educacion\CentroPoblado;
use App\Models\Educacion\Importacion;
use App\Models\Vivienda\CentroPobladoDatass;
use App\Repositories\Administracion\MenuRepositorio;
use App\Repositories\Administracion\SistemaRepositorio;
use App\Repositories\Administracion\UsuarioPerfilRepositorio;
use App\Repositories\Educacion\CuadroAsigPersonalRepositorio;
use App\Repositories\Educacion\InstEducativaRepositorio;
use App\Repositories\Educacion\MatriculaRepositorio;
use App\Repositories\Educacion\TabletaRepositorio;
use App\Repositories\Vivienda\CentroPobladoDatassRepositorio;
use App\Repositories\Vivienda\CentroPobladoRepositotio;
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
        $usuper = UsuarioPerfilRepositorio::get_porusuariosistema(auth()->user()->id, '4');
        session()->put(['usuario_id' => auth()->user()->id]);
        session()->put(['total_sistema' => $sistemas->count()]);
        session()->put(['perfil_id' => $usuper ? $usuper->perfil_id : 0]);

        if ($sistemas->count() == 1)
            return $this->sistema_acceder($sistemas->first()->sistema_id);

        return view('Access', compact(('sistemas')));
    }

    public function sistema_acceder($sistema_id)
    {
        // session()->forget('sistema_id');
        // session()->forget('sistema_nombre');
        // session()->forget('menuNivel01');
        // session()->forget('menuNivel02');

        session(['sistema_id' => $sistema_id]);

        $sistema = Sistema::find($sistema_id);
        session(['sistema_nombre' => $sistema->nombre]);

        $menuNivel01 = MenuRepositorio::Listar_Nivel01_porUsuario_Sistema(auth()->user()->id, $sistema_id);
        session(['menuNivel01' => $menuNivel01]);

        $menuNivel02 = MenuRepositorio::Listar_Nivel02_porUsuario_Sistema(auth()->user()->id, $sistema_id);
        session(['menuNivel02' => $menuNivel02]);

        switch ($sistema_id) {
            case (1):
                return $this->educacion($sistema_id);
                break;
            case (2):
                return $this->vivienda($sistema_id);
                break;
            case (4):
                return $this->administracion($sistema_id);
                break;
            default:
                return 'Ruta de sistema no establecida';
                break;
        }
    }

    public function administracion($sistema_id)
    {
        $sistemas = SistemaRepositorio::listar_sistemasconusuarios(1);
        //return $sistemas;
        return view('home', compact('sistema_id', 'sistemas'));
    }

    public function vivienda($sistema_id)
    {
        //$sistemas = SistemaRepositorio::listar_sistemasconusuarios(1);return $sistemas;
        $imp = Importacion::where('fuenteimportacion_id', '7')->select(DB::raw('max(id) as maximo'))->first();
        $data[] = ['name' => 'Centro Poblado', 'y' => CentroPobladoDatassRepositorio::listar_centroPoblado($imp->maximo)->conteo];
        $data[] = ['name' => 'con sistema de agua', 'y' => CentroPobladoRepositotio::ListarSINO_porIndicador(0, 0, 20, $imp->maximo)['indicador'][0]->y];
        $data[] = ['name' => 'con disposición de excretas', 'y' => CentroPobladoRepositotio::ListarSINO_porIndicador(0, 0, 23, $imp->maximo)['indicador2'][0]->y];
        $data[] = ['name' => 'con sistema de cloración', 'y' => CentroPobladoRepositotio::ListarSINO_porIndicador(0, 0, 21, $imp->maximo)['indicador2'][0]->y];

        $query = CentroPobladoDatass::where('importacion_id', $imp->maximo)->select(
            DB::raw('sum(total_poblacion) as poblacion'),
            DB::raw('sum(poblacion_servicio_agua) as con_agua'),
            DB::raw('sum(total_viviendas) as viviendas'),
            DB::raw('sum(viviendas_conexion) as con_conexion')
        )->first();
        $data2[] = ['name' => 'población', 'y' => $query->poblacion];/* total_poblacion */
        $data2[] = ['name' => 'poblacion con cobertura', 'y' => $query->con_agua];/* poblacion_con_servicio_agua */
        $data2[] = ['name' => 'viviendas', 'y' => $query->con_conexion];/* total_viviendas */
        $data2[] = ['name' => 'viviendas con conexion', 'y' => $query->con_conexion];/* viviendas_con_conexion */

        $grafica[] = CentroPobladoRepositotio::listarporprovincias($imp->maximo);/* total de centro poblado por provincia */
        $grafica[] = CentroPobladoRepositotio::listarporprovinciasconsistemaagua($imp->maximo);/* total de centro poblado con servicio de agua(sistema_agua) */

        $grafica2[] = CentroPobladoRepositotio::ListarSINO_porIndicador(0, 0, 20, $imp->maximo)['indicador'];
        $grafica2[] = CentroPobladoRepositotio::ListarSINO_porIndicador(0, 0, 23, $imp->maximo)['indicador2'];
        /* return $grafica2; */
        return view('home', compact('sistema_id', 'data', 'data2', 'grafica', 'grafica2'));
    }

    public function educacion($sistema_id)
    {
        $instituciones_activas = InstEducativaRepositorio::cantidad_activas_inactivas()->first()->activas;

        $docentes_inicial = CuadroAsigPersonalRepositorio::docentes_EBR()->first()->inicial;
        $docentes_primaria = CuadroAsigPersonalRepositorio::docentes_EBR()->first()->primaria;
        $docentes_Secundaria = CuadroAsigPersonalRepositorio::docentes_EBR()->first()->Secundaria;


        $matricula_id=0;
        $matricula_mas_actual = MatriculaRepositorio::matricula_mas_actual();

        if($matricula_mas_actual!=null)
        {
            $matricula_id =$matricula_mas_actual->first()->id;
        }

        $lista_total_matricula_EBR = MatriculaRepositorio::total_matricula_EBR($matricula_id,'whereNotIn',0);
        $lista_total_matricula_EBR_nivelEducativo = MatriculaRepositorio::total_matricula_EBR_porNivelEducativo($matricula_id);
      
        $totalMatriculados = 0;
        foreach($lista_total_matricula_EBR as $item)
        {
            $totalMatriculados+= ($item->hombres + $item->mujeres);
        }

        $matriculadosInicial= $lista_total_matricula_EBR_nivelEducativo->first()->inicial;
        $matriculadosPrimaria=$lista_total_matricula_EBR_nivelEducativo->first()->primaria;;
        $matriculadosSecundaria=$lista_total_matricula_EBR_nivelEducativo->first()->secundaria;;

        
        return  view('home', compact('instituciones_activas','docentes_inicial','docentes_primaria','docentes_Secundaria',
        'totalMatriculados', 'matriculadosInicial','matriculadosPrimaria','matriculadosSecundaria'));
    }
    public function educacionx($sistema_id)
    {
        $instituciones_activas = 0;
        $instituciones_inactivas = 0;
        $instituciones_total = 0;

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

        foreach ($data as $key => $item) {
            $instituciones_activas  = $item->instituciones_activas;
            $instituciones_inactivas  = $item->instituciones_inactivas;

            $instituciones_total = $instituciones_activas + $instituciones_inactivas;

            $titulados_inicial = $item->titulados_inicial;
            $titulados_primaria = $item->titulados_primaria;
            $titulados_secundaria = $item->titulados_secundaria;
            $titulados_sum = $titulados_inicial + $titulados_primaria + $titulados_secundaria;
            $noTitulados = $item->noTitulados;

            $porcentajeTitulados = round(($titulados_sum * 100 / ($titulados_sum + $noTitulados)), 2);

            $porcentajeInstituciones_activas = round(($instituciones_activas * 100 / ($instituciones_activas + $instituciones_inactivas)), 2);

            $locales_tieneInternet = $item->locales_tieneInternet;
            $localesEducativos = $item->locales_tieneInternet + $item->locales_no_tieneInternet;
            $porcentajeLocales_tieneInternet = round(($locales_tieneInternet * 100 / $localesEducativos), 2);
        }

        $par_medidor1_max =  $instituciones_total;

        $tabletas_ultimaActualizacion = TabletaRepositorio::tabletas_ultimaActualizacion()->first();

        $fechaTableta = $tabletas_ultimaActualizacion->fechaActualizacion;

        //{{number_format($sum_cero_nivel_hombre,0)}} 

        $par_medidor1_max = 100;
        $par_medidor1_data =  number_format((($tabletas_ultimaActualizacion->total_Recepcionadas * 100) / $tabletas_ultimaActualizacion->total_aDistribuir), 2);

        $par_medidor2_max = 100;
        $par_medidor2_data =  number_format((($tabletas_ultimaActualizacion->total_Asignadas * 100) / $tabletas_ultimaActualizacion->total_aDistribuir), 2);


        return view('home', compact(
            'par_medidor1_max',
            'par_medidor1_data',
            'par_medidor2_max',
            'par_medidor2_data',
            'sistema_id',
            'instituciones_activas',
            'titulados_inicial',
            'titulados_primaria',
            'titulados_secundaria',
            'titulados_sum',
            'porcentajeTitulados',
            'porcentajeInstituciones_activas',
            'localesEducativos',
            'locales_tieneInternet',
            'porcentajeLocales_tieneInternet'
        ));
    }

    public function AEI_tempo()
    {
        $data = DB::select('call edu_pa_indicadorAEI()');

        $titulados_inicial = 0;
        $total_inicial = 0;
        $porcentajeTitulados_inicial = 0;

        $bilingues = 0;

        foreach ($data as $key => $item) {
            $titulados_inicial  = $item->titulados_inicial;
            $total_inicial = $item->total_inicial;

            $porcentajeTitulados_inicial =  round($titulados_inicial * 100 / ($total_inicial), 2);

            $bilingues = $item->bilingues;
        }

        return view('homeAEI', compact('titulados_inicial', 'porcentajeTitulados_inicial', 'bilingues'));
    }
}
