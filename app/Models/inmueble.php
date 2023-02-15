<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class inmueble extends Model
{
    use HasFactory;
    protected $table = 'inmueble';
    public $timestamps = true;
    protected $primaryKey = "id";

    public function saveData($request){
        $this->Validator($request->all());

        try{
            $this->direccion = $request->direccion;
            $this->precio_solicitado = $request->precio_solicitado;
            $this->tipo_solicitud = $request->tipo_solicitud;
            $this->accion = $request->accion;
            $this->observacion = $request->observacion;
            $this->save();
            return $this;
        }catch(\Exception $e){
            throw new \Exception("Ocurrio un error al guardar el registro", 1);
        }
    }

    protected function Validator(array $data = []){

        $validator = Validator::make($data, [
            'direccion' => 'required',
            'precio_solicitado' => 'required',
            'tipo_solicitud' => 'required',
            'accion' => 'required',
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
