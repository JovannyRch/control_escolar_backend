<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materia extends Model
{
    protected $table = "materias";
    protected $fillable = ["nombre","plan","grado_id"];
    use HasFactory;

}
