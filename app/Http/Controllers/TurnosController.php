<?php

namespace App\Http\Controllers;

use App\Models\turnos;
use App\services\Response;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TurnosController extends Controller{

    public function createTurno(Request $request, $domain){
        try{
            $dateNow = Carbon::now()->format('Y-m-d');

            $model = (new turnos())->where('cli_id', $request->cli_id)
                ->where('tur_action', $request->tur_action)
                ->where('tur_date', $dateNow)
                ->first();
            
            if(!empty($model)){
                return Response::statusJson("error","Previously made request",'createTurno', null, true, true);
            }

            $model = new turnos();
            $model->cli_id = $request->cli_id;
            $model->tur_codigo = $this->getCodigo($request->tur_action);
            $model->tur_action = $request->tur_action;
            $model->tur_state = 1;
            $model->tur_date = $dateNow;
            $model->save();

            return Response::statusJson("success",'success','createTurno', $model->tur_codigo, false, true);
        }catch(\Exception $e){
            return Response::statusJson("error",$e->getMessage(),'createTurno', null, true, true);
        }
    }

    private function getCodigo($action){
        $query = (new turnos())->where('tur_action', $action)->count();
        $correlativo = $query+1;
        $correlativo = str_pad($correlativo, 5, "0", STR_PAD_LEFT);
        return $action."-".$correlativo;
    }

    public function getClientebyId(Request $request, $domain){
        try{
            $cliente = turnos::find($request->id);
            return Response::statusJson("success",'success','createTurno', $cliente, false, true);
        }catch(\Exception $e){
            return Response::statusJson("error",$e->getMessage(),'createTurno', null, true, true);
        }
    }

    public function createTurnoearch(Request $request, $domain){
        try{
            $data = [];
            $data['clientes'] = turnos::all();

            return Response::statusJson("success",'success','createTurno', $data, false, true);
        }catch(\Exception $e){
            return Response::statusJson("error",$e->getMessage(),'createTurno', null, true, true);
        }
    }
}
