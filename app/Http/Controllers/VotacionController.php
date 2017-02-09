<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Eleccion;
use App\EleccionPersona;
use App\Persona;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class VotacionController extends Controller
{
    public function index(){
        $persona = Auth::guard('persona')->user();
        //dd(collect($persona));

        $data = array();

        if($persona->persona_activa == true && $persona->persona_ingreso == true){
            //$elecciones = Eleccion::orderBy('eleccion_nombre', 'ASC')->paginate(5);
            $data["elecciones"] =   DB::table('eleccion')
                            ->leftJoin('votacion', function ($join) use ($persona) {
                                $join->on('votacion.eleccion_id', '=', 'eleccion.eleccion_id')
                                    ->where('votacion.persona_id', '=', $persona->persona_id);
                            })
                            ->where('votacion.votacion_id', null)
                            ->where('eleccion.eleccion_activa', true)
                            ->select('eleccion.eleccion_nombre', 'eleccion.eleccion_id')
                            ->get();
        }

        return view('admin.persona.menu',$data);
    }

    public function eleccion($eleccion_codigo){
        $data = array();

        $data["eleccion"] = Eleccion::find($eleccion_codigo);

        $data["candidatos"] =   DB::table('persona')
                                ->leftJoin('eleccion_persona', 'eleccion_persona.persona_id', '=', 'persona.persona_id')
                                ->where('eleccion_persona.eleccion_id', $eleccion_codigo)
                                ->get();

        return view('admin.persona.votacionui',$data);
    }

    public function create(){
        $data = array();
        $data["title"] = "Crear eleccion";
        $data["edit"] = false;
        $data["activo"] = '';

        $data["candidatos"] = DB::table('persona')
        ->where('tipo_persona_id', 2)
        ->where('persona_activa', true)
        ->select('persona_id', 'persona_nombre')
        ->get();

        //dd($candidatos);

        return view('admin.eleccion.form', $data);
    }

    public function store(Request $request){

        try{

            $request_p = array();

            foreach($request->all() as $key => $value){
                if($key == "candidatos"){
                    $candidatos = $value;
                } else {
                    $request_p[$key] = $value;
                }
            }

            $eleccion = new Eleccion($request_p);
            $eleccion->save();

            foreach($candidatos as $candidato){
                $eleccion_persona = new EleccionPersona();
                $eleccion_persona->eleccion_id = $eleccion->eleccion_id;
                $eleccion_persona->persona_id = $candidato;
                $eleccion_persona->save();
            }

            Flash('La eleccion se creo correctamente.', 'success');

            return redirect()->route('admin.eleccion.index');
        } catch(\Exception $e){
            //$error = new ErrorController();
            //$error->storeErrorException($e);
            //Flash($error->mensaje, 'danger');
            Flash('Ha ocurrido un error: ' . $e->getMessage(), 'danger');

            return redirect()->route('admin.eleccion.create');
        }

    }

    public function edit($id){

        $eleccion = Eleccion::find($id);

        $data = array();
        $data["eleccion"] = $eleccion;
        $data["title"] = "Editar eleccion";
        $data["edit"] = true;
        $data["activo"] = ($eleccion->eleccion_activa)?'checked':'';
        $data["id"] = $id;

        $data["candidatos"] = DB::table('persona')
            ->where('tipo_persona_id', 2)
            ->where('persona_activa', true)
            ->select('persona_id', 'persona_nombre')
            ->get();

        $data["candidatos_elegidos"] = DB::table('eleccion_persona')
            ->where('eleccion_id', $id)
            ->pluck('persona_id');

            //dd($data);


        return view('admin.eleccion.form', $data);
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

        $eleccion = Eleccion::find($id);

        $eleccion->eleccion_activa = (isset($request->eleccion_activa))?true:false;
        $eleccion->eleccion_nombre = $request->eleccion_nombre;

        $candidatos = EleccionPersona::where('eleccion_id', $eleccion->eleccion_id);
        $candidatos->delete();

        //dd($request->all());

        foreach($request->candidatos as $candidato){
            $eleccion_persona = new EleccionPersona();
            $eleccion_persona->eleccion_id = $eleccion->eleccion_id;
            $eleccion_persona->persona_id = $candidato;
            $eleccion_persona->save();
        }

        $eleccion->save();
        Flash('La eleccion se actualizo correctamente.', 'success');

        return redirect()->route('admin.eleccion.index');

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
