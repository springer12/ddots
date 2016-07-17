<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Contest extends Model
{

    const TYPE_TOURNAMENT = 'tournament';

    protected $fillable = [
        'name', 'description', 'user_id', 'start_date', 'end_date', 'is_active', 'is_standings_active', 'show_max', 'labs',
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
            'problems.*' => 'exists:problems,id',
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

    public function owner() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function setIsActiveAttribute($value) {
        if($value === null) {
            $this->attributes['is_active'] = false;
        } else {
            $this->attributes['is_active'] = true;
        }
    }

    public function setShowMaxAttribute($value) {
        if($value === null) {
            $this->attributes['show_max'] = false;
        } else {
            $this->attributes['show_max'] = true;
        }
    }

    public function setIsStandingsActiveAttribute($value) {
        if($value === null) {
            $this->attributes['is_standings_active'] = false;
        } else {
            $this->attributes['is_standings_active'] = true;
        }
    }

    public function setLabsAttribute($value) {
        if($value === null) {
            $this->attributes['labs'] = false;
        } else {
            $this->attributes['labs'] = true;
        }
    }
    
    public function hide(){
        $this->attributes['is_active'] = false;
    }

    public function currentUserAllowedEdit(){
        if(Auth::check() && Auth::user()->id == $this->owner->id) {
            return true;
        }
        return false;
    }
}
