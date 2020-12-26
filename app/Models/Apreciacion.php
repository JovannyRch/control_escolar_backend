<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apreciacion extends Model
{
    protected $table = "apreciaciones";

    protected $fillable = ["ciclo_id","instrucciones","status"];
    use HasFactory;
}
