<?php

namespace App\Http\Controllers;

use App\Models\contratos;
use App\Models\inmueble;
use App\services\Response;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ContratoController extends Controller{

    public function viewNotaEncargo(Request $request, $id, $uuid){
        $data = [];
        $data['id'] = $id;
        $data['uuid'] = $uuid;

        $contrato = contratos::where('id', $id)->first();

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

            $contrato = contratos::where('id', $id)->first();
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

    public function savePropuesta(Request $request){
        try{
            DB::beginTransaction();


            $contrato = $request->contrato;
            $id = Str::uuid();

            $propietarios = [];
            $firmantes = 0;

            foreach ($contrato['propietarios'] as $propietario) {
                $uuid = Str::uuid();
                $propietario['id'] = $uuid;
                $propietario['url'] = env('APP_URL')."/propuesta/$id/$uuid";
                array_push($propietarios, $propietario);
                MailController::sendContratoFirmar($propietario);
                $firmantes++;
            }
            $contrato['propietarios'] = $propietarios;

            $tipoContrato = 'PROPUESTA_CONTRATO_COMPRAVENTA';

            if($contrato['opcion'] == 'arrendamiento'){
                $tipoContrato = 'PROPUESTA_CONTRATO_ARRENDAMIENTO';
            }

            $model = new contratos();
            $model->id = $id;
            $model->inmueble_id = $request->inmueble_id;
            $model->propietario_id = $request->propietario_id;
            $model->tipo_contrato = $tipoContrato;
            $model->data_json = json_encode($contrato);
            $model->firma_pendiente = $firmantes;
            $model->created_at = Carbon::now();
            $model->save();

            DB::commit();
            return Response::statusJson("success", 'Registro guardado Exitosamente!', "saveValoracion", true, true);
        }catch(\Exception $e){
            DB::rollback();
            return Response::statusJson("warning", $e->getMessage(), "saveValoracion", true, true);
        }
    }

    public function viewPropuesta(Request $request, $id, $uuid){
        $data = [];
        $data['id'] = $id;
        $data['uuid'] = $uuid;

        $contrato = contratos::where('id', $id)->first();

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

        return view('contratos.propuesta_contrato', $data);
    }

    public function saveFirmaPropuesta(Request $request, $id, $uuid){
        try{
            $firma = $request->firma;

            $contrato = contratos::where('id', $id)->first();
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

            /* if($contrato->firma_pendiente == 0){
                $inmueble = inmueble::find($contrato->inmueble_id);
                $inmueble->modulo = 'encargo';
                $inmueble->save();
            } */

            return Response::statusJson("success", 'Documento firmado Exitosamente!', "saveFirmaNotaEncargo", true, true);
        }catch(\Exception $e){
            DB::rollback();
            return Response::statusJson("warning", $e->getMessage(), "saveValoracion", true, true);
        }
    }

    public function getContrato(Request $request){
        $search = $request->tipo;
        $data = (new contratos())
            /* ->selectRaw('contratos.*, contratos.uuid as id') */
            ->where('inmueble_id', $request->inmueble_id)
            ->where('tipo_contrato','LIKE',"%{$search}%")
            ->first();
        return Response::statusJson("success", 'success', 'getContrato', $data);
    }

    public function showContrato(Request $request, $id){
        $data = [];
        $data['id'] = $id;

        $contrato = contratos::where('id', $id)->first();

        $data['contrato'] = $contrato;
        $data['data_json'] = json_decode($contrato->data_json);

        switch ($contrato->tipo_contrato) {
            case 'NOTA_ENCARGO_COMPRAVENTA':
                return view('contratos.print-nota-encargo', $data);
                break;
            case 'NOTA_ENCARGO_ARRENDAMIENTO':
                return view('contratos.print-nota-encargo', $data);
                break;
            case 'PROPUESTA_CONTRATO_ARRENDAMIENTO':
                return view('contratos.print-propuesta_contrato', $data);
                break;
            case 'PROPUESTA_CONTRATO_COMPRAVENTA':
                return view('contratos.print-propuesta_contrato', $data);
                break;
        }

        dd("sin contrato");
    }
}
