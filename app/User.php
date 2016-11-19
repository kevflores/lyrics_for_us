<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'usuarios';
    protected $fillable = ['nickname','nombre', 'apellido', 'email', 'password', 'url', 'imagen'];
    protected $hidden = ['password', 'remember_token'];

}
