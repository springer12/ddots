<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

use Carbon\Carbon;

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
        'name', 'nickname', 'email', 'password', 'role'
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

    public function hasRole($roles) {
        if(is_array($roles)) {
            return array_search($this->role, $roles) !== false;
        } else {
            return $this->role == $roles;
        }

    }

    public function touchLastLogin() {
        $this->last_login = $this->freshTimestamp();
        $this->save();
    }

    public function upgrade() {
        if($this->hasRole(User::ROLE_LOW_USER)) {
            $this->role = User::ROLE_USER;
            $this->save();
        }
    }
    public function programmingLanguage() {
        return $this->BelongsTo(ProgrammingLanguage::class, 'programming_language');
    }

    public function getAge() {
        return Carbon::parse($this->date_of_birth)->diff(Carbon::now())->format('%y');
    }

    public function getDateOfBirth() {
        return Carbon::parse($this->date_of_birth)->format('d-m-Y');
    }

    public function getRegistrationDate() {
        return Carbon::parse($this->created_at)->format('d-m-y');
    }
}
