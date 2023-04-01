<?php

namespace App\Http\Controllers;

use App\Models\estatus;
use App\Models\inmueble;
use App\Models\pedidos;
use App\Models\propietario;
use App\Models\User;
use App\services\Response;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller{
    public function index(){
        $data = []; 

        $usuario = (new User())->whereIn('rol_id', [2,4])->get('id');
        $users = [];
        
        foreach($usuario as $usr){
            $id=$usr->id;
            array_push($users,$id);
        }

        $data['valoraciones'] = DB::table('inmueble')->selectRaw('count(*) as valoracion')->where('inmueble.accion', 6)->get();
        $data['encargos'] = DB::table('inmueble')->selectRaw('count(*) as encargo')->where('inmueble.accion', 4)->get();
        $data['pedidos'] = DB::table('pedidos')->selectRaw('count(*) as pedido')->get();
        return view('/dashboard', $data);
    }
}
