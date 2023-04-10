<?php

namespace App\Http\Controllers;

use App\Models\contratos;
use App\Models\inmueble;
use App\services\Response;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ContratoController extends Controller{

    public function viewNotaEncargo(Request $request, $id, $uuid){
        $data = [];
        $data['id'] = $id;
        $data['uuid'] = $uuid;

        $contrato = contratos::where('uuid', $id)->first();

        $decode = json_decode($contrato->data_json);

        foreach ($decode->propietarios as $propietario) {
            if($propietario->id == $uuid){
                if(empty($propietario->url) and !empty($propietario->firma)){
                    return view('error.403');
                }
            }
        }

        if(!$contrato) return view('error.403');

        $data['contrato'] = $contrato;
        $data['data_json'] = json_decode($contrato->data_json);

        return view('contratos.nota-encargo', $data);
    }

    public function saveFirmaNotaEncargo(Request $request, $id, $uuid){
        try{
            $firma = $request->firma;

            $contrato = contratos::where('uuid', $id)->first();
            $decode = json_decode($contrato->data_json);

            $propietarios = [];

            foreach ($decode->propietarios as $propietario) {
                if($propietario->id == $uuid){
                    $propietario->url = '';
                    $propietario->firma = $firma;
                    $contrato->firma_pendiente = $contrato->firma_pendiente -1;
                }
                array_push($propietarios, $propietario);
            }
            $decode->propietarios = $propietarios;
            
            $contrato->data_json = json_encode($decode);
            $contrato->save();

            if($contrato->firma_pendiente == 0){
                $inmueble = inmueble::find($contrato->inmueble_id);
                $inmueble->modulo = 'encargo';
                $inmueble->save();
            }

            return Response::statusJson("success", 'Documento firmado Exitosamente!', "saveFirmaNotaEncargo", true, true);
        }catch(\Exception $e){
            DB::rollback();
            return Response::statusJson("warning", $e->getMessage(), "saveValoracion", true, true);
        }
    }
}
