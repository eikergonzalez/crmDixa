<?php

namespace App\Http\Controllers;

use App\services\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller{

    public function index(){
        return view('auth.login');
    }

    public function login(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'email' => 'required|string|email',
                'password' => 'required|string',
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors()->all();
                $err = null;
                $ctn = 1;
                foreach($errors as $error){
                    $err.= $ctn++.')'.$error.'\r\n';
                }
                throw new \Exception(nl2br($err));
            }

            $user = new User();
            $user = $user->where('email',$request->email)->first();

            if (empty($user)) {
                Response::status($request,"warning",'Usuario no registrado.',"Login");
                return redirect()->back()->withInput($request->all());
            }

            if (!$user->activo) {
                Response::status($request,"warning",'usuario bloqueado',"Login");
                return redirect()->back()->withInput($request->all());
            }

            $credentials = $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]);

            if (Auth::attempt(['email' => $request->email, 'password' => $request->password], true)) {
                $request->session()->regenerate();
                return redirect()->intended('/');
            }
            Response::status($request,"warning",'usuario o contraseña inválida',"Login");
            return redirect()->back()->withInput($request->all());
        }catch(\Exception $e){
            Response::status($request,"warning", $e->getMessage(), "Login", true, true);
            return redirect()->back()->withInput($request->all());
        }
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/auth/login');
}
}
