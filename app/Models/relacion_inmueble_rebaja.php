<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class relacion_inmueble_rebaja extends Model
{
    use HasFactory;
    protected $table = 'relacion_inmueble_rebaja';
    public $timestamps = true;
    protected $primaryKey = "id";
}
