<?php

namespace App\Http\Controllers;

use App\Models\inmueble;
use App\Models\relacion_inmueble_visitas;
use App\Models\visitas;
use App\services\Response;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class VisitasController extends Controller{


    public function getVisitasByInmueble(Request $request, $idInmueble){
        try{
            $visitas = (new visitas())->join('relacion_inmueble_visitas', 'relacion_inmueble_visitas.visitas_id', '=', 'visitas.id')
            ->where('relacion_inmueble_visitas.inmueble_id', $idInmueble)
            ->get();

            return Response::statusJson("success",'Exito!','getVisitasByInmueble', $visitas);
        }catch(\Exception $e){
            DB::rollback();
            return Response::statusJson("warning", $e->getMessage(), "getVisitasByInmueble", true, true);
        }
    }

    public function saveVisitasInmueble(Request $request){
        try{

            DB::beginTransaction();
        
            $model = new visitas();
            $visitas = $model->saveData($request);

            if(!empty($visitas) && !empty($request->inmueble_id)){
                $relacionVisitas = new relacion_inmueble_visitas();
                $relacionVisitas->inmueble_id = $request->inmueble_id;
                $relacionVisitas->visitas_id = $visitas->id;
                $relacionVisitas->created_at = Carbon::now();
                $relacionVisitas->save();
            }

            DB::commit();

            $visitas = (new visitas())->join('relacion_inmueble_visitas', 'relacion_inmueble_visitas.visitas_id', '=', 'visitas.id')
            ->where('relacion_inmueble_visitas.inmueble_id', $request->inmueble_id)
            ->get();

            return Response::statusJson("success",'Visita creada exitosamente!','saveVisitasInmueble', $visitas);
        }catch(\Exception $e){
            DB::rollback();
            return Response::statusJson("warning", $e->getMessage(), "saveVisitasInmueble",null, true, true);
        }
    }
}
