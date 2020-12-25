<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ciclo;
use App\Models\Inscripcion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InscripcionesController extends Controller
{
    //Inscribir

    public function index(Request $request){
        $ciclo_id = Ciclo::getActual();
        $ALUMNO_FULLNAME = "CONCAT(CONCAT(CONCAT(CONCAT(alumnos.nombre, ' '),alumnos.paterno), ' '), alumnos.materno) as alumno";
        $data =  DB::table('inscripciones')
        ->where('inscripciones.ciclo_id', $ciclo_id)
        ->join('alumnos', 'inscripciones.alumno_id', '=', 'alumnos.id')
        ->join('grupos', 'inscripciones.grupo_id', '=', 'grupos.id')
        ->join('grados', 'inscripciones.grado_id', '=', 'grados.id')
        ->select("inscripciones.id", "grupos.nombre as grupo", "grados.nombre as grado", "alumnos.nombre as ciclo", DB::raw($ALUMNO_FULLNAME))
        ->get();
        return response($data);
    }
    
    public function create(Request $request){
        $ciclo_actual = Ciclo::getActual();

        if(!$ciclo_actual){return response(['message' => 'No hay ciclo activo'],404);}

        
        $request->validate([
            'alumno_id' => 'required',
            'grupo_id' => 'required',
            'grado_id' => 'required',
        ]);

        $total = Inscripcion::
             where('alumno_id', $request->alumno_id)
            ->where('ciclo_id', $ciclo_actual)
            ->count();
        if($total > 0){
            return response(['message' => 'El alumno ya esta inscrito en la clase'],400);
        }
         
        try{
            $item = Inscripcion::create([
                "alumno_id" => $request->alumno_id,
                "grupo_id" => $request->grupo_id,
                "grado_id" => $request->grado_id,
                "ciclo_id" => $ciclo_actual
            ]);
            return response($item,201);
        } catch (\Throwable $th) {
            return response(['message' => 'Ocurrio un error al crear la inscripcion: '.$th],501);
        }
    }

    public function delete(Request $request, $id){
        $item = Inscripcion::find($id);
        if(!$item){return response(['message' => 'Recurso no encontrado'],404);}
        try{
            $item->delete();
            return response(['message' => 'Eliminación exitosa']);
        } catch (\Throwable $th) {
            return response(['message' => 'Ocurrio un error al eliminar']);
        }
    }
}
