<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Admin
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
        if(Auth::guard('persona')->check()){
            return $next($request);
        } else {
            return redirect()->route('login');
        }
    }
}
