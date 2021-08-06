<?php

namespace App\Models\Vivienda;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Datass extends Model
{
    use HasFactory;

    protected $table = "viv_datass"; 
    public $timestamps = false;

    /**
     * The attributes that are mass assignable,
     *
     * @var array
     */
    protected $fillable = [
                'importacion_id', 
                'departamento',
                'provincia',
                'distrito',
                'ubigeo_cp',
                'centro_poblado',
                'total_viviendas',
                'viviendas_habitadas',
                'total_poblacion',
                'predomina_primera_lengua',
                'tiene_energia_electrica',
                'tiene_internet',
                'tiene_establecimiento_salud',
                'pronoei',
                'primaria',
                'secundaria',
                'sistema_agua',
                'sistema_disposicion_excretas',
                'prestador_codigo',
                'prestador_de_servicio_agua',
                'tipo_organizacion_comunal',
                'cuota_familiar',
                'servicio_agua_continuo',
                'sistema_cloracion',
                'realiza_cloracion_agua',
                'tipo_sistema_agua',              

                            ];
}
