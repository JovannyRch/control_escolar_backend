<?php

namespace App\Http\Controllers\Api;

use App\Models\Grado;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Materia;

class GradosController extends Controller
{
    public function index(Request $request){
        $items = Grado::all();
        return response($items);
    }

    public function show(Request $request, $id){
        $item = Grado::find($id);
        if(!$item){return response(['message' => "Recurso no encontrado"],404);}
        return response($item);
    }

    public function delete(Request $request, $id){
        $item = Grado::find($id);
        if(!$item){return response(['message' => "Recurso no encontrado"]);}
        try{
            $item->delete();
            return response(['message' => 'Eliminación exitosa']);
        } catch (\Throwable $th) {
            return response(['message' => 'Ocurrio un error al eliminar '.$th],501);
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
            'nombre'    => 'required|string|unique:grados,id,'.$id,  
        ]);
        $item = Grado::find($id);
        try {
            $item->nombre = $request->nombre; 
            $item->save();
            return response(['message' => 'Actualización exitosa']);
        } catch (\Throwable $th) {
            return response(['message' => 'Ocurrio un error al actualizar'],501);
        }
    }

    public function materias(Request $request, $id){
        $materias = Materia::where('grado_id',$id)->get();
        if($materias == null){
            return [];
        }
        return response($materias);
    }
}
