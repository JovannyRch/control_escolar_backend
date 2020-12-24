<?php

namespace App\Http\Controllers\Api;

use App\Models\Ciclo;
use App\Models\Alumno;
use App\Models\Materia;
use App\Models\Inscripcion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CalificacionFinal;
use App\Models\Clase;
use Illuminate\Support\Facades\DB;

class AlumnoController extends Controller
{
    public function materias(Request $request){
        $user = $request->user();
        $ciclo_id = Ciclo::getActual();
        $alumno_id = Alumno::select('id')->firstWhere('user_id',$user->id)->id;
        $inscripcion = Inscripcion::
            where('alumno_id',$alumno_id)
            ->where('ciclo_id',$ciclo_id)->first();
           
        if(!$inscripcion){
            return response(['message' => "El alumno no está inscrito en el ciclo actual"],404);
        }
        
        $data = Materia::select('id','nombre')->where('grado_id',$inscripcion->grado_id)->get();
        return response(compact('data'));
        
    }

    public function inscripcion(Request $request){

    }

    public function materiasConPromediosFinales(Request $request){
        $user = $request->user();
        $ciclo_id = Ciclo::getActual();
        $alumno_id = Alumno::select('id')->firstWhere('user_id',$user->id)->id;
        $inscripcion = Inscripcion::
            where('alumno_id',$alumno_id)
            ->where('ciclo_id',$ciclo_id)->first();
           
        if(!$inscripcion){
            return response(['message' => "El alumno no está inscrito en el ciclo actual"],404);
        }
        
        $clases = Clase::where('grado_id', $inscripcion->grado_id)->where('grupo_id', $inscripcion->grupo_id)->where('ciclo_id', $ciclo_id)->select('materia_id', 'id')->get();
        $data = array();
        foreach ($clases as $clase) {
            $registroCalificacion = CalificacionFinal::where('clase_id', $clase->id)->where('alumno_id', $alumno_id)->first();
            $promedio = "0.0";
            if(!$registroCalificacion){
                $promedio = "--";
            }else{
                $promedio = strval($registroCalificacion->calificacion);
            }
            $data[] = array(
                'clase_id'=> $clase->id,
                'materia' => Materia::find($clase->materia_id)->nombre,
                'promedio' => $promedio
            );
        }
        return response($data);
    }


    //Profesores de un alumno
    public function profesoresConMaterias(Request $request){
        $user = $request->user();
        $ciclo_id = Ciclo::getActual();
        $alumno_id = Alumno::select('id')->firstWhere('user_id',$user->id)->id;
        $inscripcion = Inscripcion::
            where('alumno_id',$alumno_id)
            ->where('ciclo_id',$ciclo_id)->first();
           
        if(!$inscripcion){
            return response(['message' => "El alumno no está inscrito en el ciclo actual"],404);
        }
        $PROFESOR_FULLNAME = "CONCAT(CONCAT(CONCAT(CONCAT(profesores.nombre, ' '),profesores.paterno), ' '), profesores.materno) as profesor";
        $clases = Clase::where('clases.grado_id', $inscripcion->grado_id)
                    ->where('clases.grupo_id', $inscripcion->grupo_id)
                    ->where('clases.ciclo_id', $ciclo_id)
                    ->join('materias', 'clases.materia_id', '=', 'materias.id')
                    ->join('profesores', 'clases.profesor_id', '=', 'profesores.id')
                    ->select('clases.materia_id', 'clases.profesor_id', 'clases.id as clase_id', DB::raw($PROFESOR_FULLNAME), 'materias.nombre as materia')
                    ->get();

       
        return response($clases);
    }


}
