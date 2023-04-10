<?php

namespace App\Http\Controllers;

use App\Models\ofertas;
use App\services\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OfertasController extends Controller{
    public function saveOfertas(Request $request){
        try{
            
            DB::beginTransaction();

            $model = new ofertas();
            $ofertas = $model->saveData($request);
        
            DB::commit();
            //Response::statusJson($request,"success",'Registro Actualizado Exitosamente!','saveOfertas', true);
            return Response::statusJson("success",'Visita creada exitosamente!','saveOfertas', $ofertas);
        }catch(\Exception $e){
            DB::rollback();
            return Response::statusJson("warning", $e->getMessage(), "saveOfertas", null, true, true);
        }
    }

}
