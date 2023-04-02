<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller{
 
    public static function sendContratoFirmar($propietario){
        try{
            
            $data['propietario'] = $propietario;
             Mail::send('emails.contrato-firmar', $data, function ($message) use ($propietario) {
                $message->from('info@dixa.com', 'No Responder');
                $message->to($propietario['mail'])->subject('DIXA');
            });
            return true;
        }catch (\Exception $e){
            dd($e->getMessage());
        }

    }
}