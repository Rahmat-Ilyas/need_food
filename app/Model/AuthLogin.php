<?php

namespace App\Model;

use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class AuthLogin extends Authenticatable
{
	use HasApiTokens, Notifiable;

    protected $table = 'tb_auth';
    protected $guard = 'admin';

    protected $fillable = [
        'nama', 'role', 'username', 'password',
    ];

    protected $hidden = [
        'id', 'remember_token',
    ];
}
