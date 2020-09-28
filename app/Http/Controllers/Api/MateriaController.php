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

    public function index(Request $request){
        $items = Materia::all();
        return response($items);
    }

    public function delete(Request $request, $id){
        $item = Materia::find($id);
        try{
            $item->remove();
            return response(['message' => 'Elimininación exitosa']);
        } catch (\Throwable $th) {
            return response(['message' => 'Ocurrio un error al eliminar']);
        }
    }

 

    public function create(Request $request){
        $request->validate([
            'nombre'    => 'required|string|unique:materias',
            'plan'    => 'required|string',
            'grado_id'    => 'required|number',
        ]);
        try{
            $item = Materia::create([
                "nombre" => $request->nombre,
                "plan" => $request->plan,
                "grado_id" => $request->grado_id
            ]);
            return response($item);
        } catch (\Throwable $th) {
            return response(['message' => 'Ocurrio un error al crear'],501);
        }
    }
   
}

