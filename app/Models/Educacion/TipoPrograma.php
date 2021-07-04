<?php

namespace App\Models\Educacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoPrograma extends Model
{
    use HasFactory;
    protected $table = "TipoPrograma"; 
    
    protected $fillable = [
        'codigo',
        'nombre'];
}

