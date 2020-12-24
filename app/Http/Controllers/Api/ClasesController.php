<?php

namespace App\Http\Controllers\Api;

use App\Models\Ciclo;
use App\Models\Clase;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ClasesController extends Controller
{
    
    public function index(Request $request){
        $ciclo_id = Ciclo::getActual();
        $PROFESOR_FULLNAME = "CONCAT(CONCAT(CONCAT(CONCAT(profesores.nombre, ' '),profesores.paterno), ' '), profesores.materno) as profesor";
        $data =  DB::table('clases')
        ->where('clases.ciclo_id', $ciclo_id)
        ->join('materias', 'clases.materia_id', '=', 'materias.id')
        ->join('profesores', 'clases.profesor_id', '=', 'profesores.id')
        ->join('grupos', 'clases.grupo_id', '=', 'grupos.id')
        ->join('grados', 'clases.grado_id', '=', 'grados.id')
        ->join('ciclos', 'clases.ciclo_id', '=', 'ciclos.id')
        ->select("clases.id",DB::raw($PROFESOR_FULLNAME),"materias.nombre as materia", "grupos.nombre as grupo", "grados.nombre as grado", "ciclos.nombre as ciclo")
        ->get();
        return response($data);
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

        $total = Clase::where('profesor_id', $request->profesor_id)
            ->where('grupo_id', $request->grupo_id)
            ->where('materia_id', $request->materia_id)
            ->where('ciclo_id', $ciclo_actual)
            ->where('grado_id', $request->grado_id)->count();
        if($total > 0){
            return response(['message' => 'Ya existe la clase'],400);
        }
         
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

    public function delete(Request $request, $id){
        $item = Clase::find($id);
        if(!$item){return response(['message' => "Recurso no encontrado"]);}
        try{
            $item->delete();
            return response(['message' => 'Eliminación exitosa']);
        } catch (\Throwable $th) {
            return response(['message' => 'Ocurrio un error al eliminar '.$th],501);
        }
    }
}
