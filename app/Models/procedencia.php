<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class procedencia extends Model
{
    use HasFactory;
    protected $table = 'procedencia';
    public $timestamps = true;
    protected $primaryKey = "id";
}
