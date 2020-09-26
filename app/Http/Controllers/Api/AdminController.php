<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Tutor;
use App\Models\Alumno;
use App\Models\Profesor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    
    public function createUser(Request $request){
        $request->validate([
            'email'    => 'required|string|unique:users',
            'password' => 'required|string|confirmed',
            'nombre' =>  'required|string',
            'materno' => 'required|string',
            'paterno' => 'required|string',
            'role' => 'required|string'
        ]);
     
        $newUser = new User();
        $user = new User([
            'email'    => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role
        ]);
        $user->save();

        if($request->role == 'estudiante'){
            return $this->crearAlumno($request, $user->id);
        }

        else if($request->role == 'profesor'){
            return $this->crearProfesor($request, $user->id);
        }
        else if($request->role == 'tutor'){
            return $this->crearTutor($request,$user->id);
        }

    }

    public function crearAlumno($data, $user_id){
        $alumno = new Alumno();
        $alumno->materno = $data->materno;
        $alumno->paterno = $data->paterno;
        $alumno->nombre = $data->nombre;
        $alumno->user_id = $user_id;
        $alumno->save();
        return response($alumno);
    }

    public function crearProfesor($data, $user_id){
      
        $profesor = new Profesor();
        $profesor->materno = $data->materno;
        $profesor->paterno = $data->paterno;
        $profesor->nombre = $data->nombre;
        $profesor->user_id = $user_id;
        $profesor->save();
        return response($profesor);
    }



    public function crearTutor($data, $user_id){
      
        $tutor = new Tutor();
        $tutor->materno = $data->materno;
        $tutor->paterno = $data->paterno;
        $tutor->nombre = $data->nombre;
        $tutor->user_id = $user_id;
        $tutor->save();
        return response($tutor);
    }


    public function cargarAlumnos(Request $request){
        $data = DB::select('select a.id,a.nombre,a.materno,a.paterno,a.user_id, u.email,u.role from alumnos a inner join users u on a.user_id = u.id');
        return response($data);
    }


    public function cargarProfesores(Request $request){
        $data = DB::select('select a.id,a.nombre,a.materno,a.paterno,a.user_id, u.email,u.role from profesores a inner join users u on a.user_id = u.id');
        return response($data);
    }

    public function cargarTutores(Request $request){
        $data = DB::select('select a.id,a.nombre,a.materno,a.paterno,a.user_id, u.email,u.role from tutores a inner join users u on a.user_id = u.id');
        return response($data);
    }


    public function deleteUser(Request $request, $id){
        $user = User::find($id);
        if(!$user) return response(['message' => "Usuario no encontrado"],401);
        $user->delete();
        return response(['message' => "Usuario eliminado correctamente"],200);
    }


    
}
