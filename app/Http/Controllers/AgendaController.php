<?php

namespace App\Http\Controllers;

use App\Models\agenda;
use App\Models\relacion_inmueble_agenda;
use App\services\Response;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
            DB::beginTransaction();
            $request['age_fecha'] = Carbon::createFromFormat('d/m/Y', $request->age_fecha)->format('Y-m-d');

            $model = new agenda();
            $model = $model->find($request->id);

            if(empty($model)) $model = new agenda();

            $model->saveData($request);
            DB::commit();
            Response::status($request,"success",'Registro Guardao Exitosamente!','saveUsuario', true);
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Response::status($request,"warning", $e->getMessage(), "saveUsuario", true, true);
            return redirect()->back()->withInput($request->all());
        }
    }

    public function deleteEvento(Request $request,$id){
        try{
            DB::beginTransaction();
            $model = agenda::find($id);
            if(empty($model)) return Response::statusJson("warning",'El usuario a leminar no se encuentra registrado','deleteUsuario');
            $model->deleted_at = Carbon::now();
            $model->activo = 0;
            $model->save();
            DB::commit();
            return Response::statusJson("success",'Registro Eliminado Exitosamente!','deleteUsuario', null, true);
        }catch(\Exception $e){
            DB::rollback();
            return Response::statusJson("warning", $e->getMessage(), "saveUsuario", true, true);
        }
    }


    public function getVisitasByInmueble(Request $request,$idInmueble){
        try{
            $visitas = (new agenda())->join('relacion_inmueble_agenda', 'relacion_inmueble_agenda.agenda_id', '=', 'agenda.id')
            ->where('relacion_inmueble_agenda.inmueble_id', $idInmueble)
            ->get();

            return Response::statusJson("success",'Exito!','getVisitasByInmueble', $visitas);
        }catch(\Exception $e){
            DB::rollback();
            return Response::statusJson("warning", $e->getMessage(), "getVisitasByInmueble", true, true);
        }
    }

    public function saveAgendaInmueble(Request $request){
        try{
            DB::beginTransaction();
            $request['age_fecha'] = Carbon::createFromFormat('d/m/Y', $request->age_fecha)->format('Y-m-d');

            $model = new agenda();
            $agenda = $model->saveData($request);

            if(!empty($agenda) && !empty($request->inmueble_id)){
                $relacionAgenda = new relacion_inmueble_agenda();
                $relacionAgenda->inmueble_id = $request->inmueble_id;
                $relacionAgenda->agenda_id = $agenda->id;
                $relacionAgenda->created_at = Carbon::now();
                $relacionAgenda->save();
            }


            DB::commit();

            $visitas = (new agenda())->join('relacion_inmueble_agenda', 'relacion_inmueble_agenda.agenda_id', '=', 'agenda.id')
            ->where('relacion_inmueble_agenda.inmueble_id', $request->inmueble_id)
            ->get();

            return Response::statusJson("success",'Visita creada exitosamente!','saveAgendaInmueble', $visitas);
        }catch(\Exception $e){
            DB::rollback();
            Response::status($request,"warning", $e->getMessage(), "saveAgendaInmueble", true, true);
            return redirect()->back()->withInput($request->all());
        }
    }
}
