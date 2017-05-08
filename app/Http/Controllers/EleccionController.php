<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Eleccion;
use App\Votacion;
use App\EleccionPersona;
use App\TipoPersona;
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
        ->where('candidato', true)
        ->where('persona_activa', true)
        ->select('persona_id', 'persona_nombre','persona_apellido')
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

            $this->activarEleccion($eleccion);

            Flash('La eleccion se creo correctamente.', 'success');

            return redirect()->route('admin.eleccion.edit',["eleccion" => $eleccion->eleccion_id]);
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
            ->where('candidato', true)
            ->where('persona_activa', true)
            ->select('persona_id', 'persona_nombre', 'persona_apellido')
            ->get();

        $data["candidatos_elegidos"] = DB::table('eleccion_persona')
            ->where('eleccion_id', $id)
            ->pluck('persona_id');

        $data["resultados"] = $this->getResultados($id)->get();

        //dd($this->getResultados($id)->toSql());
        //dd($this->getResultadosSinVotar($id)->toSql());
        $data["resultados_sin_votar"] = $this->getResultadosSinVotar($id)->get();

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

        $this->activarEleccion($eleccion);

        Flash('La eleccion se actualizo correctamente.', 'success');

        return redirect()->route('admin.eleccion.edit',["eleccion" => $eleccion->eleccion_id]);

    }

    public function destroyMass(Request $request){
        DB::beginTransaction();
        try{
            foreach($request->ids as $id){
                $this->deleteEleccion($id);
            }
            DB::commit();
            Flash("Las elecicones se eliminaron con exito", 'success');

            return redirect()->route('admin.eleccion.index');

        } catch(\Exception $e){
            Flash('Ha ocurrido un error: ' . $e->getMessage(), 'danger');
            DB::rollBack();

            return redirect()->route('admin.eleccion.eleccion');
        }
    }

    public function destroy($id){
        try{
            $eleccion = Eleccion::find($id);

            $this->deleteEleccion($id);

            Flash("La eleccion se elimino con exito", 'success');

            return redirect()->route('admin.eleccion.index');

        } catch(\Exception $e){
            Flash('Ha ocurrido un error: ' . $e->getMessage(), 'danger');

            return redirect()->route('admin.eleccion.index');
        }
    }

    public function reporte($eleccion_id){

        $eleccion = Eleccion::find($eleccion_id);

        $content = '';

        $salto_linea = "\r\n";

        /*$cabeceras = collect($this->getResultados($eleccion_id)->first())->keys()->toArray();

        $content .= implode(',', $cabeceras);*/

        $content .= "CANDIDATO,VOTOS";
        $content .= $salto_linea;

        foreach($this->getResultados($eleccion_id)->get() as $resultado){
            //$content .= implode(',', collect($resultado)->toArray());
            $content .= $resultado->persona_nombre . " " . $resultado->persona_apellido . ',' . $resultado->votos;
            $content .= $salto_linea;
        }

        //dd($eleccion);

        $nombre = strtolower($eleccion->eleccion_nombre);
        $nombre = str_replace(' ', '_', $nombre);
        $nombre = $nombre.".xls";

        $path = "reportes/".$nombre;

        //dd($nombre);

        Storage::disk('local')->put($path, $content);

        return response()->download($path, $nombre);
    }

    public function getResultados($id){
        return DB::table('eleccion_persona')
                            ->leftJoin('persona','persona.persona_id', '=', 'eleccion_persona.persona_id')
                            ->leftJoin('votacion',function($join){
                                    $join->on('votacion.candidato_id', '=', 'eleccion_persona.persona_id')
                                    ->on('votacion.eleccion_id', '=', 'eleccion_persona.eleccion_id');
                                })
                            ->select('persona.persona_nombre','persona.persona_apellido',
                                DB::raw('count(votacion.votacion_id) as votos'))
                            ->groupBy('votacion.candidato_id')
                            ->groupBy('persona.persona_nombre')
                            ->groupBy('persona.persona_apellido')
                            ->orderBy('votos', 'desc')
                            ->orderBy('persona_nombre', 'asc')
                            ->where('eleccion_persona.eleccion_id',$id);
    }

    public function activarEleccion(Eleccion $eleccion){
        if($eleccion->eleccion_activa == true){
            $elecciones_activas = Eleccion::where('eleccion_activa', true)->get();

            foreach ($elecciones_activas as $eleccion_activa) {
                if($eleccion_activa->eleccion_id != $eleccion->eleccion_id){
                    $eleccion_activa->eleccion_activa = false;
                    $eleccion_activa->save();
                }
            }
        }
        return true;
    }

    public function reporteDetallado($eleccion_id){

        $eleccion = Eleccion::find($eleccion_id);

        $resultados = $this->getResultadosDetallado($eleccion_id)->get();

        //dd($resultados);

        $eleccion = Eleccion::find($eleccion_id);

        $content = '';
        $salto_linea = "\r\n";

        $content .= $eleccion->eleccion_nombre . $salto_linea;

        $content .= "CANDIDATO,PERSONAS".$salto_linea;

        foreach($resultados->pluck('candidato_id')->unique() as $candidato_id){

            $resultados_candidato = $resultados->where('candidato_id',$candidato_id);

            //$key = 0;

            foreach ($resultados_candidato as $item) {
                //if($key == 0){
                    $content .= $item->candidato_nombre.' '.$item->candidato_apellido.','.$item->persona_nombre.' '.$item->persona_apellido.$salto_linea;
                /*} else {
                    $content .= ','.$item->persona_nombre.$salto_linea;
                }
                $key++;*/
            }

        }

        //dd($content);

        /*$content .= "candidato,votos";
        $content .= $salto_linea;

        foreach($this->getResultadosDetallado($eleccion_id)->get() as $resultado){
            $content .= implode(',', collect($resultado)->toArray());
            $content .= $salto_linea;
        }*/

        //dd($eleccion);

        $nombre = strtolower($eleccion->eleccion_nombre);
        $nombre = str_replace(' ', '_', $nombre);
        $nombre = $nombre."_detallado.xls";

        $path = "reportes/".$nombre;

        //dd($nombre);

        Storage::disk('local')->put($path, $content);

        return response()->download($path, $nombre);
    
    }

    public function getResultadosDetallado($id){
        return DB::table('eleccion_persona')
                            ->leftJoin('persona as candidato','candidato.persona_id', '=', 'eleccion_persona.persona_id')
                            ->leftJoin('votacion',function($join){
                                    $join->on('votacion.candidato_id', '=', 'eleccion_persona.persona_id')
                                    ->on('votacion.eleccion_id', '=', 'eleccion_persona.eleccion_id');
                                })
                            ->leftJoin('persona','persona.persona_id', '=', 'votacion.persona_id')
                            ->select('candidato.persona_nombre as candidato_nombre','candidato.persona_apellido as candidato_apellido','candidato.persona_id as candidato_id','votacion.persona_id','persona.persona_id','persona.persona_nombre','persona.persona_apellido')
                            ->orderBy('persona_nombre', 'asc')
                            ->where('eleccion_persona.eleccion_id',$id);
    }

    public function deleteEleccion($id){
        $eleccion = Eleccion::find($id);

        $candidatos = EleccionPersona::where('eleccion_id',$id)->get();
        $votaciones = Votacion::where('eleccion_id',$id)->get();

        foreach ($candidatos as $candidato) {
            $candidato->delete();
        }

        foreach ($votaciones as $votacion) {
            $votacion->delete();
        }

        $eleccion->delete();

        return true;
    }

    public function getResultadosSinVotar($id){
        return  DB::table('persona')
                ->leftJoin('tipo_persona','tipo_persona.tipo_persona_id','=','persona.tipo_persona_id')
                ->leftJoin('votacion',function($join) use($id){
                    $join->on('votacion.persona_id','=','persona.persona_id')
                        ->on('votacion.eleccion_id','=',DB::raw($id));
                })
                ->select('tipo_persona.tipo_persona_nombre',DB::raw('count(persona.persona_id) as personas'))
                ->groupBy('tipo_persona.tipo_persona_nombre')
                ->where('votacion.votacion_id',null);
    }

}
