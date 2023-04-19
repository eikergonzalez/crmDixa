<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpWord\TemplateProcessor;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

class inmueble extends Model
{
    use HasFactory;
    protected $table = 'inmueble';
    public $timestamps = true;
    protected $primaryKey = "id";

    CONST ACCION_VALORACION = 4;
    CONST ACCION_SEGUIMIENTO = 2;
    CONST ACCION_BAJA = 5;
    CONST ACCION_ENCARGO = 6;
    
    CONST STATUS_SN_RESPUESTA = 1;
    CONST STATUS_REVISION = 9;
    CONST STATUS_FIRMADO = 3;
    CONST STATUS_SEGUIMIENTO = 7;
    CONST STATUS_DISPONIBLE = 8;

    public function saveData($request){
        $this->Validator($request->all());

        try{
            if($request->accion == self::ACCION_VALORACION){
                $this->status = self::STATUS_SN_RESPUESTA;
            }
            if($request->accion == self::ACCION_SEGUIMIENTO){
                $this->status = self::STATUS_SEGUIMIENTO;
            }
            $this->direccion = $request->direccion;
            $this->precio_solicitado = $request->precio_solicitado;
            $this->tipo_solicitud = $request->tipo_solicitud;
            $this->accion = $request->accion;
            $this->observacion = $request->observacion;
            $this->agenda_id = ($request->agenda_id) ? $request->agenda_id : null;
            $this->modulo = $request->modulo;
            $this->procedencia = $request->procedencia;
            $this->user_id = Auth::user()->id;
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

    public function saveValoracion($request){
        $this->validateValoracion($request->all());
        
        try{
            $status = '';

            switch ($request->accion) {
                case self::ACCION_BAJA:
                    $status = self::STATUS_SN_RESPUESTA;
                    break;
                case self::ACCION_ENCARGO:
                    $status = self::STATUS_REVISION;
                    break;
                default:
                    $status = $this->status;
                    break;
            }

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
            $this->status = $status;
            $this->accion = $request->accion;
            $this->observacion = $request->observacion;
            $this->modulo = $request->modulo;
            $this->save();

            return $this;
        }catch(\Exception $e){
            throw new \Exception("Ocurrio un error al guardar el registro", 1);
        }
    }

    protected function validateValoracion(array $data = []){

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

    public function contrato(Request $request, inmueble $inmueble){
        switch ($inmueble->tipo_solicitud) {
            case 1:
                $tipoArchivo = "contrato_compra_venta";
                break;
            case 2:
                $tipoArchivo = "contrato_alquiler";
                break;
            case 3:
                $tipoArchivo = "contrato_compra_venta";
                break;
        }

        $path = public_path().'/plantillas/';
        if (!is_dir($path)) {
            File::makeDirectory($path,0777,true);
        }

        $path2 = public_path().'/contratos/';
        if (!is_dir($path2)) {
            File::makeDirectory($path2,0777,true);
        }
        $uuid = $request->uuid;

        $template = new TemplateProcessor("$path$tipoArchivo.docx");
        $template->setValue('nombre',$request->nombre);
        $template->setValue('apellido',$request->apellido);
        $template->setValue('direccion',$request->direccion);
        $template->setValue('email',$request->email);
        $template->setValue('telefono',$request->telefono);
        $template->setValue('precioSolicitado',$request->precio_solicitado);
        $template->setValue('precioValorado',$request->precio_valorado);
        $template->setValue('metrosUtiles',$request->metros_utiles);
        $template->setValue('metrosUsados',$request->metros_usados);
        $template->setValue('ascensor',$request->ascensor);
        $template->setValue('tipoInmueble',$request->tipo_inmueble);
        $template->setValue('reforma',$request->reforma);
        $template->setValue('exposicion',$request->exposicion);
        $template->setValue('habitaciones',$request->habitaciones);
        $template->setValue('hipoteca',$request->hipoteca);
        $template->setValue('hipotecaValor',$request->hipoteca_valor);
        $template->setValue('herencia',$request->herencia);
        $template->setValue('tipoSolicitud',$request->tipo_solicitud);
        $template->setValue('status',$request->status);
        $template->setValue('accion',$request->accion);
        $template->setValue('observacion',$request->observacion);
        $template->saveAs("$path2$tipoArchivo$uuid.docx");

        return [ "path" => "$path2$tipoArchivo$uuid.docx", "name" => "$tipoArchivo$uuid.docx"];

    }

    public function saveDeBaja($request){
        try{

            $this->status = $request-> estatus;
            $this->updated_at = Carbon::now();
            $this->save();

            return $this;
        }catch(\Exception $e){
            throw new \Exception("Ocurrio un error al guardar el registro", 1);
        }
    }
}
