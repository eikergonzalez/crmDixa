<?php

namespace App\Http\Controllers;

use App\Models\agenda;
use App\Models\estatus;
use App\Models\inmueble;
use App\Models\propietario;
use App\Models\relacion_propietario_inmueble;
use App\Models\tipo_solicitud;
use App\Models\User;
use App\services\Response;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NoticiasController extends Controller{

    public function index(){
        $data = []; 

        $usuario = (new User())->whereIn('rol_id', [2,4])->get('id');
        $users = [];
        
        foreach($usuario as $usr){
            $id=$usr->id;
            array_push($users,$id);
        }

        $propietario = (new propietario())->getPropietario();

        if(Auth::user()->rol_id == 4){
            $propietario = $propietario->where('propietario.user_id', Auth::user()->id);
        }

        if(Auth::user()->rol_id == 2){
            $propietario = $propietario->whereIn('propietario.user_id', $users);
        }

        $data['propietarios'] = $propietario->get();
        $data['tipoSolicitudes'] = (new tipo_solicitud())->whereNull('deleted_at')->get();
        $data['estatus'] = (new estatus())->where('tipo','accion')
        ->whereIn('codigo', ['ES','VA','DB'])
        ->where('tipo', 'accion')
        ->orderBy('id','desc')->get();

        return view('pages.noticias', $data);
    }

    public function saveNoticias(Request $request){
        try{
            //dd($request->all());
            DB::beginTransaction();
            $model = new propietario();
            $model = $model->find($request->id);

            if(empty($model)) $model = new propietario();

            $propietario = $model->saveData($request);

            $inmueble = (new inmueble())->find($request->id_inmueble);
            if(empty($inmueble)) $inmueble = new inmueble();

            $inmueble = $inmueble->saveData($request);

            if(!empty($request->agenda_titulo) and !empty($request->agenda_descri) and !empty($request->agenda_fecha)){
                $this->crearAgenda($request, $inmueble);
            }

            $relacion = (new relacion_propietario_inmueble())->where('inmueble_id', $inmueble->id)
                ->where('propietario_id', $propietario->id)
                ->first();
            
            if(!$relacion){
                $relacion = new relacion_propietario_inmueble();
                $relacion->inmueble_id = $inmueble->id;
                $relacion->propietario_id = $propietario->id;
                $relacion->save();
            }
            DB::commit();
            Response::status($request,"success",'Registro Guardado Exitosamente!','saveNoticias', true);
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Response::status($request,"warning", $e->getMessage(), "saveNoticias", true, true);
            return redirect()->back()->withInput($request->all());
        }
    }

    private function crearAgenda(Request $request, inmueble $inmueble){
        try{
            $request['age_fecha'] = Carbon::createFromFormat('d/m/Y', $request->agenda_fecha)->format('Y-m-d');
            $request['age_titulo'] = $request->agenda_titulo;
            $request['age_descri'] = $request->agenda_descri;
            $request['inmueble_id'] = $inmueble->id;

            $model = new agenda();
            $model = $model->find($request->id_agenda);

            if(empty($model)) $model = new agenda();

            $model->saveData($request);
        }catch(\Exception $e){
            DB::rollback();
            Response::status($request,"warning", $e->getMessage(), "saveUsuario", true, true);
            return redirect()->back()->withInput($request->all());
        }
    }


}