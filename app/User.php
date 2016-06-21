<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{

    const ROLE_ADMIN    = 'admin';
    const ROLE_LOW_USER = 'low_user';
    const ROLE_USER     = 'user';
    const ROLE_TEACHER  = 'teacher';
    const ROLE_EDITOR   = 'editor';
    const ROLE_HR       = 'hr';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Mutator to hash password
     *
     * @param $value
     *
     * @return static
     */
    public function setPasswordAttribute($value) {
        $this->attributes['password'] = bcrypt($value);

        return $this;
    }


    public function hasRole($role) {
        return $this->role == $role;
    }

    public function hasOneOfRoles(array $roles) {
        return array_search($this->role, $roles) !== false;
    }
}
