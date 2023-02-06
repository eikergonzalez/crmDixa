<?php

namespace App\Http\Controllers;

use App\Models\rol;
use App\services\Response;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class RolController extends Controller{

    public function index(){
        $data = [];
        $roles = (new rol());

            if(Auth::user()->rol_id == 1){
                $roles = $roles->where('id', Auth::user()->id);
            }
    
            $data['roles'] = (new rol())->where('description', '=', 'superAdmin')->get();

            return view('pages.ajustes.roles', $data);
            //return Response::statusJson("success",'success','getRol', rol::all(), false, true); 
    }

    public function saveRol(Request $request){
        try{
            $model = new rol();
            $model = $model->find($request->id);

            if(empty($model)) $model = new rol();

            $model->saveData($request);

            Response::status($request,"success",'Registro Guardado Exitosamente!','saveRol', true);
            return redirect()->back();
        }catch(\Exception $e){
            Response::status($request,"warning", $e->getMessage(), "saveRol", true, true);
            return redirect()->back()->withInput($request->all());
        }
    }
}