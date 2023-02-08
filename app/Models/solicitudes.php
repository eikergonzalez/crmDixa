<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class solicitudes extends Model{
    use HasFactory, Notifiable;

    protected $table = "solicitudes";
    public $timestamps = true;
    protected $primaryKey = "id";
    public $incrementing = true;

    public function getData(){
        $jsonData = json_decode($this->data_json);

        return $jsonData;
    }

    public function saveData($request){
        $this->Validator($request->all());

        try{
            $this->id = (!empty($request->id)) ? $request->id : $this->getNextId();
            $this->data_json = $request->dataJson;
            $this->type_request = $request->type_request;
            $this->type_action = $request->type_action;
            $this->save();
            return $this;
        }catch(\Exception $e){
            dd($e->getMessage());
            throw new \Exception("Ocurrio un error al guardar el registro", 1);
        }
    }

    protected function Validator(array $data = []){
        $required = 'required|unique:'.$this->table;

        if(empty($data['id'])){
            $validator = Validator::make($data, [
                'type_action' => 'required',
                'type_request' => 'required',
                'fname' => 'required',
                'lname' => 'required',
                'phone' => 'required',
                'address' => 'required',
                'price' => 'required',
            ]);
        }else{
            $validator = Validator::make($data, [
                'type_action' => 'required',
                'type_request' => 'required',
                'fname' => 'required',
                'lname' => 'required',
                'phone' => 'required',
                'address' => 'required',
                'price' => 'required',
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
        $next_id = DB::select("select nextval('seq_id_solicitudes')");
        return intval($next_id[0]->nextval);
    }

}
