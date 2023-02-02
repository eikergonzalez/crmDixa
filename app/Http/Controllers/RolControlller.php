<?php

namespace App\Http\Controllers;

use App\Models\rol;
use App\services\Response;
use Illuminate\Http\Request;

class RolController extends Controller{
    
    public function getRol(Request $request, $domain){
        try{
            return Response::statusJson("success",'success','getRol', rol::all(), false, true);
        }catch(\Exception $e){
            return Response::statusJson("error",$e->getMessage(),'getRol', null, true, true);
        }
    }


}