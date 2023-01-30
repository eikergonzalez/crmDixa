<?php

namespace App\Http\Controllers;

use App\services\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller{

    public function login(Request $request, $domain){
        try{
            $validator = Validator::make($request->all(), [
                'email' => 'required|string',
                'password' => 'required|string',
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors()->all();
                $err = null;
                $ctn = 1;
                foreach($errors as $error){
                    $err.= $ctn++.')'.$error.'\n';
                }
                throw new \Exception($err);
            }

            $credentials = $request->only('email', 'password');
            $customClaims = ['usuario' => 'asdasd'];
            $token = Auth::claims($customClaims)->setTTL(999999)->attempt($credentials);

            if (!$token) {
                return Response::statusJson("warning",'Usuario o Contraseña no válida!','login', null, true, false);
            }
            return Response::statusJson("success",'Session iniciada','login', $token, false, true);
        }catch(\Exception $e){
            return Response::statusJson("error",$e->getMessage(),'login', null, true, true);
        }
    }

    public function logout(){
        Auth::logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }

    public function refresh(){
        return response()->json([
            'status' => 'success',
            'user' => Auth::user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }
}
