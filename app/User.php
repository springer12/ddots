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
    use Sortable;

    protected static $sortable_columns = [
        'id', 'name', 'email', 'role', 'nickname', 'date_of_birth', 'place_of_study', 'programming_language', 'vk_link', 'fb_link', 'created_at', 'updated_at', 'deleted_at'
    ];

    const ROLE_ADMIN = 'admin';
    const ROLE_LOW_USER = 'low_user';
    const ROLE_USER = 'user';
    const ROLE_TEACHER = 'teacher';
    const ROLE_EDITOR = 'editor';
    const ROLE_HR = 'hr';

    const ATTEMPTS_PER_MONTH = 3;
    const RESULTS_PER_PAGE = 10;

    const SETTABLE_ROLES = [self::ROLE_LOW_USER => 'Low user', self::ROLE_USER => 'User', self::ROLE_TEACHER => 'Teacher', self::ROLE_EDITOR => 'Editor', self::ROLE_HR => 'HR'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'nickname', 'email', 'password', 'role', 'date_of_birth', 'profession', 'programming_language', 'place_of_study', 'vk_link', 'fb_link', 'description',
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

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($user) {
            $user->ownedContests()->delete();
        });

        static::restoring(function ($user) {
            $user->ownedContests()->withTrashed()->restore();
        });
    }

    public function ownedContests()
    {
        return $this->hasMany(Contest::class, 'user_id');
    }

    public function contests()
    {
        return $this->belongsToMany(Contest::class, 'contest_user', 'user_id', 'contest_id');
    }

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
            return Carbon::parse($dob)->format('Y-m-d');
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
        $rules = [
            'name' => 'required|max:255|any_lang_name',
            'avatar' => 'mimetypes:image/jpeg,image/bmp,image/png|max:1000',
            'role' => 'in:' . implode(',', array_keys(self::SETTABLE_ROLES)),
            'date_of_birth' => 'date|after:1920-01-01|before:' . Carbon::now()->sub(new \DateInterval('P4Y')),
            'profession' => 'max:255|alpha_dash_spaces',
            'place_of_study' => 'max:255|alpha_dash_spaces',
            'vk_link' => 'url_domain:vk.com,new.vk.com,www.vk.com,www.new.vk.com',
            'fb_link' => 'url_domain:facebook.com,www.facebook.com',
            'subdomain' => 'exists:subdomains,id',
            'description' => 'string|max:255',
        ];
        return $rules;
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

    public function subdomains()
    {
        return $this->belongsToMany(Subdomain::class, 'subdomain_user', 'user_id', 'subdomain_id');
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

    public function scopeAdmin($query)
    {
        return $query->where('role', self::ROLE_ADMIN);
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
        return Subdomain::currentSubdomain()
            ->users()->teacher()
            ->whereNotIn('id', function ($query) {
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

    public function setProgrammingLanguageAttribute($value)
    {
        $this->attributes['programming_language'] = !trim($value) ? null : trim($value);
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class, 'group_user', 'user_id')->withTimestamps();
    }

    public static function search($term, $page, $searchTeachers, $teacher_id = null)
    {
        if ($searchTeachers) {
            $users = User::teacher();
        } else {
            $users = User::user();
        }
        $users = $users->select(['id', 'name'])
            ->where('name', 'LIKE', '%' . $term . '%');

        if ($teacher_id) {
            $users = $users->join('teacher_student', 'student_id', '=', 'users.id')
                ->where('teacher_id', $teacher_id);
        }

        $count = $users->count();
        $users = $users->skip(($page - 1) * self::RESULTS_PER_PAGE)
            ->take(self::RESULTS_PER_PAGE)
            ->get();
        return ['results' => $users, 'total_count' => $count];
    }

    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'messages', 'sender_id');
    }

    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'messages', 'receiver_id');
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'owner_id');
    }

    public function getDialogUsers()
    {
        return User::select('users.*')->join('messages', 'users.id', '= ', DB::raw('CASE
	                      WHEN messages.sender_id = ' . $this->id . ' THEN messages.receiver_id
	                      ELSE messages.sender_id
                      END'))->where('owner_id', $this->id)->orderBy('messages.created_at', 'desc')->distinct()->get();
    }

    public function getNoDialogStudents()
    {
        return $this->students()->whereNotIn('users.id', function ($query) {
            return $query->select('users.id')->from('users')->join('messages', 'users.id', '= ', DB::raw('CASE
	                      WHEN messages.sender_id = ' . $this->id . ' THEN messages.receiver_id
	                      ELSE messages.sender_id
                      END'))->distinct();
        })->get();
    }

    public function getNoDialogTeachers()
    {
        return $this->teachers()->whereNotIn('users.id', function ($query) {
            return $query->select('users.id')->from('users')->join('messages', 'users.id', '= ', DB::raw('CASE
	                      WHEN messages.sender_id = ' . $this->id . ' THEN messages.receiver_id
	                      ELSE messages.sender_id
                      END'))->distinct();
        })->get();
    }

    public function getLastMessageWith($id)
    {
        return $this->getLatestMessagesWithQuery($id)->first();
    }

    public function getMessagesWith($id)
    {
        return $this->getLatestMessagesWithQuery($id)->get();
    }

    public function getLatestMessagesWithQuery($id)
    {
        return $this->messages()->where(function ($query) use ($id) {
            return $query->where('sender_id', $id)->orWhere('receiver_id', $id);
        })->latest();
    }

    public function getMessagesWithQuery($id)
    {
        return $this->messages()->where(function ($query) use ($id) {
            return $query->where('sender_id', $id)->orWhere('receiver_id', $id);
        });
    }


    public function canWriteTo($id)
    {
        if ($this->hasRole(self::ROLE_ADMIN)) {
            return true;
        } elseif ($this->hasRole(self::ROLE_TEACHER) && ($this->isTeacherOf($id) || User::find($id)->hasRole(self::ROLE_ADMIN))) {
            return true;
        } elseif ($this->hasRole(self::ROLE_USER) && User::find($id)->isTeacherOf($this->id)) {
            return true;
        } else {
            return false;
        }
    }
}
