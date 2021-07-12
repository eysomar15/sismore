<?php

namespace App\Models\Educacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NivelModalidad extends Model
{
    use HasFactory;
    protected $table = "edu_nivelmodalidad"; 
    
    protected $fillable = [
        'codigo',
        'nombre'];
}
