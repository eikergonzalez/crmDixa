<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class propietario extends Model{
    use HasFactory;
    protected $table = 'propietario';
    public $timestamps = true;
    protected $primaryKey = "id";

    public function saveData($request){
        $this->Validator($request->all());

        try{
            $this->nombre = $request->nombre;
            $this->apellido = $request->apellido;
            $this->telefono = $request->telefono;
            $this->save();
            return $this;
        }catch(\Exception $e){
            throw new \Exception("Ocurrio un error al guardar el registro", 1);
        }
    }

    protected function Validator(array $data = []){

        $validator = Validator::make($data, [
            'nombre' => 'required',
            'apellido' => 'required',
            'telefono' => 'required',
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
