<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Padre
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        return $next($request);
        $user = $request->user();
        if(Auth::guard('api')->check() && Auth::guard('api')->User()->role =='padre'){
            return $next($request);
        }
        return response(['message' => "Permission Denied"],401);
    }
}
