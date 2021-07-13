<?php

namespace App\Repositories\Educacion;
use App\Models\Educacion\Importacion;

class ImportacionRepositorio
{
    public static function Listar_Importaciones()
    { 
        $data = Importacion::select('par_importacion.id','par_importacion.comentario',
                                    'par_importacion.fechaActualizacion','par_importacion.estado',
                                    // 'case when Importacion.estado = '.'PE'.'then'.'pendiente'.'else Importacion.estado end as estado', 
                                    'adm_users.name','par_fuenteimportacion.nombre','par_fuenteimportacion.formato')
                ->join('adm_users', 'adm_users.id', '=', 'par_importacion.usuarioId_crea')
                ->join('par_fuenteimportacion', 'par_fuenteimportacion.id', '=', 'par_importacion.fuenteImportacion_id')
                ->where("par_importacion.estado", "=", "PE")
                ->get();

        return $data;
    }
    
    public static function ImportacionPor_Id($id)
    { 
        $entidad = Importacion::select('par_importacion.id','par_importacion.comentario',
                                    'par_importacion.fechaActualizacion','par_importacion.estado',
                                    'adm_users.name','par_fuenteimportacion.nombre','par_fuenteimportacion.formato','par_importacion.created_at')
                ->join('adm_users', 'adm_users.id', '=', 'par_importacion.usuarioId_crea')
                ->join('par_fuenteimportacion', 'par_fuenteimportacion.id', '=', 'par_importacion.fuenteImportacion_id')
                ->where("par_importacion.id", "=", $id)
                ->first();

        return $entidad;
    }
}