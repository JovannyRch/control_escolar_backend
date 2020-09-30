<?php

namespace App\Http\Controllers\Api;

use App\Models\Ciclo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ProfesoresController extends Controller
{
    public function materias(Request $request){
        $id_profesor = $request->user()->profesor()->id;
        
        $ciclo_actual = Ciclo::getActual();
        
        if(!$ciclo_actual){return response(['message' => 'No se encontró un ciclo activo'],404);}
        $materias = DB::select("SELECT m.* from materias m where m.id in (SELECT c.materia_id from clases as c where c.profesor_id = $id_profesor and c.ciclo_id = $ciclo_actual)");
        return response($materias);
    }
    
    //Recibe el id de la materia
    public function gruposPorMateria(Request $request,$id){
        $id_profesor = $request->user()->profesor()->id;
        $ciclo_actual = Ciclo::getActual();
        if(!$ciclo_actual){return response(['message' => 'No se encontró un ciclo activo'],404);}
        $grupos = DB::select("SELECT g.* from grupos g where g.id in (SELECT c.grupo_id from clases as c where c.profesor_id = $id_profesor and c.ciclo_id = $ciclo_actual and c.materia_id = $id)");
        return response($grupos);
    }

    
}
