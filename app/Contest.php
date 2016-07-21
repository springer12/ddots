<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Contest extends Model
{

    const TYPE_TOURNAMENT = 'tournament';

    protected $fillable = [
        'name', 'description', 'user_id', 'start_date', 'end_date', 'is_active', 'is_standings_active', 'show_max', 'labs',
    ];

    public static function sortable($list = false)
    {
        $columns = [
            'id', 'name', 'start_date', 'end_date', 'created_at',
        ];

        return ($list ? implode(',', $columns) : $columns);
    }

    public static function getValidationRules()
    {
        return [
            'name' => 'required|alpha_dash',
            'description' => 'required|alpha_dash',
            'start_date' => 'required|date_format:Y-m-d H:i:s',
            'end_date' => 'required|date_format:Y-m-d H:i:s',
            'programming_languages' => 'required',
            'programming_languages.*' => 'exists:programming_languages,id',
            'problems.*' => 'exists:problems,id',
            'problem_points.*' => 'required|integer|between:1,100',
        ];
    }

    public function programming_languages()
    {
        return $this->belongsToMany(ProgrammingLanguage::class, 'contest_programming_language', 'contest_id', 'programming_language_id');
    }

    public function problems()
    {
        return $this->belongsToMany(Problem::class, 'contest_problem', 'contest_id', 'problem_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'contest_user', 'contest_id', 'user_id');
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function setIsActiveAttribute($value)
    {
        if ($value === null) {
            $this->attributes['is_active'] = false;
        } else {
            $this->attributes['is_active'] = true;
        }
    }

    public function setShowMaxAttribute($value)
    {
        if ($value === null) {
            $this->attributes['show_max'] = false;
        } else {
            $this->attributes['show_max'] = true;
        }
    }

    public function setIsStandingsActiveAttribute($value)
    {
        if ($value === null) {
            $this->attributes['is_standings_active'] = false;
        } else {
            $this->attributes['is_standings_active'] = true;
        }
    }

    public function setLabsAttribute($value)
    {
        if ($value === null) {
            $this->attributes['labs'] = false;
        } else {
            $this->attributes['labs'] = true;
        }
    }

    public function hide()
    {
        $this->attributes['is_active'] = false;
    }

    public function currentUserAllowedEdit()
    {
        if (Auth::check() && Auth::user()->id == $this->owner->id) {
            return true;
        }
        return false;
    }

    public function getProblemMaxPoints($problem_id)
    {
        return DB::table('contest_problem')
            ->select('max_points')
            ->where('problem_id', '=', $problem_id)
            ->where('contest_id', '=', $this->id)
            ->first()->max_points;
    }

    public function getUserData()
    {
        $users = [];
        foreach ($this->users as $user) {
            $users[$user->id]['points'] = 0;
            $users[$user->id]['name'] = $user->name;
            foreach ($this->problems as $problem) {
                $solution = $problem->getContestUserDisplaySolution($this, $user->id);
                if ($solution) {
                    $users[$user->id]['problems'][$problem->id]['solution_id'] = $solution->id;
                    $users[$user->id]['problems'][$problem->id]['points'] = $solution->success_percentage / 100 * $this->getProblemMaxPoints($problem->id);
                    $users[$user->id]['points'] += $users[$user->id]['problems'][$problem->id]['points'];
                } else {
                    $users[$user->id]['problems'][$problem->id]['points'] = 0;
                }
            }
        }
        uasort($users, function ($a, $b) {
            if ($a['points'] > $b['points']) {
                return -1;
            } elseif ($a['points'] == $b['points']) {
                return 0;
            } else {
                return 1;
            }
        });
        return $users;
    }

    public function getProblemData(){
        $problems = [];
        foreach($this->problems as $problem) {
            $problems[$problem->id]['name'] = $problem->name;
            $problems[$problem->id]['link'] = route('frontend::contests::problem', ['contest_id' => $this->id, 'problem_id' => $problem->id]);
            $solution = $problem->getContestDisplaySolution($this);
            $problems[$problem->id]['difficulty'] = $problem->difficulty;
            if($solution) {
                if (Auth::user()->hasRole(User::ROLE_TEACHER) || Auth::user()->id == $solution->user_id) {
                    $problems[$problem->id]['solution_link'] = route('frontend::contests::solution', ['id' => $solution->id]);
                }
                $problems[$problem->id]['points'] = $solution->success_percentage / 100 * $this->getProblemMaxPoints($problem->id);
            }
        }
        return $problems;
    }
}
