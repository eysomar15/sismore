<?php

namespace App\Utilities;
use Carbon\Carbon;
use DateTime;

class Utilitario
{
    public static function Fecha_ConFormato_DMY($fecha)
    {         
        return Carbon::createFromFormat('d/m/Y',substr($fecha,0,2) . "/" .substr($fecha,3,2). "/" . substr($fecha,6,4));
       
    }   
}