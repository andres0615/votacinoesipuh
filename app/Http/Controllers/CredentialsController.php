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

}
