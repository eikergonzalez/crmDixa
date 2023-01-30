<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class DecodeToken{
    public function handle(Request $request, Closure $next){
        $token = request()->bearerToken();
        //$url = $_SERVER['SERVER_NAME'];
        //$parsedUrl = parse_url($url);
        //$host = explode('.', $parsedUrl['path']);
        //$domain = $host[0];

        if($token){
            $token2 = JWTAuth::getToken($token);
            $decoded = JWTAuth::getPayload($token2)->toArray();
            $request['user'] = (new User())->join('secprofile', 'secprofile.pro_id', '=', 'users.usu_perfil')
                ->where('users.id', $decoded['usuario']['id'])
                ->first();
        }
        return $next($request);
    }
}
