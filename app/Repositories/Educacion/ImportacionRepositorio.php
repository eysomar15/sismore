<?php

namespace App\Repositories\Educacion;
use App\Models\Educacion\Importacion;

class ImportacionRepositorio
{
    public static function Listar_Importaciones()
    { 
        $data = Importacion::select('Importacion.id','Importacion.comentario',
                                    'Importacion.fechaActualizacion','Importacion.estado',
                                    // 'case when Importacion.estado = '.'PE'.'then'.'pendiente'.'else Importacion.estado end as estado', 
                                    'users.name','fuenteimportacion.nombre','fuenteimportacion.formato')
                ->join('users', 'users.id', '=', 'Importacion.usuarioId_crea')
                ->join('fuenteimportacion', 'fuenteimportacion.id', '=', 'Importacion.fuenteImportacion_id')
                ->where("importacion.estado", "=", "PE")
                ->get();

        return $data;
    }
    
    public static function ImportacionPor_Id($id)
    { 
        $entidad = Importacion::select('Importacion.id','Importacion.comentario',
                                    'Importacion.fechaActualizacion','Importacion.estado',
                                    'users.name','fuenteimportacion.nombre','fuenteimportacion.formato','Importacion.created_at')
                ->join('users', 'users.id', '=', 'Importacion.usuarioId_crea')
                ->join('fuenteimportacion', 'fuenteimportacion.id', '=', 'Importacion.fuenteImportacion_id')
                ->where("importacion.id", "=", $id)
                ->first();

        return $entidad;
    }
}