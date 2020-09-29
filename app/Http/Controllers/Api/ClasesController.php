<?php

namespace App\Http\Controllers\Api;

use App\Models\Ciclo;
use App\Models\Clase;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ClasesController extends Controller
{
    
    public function index(Request $request){
        $items = Clase::all();
        return response($items);
    }

    public function create(Request $request){
        $ciclo_actual = Ciclo::getActual();

        if(!$ciclo_actual){return response(['message' => 'No hay ciclo activo'],404);}
        
        $request->validate([
            'profesor_id' => 'required',
            'grupo_id' => 'required',
            'grado_id' => 'required',
            'materia_id' => 'required'
        ]);
         
        try{
            $item = Clase::create([
                "profesor_id" => $request->profesor_id,
                "grupo_id" => $request->grupo_id,
                "grado_id" => $request->grado_id,
                "materia_id" => $request->materia_id,
                "ciclo_id" => $ciclo_actual
            ]);
            return response($item,201);
        } catch (\Throwable $th) {
            return response(['message' => 'Ocurrio un error al crear la clase: '.$th],501);
        }
    }
}
