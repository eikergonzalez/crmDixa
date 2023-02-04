<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable{
    use HasFactory, Notifiable;

    protected $table = "users";
    public $timestamps = true;
    protected $primaryKey = "id";
	public $incrementing = true;

    public function validateCredentials(array $credentials){
        $plain = $credentials['password'];
        return $this->hasher->check($plain, $this->getAuthPassword());
    }

    public function role(){
        return $this->hasOne('App\Models\rol','id','rol_id');
    }

    public function saveData($request){
        $request['password'] = (!empty($request->password) and strlen($request->password) < 15) ? Hash::make($request->password) : $this->password;
        $this->Validator($request->all());

        try{
            $this->id = (!empty($request->id)) ? $request->id : $this->getNextId();
            $this->email = $request->email;
            $this->name = $request->name;
            $this->password = $request->password;
            $this->rol_id = $request->rol_id;
            $this->activo = $request->activo;
            $this->save();
            return $this;
        }catch(\Exception $e){
            throw new \Exception("Ocurrio un error al guardar el registro", 1);
        }
    }

    protected function Validator(array $data = []){
        $required = 'required|unique:'.$this->table;

        if(empty($data['id'])){
            $validator = Validator::make($data, [
                'email' => $required.',email',
                'name' => 'required',
                'password' => 'required',
                'rol_id' => 'required',
                'activo' => 'required',
            ]);
        }else{
            $validator = Validator::make($data, [
                'email' =>  $required.',email,'.$data['id'].','.$this->primaryKey,
                'name' => 'required',
                'password' => 'required',
                'rol_id' => 'required',
                'activo' => 'required',
            ]);
        }

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

    public function getNextId(){
        $next_id = DB::select("select nextval('seq_id_usuario')");
        return intval($next_id[0]->nextval);
    }

}
