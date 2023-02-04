<?php

namespace App\services;

use App\Models\Notificacion;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response as FacadesResponse;

class Response extends Model{
    use HasFactory;

    private static function createNotification($status,$msg,$accion){
        $notificacion = new Notificacion();
        $notificacion->id = $notificacion->getNextId();
        $notificacion->user_id = null;
        $notificacion->accion = $accion;
        $notificacion->mensaje = $msg;
        $notificacion->estado = $status;
        $notificacion->save();
        return $notificacion;
    }

    public static function status($request, $status,$msg = "",$accion = "",$log = false, $notificacion = false){
        $code = 200;

        switch ($status){
            case "error" : {
                $code = 500;
                break;
            };
            case "warning" : {
                $code = 400;
                break;
            };
            case "Forbidden" : {
                $code = 403;
                break;
            };
            case "Not Found" : {
                $code = 404;
                break;
            };
            case "Unauthorized" : {
                $code = 401;
                break;
            };
        }

        if($notificacion) self::createNotification($status,$msg,$accion);

        $response = FacadesResponse::json(array('status' => $status,'title' => self::mensaje($status),'msg' =>$msg,'accion' =>$accion,'code' => $code),$code);
        if($log) self::sendLog($code, $response);

        $request->session()->flash('status', array('status' => $status,'title' => self::mensaje($status),'msg' =>$msg,'accion' =>$accion));
        return true;
    }

    public static function statusJson($status, $msg = "",$accion = "",$data = null, $log = false, $notificacion = false){
        $code = 200;
        switch ($status){
            case "error" : {
                $code = 500;
                break;
            };
            case "warning" : {
                $code = 400;
                break;
            };
            case "Forbidden" : {
                $code = 403;
                break;
            };
            case "Not Found" : {
                $code = 404;
                break;
            };
            case "Unauthorized" : {
                $code = 401;
                break;
            };
        }

        if($notificacion) self::createNotification($status,$msg,$accion);
        $response = FacadesResponse::json(array('status' => $status,'title' => self::mensaje($status),'msg' =>$msg,'accion' =>$accion,'data' => $data,'code' => $code),$code);

        if($log) self::sendLog($code, $response);
        return $response;
    }

    public static function sendLog($code, $response){
        switch ($code){
            case 500 : {
                Log::error($response);
                break;
            };
            case 400 : {
                Log::warning($response);
                break;
            };
            case 403 : {
                Log::alert($response);
                break;
            };
            case 404 : {
                Log::critical($response);
                break;
            };
            case 401 : {
                Log::emergency($response);
                break;
            };
            case 200 : {
                Log::info($response);
                break;
            };
        }
    }

    public static function mensaje($status): string{
        $message = "";
        switch ($status){
            case "question": {
                $message = "Confirmar";
                break;
            };
            case "info": {
                $message = "Importante!";
                break;
            };
            case "warning": {
                $message = "Alerta!";
                break;
            };
            case "error": {
                $message = "Error";
                break;
            };
            case "success": {
                $message = "Exito";
                break;
            };
        }
        return $message;
    }
}
