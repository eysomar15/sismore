<?php

namespace App\Models\Educacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ugel extends Model
{
    use HasFactory;
    protected $table = "Ugel"; 
    
    protected $fillable = [
        'codigo',
        'nombre'];
}
