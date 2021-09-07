<?php

namespace App\Repositories\Educacion;
use App\Models\Educacion\Importacion;

class ImportacionRepositorio
{
    public static function Listar_Importaciones($sistema_id)
    { 
        $data = Importacion::select('par_importacion.id','par_importacion.comentario',
                                    'par_importacion.fechaActualizacion','par_importacion.estado',
                                    // 'case when Importacion.estado = '.'PE'.'then'.'pendiente'.'else Importacion.estado end as estado', 
                                    'adm_usuario.usuario','par_fuenteimportacion.nombre','par_fuenteimportacion.codigo','par_fuenteimportacion.formato')
                ->join('adm_usuario', 'adm_usuario.id', '=', 'par_importacion.usuarioId_crea')
                ->join('par_fuenteimportacion', 'par_fuenteimportacion.id', '=', 'par_importacion.fuenteImportacion_id')
                ->where("par_importacion.estado", "=", "PE")
                ->where("par_fuenteimportacion.sistema_id", "=", $sistema_id)
                ->orderBy('par_importacion.id','desc')
                ->get();

        return $data;
    }
    
    public static function ImportacionPor_Id($id)
    { 
        $entidad = Importacion::select('par_importacion.id','par_importacion.comentario',
                                    'par_importacion.fechaActualizacion','par_importacion.estado',
                                    'adm_usuario.usuario','par_fuenteimportacion.nombre','par_fuenteimportacion.formato','par_importacion.created_at')
                ->join('adm_usuario', 'adm_usuario.id', '=', 'par_importacion.usuarioId_crea')
                ->join('par_fuenteimportacion', 'par_fuenteimportacion.id', '=', 'par_importacion.fuenteImportacion_id')
                ->where("par_importacion.id", "=", $id)
                ->first();

        return $entidad;
    }

    public static function Importacion_mismaFecha($fechaActualizacion,$fuenteImportacion_id,$importacion_id)
    { 
        $entidad = Importacion::select('par_importacion.id','par_importacion.fuenteImportacion_id','par_importacion.estado')
                ->where("par_importacion.fechaActualizacion", "=", $fechaActualizacion)
                ->where("par_importacion.fuenteImportacion_id", "=", $fuenteImportacion_id)
                ->where("par_importacion.estado", "!=", 'EL')
                ->where("par_importacion.id", "!=", $importacion_id)
                ->first();

        return $entidad;
    }

    public static function Importacion_PE($fechaActualizacion,$fuenteImportacion_id)
    { 
        $entidad = Importacion::select('par_importacion.id','par_importacion.fuenteImportacion_id','par_importacion.estado')
                ->where("par_importacion.fechaActualizacion", "=", $fechaActualizacion)
                ->where("par_importacion.fuenteImportacion_id", "=", $fuenteImportacion_id)
                ->where("par_importacion.estado", "=", 'PE')
                ->first();

        return $entidad;
    }
}