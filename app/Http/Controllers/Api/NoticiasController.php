<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Noticia;
use Illuminate\Http\Request;

class NoticiasController extends Controller{
    
    public function index(Request $request){
        $items = Noticia::all();
        return response($items);
    }

    public function show(Request $request, int $id){
        $item = Noticia::find($id);
        if(!$item){
            return response(['message' => "Recurson no encontrado"],404);
        }
        return response($item);
    }

    public function create(Request $request){
      
        try{
            $item = Noticia::create([
                "title" => $request->title,
                "body" => $request->body,
                "img" => $request->img,
            ]);
            return response($item);
        } catch (\Throwable $th) {
            return response(['message' => 'Ocurrio un error al crear'],501);
        }
    }

    public function delete(Request $request, $id){
        $item = Noticia::find($id);
        if(!$item){return response(['message' => 'Recurso no encontrado'],404);}
        try{
            $item->delete();
            return response(['message' => 'Eliminación exitosa']);
        } catch (\Throwable $th) {
            return response(['message' => 'Ocurrio un error al eliminar '.$th], 401);
        }
    }

    public function update(Request $request, $id){
       
        $item = Noticia::find($id);
        if(!$item){return response(['message' => 'Recurso no encontrado'],404);}
        try{
            $item->title = $request->title;
            $item->body = $request->body;
            $item->img = $request->img;
            $item->update();
            return response(['message' => 'Actualización exitosa']);
        } catch (\Throwable $th) {
            return response(['message' => 'Ocurrio un error al actualizar']);
        }
    }
}