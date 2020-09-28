<?php

namespace App\Http\Controllers\Api;

use App\Models\Grado;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GradosController extends Controller
{
    public function index(Request $request){
        $items = Grado::all();
        return response($items);
    }

    public function delete(Request $request, $id){
        $item = Grado::find($id);
        try{
            $item->remove();
            return response(['message' => 'Elimininación exitosa']);
        } catch (\Throwable $th) {
            return response(['message' => 'Ocurrio un error al eliminar']);
        }
    }

    public function create(Request $request){
        $request->validate([
            'nombre'    => 'required|string|unique:grados',
        ]);
        $item = Grado::create([
        "nombre" => $request->nombre
        ]);
        return response($item);
    }



    public function update(Request $request,$id){
        $request->validate([
            'nombre'    => 'required|string|unique:grados,'.$id,  
        ]);
        $item = Grado::find($id);
        try {
            $item->nombre = $request->nombre; 
            $item->save();
        } catch (\Throwable $th) {
            return response(['message' => 'Ocurrio un error al actualizar'],501);
        }
    }
}
