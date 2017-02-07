<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * Handle an authentication attempt.
     *
     * @return Response
     */
    public function authenticate($codigo_alterno)
    {
        $credentials = array('persona_codigo_alterno' => $codigo_alterno);
        if ($this->guard()->attempt($credentials)) {
            // Authentication passed...
            return redirect()->route('profile');
        }
        return redirect()->route('login')->withErrors('Codigo errado');
    }

    public function login(Request $request){
        return $this->authenticate($request->persona_codigo_alterno);
    }

    protected function guard()
    {
        return Auth::guard('persona');
    }

    public function username()
    {
        return 'persona_codigo_alterno';
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->flush();

        $request->session()->regenerate();

        return redirect('/login');
    }

}
