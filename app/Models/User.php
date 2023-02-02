<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable{
    use HasFactory, Notifiable;

    protected $table = "users";
    public $timestamps = true;
    protected $primaryKey = "id";
	public $incrementing = true;

    public function validateCredentials(array $credentials){
        $plain = $credentials['password'];
        return $this->hasher->check($plain, $this->getAuthPassword());
    }

}
