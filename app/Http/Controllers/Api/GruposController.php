<?php

namespace App\Http\Controllers\Api;

use App\Models\Ciclo;
use App\Models\Grupo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        if(!$item){return response(['message' => 'Recurso no encontrado'],404);}
        try {
            $item->delete();
            return response(['message' => 'Grupo eliminado correctamente']);
        } catch (\Throwable $th) {
            return response(['message' => 'Ocurrio un error al eliminar '.$th],501);
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

    public function alumnos(Request $request,$grupo_id){
        $ciclo_actual = Ciclo::getActual();
        if(!$ciclo_actual){return response(['message' => 'No se encontró un ciclo activo'],404);}
        $alumnos = DB::select("SELECT a.* from alumnos as a where a.id in (SELECT i.alumno_id from inscripciones as i where i.grupo_id= $grupo_id and i.ciclo_id = $ciclo_actual)");
        return response($alumnos);
    }
}
