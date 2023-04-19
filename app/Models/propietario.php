<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

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
            $this->email = $request->email;
            $this->user_id = Auth::user()->id;
            $this->user_add = (empty($request->id)) ? Auth::user()->id : $this->user_add;
            $this->user_upd = (!empty($request->id)) ? Auth::user()->id : $this->user_upd;
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

    public function getPropietario($tipo){
        return $this->selectRaw("propietario.id as propietarioId, 
            propietario.nombre, 
            propietario.apellido, 
            propietario.telefono, 
            propietario.email, 
            inmueble.id as inmuebleId, 
            inmueble.direccion, 
            inmueble.precio_solicitado,
            inmueble.precio_valorado,
            inmueble.metros_utiles,
            inmueble.metros_usados,
            inmueble.ascensor,
            inmueble.tipo_inmueble,
            inmueble.reforma,
            inmueble.exposicion,
            inmueble.habitaciones,
            inmueble.hipoteca,
            inmueble.hipoteca_valor,
            inmueble.herencia,
            inmueble.observacion, 
            inmueble.accion,
            inmueble.status, 
            inmueble.tipo_solicitud, 
            tipo_solicitud.descripcion as solicitud, 
            procedencia.descripcion as procedencia,
            estatus.descripcion as estatus"
        )
        ->join('relacion_propietario_inmueble', 'relacion_propietario_inmueble.propietario_id','=','propietario.id')
        ->join('inmueble', 'inmueble.id','=','relacion_propietario_inmueble.inmueble_id')
        ->join('tipo_solicitud', 'tipo_solicitud.id','=','inmueble.tipo_solicitud')
        ->join('procedencia', 'procedencia.id','=','inmueble.procedencia')
        ->leftjoin('estatus', 'estatus.id','=','inmueble.status')
        ->where('inmueble.modulo',$tipo)
        ->whereNull('propietario.deleted_at');
    }

    public function getPropietario_valoracion(){
        return $this->selectRaw("propietario.id as propietarioId, 
                propietario.nombre, 
                propietario.apellido, 
                propietario.telefono, 
                propietario.email, 
                inmueble.id as inmuebleId, 
                inmueble.direccion, 
                inmueble.precio_solicitado,
                inmueble.precio_valorado,
                inmueble.metros_utiles,
                inmueble.metros_usados,
                inmueble.ascensor,
                inmueble.tipo_inmueble,
                inmueble.reforma,
                inmueble.exposicion,
                inmueble.habitaciones,
                inmueble.hipoteca,
                inmueble.hipoteca_valor,
                inmueble.herencia,
                inmueble.observacion, 
                inmueble.accion,
                inmueble.status, 
                inmueble.tipo_solicitud, 
                tipo_solicitud.descripcion as solicitud,
                procedencia.descripcion as procedencia, 
                estatus.descripcion as estatus_val"
            )
            ->join('relacion_propietario_inmueble', 'relacion_propietario_inmueble.propietario_id','=','propietario.id')
            ->join('inmueble', 'inmueble.id','=','relacion_propietario_inmueble.inmueble_id')
            ->join('tipo_solicitud', 'tipo_solicitud.id','=','inmueble.tipo_solicitud')
            ->join('procedencia', 'procedencia.id','=','inmueble.procedencia')
            ->leftjoin('estatus', 'estatus.id','=','inmueble.status')
            ->where('inmueble.modulo','valoracion');
    }
}
