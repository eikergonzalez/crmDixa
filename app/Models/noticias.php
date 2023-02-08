<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class noticias extends Model{
    use HasFactory;
    protected $table = 'noticias';
    public $timestamps = true;
    protected $primaryKey = "id";

    public function saveData($request){
        $this->Validator($request->all());

        try{
            $this->id = (!empty($request->id)) ? $request->id : $this->getNextId();
            $this->fnane = $request->email;
            $this->lname = $request->email;
            $this->phone = $request->phone;
            $this->address = $request->address;
            $this->price = $request->price;
            $this->type_request = $request->type_request;
            $this->observations = $request->observations;
            $this->save();
            return $this;
        }catch(\Exception $e){
            throw new \Exception("Ocurrio un error al guardar el registro", 1);
        }
    }

    protected function Validator(array $data = []){
        $required = 'required|unique:'.$this->table;

        if(empty($data['id'])){
            $validator = Validator::make($data, [
                'fname' => $required.',fname',
                'lname' => 'required',
                'phone' => 'required',
                'address' => 'required',
                'price' => 'required',
                'observations' => 'required',
            ]);
        }else{
            $validator = Validator::make($data, [
                'fname' =>  $required.',fname,'.$data['id'].','.$this->primaryKey,
                'lname' => 'required',
                'phone' => 'required',
                'address' => 'required',
                'price' => 'required',
                'observations' => 'required',
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
        $next_id = DB::select("select nextval('seq_id_noticias')");
        return intval($next_id[0]->nextval);
    }
}
