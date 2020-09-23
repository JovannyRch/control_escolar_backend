<?php

namespace App\Http\Controllers\Api;

use App\Models\Materia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MateriaController extends Controller
{
    
    public function show(Request $request, int $id){
        $materia = Materia::select('id','nombre','plan')->find($id);
        if(!$materia){
            return response(['message' => "Materia no encontrada"],404);
        }
        return response($materia);
    }
}
