<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Alumno
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
       
        //TODO: Remove tash roles
        
        if (Auth::guard('api')->check() && (Auth::guard('api')->User()->role == 'alumno')){
            return $next($request);
        }
        return response(['message' => "Permission Denied :P"],401);
    }
}
