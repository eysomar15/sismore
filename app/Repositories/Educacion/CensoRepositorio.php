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
                ->where('v2.codigoUbigeo', 'like', $prov->codigo . '%')
                ->where('v2.fuenteEnergiaElectrica', '!=', '1.Red pública')
                ->get([DB::raw('count(v2.fuenteEnergiaElectrica) as y')]);

            $query1 = DB::table('edu_censo as v1')
                ->join('edu_censoresultado as v2', 'v2.censo_id', '=', 'v1.id')
                ->where('v1.anio_id', $anio_id)
                ->where('v1.estado', 'PR')
                ->where('v2.codigoUbigeo', 'like', $prov->codigo . '%')
                ->whereIn('v2.fuenteEnergiaElectrica', ['1.Red pública', '2.Generador o motor del Municipio'])
                ->groupBy('v2.fuenteEnergiaElectrica')
                ->orderBy('v2.fuenteEnergiaElectrica', 'asc')
                ->get(['v2.fuenteEnergiaElectrica as name', DB::raw('count(v2.fuenteEnergiaElectrica) as y')]);
        } else if ($provincia > 0 && $distrito == 0) {
            $prov = Ubigeo::find($provincia);
            $query = DB::table('edu_censo as v1')
                ->join('edu_censoresultado as v2', 'v2.censo_id', '=', 'v1.id')
                ->where('v1.anio_id', $anio_id)
                ->where('v1.estado', 'PR')
                ->where('v2.codigoUbigeo', 'like', $prov->codigo . '%')
                ->where('v2.fuenteEnergiaElectrica', '!=', '1.Red pública')
                ->get([DB::raw('count(v2.fuenteEnergiaElectrica) as y')]);

            $query1 = DB::table('edu_censo as v1')
                ->join('edu_censoresultado as v2', 'v2.censo_id', '=', 'v1.id')
                ->where('v1.anio_id', $anio_id)
                ->where('v1.estado', 'PR')
                ->where('v2.codigoUbigeo', 'like', $prov->codigo . '%')
                ->whereIn('v2.fuenteEnergiaElectrica', ['1.Red pública', '2.Generador o motor del Municipio'])
                ->groupBy('v2.fuenteEnergiaElectrica')
                ->orderBy('v2.fuenteEnergiaElectrica', 'asc')
                ->get(['v2.fuenteEnergiaElectrica as name', DB::raw('count(v2.fuenteEnergiaElectrica) as y')]);
        } else {
            $query = DB::table('edu_censo as v1')
                ->join('edu_censoresultado as v2', 'v2.censo_id', '=', 'v1.id')
                ->where('v1.anio_id', $anio_id)
                ->where('v1.estado', 'PR')
                ->where('v2.fuenteEnergiaElectrica', '!=', '1.Red pública')
                ->get([DB::raw('count(v2.fuenteEnergiaElectrica) as y')]);

            $query1 = DB::table('edu_censo as v1')
                ->join('edu_censoresultado as v2', 'v2.censo_id', '=', 'v1.id')
                ->where('v1.anio_id', $anio_id)
                ->where('v1.estado', 'PR')
                ->whereIn('v2.fuenteEnergiaElectrica', ['1.Red pública', '2.Generador o motor del Municipio'])
                ->groupBy('v2.fuenteEnergiaElectrica')
                ->orderBy('v2.fuenteEnergiaElectrica', 'asc')
                ->get(['v2.fuenteEnergiaElectrica as name', DB::raw('count(v2.fuenteEnergiaElectrica) as y')]);
        }
        foreach ($query1 as $item) {
            if ($item->name == '2.Generador o motor del Municipio') {
                $item->y = $query->first()->y;
                $item->name = '2.Otros';
            }
        }
        $data['indicador'] = $query1;
        return $data;
    }
    public static function listar_conElectricidadAux($provincia, $distrito, $indicador_id, $anio_id)
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
                ->where('v2.fuenteEnergiaElectrica', '!=', '1.Red pública')
                ->get([DB::raw('count(v2.fuenteEnergiaElectrica) as y')]);

            $query1 = DB::table('edu_censo as v1')
                ->join('edu_censoresultado as v2', 'v2.censo_id', '=', 'v1.id')
                ->where('v1.anio_id', $anio_id)
                ->where('v1.estado', 'PR')
                ->whereIn('v2.fuenteEnergiaElectrica', ['1.Red pública', '2.Generador o motor del Municipio'])
                ->groupBy('v2.fuenteEnergiaElectrica')
                ->orderBy('v2.fuenteEnergiaElectrica', 'asc')
                ->get(['v2.fuenteEnergiaElectrica as name', DB::raw('count(v2.fuenteEnergiaElectrica) as y')]);
        }
        foreach ($query1 as $item) {
            if ($item->name == '2.Generador o motor del Municipio') {
                $item->y = $query->first()->y;
                $item->name = '2.Otros';
            }
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
                ->where('v2.codigoUbigeo', 'like', $prov->codigo . '%')
                ->where('v2.fuenteAgua', '!=', '1.Red pública')
                ->get([DB::raw('count(v2.fuenteAgua) as y')]);

            $query1 = DB::table('edu_censo as v1')
                ->join('edu_censoresultado as v2', 'v2.censo_id', '=', 'v1.id')
                ->where('v1.anio_id', $anio_id)
                ->where('v1.estado', 'PR')
                ->where('v2.codigoUbigeo', 'like', $prov->codigo . '%')
                ->whereIn('v2.fuenteAgua', ['1.Red pública', '2.Pilón de uso público'])
                ->groupBy('v2.fuenteAgua')
                ->orderBy('v2.fuenteAgua', 'asc')
                ->get(['v2.fuenteAgua as name', DB::raw('count(v2.fuenteAgua) as y')]);
        } else if ($provincia > 0 && $distrito == 0) {
            $prov = Ubigeo::find($provincia);
            $query = DB::table('edu_censo as v1')
                ->join('edu_censoresultado as v2', 'v2.censo_id', '=', 'v1.id')
                ->where('v1.anio_id', $anio_id)
                ->where('v1.estado', 'PR')
                ->where('v2.codigoUbigeo', 'like', $prov->codigo . '%')
                ->where('v2.fuenteAgua', '!=', '1.Red pública')
                ->get([DB::raw('count(v2.fuenteAgua) as y')]);
            $query1 = DB::table('edu_censo as v1')
                ->join('edu_censoresultado as v2', 'v2.censo_id', '=', 'v1.id')
                ->where('v1.anio_id', $anio_id)
                ->where('v1.estado', 'PR')
                ->where('v2.codigoUbigeo', 'like', $prov->codigo . '%')
                ->whereIn('v2.fuenteAgua', ['1.Red pública', '2.Pilón de uso público'])
                ->groupBy('v2.fuenteAgua')
                ->orderBy('v2.fuenteAgua', 'asc')
                ->get(['v2.fuenteAgua as name', DB::raw('count(v2.fuenteAgua) as y')]);
        } else {
            $query = DB::table('edu_censo as v1')
                ->join('edu_censoresultado as v2', 'v2.censo_id', '=', 'v1.id')
                ->where('v1.anio_id', $anio_id)
                ->where('v1.estado', 'PR')
                ->where('v2.fuenteAgua', '!=', '1.Red pública')
                ->get([DB::raw('count(v2.fuenteAgua) as y')]);

            $query1 = DB::table('edu_censo as v1')
                ->join('edu_censoresultado as v2', 'v2.censo_id', '=', 'v1.id')
                ->where('v1.anio_id', $anio_id)
                ->where('v1.estado', 'PR')
                ->whereIn('v2.fuenteAgua', ['1.Red pública', '2.Pilón de uso público'])
                ->groupBy('v2.fuenteAgua')
                ->orderBy('v2.fuenteAgua', 'asc')
                ->get(['v2.fuenteAgua as name', DB::raw('count(v2.fuenteAgua) as y')]);
        }
        foreach ($query1 as $item) {
            if ($item->name == '2.Pilón de uso público') {
                $item->y = $query->first()->y;
                $item->name = '2.Otros';
            }
        }
        $data['indicador'] = $query1;
        return $data;
    }
    public static function listar_conAguaPotableAux($provincia, $distrito, $indicador_id, $anio_id)
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
            $query = DB::table('edu_censo as v1')
                ->join('edu_censoresultado as v2', 'v2.censo_id', '=', 'v1.id')
                ->where('v1.anio_id', $anio_id)
                ->where('v1.estado', 'PR')
                ->where('v2.codigoUbigeo', 'like', $prov->codigo . '%')
                ->where('v2.desagueInfo', '!=', '1.Desemboca en una red pública de desagüe')
                ->get([DB::raw('count(v2.desagueInfo) as y')]);

            $query1 = DB::table('edu_censo as v1')
                ->join('edu_censoresultado as v2', 'v2.censo_id', '=', 'v1.id')
                ->where('v1.anio_id', $anio_id)
                ->where('v1.estado', 'PR')
                ->where('v2.codigoUbigeo', 'like', $prov->codigo . '%')
                ->whereIn('v2.desagueInfo', ['1.Desemboca en una red pública de desagüe', '2. Utiliza pozo séptico/tanque séptico'])
                ->groupBy('v2.desagueInfo')
                ->orderBy('v2.desagueInfo', 'asc')
                ->get(['v2.desagueInfo as name', DB::raw('count(v2.desagueInfo) as y')]);
        } else if ($provincia > 0 && $distrito == 0) {
            $prov = Ubigeo::find($provincia);
            $query = DB::table('edu_censo as v1')
                ->join('edu_censoresultado as v2', 'v2.censo_id', '=', 'v1.id')
                ->where('v1.anio_id', $anio_id)
                ->where('v1.estado', 'PR')
                ->where('v2.codigoUbigeo', 'like', $prov->codigo . '%')
                ->where('v2.desagueInfo', '!=', '1.Desemboca en una red pública de desagüe')
                ->get([DB::raw('count(v2.desagueInfo) as y')]);

            $query1 = DB::table('edu_censo as v1')
                ->join('edu_censoresultado as v2', 'v2.censo_id', '=', 'v1.id')
                ->where('v1.anio_id', $anio_id)
                ->where('v1.estado', 'PR')
                ->where('v2.codigoUbigeo', 'like', $prov->codigo . '%')
                ->whereIn('v2.desagueInfo', ['1.Desemboca en una red pública de desagüe', '2. Utiliza pozo séptico/tanque séptico'])
                ->groupBy('v2.desagueInfo')
                ->orderBy('v2.desagueInfo', 'asc')
                ->get(['v2.desagueInfo as name', DB::raw('count(v2.desagueInfo) as y')]);
        } else {
            $query = DB::table('edu_censo as v1')
                ->join('edu_censoresultado as v2', 'v2.censo_id', '=', 'v1.id')
                ->where('v1.anio_id', $anio_id)
                ->where('v1.estado', 'PR')
                ->where('v2.desagueInfo', '!=', '1.Desemboca en una red pública de desagüe')
                ->get([DB::raw('count(v2.desagueInfo) as y')]);

            $query1 = DB::table('edu_censo as v1')
                ->join('edu_censoresultado as v2', 'v2.censo_id', '=', 'v1.id')
                ->where('v1.anio_id', $anio_id)
                ->where('v1.estado', 'PR')
                ->whereIn('v2.desagueInfo', ['1.Desemboca en una red pública de desagüe', '2. Utiliza pozo séptico/tanque séptico'])
                ->groupBy('v2.desagueInfo')
                ->orderBy('v2.desagueInfo', 'asc')
                ->get(['v2.desagueInfo as name', DB::raw('count(v2.desagueInfo) as y')]);
        }
        foreach ($query1 as $item) {
            if ($item->name == '2. Utiliza pozo séptico/tanque séptico') {
                $item->y = $query->first()->y;
                $item->name = '2.Otros';
            }
        }
        $data['indicador'] = $query1;
        return $data;
    }

    public static function listar_conServicioBasico($provincia, $distrito, $indicador_id, $anio_id)
    {
        if ($provincia > 0 && $distrito > 0) {
            $prov = Ubigeo::find($distrito);
            $query1 = DB::table('edu_censo as v1')
                ->join('edu_censoresultado as v2', 'v2.censo_id', '=', 'v1.id')
                ->where('v1.anio_id', $anio_id)
                ->where('v1.estado', 'PR')
                ->where('v2.codigoUbigeo', 'like', $prov->codigo . '%')
                ->where('v2.fuenteEnergiaElectrica', '=', '1.Red pública')
                ->where('v2.fuenteAgua', '=', '1.Red pública')
                ->where('v2.desagueInfo', '=', '1.Desemboca en una red pública de desagüe')
                ->get([DB::raw('count(v2.id) as y')]);
            $query2 = DB::table('edu_censo as v1')
                ->join('edu_censoresultado as v2', 'v2.censo_id', '=', 'v1.id')
                ->where('v1.anio_id', $anio_id)
                ->where('v1.estado', 'PR')
                ->where('v2.codigoUbigeo', 'like', $prov->codigo . '%')
                ->where('v2.fuenteEnergiaElectrica', '!=', 'NULL')
                ->where('v2.fuenteAgua', '!=', 'NULL')
                ->where('v2.desagueInfo', '!=', 'NULL')
                ->get([DB::raw('count(v2.id) as y')]);
        } else if ($provincia > 0 && $distrito == 0) {
            $prov = Ubigeo::find($provincia);
            $query1 = DB::table('edu_censo as v1')
                ->join('edu_censoresultado as v2', 'v2.censo_id', '=', 'v1.id')
                ->where('v1.anio_id', $anio_id)
                ->where('v1.estado', 'PR')
                ->where('v2.codigoUbigeo', 'like', $prov->codigo . '%')
                ->where('v2.fuenteEnergiaElectrica', '=', '1.Red pública')
                ->where('v2.fuenteAgua', '=', '1.Red pública')
                ->where('v2.desagueInfo', '=', '1.Desemboca en una red pública de desagüe')
                ->get([DB::raw('count(v2.id) as y')]);
            $query2 = DB::table('edu_censo as v1')
                ->join('edu_censoresultado as v2', 'v2.censo_id', '=', 'v1.id')
                ->where('v1.anio_id', $anio_id)
                ->where('v1.estado', 'PR')
                ->where('v2.codigoUbigeo', 'like', $prov->codigo . '%')
                ->where('v2.fuenteEnergiaElectrica', '!=', 'NULL')
                ->where('v2.fuenteAgua', '!=', 'NULL')
                ->where('v2.desagueInfo', '!=', 'NULL')
                ->get([DB::raw('count(v2.id) as y')]);
        } else {
            $query1 = DB::table('edu_censo as v1')
                ->join('edu_censoresultado as v2', 'v2.censo_id', '=', 'v1.id')
                ->where('v1.anio_id', $anio_id)
                ->where('v1.estado', 'PR')
                ->where('v2.fuenteEnergiaElectrica', '=', '1.Red pública')
                ->where('v2.fuenteAgua', '=', '1.Red pública')
                ->where('v2.desagueInfo', '=', '1.Desemboca en una red pública de desagüe')
                ->get([DB::raw('count(v2.id) as y')]);
            $query2 = DB::table('edu_censo as v1')
                ->join('edu_censoresultado as v2', 'v2.censo_id', '=', 'v1.id')
                ->where('v1.anio_id', $anio_id)
                ->where('v1.estado', 'PR')
                ->where('v2.fuenteEnergiaElectrica', '!=', 'NULL')
                ->where('v2.fuenteAgua', '!=', 'NULL')
                ->where('v2.desagueInfo', '!=', 'NULL')
                ->get([DB::raw('count(v2.id) as y')]);
        }
        $data['indicador'] = [
            ['name' => '1.Tres Servicios Basicos', 'y' => $query1->first()->y],
            ['name' => '2.Otros', 'y' => $query2->first()->y - $query1->first()->y]
        ];
        return $data;
    }

    public static function Listar_IE($anio_id)
    {
        $query1 = DB::table('edu_censo as v1')
            ->join('edu_censoresultado as v2', 'v2.censo_id', '=', 'v1.id')
            ->join('edu_institucioneducativa as v3', 'v3.codModular', '=', 'v2.codigosModulares')
            ->where('v1.anio_id', $anio_id)
            ->where('v1.estado', 'PR')
            ->get();
        return $query1;
    }
}
