<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AsistenciasController extends Controller
{
    public function create(Request $request){
        $request->validate([
        ]);
        try{
            $item = Asistencia::create([]);
            return response($item);
        } catch (\Throwable $th) {
            return response(['message' => 'Ocurrio un error al crear'],501);
        }
    }
}
