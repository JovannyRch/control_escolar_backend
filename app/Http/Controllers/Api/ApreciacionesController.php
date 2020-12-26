<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Apreciacion;
use App\Models\Ciclo;
use App\Models\PreguntaApreciacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApreciacionesController extends Controller
{

    public function index(Request $request){
        $data =  DB::table('apreciaciones')
        ->join('ciclos', 'apreciaciones.ciclo_id', '=', 'ciclos.id')
        ->select("apreciaciones.*", "ciclos.nombre as ciclo")
        ->get();
        return response($data);
    }

    public function show(Request $request, $id){
        $item =  DB::table('apreciaciones')
        ->where('apreciaciones.id', $id)
        ->join('ciclos', 'apreciaciones.ciclo_id', '=', 'ciclos.id')
        ->select("apreciaciones.*", "ciclos.nombre as ciclo")
        ->get()
        ->first();
        
        if(!$item){
            return response(['message' => "Recurso no encontrado"],404);
        }
        $item = @json_decode(json_encode($item), true);
        return response($item);
    }

    public function create(Request $request){
        $ciclo_actual = Ciclo::getActual();

        if(!$ciclo_actual){return response(['message' => 'No hay ciclo activo'],404);}

        
        $request->validate([
            'instrucciones' => 'required',
        ]);
 
         
        try{
            $item = Apreciacion::create([
                "instrucciones" => $request->instrucciones,
                "ciclo_id" => $ciclo_actual
            ]);
            return response($item,201);
        } catch (\Throwable $th) {
            return response(['message' => 'Ocurrio un error al crear el recurso: '.$th],501);
        }
    }
    
    public function delete(Request $request, $id){
        $item = Apreciacion::find($id);
        if(!$item){return response(['message' => 'Recurso no encontrado'],404);}
        try{
            $item->delete();
            return response(['message' => 'Eliminación exitosa']);
        } catch (\Throwable $th) {
            return response(['message' => 'Ocurrio un error al eliminar']);
        }
    }

    public function update(Request $request,$id){
        $request->validate([
            'instrucciones'    => 'required|string',
            'status' => 'required'
        ]);
        $item = Apreciacion::find($id);
        if(!$item){return response(['message' => 'Recurso no encontrado'],404);}
        
        try {
            $item->instrucciones = $request->instrucciones;
            $item->status = $request->status;
            $item->save();
            return response(['message' => 'Actualización exitosa']);
        } catch (\Throwable $th) {
            return response(['message' => 'Ocurrio un error al actualizar'],501);
        }

    }

    public function preguntas(Request $request, $id){
        $data = PreguntaApreciacion::where('apreciacion_id',$id)->get();
        return response($data);
    }

    public function createPregunta(Request $request){
        $request->validate([
            'pregunta' => 'required',
            'apreciacion_id' => 'required'
        ]);

        try{
            $item = PreguntaApreciacion::create([
                "pregunta" => $request->pregunta,
                "apreciacion_id" => $request->apreciacion_id
            ]);
            return response($item,201);
        } catch (\Throwable $th) {
            return response(['message' => 'Ocurrio un error al crear el recurso: '.$th],501);
        }

    }

    public function deletePregunta(Request $request, $id){
        $item = PreguntaApreciacion::find($id);
        if(!$item){return response(['message' => 'Recurso no encontrado'],404);}
        try{
            $item->delete();
            return response(['message' => 'Eliminación exitosa']);
        } catch (\Throwable $th) {
            return response(['message' => 'Ocurrio un error al eliminar']);
        }
    }

}
