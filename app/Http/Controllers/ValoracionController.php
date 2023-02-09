<?php

namespace App\Http\Controllers;

use App\Models\noticias;
use App\Models\tipo_inmueble;
use App\Models\estatus;
use App\Models\solicitudes;
use App\Models\User;
use App\services\Response;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ValoracionController extends Controller
{
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
        //dd($data['noticias']);
        $data['estatus'] = (new estatus())->get();
        $data['tipo_inmueble'] = (new tipo_inmueble())->get();

        return view('pages.valoracion', $data);
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
                "correo" => $request->correo,
                "address" => $request->address,
                "price" => $request->price,
                "price_value" => $request->price_value,
                "mutiles" => $request->mutiles,
                "mconstruidos" => $request->mconstruidos,
                "ascensor" => $request->ascensor,
                "tinmueble" => $request->tinmueble,
                "reforma" => $request->reforma,
                "exposicion" => $request->exposicion,
                "hipoteca" => $request->hipoteca,
                "herencia" => $request->herencia,
                "observations" => $request->observations,
            ]);

            $request['dataJson'] = $dataJson;

            $model->saveData($request);

            Response::status($request,"success",'Registro Guardado Exitosamente!','saveValoracion', true);
            return redirect()->back();
        }catch(\Exception $e){
            dd($e->getMessage());
            Response::status($request,"warning", $e->getMessage(), "saveNoticias", true, true);
            return redirect()->back()->withInput($request->all());
        }
    }
}
