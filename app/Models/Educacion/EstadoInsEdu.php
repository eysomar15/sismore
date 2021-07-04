<?php

namespace App\Models\Educacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadoInsEdu extends Model
{
    use HasFactory;
    protected $table = "EstadoInsEdu"; 
    
    protected $fillable = [
        'codigo',
        'nombre'];
}
