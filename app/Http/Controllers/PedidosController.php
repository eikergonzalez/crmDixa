<?php

namespace App\Http\Controllers;

use App\Models\estatus;
use App\Models\inmueble;
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

class PedidosController extends Controller
{
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
            ->where('inmueble.accion',5);

            //dd($propietario);

        if(Auth::user()->rol_id == 4){
            $propietario = $propietario->where('propietario.user_id', Auth::user()->id);
        }

        if(Auth::user()->rol_id == 2){
            $propietario = $propietario->whereIn('propietario.user_id', $users);
        }

        $data['propietarios'] = $propietario->whereNull('propietario.deleted_at')->get();
        $data['tipoSolicitudes'] = (new tipo_solicitud())->whereNull('deleted_at')->get();
        $data['estatus'] = (new estatus())->where('tipo','accion')
        ->whereIn('codigo', ['ES','EN','DB'])->orderBy('id','desc')->get();
        $data['tipo_inmueble']  = (new tipo_inmueble())->whereNull('deleted_at')->get();
        //dd($data);
        return view('pages.de-baja', $data);
    }
}
