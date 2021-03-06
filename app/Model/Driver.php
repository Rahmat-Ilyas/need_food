<?php

namespace App\Model;

use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Driver extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $table = 'tb_driver';
    protected $guard = 'driver';
    protected $guarded = [];

    protected $hidden = [
    	'remember_token'
    ];
}
