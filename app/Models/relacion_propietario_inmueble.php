<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class relacion_propietario_inmueble extends Model
{
    use HasFactory;
    protected $table = 'relacion_propietario_inmueble';
    public $timestamps = true;
    protected $primaryKey = "id";
}
