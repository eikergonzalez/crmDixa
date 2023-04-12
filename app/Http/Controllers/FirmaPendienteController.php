<?php

namespace App\Http\Controllers;

use App\Models\estatus;
use App\Models\inmueble;
use App\Models\pedidos;
use App\Models\propietario;
use App\Models\relacion_inmueble_archivos;
use App\Models\relacion_inmueble_rebaja;
use App\Models\tipo_archivo;
use App\Models\tipo_solicitud;
use App\Models\tipo_inmueble;
use App\Models\User;
use App\services\Response;
use App\services\FilesService;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FirmaPendienteController extends Controller{

    public function index(){
        $data = []; 

        $usuario = (new User())->whereIn('rol_id', [2,4])->get('id');
        $users = [];
        
        foreach($usuario as $usr){
            $id=$usr->id;
            array_push($users,$id);
        }

        $propietario = (new propietario())
            ->selectRaw("propietario.id as propietarioId, 
                propietario.nombre, 
                propietario.apellido, 
                propietario.telefono, 
                inmueble.id as inmuebleId , 
                inmueble.direccion, 
                inmueble.precio_solicitado, 
                inmueble.observacion, 
                inmueble.accion, 
                inmueble.tipo_inmueble, 
                inmueble.tipo_solicitud, 
                tipo_solicitud.descripcion as solicitud, 
                estatus.descripcion as estatus"
            )
            ->join('relacion_propietario_inmueble', 'relacion_propietario_inmueble.propietario_id','=','propietario.id')
            ->join('inmueble', 'inmueble.id','=','relacion_propietario_inmueble.inmueble_id')
            ->join('tipo_solicitud', 'tipo_solicitud.id','=','inmueble.tipo_solicitud')
            ->join('estatus', 'estatus.id','=','inmueble.accion')
            ->where('inmueble.accion',6);

            //dd($propietario);

        if(Auth::user()->rol_id == 4){
            $propietario = $propietario->where('propietario.user_id', Auth::user()->id);
        }

        if(Auth::user()->rol_id == 2){
            $propietario = $propietario->whereIn('propietario.user_id', $users);
        }

        $data['propietarios'] = $propietario->whereNull('propietario.deleted_at')->get();
        $data['tipoSolicitudes'] = (new tipo_solicitud())->whereNull('deleted_at')->get();
        $data['estatus'] = (new estatus())->where('tipo','estatus')
        ->whereIn('codigo', ['DI','ER'])->orderBy('id','desc')->get();
        $data['tipo_inmueble']  = (new tipo_inmueble())->whereNull('deleted_at')->get();
        
        return view('pages.firma-pendiente', $data);
    }

    public function getDetalle(Request $request, $inmuebleId){
        $data = [];
        $data['inmuebleId'] = $inmuebleId;

        $data['tipoArchivo'] = tipo_archivo::orderBy('descripcion')->get();

        $data['propietarios'] = (new propietario())
            ->selectRaw("propietario.id as propietarioId, 
                propietario.nombre, 
                propietario.apellido, 
                propietario.telefono, 
                inmueble.id as inmuebleId , 
                inmueble.direccion, 
                inmueble.precio_solicitado, 
                inmueble.observacion, 
                inmueble.accion, 
                inmueble.tipo_inmueble,
                inmueble.direccion, 
                inmueble.precio_valorado, 
                inmueble.metros_utiles, 
                inmueble.metros_usados, 
                inmueble.ascensor, 
                inmueble.exposicion, 
                inmueble.habitaciones, 
                inmueble.hipoteca, 
                inmueble.hipoteca_valor, 
                inmueble.herencia, 
                inmueble.status,
                inmueble.reforma,
                tipo_solicitud.descripcion as solicitud,
                tipo_inmueble.descripcion as tipoinmueble,
                estatus.descripcion as estatus"
            )
            ->join('relacion_propietario_inmueble', 'relacion_propietario_inmueble.propietario_id','=','propietario.id')
            ->join('inmueble', 'inmueble.id','=','relacion_propietario_inmueble.inmueble_id')
            ->join('tipo_solicitud', 'tipo_solicitud.id','=','inmueble.tipo_solicitud')
            ->join('estatus', 'estatus.id','=','inmueble.accion')
            ->join('tipo_inmueble', 'tipo_inmueble.id','=','inmueble.tipo_inmueble')
            ->where('inmueble.id', $inmuebleId)
            ->first();

            $data['imagenes'] = (new relacion_inmueble_archivos())->where('inmueble_id', $inmuebleId)
            ->where('tipo', 'imagen')
            ->get();

            $data['pedidos'] = pedidos::all();

        return view('pages.firma-pendiente-detalle', $data);
    }

    public function saveArchivo(Request $request){
        try{
            DB::beginTransaction();

            if($request->tipo == 'imagen' && empty($request->images_file)){
                return Response::statusJson("warning", 'Debe seleccionar al menos un archivo', "saveArchivo", true, true);
            }

            if($request->tipo == 'archivo'){
                if(empty($request->documento_file)){
                    return Response::statusJson("warning", 'Debe seleccionar un archivo', "saveArchivo", true, true);
                }
                if(empty($request->tipo_archivo)){
                    return Response::statusJson("warning", 'Debe indicar el tipo de archivo', "saveArchivo", true, true);
                }
            }

            if($request->tipo == 'imagen'){
                foreach ($request->images_file as $file) {
                    $path = FilesService::uploadFile($request, $file);
                    $model = new relacion_inmueble_archivos();
                    $model->tipo = $request->tipo;
                    $model->created_at = Carbon::now();
                    $model->uuid = $request->uuid;
                    $model->path = $path['path'];
                    $model->name_file = $path['name'];
                    $model->inmueble_id = (!empty($request->inmueble_id)) ? $request->inmueble_id : null;
                    $model->save();
                }
            }

            if($request->tipo == 'archivo'){
                $path = FilesService::uploadFile($request, $request->documento_file);

                $model = (new relacion_inmueble_archivos())->where('tipo_archivo', $request->tipo_archivo)
                ->where('inmueble_id', $request->inmueble_id)
                ->first();

                if(!$model) $model = new relacion_inmueble_archivos();

                if($model) FilesService::deleteFile($model->path);

                $model->tipo = $request->tipo;
                $model->tipo_archivo = $request->tipo_archivo;
                $model->created_at = Carbon::now();
                $model->uuid = $request->uuid;
                $model->path = $path['path'];
                $model->name_file = $path['name'];
                $model->inmueble_id = (!empty($request->inmueble_id)) ? $request->inmueble_id : null;
                $model->save();
            }

            DB::commit();

            $archivos = (new relacion_inmueble_archivos())
                ->selectRaw("relacion_inmueble_archivos.*, tipo_archivo.descripcion as tipoDescri")
                ->where('uuid',$request->uuid)
                ->leftjoin('tipo_archivo','tipo_archivo.id','=','relacion_inmueble_archivos.tipo_archivo')
                ->get();
            return Response::statusJson("success",'Archivo guardado Exitosamente!','saveArchivo',$archivos, true);
        }catch(\Exception $e){
            DB::rollback();
            return Response::statusJson("warning", $e->getMessage(), "saveArchivo", null, true, true);
        }
    }

}
