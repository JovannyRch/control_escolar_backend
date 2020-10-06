<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parcial extends Model
{
    protected $table = "parciales";
    protected $fillable = ['nombre'];
    use HasFactory;
}
