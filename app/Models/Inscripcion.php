<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inscripcion extends Model
{
    protected $table = "inscripciones";
    protected $fillable = ['turno','alumno_id','grupo_id','grado_id','ciclo_id'];
    use HasFactory;
    
    
}
