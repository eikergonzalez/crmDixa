<?php

namespace App\Http\Controllers;

use App\Models\agenda;
use App\services\Response;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Spatie\GoogleCalendar\Event;

class AgendaController extends Controller{

    public function index(){
        /* $events = Event::get('846099292446-21lk41l36cfkd7kd7j8b12pteu0ujms7.apps.googleusercontent.com');
        dd($events); */
        $data = [];
        $agenda = (new agenda());

        if(Auth::user()->rol_id == 3){
            $agenda = $agenda->join('users','users.id','=','agenda.user_id')
                ->where('users.rol_id', Auth::user()->rol_id);
        }
        if(Auth::user()->rol_id == 4){
            $agenda = $agenda->where('id', Auth::user()->id);
        }

        $data['agenda'] = $agenda->whereNull('deleted_at')->get();
        return view('pages.agenda', $data);
    }

    public function saveEvento(Request $request){
        try{
            $request['age_fecha'] = Carbon::createFromFormat('d/m/Y', $request->age_fecha)->format('Y-m-d');

            $model = new agenda();
            $model = $model->find($request->id);

            if(empty($model)) $model = new agenda();

            $model->saveData($request);
            Response::status($request,"success",'Registro Guardao Exitosamente!','saveUsuario', true);
            return redirect()->back();
        }catch(\Exception $e){
            Response::status($request,"warning", $e->getMessage(), "saveUsuario", true, true);
            return redirect()->back()->withInput($request->all());
        }
    }

    public function deleteEvento(Request $request,$id){
        try{
            $model = agenda::find($id);
            if(empty($model)) return Response::statusJson("warning",'El usuario a leminar no se encuentra registrado','deleteUsuario');
            $model->deleted_at = Carbon::now();
            $model->activo = 0;
            $model->save();
            return Response::statusJson("success",'Registro Eliminado Exitosamente!','deleteUsuario', true);
        }catch(\Exception $e){
            return Response::statusJson("warning", $e->getMessage(), "saveUsuario", true, true);
        }
    }
}
