<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;

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
        'name', 'nickname', 'email', 'password', 'role', 'date_of_birth', 'profession', 'programming_language', 'place_of_study', 'vk_link', 'fb_link',
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
        }
    }
    public function programmingLanguage() {
        return $this->BelongsTo(ProgrammingLanguage::class, 'programming_language');
    }

    public function getAge() {
        if($this->date_of_birth != null) {
            return Carbon::parse($this->date_of_birth)->diff(Carbon::now())->format('%y');
        } else {
            return null;
        }
    }

    public function getDateOfBirthAttribute($dob) {
        if($dob) {
            return Carbon::parse($dob)->format('d-m-Y');
        }
        return '';
    }

    public function setDateOfBirthAttribute($value) {
            $this->attributes['date_of_birth'] = !$value?:Carbon::parse($value);
    }

    public function getRegistrationDate() {
        return Carbon::parse($this->created_at)->format('d-m-y');
    }

    public function getValidationRules() {
        return [
            'name'     => 'required|max:255|any_lang_name',
            'avatar' => 'mimes:jpeg,png,bmp',
            'nickname' => 'required|max:255|english_alpha_dash|unique:users,nickname,' . $this->id,
            'date_of_birth' => 'date',
            'profession' => 'max:255|alpha_dash',
            'place_of_study' => 'max:255|alpha_dash',
            'programming_language' => 'exists:programming_languages,id',
            'vk_link' => 'url_domain:vk.com,new.vk.com,www.vk.com,www.new.vk.com',
            'fb_link' => 'url_domain:facebook.com,www.facebook.com'
        ];
    }
    
    public function setAvatar($name){
        if(Input::file($name)->isValid()) {
            if($this->avatar) {
                File::delete('userdata/avatars/' . $this->avatar);
            }
            $this->avatar = uniqid() . '.' . Input::file($name)->getClientOriginalExtension();
            Input::file($name)->move('userdata/avatars/', $this->avatar);
        }
    }

    public function getAvatarAttribute($avatar) {
        if($avatar) {
            return url('userdata/avatars/' . $avatar);
        } else {
            return url('userdata/avatars/default.jpg');
        }
    }

    public function students() {
        return $this->belongsToMany(User::class, 'teacher_student_relation', 'teacher_id', 'student_id');
    }

    public function teachers() {
        return $this->belongsToMany(User::class, 'teacher_student_relation', 'student_id', 'teacher_id');
    }

    public function isTeacherOf($id) {
        $students = $this->students;
        foreach($students as $student) {
            if($student->id == $id) {
                return true;
            }
        }
        return false;
    }
}
