<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RespuestaApreciacion extends Model
{

    protected $table = "respuesta_apreciaciones";
    protected $fillable = ['puntaje', 'pregunta_id'];


    use HasFactory;
}
