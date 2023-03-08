<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpWord\TemplateProcessor;

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
            $this->agenda_id = ($request->agenda_id) ? $request->agenda_id : $this->agenda_id;
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


    public function contrato($request){

       // dd($request->all());
        try {
            $template = new TemplateProcessor(storage_path('contrato.docx'));
            $template->setValue('nombre',$request->nombre);
            $template->setValue('apellido',$request->apellido);
            $template->setValue('direccion',$request->direccion);
            $template->setValue('email',$request->email);
            $template->setValue('telefono',$request->telefono);
            $template->setValue('precio_solicitado',$request->precio_solicitado);
            $template->setValue('precio_valorado',$request->precio_valorado);
            $template->setValue('metros_utiles',$request->metros_utiles);
            $template->setValue('metros_usados',$request->metros_usados);
            $template->setValue('ascensor',$request->ascensor);
            $template->setValue('tipo_inmueble',$request->tipo_inmueble);
            $template->setValue('reforma',$request->reforma);
            $template->setValue('exposicion',$request->exposicion);
            $template->setValue('habitaciones',$request->habitaciones);
            $template->setValue('hipoteca',$request->hipoteca);
            $template->setValue('hipoteca_valor',$request->hipoteca_valor);
            $template->setValue('herencia',$request->herencia);
            $template->setValue('tipo_solicitud',$request->tipo_solicitud);
            $template->setValue('status',$request->status);
            $template->setValue('accion',$request->accion);
            $template->setValue('observacion',$request->observacion);
            $template->saveAs(storage_path('contrato_mod.docx'));

            //return response()->download(storage_path('contrato.docx'));//->download($tenpFile, 'contrato.docx', $header)->deleteFileAfterSend($shouldDelete = true);
        } catch (\PhpOffice\PhpWord\Exception\Exception $e) {
            //throw $th;
            console.log($e);
            return back($e->getCode());
        }
    }
}
