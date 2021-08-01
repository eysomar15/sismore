<?php

namespace App\Repositories\Educacion;

use App\Models\Educacion\Censo;
use App\Models\Educacion\CensoResultado;

class CensoRepositorio
{  

    public static function Listar_Por_Importacion_id($importacion_id)
    {         
        $data = CensoResultado::select('codLocal','codigosModulares','nombreInstitucion','codigoGestion',
                'descripcionGestion','codigoOrganoInter','nombreDre_Ugel','codigoUbigeo','Departamento','Provincia','Distrito',
                'centoPoblado','direccion','areaGeo','estadoCenso','totalAulas','aulasBuenas','aulasRegulares','aulasMalas',
                'noPuedePrecisarEstadoAulas','elLocalEs','propietarioLocal','cuenta_con_itse','plan_contingencia','plan_desastre',
                'plandesastre_act','compuEscri_operativos','compuEscri_inoperativos','compuPorta_operativos','compuPorta_inoperativos',
                'lapto_operativos','lapto_inoperativos','tieneInternet','tipoConexion','fuenteEnergiaElectrica','empresaEnergiaElect',
                'tieneEnergiaElectTodoDia','fuenteAgua','empresaAgua','tieneAguaPotTodoDia','desagueInfo')
                ->join('edu_censo', 'edu_censo.id', '=', 'edu_censoresultado.censo_id')
                ->where("edu_censo.importacion_id", "=", $importacion_id)
                ->get();

        return $data;
    }   
    
    public static function censo_Por_Importacion_id($importacion_id)
    {         
        $data = Censo::select('edu_censo.id','edu_censo.estado','anio')
                ->join('par_anio', 'par_anio.id', '=', 'edu_censo.anio_id')
                ->where("edu_censo.importacion_id", "=", $importacion_id)
                ->get();

        return $data;
    } 

    public static function censo_Por_anio_estado($anio,$estado)
    {         
        $data = Censo::select('edu_censo.id','edu_censo.estado','anio')
                ->join('par_anio', 'par_anio.id', '=', 'edu_censo.anio_id')
                ->where("par_anio.anio", "=", $anio)
                ->where("edu_censo.estado", "=", $estado)
                ->get();

        return $data;
    } 
}