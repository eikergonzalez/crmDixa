<?php

namespace App\Http\Middleware;

use App\Models\Logs;
use Closure;
use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class LogsMiddleware{

    public function handle(Request $request, Closure $next){
        $log = new Logs();
        //$token = request()->bearerToken();

        /* if($token){
            $token2 = JWTAuth::getToken($token);
            $decoded = JWTAuth::getPayload($token2)->toArray();
            $log->user = $decoded['usuario']['id'];
        }*/
        $log->user = 1;
        $parameters = json_encode($request->all(),true);
        list($controller,$action) = explode('@', $request->route()->getAction()["controller"]);

        $log->controller = $controller;
        $log->action = $action;
        $log->parameters = $parameters ?? null;
        $log->url = $_SERVER['REQUEST_URI'];
        $log->save();
        return $next($request);
    }
}
