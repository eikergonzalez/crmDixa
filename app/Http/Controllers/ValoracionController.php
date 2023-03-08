<?php

namespace App\Http\Controllers;

use App\Models\estatus;
use App\Models\inmueble;
use App\Models\relacion_inmueble_archivos;
use App\Models\propietario;
use App\Models\tipo_archivo;
use App\Models\tipo_solicitud;
use App\Models\tipo_inmueble;
use App\Models\User;
use App\services\Response;
use App\services\AgendaService;
use App\services\FilesService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ValoracionController extends Controller{

    public function index(){
        $data = []; 

        $usuario = (new User())->whereIn('rol_id', [2,4])->get('id');
        $users = [];
        
        foreach($usuario as $usr){
            $id=$usr->id;
            array_push($users,$id);
        }

        $propietario = (new propietario())->getPropietario('valoracion');

        if(Auth::user()->rol_id == 4){
            $propietario = $propietario->where('propietario.user_id', Auth::user()->id);
        }

        if(Auth::user()->rol_id == 2){
            $propietario = $propietario->whereIn('propietario.user_id', $users);
        }

        $data['propietarios'] = $propietario->whereNull('propietario.deleted_at')->get();
        $data['tipoSolicitudes'] = (new tipo_solicitud())->whereNull('deleted_at')->get();
        $data['estatus'] = (new estatus())->where('tipo','accion')
            ->whereIn('codigo', ['ES','EN','DB','VA'])->orderBy('id','desc')->get();
        $data['stat'] = (new estatus())->where('tipo','estatus')
            ->whereIn('codigo', ['ES','SR','FI'])->orderBy('id','desc')->get();
        $data['tipo_inmueble']  = (new tipo_inmueble())->whereNull('deleted_at')->get();
        $data['tipoArchivo'] = (new tipo_archivo())->get();
        return view('pages.valoracion', $data);
    }

    public function saveValoracion(Request $request){
        try{

            DB::beginTransaction();

            $model =propietario::find($request->id);
            $propietario = $model->saveData($request);

            $agenda = null;
            if(!empty($request->age_titulo) and !empty($request->age_descri) and !empty($request->age_fecha)){
                $agenda = AgendaService::crearAgenda($request);
            }

            $request['agenda_id'] = (!empty($agenda)) ? $agenda->id : null;
            $modulo = 'valoracon';

            if($request->accion == 5) $modulo = 'baja';
            if($request->accion == 6) $modulo = 'encargo';

            $request['modulo'] = $modulo;

            $valoracion = inmueble::find($request->id_inmueble);
            $valoracion = $valoracion->saveValoracion($request);
            
            $request['uuid']= Str::uuid();
            $valoracion_contrato = $valoracion->contrato($request);

            $model = new relacion_inmueble_archivos();
            $model->tipo = "contrato";
            $model->created_at = Carbon::now();
            $model->uuid = $request->uuid;
            $model->path = $valoracion_contrato['path'];
            $model->name_file = $valoracion_contrato['name'];
            $model->inmueble_id = $valoracion->id;
            $model->save();

            DB::commit();
            Response::status($request,"success",'Registro Actualizado Exitosamente!','saveValoracion', true);
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Response::status($request,"warning", $e->getMessage(), "saveValoracion", true, true);
            return redirect()->back()->withInput($request->all());
        }
    }

    public function getArchivos(Request $request, $id){
        $data = (new relacion_inmueble_archivos())
            ->selectRaw("relacion_inmueble_archivos.*, tipo_archivo.descripcion as tipoDescri")
            ->where('inmueble_id', $id)
            ->leftjoin('tipo_archivo','tipo_archivo.id','=','relacion_inmueble_archivos.tipo_archivo')
            ->get();
        return Response::statusJson("success", 'success', 'getArchivos', $data);
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
                $model = new relacion_inmueble_archivos();
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

    public function deleteArchivo(Request $request, $id){
        try{
            DB::beginTransaction();

            $model = (new relacion_inmueble_archivos())->find($id);

            if(!$model) return Response::statusJson("warning", 'El archivo no se encuentra registrado', "deleteArchivo", true, true);

            $inmuebleId = $model->inmueble_id;
            $uuid = $model->uuid;

            FilesService::deleteFile($model->path);

            $model->delete();
            DB::commit();

            $archivos = (new relacion_inmueble_archivos())
                ->selectRaw("relacion_inmueble_archivos.*, tipo_archivo.descripcion as tipoDescri")
                ->leftjoin('tipo_archivo','tipo_archivo.id','=','relacion_inmueble_archivos.tipo_archivo');
            
            if(!empty($inmuebleId)){
                $archivos = $archivos->where('inmueble_id', $inmuebleId);
            }else{
                $archivos = $archivos->where('uuid', $uuid);
            }

            $archivos = $archivos->get();

            return Response::statusJson("success",'Archivo guardado Exitosamente!','saveArchivo',$archivos, true);
        }catch(\Exception $e){
            DB::rollback();
            return Response::statusJson("warning", $e->getMessage(), "saveArchivo", null, true, true);
        }
    }

   
}
