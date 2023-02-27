<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class valoracion extends Model
{
    use HasFactory;
    protected $table = 'inmueble';
    public $timestamps = true;
    protected $primaryKey = "id";

    public function saveData($request){
        $this->Validator($request->all());
        
        try{
            // if($request->accion == self::ACCION_VALORACION){
            //     $this->status = self::STATUS_SN_RESPUESTA;
            // }
            $this->direccion = $request->direccion;
            $this->precio_solicitado = $request->precio_solicitado;
            $this->precio_valorado = $request->precio_valorado;
            $this->metros_utiles = $request->metros_utiles;
            $this->metros_usados = $request->metros_usados;
            $this->ascensor = $request->ascensor;
            $this->tipo_inmueble = $request->tipo_inmueble;
            $this->reforma = $request->reforma;
            $this->exposicion = $request->exposicion;
            $this->habitaciones = $request->habitaciones;
            $this->hipoteca = $request->hipoteca;
            $this->hipoteca_valor = $request->hipoteca_valor;
            $this->herencia = $request->herencia;
            $this->tipo_solicitud = $request->tipo_solicitud;
            $this->status = $request->estatus;
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
            'email' => 'required',
            'direccion' => 'required',
            'precio_solicitado' => 'required',
            'precio_valorado' => 'required',
            'tipo_solicitud' => 'required',
            'tipo_inmueble' => 'required',
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
