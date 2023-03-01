<?php

namespace App\services;

use App\Models\agenda;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\services\Response;
use Illuminate\Http\Request;

class AgendaService {

    public static function crearAgenda(Request $request){
        try{
            $request['age_fecha'] = Carbon::createFromFormat('d/m/Y', $request->age_fecha)->format('Y-m-d');

            $model = new agenda();
            $model = $model->find($request->id_agenda);

            if(empty($model)) $model = new agenda();

            return $model->saveData($request);
        }catch(\Exception $e){
            DB::rollback();
            Response::status($request,"warning", $e->getMessage(), "crearAgenda", true, true);
            return redirect()->back()->withInput($request->all());
        }
    }
}
