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
use App\Mail\OrderShipped;
use Illuminate\Support\Facades\Mail;
use Storage;
use Resource;

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

      return redirect()->route('admin.persona.edit',["persona" => $persona->persona_id]);
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
    $persona->persona_email = $request->persona_email;

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

    return redirect()->route('admin.persona.edit',["persona" => $persona->persona_id]);

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

  public function ingreso(Request $request){
  try{

      $persona = Persona::where('persona_identificacion', $request->persona_identificacion)->first();

      if(is_object($persona)){
        $persona->persona_ingreso = isset($request->persona_ingreso);
        $persona->save();

        Flash('Proceso exitoso', 'success');
        return redirect()->route('admin.persona.ingreso');

        //dd($request->all());
      } else {
        Flash('Identificacion no encontrada', 'danger');
        return redirect()->route('admin.persona.ingreso');
      }
    

    } catch(\Exception $e){
      Flash('Ha ocurrido un error: ' . $e->getMessage(), 'danger');
      return redirect()->route('admin.persona.ingreso');
    }

  }

  public function getIdentificacionesJson($text = null){
    $identificaciones = Persona::select(["persona_identificacion",'persona_ingreso'])
    ->where('persona_identificacion','like',$text.'%')
    ->get()/*->pluck('persona_identificacion')*/->toArray();

    return response($identificaciones);
  }

  public function profile(){
    return view('admin.persona.updateprofile');
  }

  public function profileUpdate(Request $request, $id){
    try{

    $persona = Persona::find($id);

    if($request->persona_codigo_alterno != null){
      if($request->persona_codigo_alterno == $request->persona_codigo_alterno_confirm){
        $persona->persona_codigo_alterno = $request->persona_codigo_alterno;
      } else {
        Flash('Las contraseñas no coinciden', 'danger');
        return redirect()->route('profile');
      }
    }

    $imagen = $request->file('persona_foto');

    //dd($imagen);

    if ($imagen != null){
      if(in_array($imagen->getMimeType(), array("image/jpeg", "image/png"))){
        $nombre_imagen = 'app/persona_foto/' . str_random(5) . '-' . str_replace(' ', '', $imagen->getClientOriginalName());
        $path = public_path($nombre_imagen);
        Image::make($imagen->getRealPath())->resize(400, 400)->save($path);
        $persona->persona_foto = $nombre_imagen;
      } else {
        throw new \Exception("La imagen debe ser en formato png o jpg");
      }
    }

    $persona->save();

    Flash('Sus datos se actualizaron correctamente.', 'success');

    return redirect()->route('profile');

    } catch(\Exception $e){
      Flash('Ha ocurrido un error: ' . $e->getMessage(), 'danger');

      return redirect()->route('profile');
    }

  }

  public function testmail(){
    $persona = Persona::find(4);

    Mail::to($persona->persona_email)->send(new OrderShipped($persona));
  }

  public function candidato(Request $request){
    $persona = Persona::find($request->persona_id);
    $persona->candidato = $request->candidato;
    $persona->save();
    return response("true");
  }

  public function reporteGeneral(){

    $personas = Persona::all();

    $content = '';
    $salto_linea = "\r\n";

    $content .= "IDENTIFICACION,NOMBRE,APELLIDO,ACTIVO,INGRESO,TIPO PERSONA".$salto_linea;
    $tipos_persona = TipoPersona::all();

    foreach($personas as $persona){
      //$tipo_persona = TipoPersona::where('tipo_persona_id',$persona->tipo_persona_id)->first();
      $tipo_persona = $tipos_persona->where('tipo_persona_id', $persona->tipo_persona_id)->first();

      $content .= $persona->persona_identificacion.',';
      $content .= $persona->persona_nombre.',';
      $content .= $persona->persona_apellido.',';
      $content .= (($persona->persona_activa)?'SI':'NO').',';
      $content .= (($persona->persona_ingreso)?'SI':'NO').',';
      $content .= $tipo_persona->tipo_persona_nombre.',';      
      $content .= $salto_linea;
    }

    $nombre = "reporte_general_personas.xls";

    $path = "reportes/".$nombre;

    //dd($nombre);

    Storage::disk('local')->put($path, $content);

    return response()->download($path, $nombre);

  }

  public function salidaGeneral(){
    $personas = Persona::all();

    foreach($personas as $persona){
      $persona->persona_ingreso = false;
      $persona->save();
    }

    Flash('Se le ha dado salida a todas las personas', 'success');
    return redirect()->route('admin.persona.index');

  }

  public function reportePersonasIngreso(){

    $content = '';
    $salto_linea = "\r\n";

    $content .= "TIPO PERSONA, NUMERO DE PERSONAS".$salto_linea;

    $personas = Persona::all();
    $tipos_persona = TipoPersona::all();

    $content .=  'ACTIVAS INGRESADAS'.$salto_linea;

    foreach ($tipos_persona as $tipo_persona) {
      $count = $personas->where('persona_activa', true)->where('persona_ingreso', true)->where('tipo_persona_id', $tipo_persona->tipo_persona_id)->count();

      $content .= $tipo_persona->tipo_persona_nombre.',';
      $content .= $count;
      $content .= $salto_linea;
    }

    $content .=  'ACTIVAS NO INGRESADAS'.$salto_linea;

    foreach ($tipos_persona as $tipo_persona) {
      $count = $personas->where('persona_activa', true)->where('persona_ingreso', false)->where('tipo_persona_id', $tipo_persona->tipo_persona_id)->count();

      $content .= $tipo_persona->tipo_persona_nombre.',';
      $content .= $count;
      $content .= $salto_linea;
    }

    $content .=  'INACTIVAS'.$salto_linea;

    foreach ($tipos_persona as $tipo_persona) {
      $count = $personas->where('persona_activa', false)->where('tipo_persona_id', $tipo_persona->tipo_persona_id)->count();

      $content .= $tipo_persona->tipo_persona_nombre.',';
      $content .= $count;
      $content .= $salto_linea;
    }

    //dd($content);

    $nombre = "reporte_ingreso_personas.xls";

    $path = "reportes/".$nombre;

    //dd($nombre);

    Storage::disk('local')->put($path, $content);

    return response()->download($path, $nombre);
  }

}
