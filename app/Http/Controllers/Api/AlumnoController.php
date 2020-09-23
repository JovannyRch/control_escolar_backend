<?php

namespace App\Http\Controllers\Api;

use App\Models\Ciclo;
use App\Models\Alumno;
use App\Models\Materia;
use App\Models\Inscripcion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AlumnoController extends Controller
{
    public function materias(Request $request){
        $user = $request->user();
        $ciclo_id = Ciclo::getActual();
        if( $user->role == "student" || $user->role == "estudiante" ) {
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
        else if($user->role == "teacher"){

        }
        
    }

    public function inscripcion(Request $request){

    }
}
