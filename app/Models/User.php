<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Hash;

class User extends Authenticatable
{
	use Notifiable;
	protected $table = 'user';
	protected $hidden = [
        'password'
    ];
    public function setPasswordAttribute($password){ 
        return $this->attributes['password'] = Hash::make($password); 
    }
}
