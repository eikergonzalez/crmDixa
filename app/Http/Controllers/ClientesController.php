<?php

namespace App\Http\Controllers;

use App\Models\clientes;
use App\services\Response;
use Illuminate\Http\Request;

class ClientesController extends Controller{

    public function getClientes(Request $request, $domain){
        try{
            return Response::statusJson("success",'success','getClientes', clientes::all(), false, true);
        }catch(\Exception $e){
            return Response::statusJson("error",$e->getMessage(),'getClientes', null, true, true);
        }
    }

	public function getClientebyId(Request $request, $domain){
        try{
            $cliente = clientes::find($request->id);
            return Response::statusJson("success",'success','getClientes', $cliente, false, true);
        }catch(\Exception $e){
            return Response::statusJson("error",$e->getMessage(),'getClientes', null, true, true);
        }
    }

    public function getClienteSearch(Request $request, $domain){
        try{
            $data = [];
            $data['clientes'] = clientes::all();

            return Response::statusJson("success",'success','getClientes', $data, false, true);
        }catch(\Exception $e){
            return Response::statusJson("error",$e->getMessage(),'getClientes', null, true, true);
        }
    }
}
