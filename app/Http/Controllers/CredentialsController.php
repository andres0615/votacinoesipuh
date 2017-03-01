<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Persona;
use App\TipoPersona;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Mail\OrderShipped;
use Illuminate\Support\Facades\Mail;

class CredentialsController extends BaseController
{

  public function showAdminValidation(){
      if(Auth::guard('persona')->user()->tipo_persona_id == 6 && !session()->exists('menu')){
        return view('auth.authadmin');
      } else {
        return redirect()->route('inicio');
      }
  }

  public function adminValidation($opcion){

  		session(['menu' => $opcion]);

		if($opcion == "normal"){
			return redirect()->route('inicio');
		} elseif($opcion == "auxiliar"){
			return redirect()->route('admin.persona.ingreso');
		}
  }

  public function showForgetPassword(){
    return view('forgetpassword');
  }

  public function proccessForgetPassword(Request $request){
    try{

    $persona = Persona::where('persona_identificacion', $request->persona_identificacion)->first();

    if(is_object($persona)){
      Mail::to($persona->persona_email)->send(new OrderShipped($persona));
      Flash('La contraseña ha sido enviada a tu correo electronico', 'success');
      return redirect()->route('login');
    } else {
      Flash('Identificacion no encontrada', 'danger');
      return redirect()->route('forgetpassword');
    }

    } catch(\Exception $e){
      Flash('Ha ocurrido un error: ' . $e->getMessage(), 'danger');
      return redirect()->route('forgetpassword');
    }

  }

}
