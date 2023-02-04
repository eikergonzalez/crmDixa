<?php

namespace App\Http\Controllers;

use App\Models\rol;
use App\services\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RolController extends Controller{

    public function index(){
            $data = array();
            $data['roles'] = DB::table('rol')->get();
            //dd($data);
            return view('pages.ajustes.roles', $data);
            //return Response::statusJson("success",'success','getRol', rol::all(), false, true); 
    }

    public function getRolbyId(Request $request, $domain){
        try{
            $rol = turnos::find($request->id);
            return Response::statusJson("success",'success','createTurno', $cliente, false, true);
        }catch(\Exception $e){
            return Response::statusJson("error",$e->getMessage(),'createTurno', null, true, true);
        }
    }



}