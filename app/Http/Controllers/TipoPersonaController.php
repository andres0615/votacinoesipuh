<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TipoPersona;
use Illuminate\Support\Facades\DB;

class TipoPersonaController extends Controller
{
    public function index(){
        $tipo_personas = TipoPersona::orderBy('tipo_persona_nombre', 'ASC')->paginate(5);
        return view('admin.tipopersona.index',compact('tipo_personas'));
    }

    public function create(){
        $data = array();
        $data["title"] = "Crear tipo persona";
        $data["edit"] = false;
        $data["tipo_persona_votacion"] = null;

        return view('admin.tipopersona.form', $data);
    }

    public function store(Request $request){

        try{

            $tipo_persona = new TipoPersona($request->all());
            $tipo_persona->tipo_persona_votacion = isset($request->tipo_persona_votacion);
            $tipo_persona->save();
            Flash('El tipo de persona se creo correctamente.', 'success');

            return redirect()->route('admin.tipopersona.edit',["tipopersona" => $tipo_persona->tipo_persona_id]);
        } catch(\Exception $e){
            //$error = new ErrorController();
            //$error->storeErrorException($e);
            //Flash($error->mensaje, 'danger');
            Flash('Ha ocurrido un error: ' . $e->getMessage(), 'danger');

            return redirect()->route('admin.tipopersona.index');
        }

    }

    public function edit($id){
        $data = array();

        $tipo_persona = TipoPersona::find($id);
        $data["tipo_persona"] = $tipo_persona;
        $data["title"] = "Editar tipo persona";
        $data["edit"] = true;
        $data["id"] = $id;
        $data["tipo_persona_votacion"] = ($tipo_persona->tipo_persona_votacion)?'checked':null;


        return view('admin.tipopersona.form', $data);
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

        $tipo_persona = TipoPersona::find($id);

        $tipo_persona->tipo_persona_nombre = $request->tipo_persona_nombre;
        $tipo_persona->tipo_persona_votacion = isset($request->tipo_persona_votacion);

        $tipo_persona->save();
        Flash('El tipo de persona se creo correctamente.', 'success');

        return redirect()->route('admin.tipopersona.edit',["tipopersona" => $tipo_persona->tipo_persona_id]);

    }

    public function destroyMass(Request $request){
        DB::beginTransaction();
        try{
            foreach($request->ids as $id){
                $persona = TipoPersona::find($id);
                $persona->delete();
            }
            DB::commit();
            Flash("El tipo de persona se elimino con exito", 'success');

            return redirect()->route('admin.tipopersona.index');

        } catch(\Exception $e){
            Flash('Ha ocurrido un error: ' . $e->getMessage(), 'danger');
            DB::rollBack();

            return redirect()->route('admin.tipopersona.create');
        }
    }

    public function destroy($id){
        try{
            $persona = TipoPersona::find($id);
            $persona->delete();
            Flash("El tipo de persona se elimino con exito", 'success');

            return redirect()->route('admin.tipopersona.index');

        } catch(\Exception $e){
            Flash('Ha ocurrido un error: ' . $e->getMessage(), 'danger');

            return redirect()->route('admin.tipopersona.create');
        }
    }
}
