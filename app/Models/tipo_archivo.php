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
}
