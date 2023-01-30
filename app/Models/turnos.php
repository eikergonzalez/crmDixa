<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class turnos extends Model{
    use HasFactory;
    protected $table = 'turnos';
    public $timestamps = true;
    protected $primaryKey = "tur_id";
}
