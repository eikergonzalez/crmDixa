<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class inmueble_files extends Model
{
    use HasFactory;
    protected $table = 'inmueble_files';
    public $timestamps = true;
    protected $primaryKey = "id";
}
