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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class ValoracionController extends Controller
{
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

            $valoracion = $valoracion->contrato($request);

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
        $data['files'] = (new relacion_inmueble_archivos())
            ->selectRaw("relacion_inmueble_archivos.*, tipo_archivo.descripcion as tipoDescri")
            ->where('inmueble_id', $id)
            ->join('tipo_archivo','tipo_archivo.id','=','relacion_inmueble_archivos.tipo_archivo')
            ->get();
        return Response::statusJson($request, "success", 'success', 'getArchivos', $data);
    }

    public function saveArchivo(Request $request, $id){
        try{
            DB::beginTransaction();

            $model = new relacion_inmueble_archivos();

            if(!empty($id)){
                $model = (new relacion_inmueble_archivos())->find($id);
            }

            dd($request->all());



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

            DB::commit();
            Response::status($request,"success",'Registro Actualizado Exitosamente!','saveValoracion', true);
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Response::status($request,"warning", $e->getMessage(), "saveValoracion", true, true);
            return redirect()->back()->withInput($request->all());
        }
    }
    public function deleteArchivo(Request $request, $id){
        # code...
    }


    public function contrato($request){

        dd($request->all());
        try {
            $template = new TemplateProcessor(storage_path('contrato.docx'));
            $template->setValue('nombre',$request->nombre);
            $template->setValue('apellido',$request->apellido);
            $template->setValue('direccion',$request->direccion);
            $template->setValue('email',$request->email);
            $template->setValue('precio_solicitado',$request->precio_solicitado);
            $template->setValue('precio_valorado',$request->precio_valorado);
            $template->setValue('metros_utiles',$request->metros_utiles);
            $template->setValue('metros_usados',$request->metros_usados);
            $template->setValue('ascensor',$request->ascensor);
            $template->setValue('tipo_inmueble',$request->tipo_inmueble);
            $template->setValue('reforma',$request->reforma);
            $template->setValue('exposicion',$request->exposicion);
            $template->setValue('habitaciones',$request->habitaciones);
            $template->setValue('hipoteca',$request->hipoteca);
            $template->setValue('hipoteca_valor',$request->hipoteca_valor);
            $template->setValue('herencia',$request->herencia);
            $template->setValue('tipo_solicitud',$request->tipo_solicitud);
            $template->setValue('status',$request->status);
            $template->setValue('accion',$request->accion);
            $template->setValue('observacion',$request->observacion);
            $template->saveAs(storage_path('contrato_mod.docx'));

            //return response()->download(storage_path('contrato.docx'));//->download($tenpFile, 'contrato.docx', $header)->deleteFileAfterSend($shouldDelete = true);
        } catch (\PhpOffice\PhpWord\Exception\Exception $e) {
            //throw $th;
            console.log($e);
            return back($e->getCode());
        }
    }
}
