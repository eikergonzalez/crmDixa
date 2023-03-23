<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Model;

class ofertas extends Model
{
    use HasFactory;
    protected $table = 'ofertas';
    public $timestamps = true;
    protected $primaryKey = "id";

    public function saveData($request){
        $this->validate($request->all());
        try{
           
            $this->inmueble_id = $request-> inmueble_id; 
            $this->nota = $request-> nota; 
            $this->created_at = Carbon::now();
            $this->save();

            return $this;
        }catch(\Exception $e){
            throw new \Exception("Ocurrio un error al guardar el registro", 1);
        }
    }

    protected function validate(array $data = []){

        $validator = Validator::make($data, [
            'inmueble_id' => 'required',
            'nota' => 'required',
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

    public function getOfertas($tipo){
        return $this->selectRaw("ofertas.id as id, 
            ofertas.nota as nota, 
            propietario.nombre as nombre,
            propietario.apellido as apellido,
            propietario.telefono, 
            propietario.email, 
            inmueble.id as inmuebleId, 
            inmueble.direccion as direccion, 
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
            inmueble.tipo_solicitud"
        )
        ->join('inmueble', 'inmueble.id','=','ofertas.inmueble_id')
        ->join('relacion_propietario_inmueble', 'relacion_propietario_inmueble.inmueble_id','=','ofertas.inmueble_id')
        ->join('propietario', 'propietario.id','=','relacion_propietario_inmueble.propietario_id')
        ->join('tipo_solicitud', 'tipo_solicitud.id','=','inmueble.tipo_solicitud')
        ->leftjoin('estatus', 'estatus.id','=','inmueble.status')
        ->where('inmueble.modulo',$tipo)
        ->whereNull('propietario.deleted_at');
    }
}
