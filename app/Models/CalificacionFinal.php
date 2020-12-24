<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalificacionFinal extends Model
{
   
    protected $table = "calificaciones_finales";
    protected $fillable = ['calificacion', 'clase_id','alumno_id'];

    use HasFactory;
}
