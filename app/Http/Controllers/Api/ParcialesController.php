<?php

namespace App\Http\Controllers\Api;

use App\Models\Parcial;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ParcialesController extends Controller
{   

    public function index(Request $request){
        $items = Parcial::all();
        return response($items);
    }

    public function create(Request $request){
        $request->validate([
            'nombre'    => 'required|string|unique:parciales',
        ]);
        try{
            $item = Parcial::create([
                "nombre" => $request->nombre
            ]);
            return response($item);
        } catch (\Throwable $th) {
            return response(['message' => 'Ocurrio un error al crear'],501);
        }
    }

    public function delete(Request $request, $id){
        $item = Parcial::find($id);
        if(!$item){return response(['message' => 'Recurso no encontrado'],404);}
        try{
            $item->delete();
            return response(['message' => 'Eliminación exitosa']);
        } catch (\Throwable $th) {
            return response(['message' => 'Ocurrio un error al eliminar '.$th], 401);
        }
    }

    public function update(Request $request, $id){
        $request->validate([
            'nombre'    => 'required|string|unique:parciales,id,'.$id,  
        ]);
        $item = Parcial::find($id);
        if(!$item){return response(['message' => 'Recurso no encontrado'],404);}
        try{
            $item->nombre = $request->nombre;
            $item->update();
            return response(['message' => 'Actualización exitosa']);
        } catch (\Throwable $th) {
            return response(['message' => 'Ocurrio un error al actualizar']);
        }
    }
}
