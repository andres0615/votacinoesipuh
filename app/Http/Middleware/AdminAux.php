<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminAux
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
        //dd(Auth::guard('persona')->check());
        $persona = Auth::guard('persona')->user();

        if($persona->tipo_persona_id == 6){
            if(session()->has('menu')){
                return $next($request);
            } else {
                return redirect()->route('authshowvalidation');
            }
        } else {
            dd("hola");
            return redirect()->route('inicio');
        }
        
    }
}
