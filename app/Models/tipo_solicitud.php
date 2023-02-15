<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tipo_solicitud extends Model
{
    use HasFactory;
    protected $table = 'tipo_solicitud';
    public $timestamps = true;
    protected $primaryKey = "id";
}
