<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{

    const ROLE_ADMIN    = 'low_user';
    const ROLE_LOW_USER = 'user';
    const ROLE_USER     = 'teacher';
    const ROLE_TEACHER  = 'editor';
    const ROLE_EDITOR   = 'admin';
    const ROLE_HR       = 'hr';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
