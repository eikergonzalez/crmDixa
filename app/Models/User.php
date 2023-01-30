<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;


class User extends Authenticatable implements JWTSubject{
    use HasFactory, Notifiable;

    protected $connection = 'mysql';
    protected $table = "users";
    public $timestamps = true;
    protected $primaryKey = "id";


    public function getJWTIdentifier(){
        return $this->getKey();
    }

    public function getJWTCustomClaims(){
        return [

        ];
    }

    public function validateCredentials(array $credentials){
        $plain = $credentials['usu_password'];
        return $this->hasher->check($plain, $this->getAuthPassword());
    }

}
