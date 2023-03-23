<?php

namespace App\Http\Controllers;

use App\Models\estatus;
use App\Models\pedidos;
use App\Models\ofertas;
use App\Models\propietario;
use App\Models\tipo_solicitud;
use App\Models\forma_de_pago;
use App\Models\tipo_inmueble;
use App\Models\User;
use App\services\Response;
use Illuminate\Http\Request;
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
            ->selectRaw("pedidos.id as pedidoid, 
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
                        tipo_solicitud.descripcion as tipo_solicitud, 
                        tipo_solicitud.id as idtipo_solicitud, 
                        forma_de_pago.descripcion as forma_de_pago,
                        forma_de_pago.id as idforma_de_pago,
                        tipo_inmueble.descripcion as tipo_inmueble,
                        tipo_inmueble.id as idtipo_inmueble,
                        estatus.descripcion as estatus,
                        estatus.id as idestatus,
                        pedidos.observacion"
            )
            ->join('forma_de_pago', 'forma_de_pago.id','=','pedidos.forma_de_pago')
            ->join('tipo_solicitud', 'tipo_solicitud.id','=','pedidos.tipo_solicitud')
            ->join('tipo_inmueble', 'tipo_inmueble.id','=','pedidos.tipo_inmueble')
            ->join('estatus', 'estatus.id', '=', 'pedidos.estatus');
        
        $data['pedidos'] = $pedidos->whereNull('pedidos.deleted_at')->get();
        $data['formadepago'] = (new forma_de_pago())->whereNull('deleted_at')->get();
        $data['tipoSolicitudes'] = (new tipo_solicitud())->whereIn('codigo', ['AL','CO'])->orderBy('id','desc')->get();
        $data['stat'] = (new estatus())->where('tipo','estatus')
        ->whereIn('codigo', ['FI','ER','DI'])->orderBy('id','desc')->get();
        $data['tipo_inmueble']  = (new tipo_inmueble())->whereNull('deleted_at')->get();
   
        return view('pages.pedidos', $data);
    }

    public function savePedidos(Request $request){
        try{

            DB::beginTransaction();

            $model = new pedidos();
            $model = $model->find($request->id);

            if(empty($model)) $model = new pedidos();

            $pedidos = $model->saveData($request);
        
            DB::commit();
            Response::statusJson($request,"success",'Registro Actualizado Exitosamente!','savePedidos', true);
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Response::statusJson($request,"warning", $e->getMessage(), "savePedidos", true, true);
            return redirect()->back()->withInput($request->all());
        }
    }

    public function getDetallePedidos(Request $request, $pedidosId){
        $data = [];

        $ofertas = (new ofertas())->getOfertas('noticia');
       // dd($ofertas);
        $propietario = (new propietario())->getPropietario('noticia');
        
        $data['pedidos'] = (new pedidos())
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
                    tipo_solicitud.descripcion as tipo_solicitud, 
                    tipo_solicitud.id as idtipo_solicitud, 
                    forma_de_pago.descripcion as forma_de_pago,
                    forma_de_pago.id as idforma_de_pago,
                    tipo_inmueble.descripcion as tipo_inmueble,
                    tipo_inmueble.id as idtipo_inmueble,
                    estatus.descripcion as estatus,
                    estatus.id as idestatus,
                    pedidos.observacion"
            )
            ->join('forma_de_pago', 'forma_de_pago.id','=','pedidos.forma_de_pago')
            ->join('tipo_solicitud', 'tipo_solicitud.id','=','pedidos.tipo_solicitud')
            ->join('tipo_inmueble', 'tipo_inmueble.id','=','pedidos.tipo_inmueble')
            ->join('estatus', 'estatus.id', '=', 'pedidos.estatus')
            ->where('pedidos.id', $pedidosId)
            ->first();

            $data['propietarios'] = $propietario->get();
            $data['ofertas'] = $ofertas->whereNull('ofertas.deleted_at')->get();
            $data['debaja'] = (new estatus())->where('tipo','estatus')
            ->whereIn('codigo', ['DB'])->orderBy('id','desc')->get();
            //dd($data);

        return view('pages.pedidos-detalle', $data);
    }

    public function darDeBaja(Request $request, $id){
        try{
            DB::beginTransaction();

            $model = new pedidos();
            $model = $model->find($id);

            $pedidos = $model->saveDeBaja($request);
        
            DB::commit();
           
            return Response::statusJson("success",'Registro Actualizado Exitosamente!','saveDeBaja', null, true);
        }catch(\Exception $e){
            DB::rollback();
            return Response::statusJson("warning", $e->getMessage(), "saveDeBaja", null, true, true);
        }
    }

    public function getDetalleEncargo(){
        $data = [];

        $data['propietarios'] = (new propietario())
            ->selectRaw("propietario.id as propietarioId, 
                propietario.nombre, 
                propietario.apellido, 
                propietario.telefono, 
                propietario.email as correo"
            )
            ->join('relacion_propietario_inmueble', 'relacion_propietario_inmueble.propietario_id','=','propietario.id')
            ->join('inmueble', 'inmueble.id','=','relacion_propietario_inmueble.inmueble_id')
            ->join('tipo_solicitud', 'tipo_solicitud.id','=','inmueble.tipo_solicitud')
            ->join('estatus', 'estatus.id','=','inmueble.accion')
            ->join('tipo_inmueble', 'tipo_inmueble.id','=','inmueble.tipo_inmueble')
            ->where('inmueble.accion',6)
            ->first();
        dd($data);
        return view('pages.pedidos-detalle', $data);
    }

}
