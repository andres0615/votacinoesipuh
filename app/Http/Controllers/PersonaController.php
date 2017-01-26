<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Persona;

class PersonaController extends BaseController
{
  public function index(){
    $personas = Persona::orderBy('persona_nombre', 'ASC')->paginate(5);
    return view('admin.persona.index',compact('personas'));
  }

  public function create(){

  }
}
