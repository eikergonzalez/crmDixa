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

    CONST ACCION_VALORACION = 4;
    CONST ACCION_SEGUIMIENTO = 7;
    CONST ACCION_BAJA = 5;
    CONST ACCION_ENCARGO = 6;
    
    CONST STATUS_SN_RESPUESTA = 1;
    CONST STATUS_REVISION = 9;
    CONST STATUS_FIRMADO = 3;
    CONST STATUS_SEGUIMIENTO = 2;
    CONST STATUS_DISPONIBLE = 8;

    public function saveData($request){
        $this->Validator($request->all());

        try{
            if($request->accion == self::ACCION_VALORACION){
                $this->status = self::STATUS_SN_RESPUESTA;
            }
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
