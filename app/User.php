<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use SoftDeletes;
    const ROLE_ADMIN = 'admin';
    const ROLE_LOW_USER = 'low_user';
    const ROLE_USER = 'user';
    const ROLE_TEACHER = 'teacher';
    const ROLE_EDITOR = 'editor';
    const ROLE_HR = 'hr';

    const ATTEMPTS_PER_MONTH = 3;

    const SETTABLE_ROLES = [self::ROLE_LOW_USER => 'Low user', self::ROLE_USER => 'User', self::ROLE_TEACHER => 'Teacher', self::ROLE_EDITOR => 'Editor', self::ROLE_HR => 'HR'];
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

    protected $dates = [
        'created_at'
    ];

    /**
     * Mutator to hash password
     *
     * @param $value
     *
     * @return static
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);

        return $this;
    }

    public function hasRole($roles)
    {
        if (is_array($roles)) {
            return array_search($this->role, $roles) !== false;
        } else {
            return $this->role == $roles;
        }

    }

    public function touchLastLogin()
    {
        $this->last_login = $this->freshTimestamp();
        $this->save();
    }

    public function upgrade()
    {
        if ($this->hasRole(User::ROLE_LOW_USER)) {
            $this->role = User::ROLE_USER;
        }
    }

    public function programmingLanguage()
    {
        return $this->BelongsTo(ProgrammingLanguage::class, 'programming_language');
    }

    public function getAge()
    {
        if ($this->date_of_birth != null) {
            return Carbon::parse($this->date_of_birth)->diff(Carbon::now())->format('%y');
        }
    }

    public function getDateOfBirthAttribute($dob)
    {
        if ($dob) {
            return Carbon::parse($dob)->format('d-m-Y');
        }
        return '';
    }

    public function setDateOfBirthAttribute($value)
    {
        $this->attributes['date_of_birth'] = !trim($value) ? null : Carbon::parse($value);
    }

    public function getRegistrationDate()
    {
        return Carbon::parse($this->created_at)->format('d-m-y');
    }


    public static function getValidationRules()
    {
        return [
            'name' => 'required|max:255|any_lang_name',
            'avatar' => 'mimetypes:image/jpeg,image/bmp,image/png|max:1000',
            'role' => 'in:' . implode(',', array_keys(self::SETTABLE_ROLES)),
            'date_of_birth' => 'date',
            'profession' => 'max:255|alpha_dash',
            'place_of_study' => 'max:255|alpha_dash',
            'programming_language' => 'exists:programming_languages,id',
            'vk_link' => 'url_domain:vk.com,new.vk.com,www.vk.com,www.new.vk.com',
            'fb_link' => 'url_domain:facebook.com,www.facebook.com'
        ];
    }

    public function setAvatar($name)
    {

        if (Input::file($name)->isValid()) {
            if ($this->avatar) {
                File::delete('userdata/avatars/' . $this->avatar);
            }
            $this->avatar = uniqid() . '.' . Input::file($name)->getClientOriginalExtension();
            Input::file($name)->move('userdata/avatars/', $this->avatar);
        }
    }

    public function getAvatarAttribute($avatar)
    {
        if ($avatar) {
            return url('userdata/avatars/' . $avatar);
        } else {
            return url('userdata/avatars/default.jpg');
        }
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'teacher_student', 'teacher_id', 'student_id')->withPivot('confirmed', 'created_at')->withTimestamps();
    }

    public function teachers()
    {
        return $this->belongsToMany(User::class, 'teacher_student', 'student_id', 'teacher_id')->withPivot('confirmed', 'created_at')->withTimestamps();
    }

    public function isTeacherOf($id)
    {
        $students = $this->students;
        foreach ($students as $student) {
            if ($student->id == $id) {
                return true;
            }
        }
        return false;
    }

    public function scopeTeacher($query)
    {
        return $query->where('role', self::ROLE_TEACHER);
    }

    public function scopeUser($query)
    {
        return $query->where('role', self::ROLE_USER);
    }

    public function allowedToRequestTeacher()
    {
        return $this->getRemainingRequests() > 0;
    }

    public function getRemainingRequests()
    {
        return self::ATTEMPTS_PER_MONTH - DB::table('teacher_student')
            ->where('student_id', $this->id)
            ->where('confirmed', 0)
            ->where('teacher_student.created_at', '>', Carbon::now()->subMonth())
            ->count();
    }

    public function getConfirmedTeachersQuery()
    {
        return $this->whereIn('id', function ($query) {
            $query->select('teacher_id')
                ->from('teacher_student')
                ->where('student_id', $this->id)
                ->where('confirmed', '=', true);
        })->teacher()->groupBy('id');
    }

    public function getUnrelatedOrUnconfirmedTeachersQuery()
    {
        return $this->teacher()->whereNotIn('id', function ($query) {
            $query->select('teacher_id')
                ->from('teacher_student')
                ->where('student_id', $this->id)
                ->where('confirmed', '=', true);
        })->groupBy('id');
    }

    public function markRelated($teachers)
    {
        foreach ($teachers as $teacher) {
            $teacher['relation_exists'] = $teacher->students()->get()->contains('id', $this->id);
        }
    }

    public static function sortable($list = false)
    {
        $columns = [
            'id', 'name', 'email', 'role', 'nickname', 'date_of_birth', 'place_of_study', 'programming_language', 'vk_link', 'fb_link', 'created_at', 'updated_at', 'deleted_at'
        ];

        return ($list ? implode(',', $columns) : $columns);
    }

    public function setProgrammingLanguageAttribute($value)
    {
        $this->attributes['programming_language'] = !trim($value) ?null: trim($value);
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class, 'group_user', 'user_id')->withTimestamps();
    }
}
