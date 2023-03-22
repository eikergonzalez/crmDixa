<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tipo_archivo extends Model
{
    use HasFactory;
    protected $table = 'tipo_archivo';
    public $timestamps = true;
    protected $primaryKey = "id";

    public function getDocumentos($inmuebleId){
        $query =  $this->join('relacion_inmueble_archivos', 'relacion_inmueble_archivos.tipo_archivo','=','tipo_archivo.id')
        ->where('relacion_inmueble_archivos.inmueble_id', $inmuebleId)
        ->where('tipo_archivo.id', $this->id)
        ->where('relacion_inmueble_archivos.tipo', 'archivo')
        ->first();

        if(!$query) return new relacion_inmueble_archivos();

        return $query;
    }
}
