<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreguntaApreciacion extends Model
{
    protected $table = "preguntas_apreciaciones";
    protected $fillable = ['apreciacion_id', 'pregunta'];
    use HasFactory;
}
