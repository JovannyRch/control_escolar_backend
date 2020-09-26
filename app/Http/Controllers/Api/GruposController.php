<?php

namespace App\Http\Controllers\Api;

use App\Models\Grupo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GruposController extends Controller
{
    public function index(Request $request){
        $data = Grupo::all();
        return response($data);
    }

    public function create(Request $request){
        $request->validate([
            'nombre'    => 'required|string|unique:grupos',
        ]);
        $item = Grupo::create([]);
        return response(item);
    }

    public function delete(Request $request, $id){
        $item = Grupo::find($id);
        try {
            $item->remove();
            return response(['message' => 'Grupo eliminado correctamente']);
        } catch (\Throwable $th) {
            return response(['message' => 'Ocurrio un error al eliminar'],501);
        }
    }

    

    public function update(Request $request, $id){
        $request->validate([
            'nombre'    => 'required|string|unique:grupos,'.$id,
        ]);
       try {
        $item = Grupo::find($id);
        $item->nombre = $request->nombre;
        $item->save();
        return response(['message' => 'Actualizado con éxito']);
       } catch (\Throwable $th) {
           return response(['message' => 'Ocurrio un error al actualizar'],501);
       }
    }
}
