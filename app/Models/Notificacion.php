<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Notificacion extends Model{
    use HasFactory;

    //protected $connection = 'mysql';
    protected $table = "notificaciones";
    public $timestamps = true;
    protected $primaryKey = "id";

}
