<?php

namespace App\Http\Controllers;

use App\Models\estatus;
use App\Models\pedidos;
use App\Models\tipo_solicitud;
use App\Models\forma_de_pago;
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

        $pedidos = (new pedidos())
            ->selectRaw("pedidos.id as pedidosId, 
                        pedidos.nombre, 
                        pedidos.apellido, 
                        pedidos.telefono, 
                        pedidos.correo_electronico, 
                        pedidos.zona_interesada,
                        pedidos.precio,
                        pedidos.metros_cuadrados,
                        pedidos.ascensor,
                        pedidos.tipo_inmueble,
                        pedidos.reforma,
                        pedidos.exposicion,
                        pedidos.habitaciones,
                        pedidos.terraza,
                        tipo_solicitud.descripcion as solicitud, 
                        forma_de_pago.descripcion as forma_de_pago,
                        tipo_inmueble.descripcion as tipo_inmueble,
                        pedidos.observacion"
            )
            ->join('forma_de_pago', 'forma_de_pago.id','=','pedidos.forma_de_pago')
            ->join('tipo_solicitud', 'tipo_solicitud.id','=','pedidos.tipo_solicitud')
            ->join('tipo_inmueble', 'tipo_inmueble.id','=','pedidos.tipo_inmueble');

            //dd($pedidos);
        $data['pedidos'] = $pedidos->whereNull('pedidos.deleted_at')->get();
        $data['formadepago'] = (new forma_de_pago())->whereNull('deleted_at')->get();
        $data['tipoSolicitudes'] = (new tipo_solicitud())->whereIn('codigo', ['AL','CO'])->orderBy('id','desc')->get();
        $data['stat'] = (new estatus())->where('tipo','estatus')
        ->whereIn('codigo', ['FI','ER','DI'])->orderBy('id','desc')->get();
        $data['tipo_inmueble']  = (new tipo_inmueble())->whereNull('deleted_at')->get();
        //dd($data);
        return view('pages.pedidos', $data);
    }
}
