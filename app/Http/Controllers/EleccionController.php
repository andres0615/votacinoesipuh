<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Eleccion;
use App\Votacion;
use App\EleccionPersona;
use Illuminate\Support\Facades\DB;
use Storage;
use Resource;

class EleccionController extends Controller
{
    public function index(){
        $elecciones = Eleccion::orderBy('eleccion_nombre', 'ASC')->paginate(5);


        return view('admin.eleccion.index',compact('elecciones'));
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

        $data["resultados"] = $this->getResultados($id)->get();

        //dd($data);

        $data["count"] = 0;


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

    public function reporte($eleccion_id){

        $eleccion = Eleccion::find($eleccion_id);

        $content = '';

        $salto_linea = "\r\n";

        /*$cabeceras = collect($this->getResultados($eleccion_id)->first())->keys()->toArray();

        $content .= implode(',', $cabeceras);*/

        $content .= "candidato,votos";
        $content .= $salto_linea;

        foreach($this->getResultados($eleccion_id)->get() as $resultado){
            $content .= implode(',', collect($resultado)->toArray());
            $content .= $salto_linea;
        }

        //dd($eleccion);

        $nombre = strtolower($eleccion->eleccion_nombre);
        $nombre = str_replace(' ', '_', $nombre);
        $nombre = $nombre.".csv";

        //dd($nombre);

        Storage::disk('local')->put($nombre, $content);

        return response()->download($nombre, $nombre);
    }

    public function getResultados($id){
        return DB::table('eleccion_persona')
                            ->leftJoin('persona','persona.persona_id', '=', 'eleccion_persona.persona_id')
                            ->leftJoin('votacion',function($join){
                                    $join->on('votacion.candidato_id', '=', 'eleccion_persona.persona_id')
                                    ->on('votacion.eleccion_id', '=', 'eleccion_persona.eleccion_id');
                                })
                            ->select('persona.persona_nombre',
                                DB::raw('count(votacion.votacion_id) as votos'))
                            ->groupBy('votacion.candidato_id')
                            ->groupBy('persona.persona_nombre')
                            ->orderBy('votos', 'desc')
                            ->orderBy('persona_nombre', 'asc')
                            ->where('eleccion_persona.eleccion_id',$id);
    }

}
