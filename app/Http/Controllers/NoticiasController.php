<?php

namespace App\Http\Controllers;

use App\Models\noticias;
use App\Models\solicitudes;
use App\Models\User;
use App\services\Response;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class NoticiasController extends Controller{

    public function index(){
        $data = []; 

        $usuario = (new User())->whereIn('rol_id', [2,4])->get('id');
        $users = [];
        
        foreach($usuario as $usr){
            $id=$usr->id;
            array_push($users,$id);
        }

        $noticias = (new solicitudes());

        if(Auth::user()->rol_id == 4){
            $noticias = $noticias->where('user_id', Auth::user()->id);
        }

        if(Auth::user()->rol_id == 2){
            $noticias = $noticias->whereIn('user_id', $users);
        }

        $data['noticias'] = $noticias->whereNull('deleted_at')->get();

        return view('pages.noticias', $data);
    }

    public function saveNoticias(Request $request){
        try{
            $model = new solicitudes();
            $model = $model->find($request->id);

            if(empty($model)) $model = new solicitudes();

            $dataJson = json_encode([
                "fname" => $request->fname,
                "lname" => $request->lname,
                "phone" => $request->phone,
                "address" => $request->address,
                "price" => $request->price,
                "observations" => $request->observations,
            ]);


            $request['dataJson'] = $dataJson;

            $model->saveData($request);

            Response::status($request,"success",'Registro Guardado Exitosamente!','saveNoticias', true);
            return redirect()->back();
        }catch(\Exception $e){
            dd($e->getMessage());
            Response::status($request,"warning", $e->getMessage(), "saveNoticias", true, true);
            return redirect()->back()->withInput($request->all());
        }
    }


}