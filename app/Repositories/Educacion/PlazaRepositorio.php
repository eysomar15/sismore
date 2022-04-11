<?php

namespace App\Repositories\Educacion;

use App\Models\Educacion\Importacion;
use App\Models\Educacion\Plaza;
use Illuminate\Support\Facades\DB;

class PlazaRepositorio
{
    public static function listar_provincia()
    {
        $query = Plaza::select('v3.id', 'v3.nombre')
            ->join('par_ubigeo as v2', 'v2.id', '=', 'edu_plaza.ubigeo_id')
            ->join('par_ubigeo as v3', 'v3.id', '=', 'v2.dependencia')
            ->groupBy('v3.id')->groupBy('v3.nombre')
            ->get();
        return $query;
    }
    public static function listar_distrito($provincia)
    {
        $query = Plaza::select('v2.id', 'v2.nombre')
            ->join('par_ubigeo as v2', 'v2.id', '=', 'edu_plaza.ubigeo_id')
            /*->join('par_ubigeo as v3', 'v3.id', '=', 'v2.dependencia')*/
            ->where('v2.dependencia', $provincia)
            ->groupBy('v2.id')->groupBy('v2.nombre')
            ->get();
        return $query;
    }
    public static function listar_profesorestitulados($importacion_id, $nivel, $provincia, $distrito)
    {
        $nivelxx = $nivel == 31 ? '1,31,30' : '' . $nivel;
        $ubicacion = '';
        if ($provincia > 0 && $distrito > 0) $ubicacion = ' and v4.id=' . $distrito;
        else if ($provincia > 0 && $distrito == 0) $ubicacion = ' and v4.dependencia=' . $provincia;
        $query =  DB::table(DB::raw('(select if(v1.esTitulado=1,"SI","NO") as titulado,count(v1.esTitulado) as conteo from edu_plaza as v1
        inner join par_importacion as v2 on v2.id=v1.importacion_id 
        inner join edu_tipotrabajador as v3 on v3.id=v1.tipoTrabajador_id 
        inner join par_ubigeo as v4 on v4.id=v1.ubigeo_id 
        where tipoTrabajador_id in (13,6) and v1.situacion="AC" and v1.importacion_id=' . $importacion_id . ' and v1.nivelModalidad_id in (' . $nivelxx . ')' . $ubicacion . ' 
        group by v1.esTitulado) as tb'))
            ->select('titulado as name', 'conteo as y')
            ->orderBy('titulado', 'desc')
            ->get();
        return $query;
    }
    public static function listar_profesorestituladougel($nivel, $titulado = null)
    {
        $nivelxx = $nivel == 31 ? '1,31,30' : '' . $nivel;
        $query = DB::table(DB::raw('(select v5.nombre as ugel,count(v5.nombre) as conteo from edu_plaza as v1
        inner join par_importacion as v2 on v2.id=v1.importacion_id 
        inner join edu_tipotrabajador as v3 on v3.id=v1.tipoTrabajador_id 
        inner join par_ubigeo as v4 on v4.id=v1.ubigeo_id 
        inner join edu_ugel as v5 on v5.id=v1.ugel_id 
        where tipoTrabajador_id in (13,6) and v1.situacion="AC" and v1.esTitulado=' . $titulado . ' and 
              v1.importacion_id=337 and v1.nivelModalidad_id in (' . $nivelxx . ')
        group by v5.nombre) as tb'))
            ->select('ugel as name', 'conteo as y')
            ->get();
        return $query;
    }
    public static function listar_anios()
    {
        $query = Plaza::select(DB::raw('YEAR(fechaActualizacion) as anio'))
            ->distinct()
            ->join('par_importacion as v2', 'v2.id', '=', 'edu_plaza.importacion_id')
            ->where('v2.estado', 'PR')
            ->orderBy('anio', 'desc')
            ->get();
        return $query;
    }
    public static function listar_meses($anio)
    {
        $query = Plaza::select(DB::raw('MONTH(fechaActualizacion) as mes'))
            ->distinct()
            ->join('par_importacion as v2', 'v2.id', '=', 'edu_plaza.importacion_id')
            ->where('v2.estado', 'PR')
            ->where(DB::raw('YEAR(fechaActualizacion)'), $anio)
            ->orderBy('mes', 'desc')
            ->get();
        return $query;
    }
    public static function listar_importados($anio, $mes)
    {
        $query = Plaza::select('v2.id', 'v2.fechaActualizacion')
            ->join('par_importacion as v2', 'v2.id', '=', 'edu_plaza.importacion_id')
            ->where('v2.estado', 'PR')
            ->where(DB::raw('YEAR(fechaActualizacion)'), $anio)
            //->where(DB::raw('MONTH(fechaActualizacion)'), $mes)
            ->distinct()
            ->orderBy('v2.fechaActualizacion', 'desc')
            ->get();
        return $query;
    }
    /* 
    public static function sqlTotalDocentes($importacion_id) //' . $importacion_id . '
    {
        $query = '(select v1.* from edu_plaza as v1 
        inner join edu_tipotrabajador as v2 on v2.id=v1.tipoTrabajador_id 
        inner join edu_tipotrabajador as v3 on v3.id=v2.dependencia 
        inner join edu_tipo_registro_plaza as v4 on v4.id=v1.tipo_registro_id 
        inner join edu_ugel as v5 on v5.id=v1.ugel_id 
        where 
            v1.importacion_id=' . $importacion_id . ' and
            v3.id in (1) and
            v2.id in (8,9,15) and
            v4.id in(1,2,5) ) as v1';
        return $query;
    }
    public static function listar_docentes_ugel($importacion_id)
    {
        $query = DB::table(DB::raw(PlazaRepositorio::sqlTotalDocentes($importacion_id)))
            //->join('edu_institucioneducativa as v2', 'v2.id', '=', 'v1.institucionEducativa_id')
            ->join('edu_ugel as v3', 'v3.id', '=', 'v1.Ugel_id')
            ->groupBy('v3.nombre')
            ->select('v3.nombre as name', DB::raw('count(v1.id) as y'))
            ->orderBy('y', 'desc')
            ->get();
        return $query;
    }
    public static function listar_trabajadores_tipo($importacion_id)
    {
        $query = DB::table('edu_plaza as v1')
            ->join('edu_situacionlab as v2', 'v2.id', '=', 'v1.situacionLab_id')
            ->where('v1.importacion_id', $importacion_id)
            ->where('v1.situacion', 'AC')
            ->where('v2.estado', 'AC')
            ->groupBy('v2.nombre')
            ->select('v2.nombre as name', DB::raw('count(v1.id) as y'))
            ->orderBy('y', 'desc')
            ->get();
        return $query;
    }*/
    public static function listar_tipotrabajadores($importacion_id, $tipoTrabajador_id)
    {
        $query = DB::table('edu_plaza as v1')
            ->join('edu_tipotrabajador as v2', 'v2.id', '=', 'v1.tipoTrabajador_id')
            ->join('edu_tipo_registro_plaza as v3', 'v3.id', '=', 'v1.tipo_registro_id')
            ->where('v1.importacion_id', $importacion_id)
            ->where('v2.dependencia', $tipoTrabajador_id)
            ->where('v3.id', '!=', '3')
            ->select('v1.*')
            ->get();
        return $query;
    }
    public static function listar_docentesporniveleducativo_grafica($importacion_id)
    {
        $result1 = DB::table('edu_plaza as v1')
            ->join('edu_tipotrabajador as v2', 'v2.id', '=', 'v1.tipoTrabajador_id')
            ->join('edu_nivelmodalidad as v3', 'v3.id', '=', 'v1.nivelModalidad_id')
            ->where('v1.importacion_id', $importacion_id)
            ->where('v2.dependencia', '1')
            ->whereIn('v2.id', ['15', '16'])
            ->groupBy('v3.tipo', 'v2.nombre')
            ->select('v3.tipo', 'v2.nombre', DB::raw('count(v1.id) as conteo'))
            ->get();

        $categoriax = [];
        $categoria = [];
        $data[] = ['name' => 'TOTAL DOCENTES', 'data' => []];
        $data[] = ['name' => 'TOTAL AUXILIARES', 'data' => []];
        foreach ($result1 as $key => $value) {
            $categoriax[] = $value->tipo;
        }
        $categoriax = array_unique($categoriax);
        foreach ($categoriax as $value) {
            $categoria[] = $value;
        }
        foreach ($categoria as $pos => $cat) {
            $data[0]['data'][$pos] = 0;
            $data[1]['data'][$pos] = 0;
            foreach ($result1 as  $value) {
                if ($value->tipo == $cat && $value->nombre == 'DOCENTE') {
                    $data[0]['data'][$pos] = $value->conteo;
                }
                if ($value->tipo == $cat && $value->nombre == 'AUXILIAR DE EDUCACION') {
                    $data[1]['data'][$pos] = $value->conteo;
                }
            }
        }
        $dato['categoria'] = $categoria;
        $dato['data'] = $data;
        return $dato;
    }
    public static function listar_docentesyauxiliaresporugel_grafica($importacion_id)
    {
        $result1 = DB::table('edu_plaza as v1')
            ->join('edu_tipotrabajador as v2', 'v2.id', '=', 'v1.tipoTrabajador_id')
            ->join('edu_ugel as v3', 'v3.id', '=', 'v1.ugel_id')
            ->where('v1.importacion_id', $importacion_id)
            ->where('v2.dependencia', '1')
            ->whereIn('v2.id', ['15', '16'])
            ->groupBy('v3.nombre', 'v2.nombre')
            ->select('v3.nombre as ugel', 'v2.nombre as subtipo', DB::raw('count(v1.id) as conteo'))
            ->get();
        $categoriax = [];
        $categoria = [];
        $data[] = ['name' => 'TOTAL DOCENTES', 'data' => []];
        $data[] = ['name' => 'TOTAL AUXILIARES', 'data' => []];
        foreach ($result1 as $key => $value) {
            $categoriax[] = $value->ugel;
        }
        $categoriax = array_unique($categoriax);
        foreach ($categoriax as $value) {
            $categoria[] = $value;
        }
        foreach ($categoria as $pos => $cat) {
            $data[0]['data'][$pos] = 0;
            $data[1]['data'][$pos] = 0;
            foreach ($result1 as  $value) {
                if ($value->ugel == $cat && $value->subtipo == 'DOCENTE') {
                    $data[0]['data'][$pos] = $value->conteo;
                }
                if ($value->ugel == $cat && $value->subtipo == 'AUXILIAR DE EDUCACION') {
                    $data[1]['data'][$pos] = $value->conteo;
                }
            }
        }
        $dato['categoria'] = $categoria;
        $dato['data'] = $data;
        return $dato;
    }
    public static function listar_trabajadoresadministrativosporugel_grafica($importacion_id)
    {
        $result1 = DB::table('edu_plaza as v1')
            ->join('edu_tipotrabajador as v2', 'v2.id', '=', 'v1.tipoTrabajador_id')
            ->join('edu_tipotrabajador as v3', 'v3.id', '=', 'v2.dependencia')
            ->join('edu_ugel as v4', 'v4.id', '=', 'v1.ugel_id')
            ->where('v1.importacion_id', $importacion_id)
            ->whereIn('v3.id', ['2', '3'])
            ->groupBy('v4.nombre', 'v3.nombre')
            ->orderBy('v4.nombre')
            ->select('v4.nombre as ugel', 'v3.nombre as tipo', DB::raw('count(v1.id) as conteo'))
            ->get();
        $categoriax = [];
        $categoria = [];
        $data[] = ['name' => 'TOTAL ADMINISTRATIVOS', 'data' => []];
        $data[] = ['name' => 'TOTAL CAS', 'data' => []];
        foreach ($result1 as $key => $value) {
            $categoriax[] = $value->ugel;
        }
        $categoriax = array_unique($categoriax);
        foreach ($categoriax as $value) {
            $categoria[] = $value;
        }
        foreach ($categoria as $pos => $cat) {
            $data[0]['data'][$pos] = 0;
            $data[1]['data'][$pos] = 0;
            foreach ($result1 as  $value) {
                if ($value->ugel == $cat && $value->tipo == 'ADMINISTRATIVO') {
                    $data[0]['data'][$pos] = $value->conteo;
                }
                if ($value->ugel == $cat && $value->tipo == 'CAS') {
                    $data[1]['data'][$pos] = $value->conteo;
                }
            }
        }
        $dato['categoria'] = $categoria;
        $dato['data'] = $data;
        return $dato;
    }
    public static function listar_trabajadorespecporugel_grafica($importacion_id)
    {
        $result1 = DB::table('edu_plaza as v1')
            ->join('edu_tipotrabajador as v2', 'v2.id', '=', 'v1.tipoTrabajador_id')
            ->join('edu_tipotrabajador as v3', 'v3.id', '=', 'v2.dependencia')
            ->join('edu_ugel as v4', 'v4.id', '=', 'v1.ugel_id')
            ->where('v1.importacion_id', $importacion_id)
            ->where('v3.id', '4')
            ->groupBy('v4.nombre', 'v3.nombre')
            ->orderBy('v4.nombre')
            ->select('v4.nombre as name', DB::raw('count(v1.id) as y'))
            ->get();
        return $result1;
    }


    public static function listar_plazasegununidaddegestioneducativa_grafica($importacion_id)
    {
        $result1 = DB::table('edu_plaza as v1')
            ->join('edu_institucioneducativa as v2', 'v2.id', '=', 'v1.institucionEducativa_id')
            ->join('edu_tipogestion as v3', 'v3.id', '=', 'v2.TipoGestion_id')
            ->join('edu_ugel as v4', 'v4.id', '=', 'v2.Ugel_id')
            ->join('edu_tipo_registro_plaza as v5', 'v5.id', '=', 'v1.tipo_registro_id')
            ->where('v1.importacion_id', $importacion_id)
            ->where('v5.nombre', '!=', 'POR REEMPLAZO')
            ->groupBy('v4.nombre')
            ->select('v4.nombre as name', DB::raw('count(v1.id) as y'))
            ->orderBy('y', 'desc')
            ->get();
        return $result1;
    }
    public static function listar_plazaseguntipodeniveleducactivo_grafica($importacion_id)
    {
        $result1 = DB::table('edu_plaza as v1')
            ->join('edu_nivelmodalidad as v2', 'v2.id', '=', 'v1.NivelModalidad_id')
            ->join('edu_tipo_registro_plaza as v5', 'v5.id', '=', 'v1.tipo_registro_id')
            ->where('v1.importacion_id', $importacion_id)
            ->where('v5.nombre', '!=', 'POR REEMPLAZO')
            ->groupBy('v2.tipo')
            ->select('v2.tipo as name', DB::raw('count(v1.id) as y'))
            ->orderBy('y', 'desc')
            ->get();
        return $result1;
    }

    public static function listar_plazaseguntipotrabajador_grafica($importacion_id)
    {
        $result1 = DB::table('edu_plaza as v1')
            ->join('edu_tipotrabajador as v2', 'v2.id', '=', 'v1.tipoTrabajador_id')
            ->join('edu_tipotrabajador as v3', 'v3.id', '=', 'v2.dependencia')
            ->join('edu_tipo_registro_plaza as v5', 'v5.id', '=', 'v1.tipo_registro_id')
            ->where('v1.importacion_id', $importacion_id)
            ->where('v5.nombre', '!=', 'POR REEMPLAZO')
            ->where('v3.nombre', 'DOCENTE')
            ->groupBy('v2.nombre')
            ->select('v2.nombre as name', DB::raw('count(v1.id) as y'))
            ->orderBy('y', 'desc')
            ->get();
        return $result1;
    }

    public static function listar_plazadocenteseguntipodeniveleducactivo_grafica($importacion_id)
    {
        $result1 = DB::table('edu_plaza as v1')
            ->join('edu_nivelmodalidad as v2', 'v2.id', '=', 'v1.NivelModalidad_id')
            ->join('edu_tipotrabajador as v3', 'v3.id', '=', 'v1.tipoTrabajador_id')
            ->join('edu_tipotrabajador as v4', 'v4.id', '=', 'v3.dependencia')
            ->join('edu_tipo_registro_plaza as v5', 'v5.id', '=', 'v1.tipo_registro_id')
            ->where('v1.importacion_id', $importacion_id)
            ->where('v5.nombre', '!=', 'POR REEMPLAZO')
            ->where('v3.nombre', 'DOCENTE')
            ->groupBy('v2.tipo')
            ->select('v2.tipo as name', DB::raw('count(v1.id) as y'))
            ->orderBy('y', 'desc')
            ->get();
        return $result1;
    }

    public static function listar_plazadocentesegunsituacionlaboral_grafica($importacion_id)
    {
        $result1 = DB::table('edu_plaza as v1')
            ->join('edu_situacionlab as v2', 'v2.id', '=', 'v1.situacionLab_id')
            ->join('edu_tipotrabajador as v3', 'v3.id', '=', 'v1.tipoTrabajador_id')
            ->join('edu_tipotrabajador as v4', 'v4.id', '=', 'v3.dependencia')
            ->join('edu_tipo_registro_plaza as v5', 'v5.id', '=', 'v1.tipo_registro_id')
            ->where('v1.importacion_id', $importacion_id)
            ->where('v5.nombre', '!=', 'POR REEMPLAZO')
            ->where('v3.nombre', 'DOCENTE')
            ->where('v4.nombre', 'DOCENTE')
            ->groupBy('v2.nombre')
            ->select('v2.nombre as name', DB::raw('count(v1.id) as y'))
            ->orderBy('y', 'desc')
            ->get();
        return $result1;
    }

    public static function listar_plazadocentesegunregimenlaboral_grafica($importacion_id)
    {
        $result1 = DB::table('edu_plaza as v1')
            ->join('edu_tipotrabajador as v3', 'v3.id', '=', 'v1.tipoTrabajador_id')
            ->join('edu_tipotrabajador as v4', 'v4.id', '=', 'v3.dependencia')
            ->join('edu_tipo_registro_plaza as v5', 'v5.id', '=', 'v1.tipo_registro_id')
            ->where('v1.importacion_id', $importacion_id)
            ->where('v5.nombre', '!=', 'POR REEMPLAZO')
            ->where('v3.nombre', 'DOCENTE')
            ->where('v4.nombre', 'DOCENTE')
            ->groupBy('v1.ley')
            ->select('v1.ley as name', DB::raw('count(v1.id) as y'))
            ->orderBy('y', 'desc')
            ->get();
        return $result1;
    }
    public static function listar_plazadocentesegunano_grafica()
    {
        $query = DB::table('edu_plaza as v1')
            ->join('edu_situacionlab as v2', 'v2.id', '=', 'v1.situacionLab_id')
            ->join('edu_tipotrabajador as v3', 'v3.id', '=', 'v1.tipoTrabajador_id')
            ->join('edu_tipotrabajador as v4', 'v4.id', '=', 'v3.dependencia')
            ->join('edu_tipo_registro_plaza as v5', 'v5.id', '=', 'v1.tipo_registro_id')
            ->join('par_importacion as v6', 'v6.id', '=', 'v1.importacion_id')
            ->where('v6.estado', 'PR')
            ->where('v5.nombre', '!=', 'POR REEMPLAZO')
            ->where('v3.nombre', 'DOCENTE')
            ->where('v4.nombre', 'DOCENTE')
            ->whereIn('v2.nombre', ["NOMBRADO", "CONTRATADO"])
            ->groupBy('name')
            ->select(
                DB::raw('YEAR(v6.fechaActualizacion) as name'),
                DB::raw('SUM(IF(v1.importacion_id=(
                    select max(xx.id)  from par_importacion as xx 
                    where xx.estado="PR" and xx.fuenteImportacion_id=2 and year(xx.fechaActualizacion)=year(v6.fechaActualizacion) 
                    group by year(xx.fechaActualizacion)
                    ),1,0)) as y')
            )
            ->orderBy('name', 'ASC')
            ->get();
        foreach ($query as $key => $value) {
            $value->name = "" . $value->name;
            $value->y = (int)$value->y;
        }
        return $query;
    }
    public static function listar_plazadocentesegunmes_grafica($importacion_id, $anio)
    {
        $query = DB::table('edu_plaza as v1')
            ->join('edu_situacionlab as v2', 'v2.id', '=', 'v1.situacionLab_id')
            ->join('edu_tipotrabajador as v3', 'v3.id', '=', 'v1.tipoTrabajador_id')
            ->join('edu_tipotrabajador as v4', 'v4.id', '=', 'v3.dependencia')
            ->join('edu_tipo_registro_plaza as v5', 'v5.id', '=', 'v1.tipo_registro_id')
            ->join('par_importacion as v6', 'v6.id', '=', 'v1.importacion_id')
            ->where('v6.estado', 'PR')
            ->where(DB::raw('YEAR(v6.fechaActualizacion)'), '=', $anio)
            ->where('v5.nombre', '!=', 'POR REEMPLAZO')
            ->where('v3.nombre', 'DOCENTE')
            ->where('v4.nombre', 'DOCENTE')
            ->whereIn('v2.nombre', ["NOMBRADO", "CONTRATADO"])
            ->groupBy('name')
            ->select(
                DB::raw('CASE 
                WHEN month(`v6`.`fechaActualizacion`)=1 THEN "ENE"  
                WHEN month(`v6`.`fechaActualizacion`)=2 THEN "FEB"  
                WHEN month(`v6`.`fechaActualizacion`)=3 THEN "MAR"  
                WHEN month(`v6`.`fechaActualizacion`)=4 THEN "ABR"  
                WHEN month(`v6`.`fechaActualizacion`)=5 THEN "MAY"  
                WHEN month(`v6`.`fechaActualizacion`)=6 THEN "JUN"  
                WHEN month(`v6`.`fechaActualizacion`)=7 THEN "JUL"  
                WHEN month(`v6`.`fechaActualizacion`)=8 THEN "AGO"  
                WHEN month(`v6`.`fechaActualizacion`)=9 THEN "SET"  
                WHEN month(`v6`.`fechaActualizacion`)=10 THEN "OCT"  
                WHEN month(`v6`.`fechaActualizacion`)=11 THEN "NOV"  
                WHEN month(`v6`.`fechaActualizacion`)=12 THEN "DIC"  
                ELSE "" END as `name`'),
                DB::raw('SUM(IF(v1.importacion_id=(
                    select max(id)  from par_importacion 
                    where estado="PR" and fuenteImportacion_id=2 and year(fechaActualizacion)=' . $anio . ' and month(fechaActualizacion)=month(v6.fechaActualizacion)
                    group by month(fechaActualizacion)),1,0)) as y ')
            )
            ->orderBy('name', 'ASC')
            ->get();
        foreach ($query as $key => $value) {
            $value->name = "" . $value->name;
            $value->y = (int)$value->y;
        }
        return $query;
    }
    public static function listar_totalplazacontratadoynombradossegunugelyniveleducativo($importacion_id)
    {
        $bodys = DB::table('edu_plaza as v1')
            ->join('edu_ugel as v2', 'v2.id', '=', 'v1.ugel_id')
            ->join('edu_nivelmodalidad as v3', 'v3.id', '=', 'v1.nivelModalidad_id')
            ->join('edu_tipotrabajador as v4', 'v4.id', '=', 'v1.tipoTrabajador_id')
            ->join('edu_tipotrabajador as v5', 'v5.id', '=', 'v4.dependencia')
            ->join('edu_situacionlab as v6', 'v6.id', '=', 'v1.situacionLab_id')
            ->where('v1.importacion_id', $importacion_id)
            ->whereIn('v6.nombre', ['NOMBRADO', 'CONTRATADO'])
            ->groupBy(/* 'v2.nombre', */'v3.nombre')
            ->select(
                /* 'v2.nombre as ugel', */
                'v3.nombre as nivel',
                DB::raw('sum(if(v6.nombre="CONTRATADO" and v5.nombre="ADMINISTRATIVO",1,0)) as ACONTRATADO'),
                DB::raw('sum(if(v6.nombre="NOMBRADO" and v5.nombre="ADMINISTRATIVO",1,0)) as ANOMBRADO'),
                DB::raw('sum(if(v5.nombre="ADMINISTRATIVO",1,0)) as ADMINISTRATIVO'),
                DB::raw('sum(if(v6.nombre="CONTRATADO" and v5.nombre="DOCENTE",1,0)) as DCONTRATADO'),
                DB::raw('sum(if(v6.nombre="NOMBRADO" and v5.nombre="DOCENTE",1,0)) as DNOMBRADO'),
                DB::raw('sum(if(v5.nombre="DOCENTE",1,0)) as DOCENTE'),
                DB::raw('sum(if(v6.nombre="CONTRATADO" and v5.nombre="CAS",1,0)) as CCONTRATADO'),
                DB::raw('sum(if(v6.nombre="NOMBRADO" and v5.nombre="CAS",1,0)) as CNOMBRADO'),
                DB::raw('sum(if(v5.nombre="CAS",1,0)) as CAS'),
                DB::raw('sum(if(v6.nombre="CONTRATADO" and v5.nombre="PEC",1,0)) as PCONTRATADO'),
                DB::raw('sum(if(v6.nombre="NOMBRADO" and v5.nombre="PEC",1,0)) as PNOMBRADO'),
                DB::raw('sum(if(v5.nombre="PEC",1,0)) as PEC'),
                DB::raw('count(v1.id) as TOTAL')
            )
            ->orderBy('TOTAL', 'desc')
            ->get();
        /* $heads = DB::table('edu_plaza as v1')
            ->join('edu_ugel as v2', 'v2.id', '=', 'v1.ugel_id')
            ->join('edu_nivelmodalidad as v3', 'v3.id', '=', 'v1.nivelModalidad_id')
            ->join('edu_tipotrabajador as v4', 'v4.id', '=', 'v1.tipoTrabajador_id')
            ->join('edu_tipotrabajador as v5', 'v5.id', '=', 'v4.dependencia')
            ->join('edu_situacionlab as v6', 'v6.id', '=', 'v1.situacionLab_id')
            ->where('v1.importacion_id', $importacion_id)
            ->whereIn('v6.nombre', ['NOMBRADO', 'CONTRATADO'])
            ->groupBy('v2.nombre')
            ->select(
                'v2.nombre as ugel',
                DB::raw('sum(if(v6.nombre="CONTRATADO" and v5.nombre="ADMINISTRATIVO",1,0)) as ACONTRATADO'),
                DB::raw('sum(if(v6.nombre="NOMBRADO" and v5.nombre="ADMINISTRATIVO",1,0)) as ANOMBRADO'),
                DB::raw('sum(if(v5.nombre="ADMINISTRATIVO",1,0)) as ADMINISTRATIVO'),
                DB::raw('sum(if(v6.nombre="CONTRATADO" and v5.nombre="DOCENTE",1,0)) as DCONTRATADO'),
                DB::raw('sum(if(v6.nombre="NOMBRADO" and v5.nombre="DOCENTE",1,0)) as DNOMBRADO'),
                DB::raw('sum(if(v5.nombre="DOCENTE",1,0)) as DOCENTE'),
                DB::raw('sum(if(v6.nombre="CONTRATADO" and v5.nombre="CAS",1,0)) as CCONTRATADO'),
                DB::raw('sum(if(v6.nombre="NOMBRADO" and v5.nombre="CAS",1,0)) as CNOMBRADO'),
                DB::raw('sum(if(v5.nombre="CAS",1,0)) as CAS'),
                DB::raw('sum(if(v6.nombre="CONTRATADO" and v5.nombre="PEC",1,0)) as PCONTRATADO'),
                DB::raw('sum(if(v6.nombre="NOMBRADO" and v5.nombre="PEC",1,0)) as PNOMBRADO'),
                DB::raw('sum(if(v5.nombre="PEC",1,0)) as PEC'),
                DB::raw('count(v1.id) as TOTAL')
            )
            ->orderBy('TOTAL', 'desc')
            ->get(); */
        $foot = DB::table('edu_plaza as v1')
            ->join('edu_ugel as v2', 'v2.id', '=', 'v1.ugel_id')
            ->join('edu_nivelmodalidad as v3', 'v3.id', '=', 'v1.nivelModalidad_id')
            ->join('edu_tipotrabajador as v4', 'v4.id', '=', 'v1.tipoTrabajador_id')
            ->join('edu_tipotrabajador as v5', 'v5.id', '=', 'v4.dependencia')
            ->join('edu_situacionlab as v6', 'v6.id', '=', 'v1.situacionLab_id')
            ->where('v1.importacion_id', $importacion_id)
            ->whereIn('v6.nombre', ['NOMBRADO', 'CONTRATADO'])
            ->select(
                DB::raw('sum(if(v6.nombre="CONTRATADO" and v5.nombre="ADMINISTRATIVO",1,0)) as ACONTRATADO'),
                DB::raw('sum(if(v6.nombre="NOMBRADO" and v5.nombre="ADMINISTRATIVO",1,0)) as ANOMBRADO'),
                DB::raw('sum(if(v5.nombre="ADMINISTRATIVO",1,0)) as ADMINISTRATIVO'),
                DB::raw('sum(if(v6.nombre="CONTRATADO" and v5.nombre="DOCENTE",1,0)) as DCONTRATADO'),
                DB::raw('sum(if(v6.nombre="NOMBRADO" and v5.nombre="DOCENTE",1,0)) as DNOMBRADO'),
                DB::raw('sum(if(v5.nombre="DOCENTE",1,0)) as DOCENTE'),
                DB::raw('sum(if(v6.nombre="CONTRATADO" and v5.nombre="CAS",1,0)) as CCONTRATADO'),
                DB::raw('sum(if(v6.nombre="NOMBRADO" and v5.nombre="CAS",1,0)) as CNOMBRADO'),
                DB::raw('sum(if(v5.nombre="CAS",1,0)) as CAS'),
                DB::raw('sum(if(v6.nombre="CONTRATADO" and v5.nombre="PEC",1,0)) as PCONTRATADO'),
                DB::raw('sum(if(v6.nombre="NOMBRADO" and v5.nombre="PEC",1,0)) as PNOMBRADO'),
                DB::raw('sum(if(v5.nombre="PEC",1,0)) as PEC'),
                DB::raw('count(v1.id) as TOTAL')
            )
            ->get()->first();
        $dt['table'] = view('educacion.Plaza.DT_tabla1', compact(/* 'heads', */'bodys', 'foot'))->render();
        return $dt;
    }
}
