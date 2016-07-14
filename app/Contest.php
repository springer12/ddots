<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contest extends Model
{

    protected $fillable = [
        'name', 'description', 'user_id', 'start_date', 'end_date', 'is_active', 'is_standings_active',
    ];

    public static function sortable($list = false){
        $columns = [
            'id', 'name', 'start_date', 'end_date',
        ];

        return ($list ? implode(',', $columns) : $columns);
    }

    public static function getValidationRules(){
        return [
            'name' => 'required|alpha_dash',
            'description' => 'required|alpha_dash',
            'start_date' => 'required|date_format:Y-m-d H:i:s',
            'end_date' => 'required|date_format:Y-m-d H:i:s',
            'programming_languages.*' => 'exists:programming_languages,id',
            'users.*' => 'exists:users,id',
        ];
    }

    public function programming_languages(){
        return $this->belongsToMany(ProgrammingLanguage::class, 'contest_programming_language', 'contest_id', 'programming_language_id');
    }

    public function problems(){
        return $this->belongsToMany(Problem::class, 'contests_problems', 'contest_id', 'problem_id');
    }

    public function users(){
        return $this->belongsToMany(User::class, 'contest_user', 'contest_id', 'user_id');
    }

    public function setIsActiveAttribute($value) {
        if($value === null) {
            $this->attributes['is_active'] = false;
        } else {
            $this->attributes['is_active'] = true;
        }
    }

    public function setIsStandingsActiveAttribute($value) {
        if($value === null) {
            $this->attributes['is_standings_active'] = false;
        } else {
            $this->attributes['is_standings_active'] = true;
        }
    }
}
