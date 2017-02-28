<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Authenticate
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

        //dd(session()->all());
        //dd(session()->get('menu'));

        $persona = Auth::guard('persona');
        
        if($persona->check()){

            if($persona->user()->tipo_persona_id == 6 && !session()->has('menu') && !in_array($request->route()->getName(),array('authshowvalidation','authvalidation'))){
                return redirect()->route('authshowvalidation');
            }

            if($persona->user()->tipo_persona_id == 6 && session()->has('menu') && session()->get('menu') == 'auxiliar' && !in_array($request->route()->getName(),array('admin.persona.ingreso','admin.persona.identificaciones'))){
                return redirect()->route('admin.persona.ingreso');
            } else {
                return $next($request);
            }
        } else {
            return redirect()->route('login');
        }
    }
}
