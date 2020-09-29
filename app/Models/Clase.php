<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clase extends Model
{
    protected $table="clases";
    protected $fillable = ['profesor_id','grupo_id','grado_id','materia_id','ciclo_id'];
    use HasFactory;
}
