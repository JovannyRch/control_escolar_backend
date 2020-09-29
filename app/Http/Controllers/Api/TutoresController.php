<?php

namespace App\Http\Controllers\Api;

use App\Models\Alumno;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class TutoresController extends Controller
{
    public function agregarAlumno(Request $request){
        $request->validate([
            'tutor_id'    => 'required',
            'alumno_id'    => 'required',
        ]);
        try{
            $total = DB::table('alumnos_on_tutores')->where('alumno_id',$request->alumno_id)->count();
            if($total >= 1){
                return response(['message' => 'El alumno ya tiene asignado un tutor'],401);
            }
            $item = DB::insert('insert into alumnos_on_tutores(tutor_id,alumno_id) values(?,?)',[$request->tutor_id,$request->alumno_id]);
            return response($item);
        } catch (\Throwable $th) {
            return response(['message' => 'Ocurrio un error al agregar el alumno al tutor'.$th],501);
        }
    }


    public function deleteTutorado(Request $request){
        $request->validate([
            'alumno_id'    => 'required',
        ]);
        try{
            DB::table('alumnos_on_tutores')->where('alumno_id',$request->alumno_id)->delete();
            return response(['message' => 'Eliminación exitosa']);
        } catch (\Throwable $th) {
            return response(['message' => 'Ocurrio un error al eliminar']);
        }
    }

    //$id = Id del tutor
    public function tutorados(Request $request, $id){
        $tutorados = DB::select("select * from alumnos where id in (select alumno_id from  alumnos_on_tutores where tutor_id = $id)");
        return response($tutorados);
    }

    


}
