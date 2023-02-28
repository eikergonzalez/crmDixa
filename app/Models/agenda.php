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

class agenda extends Authenticatable{
    use HasFactory, Notifiable;

    protected $table = "agenda";
    public $timestamps = true;
    protected $primaryKey = "id";
    public $incrementing = true;

    public function user(){
        return $this->hasOne('App\Models\User','id','user_id');
    }

    public function saveData($request){
        $this->Validator($request->all());

        try{
            $this->age_titulo = $request->age_titulo;
            $this->age_descri = $request->age_descri;
            $this->age_fecha = $request->age_fecha;
            $this->age_status = 1;
            $this->created_at = Carbon::now();
            $this->user_id = Auth::user()->id;
            $this->save();
            return $this;
        }catch(\Exception $e){
            throw new \Exception("Ocurrio un error al guardar el registro", 1);
        }
    }

    protected function Validator(array $data = []){
        $required = 'required|unique:'.$this->table;

        $validator = Validator::make($data, [
            'age_titulo' => 'required',
            'age_descri' => 'required',
            'age_fecha' => 'required',
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
    }
}
