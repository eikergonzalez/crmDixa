<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class GetUserAuth{
    public function handle(Request $request, Closure $next){
        $user = Auth::user();
        dd($user);
        /* $token = request()->bearerToken();

        if($token){
            $token2 = JWTAuth::getToken($token);
            $decoded = JWTAuth::getPayload($token2)->toArray();
            $user = $decoded[0];
            $request['user'] = $user;
        } */
        return $next($request);
    }
}