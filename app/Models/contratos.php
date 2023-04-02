<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class contratos extends Authenticatable{
    use HasFactory, Notifiable;

    protected $table = "contratos";
    public $timestamps = true;
    protected $primaryKey = "uuid";
    public $incrementing = true;

}
