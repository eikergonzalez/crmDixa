<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class visitas extends Model
{
    use HasFactory;
    protected $table = 'visitas';
    public $timestamps = true;
    protected $primaryKey = "id";

    public function user(){
        return $this->hasOne('App\Models\User','id','user_id');
    }

    public function saveData($request){
        $this->Validator($request->all());
        //dd($request->all());
        try{
            $this->nombre = $request->nombre;
            $this->apellido = $request->apellido;
            $this->telefono = $request->telefono;
            $this->correo = $request->correo;
            $this->created_at = Carbon::now();
            $this->save();
            return $this;
        }catch(\Exception $e){
            throw new \Exception("Ocurrio un error al guardar el registro", 1);
        }
    }

}
