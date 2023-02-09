<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tipo_inmueble extends Model
{
    use HasFactory;
    protected $table = 'tipo_inmueble';
    public $timestamps = true;
    protected $primaryKey = "id";
}
