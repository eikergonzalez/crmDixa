<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Logs extends Model{

    //protected $connection = 'mysql';
    protected $table = 'logs';
    public $timestamps = true;
    protected $primaryKey = "id";
    protected $fillable = ["user","controller","action","parameters"];

}
