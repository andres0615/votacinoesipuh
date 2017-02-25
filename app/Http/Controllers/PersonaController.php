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

class PersonaController extends BaseController
{
  public function index(){
    $personas = Persona::orderBy('persona_nombre', 'ASC')->paginate(5);
    return view('admin.persona.index',compact('personas'));
  }

  public function create(){
    $data = array();
    $data["title"] = "Crear persona";
    $data["edit"] = false;
    $data["tipos_persona"] = $this->getTiposPersona();
    $data["activo"] = "";
    $data["ingreso"] = "";

    return view('admin.persona.form', $data);
  }

  public function store(Request $request){

    try{

      $imagen = $request->file('persona_foto');

      if ($imagen != null){

        if(in_array($imagen->getMimeType(), array("image/jpeg", "image/png"))){
          $nombre_imagen = 'app/persona_foto/' . str_random(5) . '-' . str_replace(' ', '', $imagen->getClientOriginalName());
          $path = public_path($nombre_imagen);
          Image::make($imagen->getRealPath())->resize(400, 400)->save($path);
        } else {
          throw new \Exception("La imagen debe ser en formato png o jpg");
        }

      } else {
        $nombre_imagen = 'app/persona_foto/default_user.png';
      }

      $request_p = array();

      foreach($request->all() as $key => $value){
        if($key == "persona_foto"){
          $request_p[$key] = $nombre_imagen;
        } else {
          $request_p[$key] = $value;
        }
      }

      if(! isset($request_p["persona_foto"])){
        $request_p["persona_foto"] = $nombre_imagen;
      }

      $persona = new Persona($request_p);
      $persona->save();
      Flash('La persona se creo correctamente.', 'success');

      return redirect()->route('admin.persona.index');
    } catch(\Exception $e){
      //$error = new ErrorController();
      //$error->storeErrorException($e);
      //Flash($error->mensaje, 'danger');
      Flash('Ha ocurrido un error: ' . $e->getMessage(), 'danger');

      return redirect()->route('admin.persona.create');
    }

  }

  public function edit($id){
    $data = array();

    $persona = Persona::find($id);
    $data["persona"] = $persona;
    $data["tipos_persona"] = $this->getTiposPersona();
    $data["title"] = "Editar persona";
    $data["edit"] = true;
    $data["activo"] = ($persona->persona_activa)?'checked':'';
    $data["ingreso"] = ($persona->persona_ingreso)?'checked':'';
    $data["id"] = $id;


    return view('admin.persona.form', $data);
  }

  public function getTiposPersona(){
    $tipos_persona = TipoPersona::all();

    $tipos_persona_arr = array();

    foreach ($tipos_persona as $tipo_persona) {
      $tipos_persona_arr[$tipo_persona->tipo_persona_id] = $tipo_persona->tipo_persona_nombre;
    }

    return $tipos_persona_arr;
  }

  public function update(Request $request, $id){

    $persona = Persona::find($id);

    $persona->persona_nombre = $request->persona_nombre;
    $persona->persona_apellido = $request->persona_apellido;
    $persona->persona_codigo_alterno = $request->persona_codigo_alterno;
    $persona->tipo_persona_id = $request->tipo_persona_id;
    $persona->persona_activa = isset($request->persona_activa);
    $persona->persona_ingreso = isset($request->persona_ingreso);
    $persona->persona_identificacion = $request->persona_identificacion;

    $imagen = $request->file('persona_foto');

    if ($imagen){

      if(in_array($imagen->getMimeType(), array("image/jpeg", "image/png"))){
        $nombre_imagen = 'app/persona_foto/' . str_random(5) . '-' . str_replace(' ', '', $imagen->getClientOriginalName());
        $path = public_path($nombre_imagen);
        Image::make($imagen->getRealPath())->resize(400, 400)->save($path);
      } else {
        throw new \Exception("La imagen debe ser en formato png o jpg");
      }

      $persona->persona_foto = $nombre_imagen;

    }

    $persona->save();
    Flash('La persona se actualizo correctamente.', 'success');

    return redirect()->route('admin.persona.index');

  }

  public function destroyMass(Request $request){
    DB::beginTransaction();
    try{
      foreach($request->ids as $id){
        $persona = Persona::find($id);
        $persona->delete();
      }
      DB::commit();
      Flash("La persona se elimino con exito", 'success');

      return redirect()->route('admin.persona.index');

    } catch(\Exception $e){
      Flash('Ha ocurrido un error: ' . $e->getMessage(), 'danger');
      DB::rollBack();

      return redirect()->route('admin.persona.create');
    }
  }

  public function destroy($id){
    try{
      $persona = Persona::find($id);
      $persona->delete();
      Flash("La persona se elimino con exito", 'success');

      return redirect()->route('admin.persona.index');

    } catch(\Exception $e){
      Flash('Ha ocurrido un error: ' . $e->getMessage(), 'danger');

      return redirect()->route('admin.persona.create');
    }
  }

  public function ingresoForm(){
    return view('admin.persona.ingreso');
  }

  public function getIdentificacionesJson(){
    $identificaciones = Persona::select(["persona_identificacion"])->get()->pluck('persona_identificacion')->toArray();

    return response($identificaciones);
  }

}
