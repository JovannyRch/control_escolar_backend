<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ciclo extends Model
{
    use HasFactory;
    protected $table = "ciclos";
    protected $fillable = ['nombre', 'status'];


    static function getActual(){
        return Ciclo::select('id')->firstWhere('status','activo')->id;
    }
}
