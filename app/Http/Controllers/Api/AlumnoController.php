<?php

namespace App\Http\Controllers\Api;

use App\Models\Ciclo;
use App\Models\Alumno;
use App\Models\Materia;
use App\Models\Inscripcion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Clase;

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
        
        $data = Clase::where('grado_id', $inscripcion->grado_id)->where('grupo_id', $inscripcion->grupo_id)->where('ciclo_id', $ciclo_id)->get();
        return response(compact('inscripcion'));
    }
}
