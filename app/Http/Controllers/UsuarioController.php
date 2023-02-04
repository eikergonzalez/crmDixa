<?php

namespace App\Http\Controllers;

use App\Models\rol;
use App\services\Response;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class UsuarioController extends Controller{

    public function index(){
        $data = [];
        $usuarios = (new User());

        if(Auth::user()->rol_id == 4){
            $usuarios = $usuarios->where('id', Auth::user()->id);
        }

        $data['usuarios'] = $usuarios->whereNull('deleted_at')->get();
        $data['roles'] = (new rol())->where('description', '<>', 'superAdmin')->get();
        return view('pages.ajustes.usuarios', $data);
    }

    public function saveUsuario(Request $request){
        try{
            $model = new User();
            $model = $model->find($request->id);

            if(empty($model)) $model = new User();

            $model->saveData($request);

            Response::status($request,"success",'Registro Guardao Exitosamente!','saveUsuario', true);
            return redirect()->back();
        }catch(\Exception $e){
            Response::status($request,"warning", $e->getMessage(), "saveUsuario", true, true);
            return redirect()->back()->withInput($request->all());
        }
    }

    public function deleteUsuario(Request $request,$id){
        try{
            $model = User::find($id);

            if(empty($model)) return Response::statusJson("warning",'El usuario a leminar no se encuentra registrado','deleteUsuario');

            $model->deleted_at = Carbon::now();
            $model->activo = 0;
            $model->save();

            return Response::statusJson("success",'Registro Eliminado Exitosamente!','deleteUsuario', true);
        }catch(\Exception $e){
            return Response::statusJson("warning", $e->getMessage(), "saveUsuario", true, true);
        }
    }
}
