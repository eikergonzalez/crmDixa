<?php

namespace App\Http\Controllers;

use App\Models\estatus;
use App\Models\inmueble;
use App\Models\valoracion;
use App\Models\propietario;
use App\Models\relacion_propietario_inmueble;
use App\Models\tipo_solicitud;
use App\Models\tipo_inmueble;
use App\Models\User;
use App\services\Response;
use Illuminate\Http\Request;
use Carbon\Carbon;
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

        $propietario = (new propietario())->getPropietario_valoracion();

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
        return view('pages.valoracion', $data);
    }

    public function saveValoracion(Request $request){
        try{

            DB::beginTransaction();
            //ACTUALIZA LOS DATOS DEL PROPIETARIO
            $model =propietario::find($request->id);
            $propietario = $model->saveData($request);

            //ACTUALIZA LOS DATOS DEL INMUEBLE
            $valoracion = valoracion::find($request->id_inmueble);
            $valoracion = $valoracion->saveData($request);
            
            DB::commit();
            Response::status($request,"success",'Registro Actualizado Exitosamente!','saveValoracion', true);
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            dd($e->getMessage());
            Response::status($request,"warning", $e->getMessage(), "saveValoracion", true, true);
            return redirect()->back()->withInput($request->all());
        }
    }
}
