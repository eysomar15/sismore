<?php

namespace App\Models\Educacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NivelModalidad extends Model
{
    use HasFactory;
<<<<<<< HEAD
    protected $table = "edu_nivelModalidad"; 
=======
    protected $table = "edu_nivelmodalidad"; 
>>>>>>> 29d5158a9b31bab00e8d863dd2a23a9bbb71f1f6
    
    protected $fillable = [
        'codigo',
        'nombre'];
}
