<?php

namespace App\Repositories\Educacion;

use App\Models\Educacion\Censo;
use App\Models\Educacion\CensoResultado;
use App\Models\Ubigeo;
use Illuminate\Support\Facades\DB;

class CensoRepositorio
{

    public static function Listar_Por_Importacion_id($importacion_id)
    {
        $data = CensoResultado::select(
            'codLocal',
            'codigosModulares',
            'nombreInstitucion',
            'codigoGestion',
            'descripcionGestion',
            'codigoOrganoInter',
            'nombreDre_Ugel',
            'codigoUbigeo',
            'Departamento',
            'Provincia',
            'Distrito',
            'centoPoblado',
            'direccion',
            'areaGeo',
            'estadoCenso',
            'totalAulas',
            'aulasBuenas',
            'aulasRegulares',
            'aulasMalas',
            'noPuedePrecisarEstadoAulas',
            'elLocalEs',
            'propietarioLocal',
            'cuenta_con_itse',
            'plan_contingencia',
            'plan_desastre',
            'plandesastre_act',
            'compuEscri_operativos',
            'compuEscri_inoperativos',
            'compuPorta_operativos',
            'compuPorta_inoperativos',
            'lapto_operativos',
            'lapto_inoperativos',
            'tieneInternet',
            'tipoConexion',
            'fuenteEnergiaElectrica',
            'empresaEnergiaElect',
            'tieneEnergiaElectTodoDia',
            'fuenteAgua',
            'empresaAgua',
            'tieneAguaPotTodoDia',
            'desagueInfo'
        )
            ->join('edu_censo', 'edu_censo.id', '=', 'edu_censoresultado.censo_id')
            ->where("edu_censo.importacion_id", "=", $importacion_id)
            ->get();

        return $data;
    }

    public static function censo_Por_Importacion_id($importacion_id)
    {
        $data = Censo::select('edu_censo.id', 'edu_censo.estado', 'anio')
            ->join('par_anio', 'par_anio.id', '=', 'edu_censo.anio_id')
            ->where("edu_censo.importacion_id", "=", $importacion_id)
            ->get();

        return $data;
    }

    public static function censo_Por_anio_estado($anio, $estado)
    {
        $data = Censo::select('edu_censo.id', 'edu_censo.estado', 'anio')
            ->join('par_anio', 'par_anio.id', '=', 'edu_censo.anio_id')
            ->where("par_anio.anio", "=", $anio)
            ->where("edu_censo.estado", "=", $estado)
            ->get();

        return $data;
    }

    public static function listar_anios()
    {
        $query = DB::table('edu_censo as v1')
            ->join('par_anio as v2', 'v2.id', '=', 'v1.anio_id')
            ->where('v1.estado', 'PR')
            ->distinct('v2.*')
            ->select('v2.*')
            ->get();
        return $query;
    }

    public static function listar_conElectricidad($provincia, $distrito, $indicador_id, $anio_id)
    {
        if ($provincia > 0 && $distrito > 0) {
            $prov = Ubigeo::find($distrito);
            $query = DB::table('edu_censo as v1')
                ->join('edu_censoresultado as v2', 'v2.censo_id', '=', 'v1.id')
                ->where('v1.anio_id', $anio_id)
                ->where('v1.estado', 'PR')
                ->where('codigoUbigeo', 'like', $prov->codigo . '%')
                ->whereIn('v2.tieneEnergiaElectTodoDia', ['Si', 'No sabe o no puede precisar', '-----'])
                ->get([DB::raw('count(v2.tieneEnergiaElectTodoDia) as y')]);

            $query1 = DB::table('edu_censo as v1')
                ->join('edu_censoresultado as v2', 'v2.censo_id', '=', 'v1.id')
                ->where('v1.anio_id', $anio_id)
                ->where('v1.estado', 'PR')
                ->where('codigoUbigeo', 'like', $prov->codigo . '%')
                ->whereIn('v2.tieneEnergiaElectTodoDia', ['Si', 'No'])
                ->groupBy('v2.tieneEnergiaElectTodoDia')
                ->orderBy('v2.tieneEnergiaElectTodoDia', 'desc')
                ->get(['v2.tieneEnergiaElectTodoDia as name', DB::raw('count(v2.tieneEnergiaElectTodoDia) as y')]);
        } else if ($provincia > 0 && $distrito == 0) {
            $prov = Ubigeo::find($provincia);
            $query = DB::table('edu_censo as v1')
                ->join('edu_censoresultado as v2', 'v2.censo_id', '=', 'v1.id')
                ->where('v1.anio_id', $anio_id)
                ->where('v1.estado', 'PR')
                ->where('codigoUbigeo', 'like', $prov->codigo . '%')
                ->whereIn('v2.tieneEnergiaElectTodoDia', ['Si', 'No sabe o no puede precisar', '-----'])
                ->get([DB::raw('count(v2.tieneEnergiaElectTodoDia) as y')]);

            $query1 = DB::table('edu_censo as v1')
                ->join('edu_censoresultado as v2', 'v2.censo_id', '=', 'v1.id')
                ->where('v1.anio_id', $anio_id)
                ->where('v1.estado', 'PR')
                ->where('codigoUbigeo', 'like', $prov->codigo . '%')
                ->whereIn('v2.tieneEnergiaElectTodoDia', ['Si', 'No'])
                ->groupBy('v2.tieneEnergiaElectTodoDia')
                ->orderBy('v2.tieneEnergiaElectTodoDia', 'desc')
                ->get(['v2.tieneEnergiaElectTodoDia as name', DB::raw('count(v2.tieneEnergiaElectTodoDia) as y')]);
        } else {
            $query = DB::table('edu_censo as v1')
                ->join('edu_censoresultado as v2', 'v2.censo_id', '=', 'v1.id')
                ->where('v1.anio_id', $anio_id)
                ->where('v1.estado', 'PR')
                ->whereIn('v2.tieneEnergiaElectTodoDia', ['Si', 'No sabe o no puede precisar', '-----'])
                ->get([DB::raw('count(v2.tieneEnergiaElectTodoDia) as y')]);

            $query1 = DB::table('edu_censo as v1')
                ->join('edu_censoresultado as v2', 'v2.censo_id', '=', 'v1.id')
                ->where('v1.anio_id', $anio_id)
                ->where('v1.estado', 'PR')
                ->whereIn('v2.tieneEnergiaElectTodoDia', ['Si', 'No'])
                ->groupBy('v2.tieneEnergiaElectTodoDia')
                ->orderBy('v2.tieneEnergiaElectTodoDia', 'desc')
                ->get(['v2.tieneEnergiaElectTodoDia as name', DB::raw('count(v2.tieneEnergiaElectTodoDia) as y')]);
        }
        foreach ($query1 as $item) {
            if ($item->name == 'Si')
                $item->y = $query->first()->y;
        }
        $data['indicador'] = $query1;
        return $data;
    }
    public static function listar_conAguaPotable($provincia, $distrito, $indicador_id, $anio_id)
    {
        if ($provincia > 0 && $distrito > 0) {
            $prov = Ubigeo::find($distrito);
            $query = DB::table('edu_censo as v1')
                ->join('edu_censoresultado as v2', 'v2.censo_id', '=', 'v1.id')
                ->where('v1.anio_id', $anio_id)
                ->where('v1.estado', 'PR')
                ->where('codigoUbigeo', 'like', $prov->codigo . '%')
                ->whereIn('v2.tieneAguaPotTodoDia', ['Si', 'No sabe o no puede precisar', '-----'])
                ->get([DB::raw('count(v2.tieneAguaPotTodoDia) as y')]);

            $query1 = DB::table('edu_censo as v1')
                ->join('edu_censoresultado as v2', 'v2.censo_id', '=', 'v1.id')
                ->where('v1.anio_id', $anio_id)
                ->where('v1.estado', 'PR')
                ->where('codigoUbigeo', 'like', $prov->codigo . '%')
                ->whereIn('v2.tieneAguaPotTodoDia', ['Si', 'No'])
                ->groupBy('v2.tieneAguaPotTodoDia')
                ->orderBy('v2.tieneAguaPotTodoDia', 'desc')
                ->get(['v2.tieneAguaPotTodoDia as name', DB::raw('count(v2.tieneAguaPotTodoDia) as y')]);
        } else if ($provincia > 0 && $distrito == 0) {
            $prov = Ubigeo::find($provincia);
            $query = DB::table('edu_censo as v1')
                ->join('edu_censoresultado as v2', 'v2.censo_id', '=', 'v1.id')
                ->where('v1.anio_id', $anio_id)
                ->where('v1.estado', 'PR')
                ->where('codigoUbigeo', 'like', $prov->codigo . '%')
                ->whereIn('v2.tieneAguaPotTodoDia', ['Si', 'No sabe o no puede precisar', '-----'])
                ->get([DB::raw('count(v2.tieneAguaPotTodoDia) as y')]);

            $query1 = DB::table('edu_censo as v1')
                ->join('edu_censoresultado as v2', 'v2.censo_id', '=', 'v1.id')
                ->where('v1.anio_id', $anio_id)
                ->where('v1.estado', 'PR')
                ->where('codigoUbigeo', 'like', $prov->codigo . '%')
                ->whereIn('v2.tieneAguaPotTodoDia', ['Si', 'No'])
                ->groupBy('v2.tieneAguaPotTodoDia')
                ->orderBy('v2.tieneAguaPotTodoDia', 'desc')
                ->get(['v2.tieneAguaPotTodoDia as name', DB::raw('count(v2.tieneAguaPotTodoDia) as y')]);
        } else {
            $query = DB::table('edu_censo as v1')
                ->join('edu_censoresultado as v2', 'v2.censo_id', '=', 'v1.id')
                ->where('v1.anio_id', $anio_id)
                ->where('v1.estado', 'PR')
                ->whereIn('v2.tieneAguaPotTodoDia', ['Si', 'No sabe o no puede precisar', '-----'])
                ->get([DB::raw('count(v2.tieneAguaPotTodoDia) as y')]);

            $query1 = DB::table('edu_censo as v1')
                ->join('edu_censoresultado as v2', 'v2.censo_id', '=', 'v1.id')
                ->where('v1.anio_id', $anio_id)
                ->where('v1.estado', 'PR')
                ->whereIn('v2.tieneAguaPotTodoDia', ['Si', 'No'])
                ->groupBy('v2.tieneAguaPotTodoDia')
                ->orderBy('v2.tieneAguaPotTodoDia', 'desc')
                ->get(['v2.tieneAguaPotTodoDia as name', DB::raw('count(v2.tieneAguaPotTodoDia) as y')]);
        }
        foreach ($query1 as $item) {
            if ($item->name == 'Si')
                $item->y = $query->first()->y;
        }
        $data['indicador'] = $query1;
        return $data;
    }
    public static function listar_conDesague($provincia, $distrito, $indicador_id, $anio_id)
    {
        if ($provincia > 0 && $distrito > 0) {
            $prov = Ubigeo::find($distrito);
            $query1 = DB::table('edu_censo as v1')
            ->join('edu_censoresultado as v2', 'v2.censo_id', '=', 'v1.id')
            ->where('v1.anio_id', $anio_id)
            ->where('v1.estado', 'PR')
            ->where('codigoUbigeo', 'like', $prov->codigo . '%')
            ->where('v2.desagueInfo','!=', 'null')
            ->groupBy('v2.desagueInfo')
            ->orderBy('v2.desagueInfo', 'asc')
            ->get(['v2.desagueInfo as name', DB::raw('count(v2.desagueInfo) as y')]);
        } else if ($provincia > 0 && $distrito == 0) {
            $prov = Ubigeo::find($provincia);
                $query1 = DB::table('edu_censo as v1')
                ->join('edu_censoresultado as v2', 'v2.censo_id', '=', 'v1.id')
                ->where('v1.anio_id', $anio_id)
                ->where('v1.estado', 'PR')
                ->where('codigoUbigeo', 'like', $prov->codigo . '%')
                ->where('v2.desagueInfo','!=', 'null')
                ->groupBy('v2.desagueInfo')
                ->orderBy('v2.desagueInfo', 'asc')
                ->get(['v2.desagueInfo as name', DB::raw('count(v2.desagueInfo) as y')]);
        } else {
            $query1 = DB::table('edu_censo as v1')
            ->join('edu_censoresultado as v2', 'v2.censo_id', '=', 'v1.id')
            ->where('v1.anio_id', $anio_id)
            ->where('v1.estado', 'PR')
            ->where('v2.desagueInfo','!=', 'null')
            ->groupBy('v2.desagueInfo')
            ->orderBy('v2.desagueInfo', 'asc')
            ->get(['v2.desagueInfo as name', DB::raw('count(v2.desagueInfo) as y')]);
        }
        $data['indicador'] = $query1;
        return $data;
    }
    public static function listar_conDesagueAux($provincia, $distrito, $indicador_id, $anio_id)
    {
        if ($provincia > 0 && $distrito > 0) {
            $prov = Ubigeo::find($distrito);
            $query = DB::table('edu_censo as v1')
                ->join('edu_censoresultado as v2', 'v2.censo_id', '=', 'v1.id')
                ->where('v1.anio_id', $anio_id)
                ->where('v1.estado', 'PR')
                ->where('codigoUbigeo', 'like', $prov->codigo . '%')
                ->whereIn('v2.tieneAguaPotTodoDia', ['Si', 'No sabe o no puede precisar', '-----'])
                ->get([DB::raw('count(v2.tieneAguaPotTodoDia) as y')]);

            $query1 = DB::table('edu_censo as v1')
                ->join('edu_censoresultado as v2', 'v2.censo_id', '=', 'v1.id')
                ->where('v1.anio_id', $anio_id)
                ->where('v1.estado', 'PR')
                ->where('codigoUbigeo', 'like', $prov->codigo . '%')
                ->whereIn('v2.tieneAguaPotTodoDia', ['Si', 'No'])
                ->groupBy('v2.tieneAguaPotTodoDia')
                ->orderBy('v2.tieneAguaPotTodoDia', 'desc')
                ->get(['v2.tieneAguaPotTodoDia as name', DB::raw('count(v2.tieneAguaPotTodoDia) as y')]);
        } else if ($provincia > 0 && $distrito == 0) {
            $prov = Ubigeo::find($provincia);
            $query = DB::table('edu_censo as v1')
                ->join('edu_censoresultado as v2', 'v2.censo_id', '=', 'v1.id')
                ->where('v1.anio_id', $anio_id)
                ->where('v1.estado', 'PR')
                ->where('codigoUbigeo', 'like', $prov->codigo . '%')
                ->whereIn('v2.tieneAguaPotTodoDia', ['Si', 'No sabe o no puede precisar', '-----'])
                ->get([DB::raw('count(v2.tieneAguaPotTodoDia) as y')]);

            $query1 = DB::table('edu_censo as v1')
                ->join('edu_censoresultado as v2', 'v2.censo_id', '=', 'v1.id')
                ->where('v1.anio_id', $anio_id)
                ->where('v1.estado', 'PR')
                ->where('codigoUbigeo', 'like', $prov->codigo . '%')
                ->whereIn('v2.tieneAguaPotTodoDia', ['Si', 'No'])
                ->groupBy('v2.tieneAguaPotTodoDia')
                ->orderBy('v2.tieneAguaPotTodoDia', 'desc')
                ->get(['v2.tieneAguaPotTodoDia as name', DB::raw('count(v2.tieneAguaPotTodoDia) as y')]);
        } else {
            $query = DB::table('edu_censo as v1')
                ->join('edu_censoresultado as v2', 'v2.censo_id', '=', 'v1.id')
                ->where('v1.anio_id', $anio_id)
                ->where('v1.estado', 'PR')
                ->whereIn('v2.tieneAguaPotTodoDia', ['Si', 'No sabe o no puede precisar', '-----'])
                ->get([DB::raw('count(v2.tieneAguaPotTodoDia) as y')]);

            $query1 = DB::table('edu_censo as v1')
                ->join('edu_censoresultado as v2', 'v2.censo_id', '=', 'v1.id')
                ->where('v1.anio_id', $anio_id)
                ->where('v1.estado', 'PR')
                ->whereIn('v2.tieneAguaPotTodoDia', ['Si', 'No'])
                ->groupBy('v2.tieneAguaPotTodoDia')
                ->orderBy('v2.tieneAguaPotTodoDia', 'desc')
                ->get(['v2.tieneAguaPotTodoDia as name', DB::raw('count(v2.tieneAguaPotTodoDia) as y')]);
        }
        foreach ($query1 as $item) {
            if ($item->name == 'Si')
                $item->y = $query->first()->y;
        }
        $query1 = DB::table('edu_censo as v1')
                ->join('edu_censoresultado as v2', 'v2.censo_id', '=', 'v1.id')
                ->where('v1.anio_id', $anio_id)
                ->where('v1.estado', 'PR')
                ->where('v2.desagueInfo','!=', 'null')
                ->groupBy('v2.desagueInfo')
                ->orderBy('v2.desagueInfo', 'desc')
                ->get(['v2.desagueInfo as name', DB::raw('count(v2.desagueInfo) as y')]);
        $data['indicador'] = $query1;
        return $data;
    }
}
