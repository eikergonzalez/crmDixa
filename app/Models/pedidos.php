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

class pedidos extends Model
{
    use HasFactory;
    protected $table = 'pedidos';
    public $timestamps = true;
    protected $primaryKey = "id";


    public function saveData($request){
        $this->validatePedidos($request->all());
        //dd($request->all());
        try{

            $this->nombre = $request-> nombre; 
            $this->apellido = $request-> apellido; 
            $this->telefono = $request-> telefono; 
            $this->correo_electronico = $request-> correo_electronico; 
            $this->zona_interesada = $request-> zona_interesada;
            $this->precio = $request-> precio;
            $this->metros_cuadrados = $request-> metros_cuadrados; 
            $this->ascensor = $request-> ascensor;
            $this->tipo_inmueble= $request-> tipo_inmueble; 
            $this->reforma = $request-> reforma;
            $this->exposicion = $request-> exposicion;
            $this->habitaciones = $request-> habitaciones;
            $this->terraza = $request-> terraza;
            $this->tipo_solicitud = $request-> tipo_solicitud;
            $this->forma_de_pago = $request-> forma_de_pago;
            $this->observacion = $request-> observacion;
            $this->estatus = $request-> estatus;
            $this->created_at = Carbon::now();
            $this->save();

            return $this;
        }catch(\Exception $e){
            throw new \Exception("Ocurrio un error al guardar el registro", 1);
        }
    }

    protected function validatePedidos(array $data = []){

        $validator = Validator::make($data, [
            'correo_electronico' => 'required',
            'nombre' => 'required',
            'apellido' => 'required',
            'telefono' => 'required',
            'precio' => 'required',
            'forma_de_pago' => 'required',
            'estatus' => 'required',
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
    
    public function saveDeBaja($request){
        $this->validateDeBaja($request->all());
        //dd($request->all());
        try{

            $this->estatus = $request-> estatus;
            $this->motivo_de_baja = $request-> motivo_de_baja;
            $this->updated_at = Carbon::now();
            $this->save();

            return $this;
        }catch(\Exception $e){
            throw new \Exception("Ocurrio un error al guardar el registro", 1);
        }
    }

    protected function validateDeBaja(array $data = []){

        $validator = Validator::make($data, [
            'motivo_de_baja' => 'required',
           
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
