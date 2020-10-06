<?php

namespace App\Http\Controllers\Api;

use App\Models\Ciclo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CiclosController extends Controller
{
    
    public function index(Request $request){
        $data = Ciclo::orderBy('id','desc')->get();
        return response($data);
    }


    public function crear(Request $request){
        $request->validate([
            'nombre'    => 'required|string|unique:ciclos',
        ]);
        
        $ciclo = Ciclo::create(['nombre' => $request->nombre]);
        $ciclo->status = "noactivo";
        return response($ciclo);
    }

    
    public function update(Request $request,$id){
       
        $request->validate([
            'nombre'    => 'required|string|unique:ciclos,id,'.$id,  
        ]);
        $ciclo = Ciclo::find($id);
        $ciclo->nombre = $request->nombre;
        $ciclo->save();
        return response(['message' => 'Ciclo actualizado correctamente']);
    }


    public function activar(Request $request, $id){
        
        try {
            $ciclo = Ciclo::find($id);
            if($ciclo->status == "noactivo"){
                Ciclo::where('status','activo')->update(['status' => 'noactivo']); 
                $ciclo->status = "activo";
                $ciclo->save();
            }
            return response($ciclo);
        } catch (\Throwable $th) {
            return response(['message' => "An error ocurred updating item"],501);
        }
    }

    public function eliminar(Request $request, $id){
        try {
            Ciclo::destroy($id);
            return response(['message' => "Ciclo eliminado correctamente"]);
        } catch (\Throwable $th) {
            return response(['message' => "Ocurrio un error al eliminar el ciclo"],501);
        }
    }
}
