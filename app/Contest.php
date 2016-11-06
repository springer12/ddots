<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Contest extends Model
{
    use Sortable;
    use SoftDeletes;

    protected static $sortable_columns = [
        'id', 'name', 'start_date', 'end_date', 'created_at', 'owner',
    ];

    const TYPE_TOURNAMENT = 'tournament';

    protected $fillable = [
        'name', 'description', 'user_id', 'start_date', 'end_date', 'is_active', 'is_standings_active', 'show_max', 'labs',
    ];

    protected $dates = [
        'start_date',
        'end_date',
        'created_at',
    ];

    public $standings_score = [];

    public static function getValidationRules()
    {
        return [
            'name' => 'required|max:255',
            'description' => 'required|max:3000',
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

    public function solutions()
    {
        return $this->belongsToMany(Solution::class, 'contest_solution', 'contest_id', 'solution_id');
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

    public function show()
    {
        $this->attributes['is_active'] = true;
    }

    public function currentUserAllowedEdit()
    {
        return Auth::user()->id == $this->owner->id;
    }

    public function getProblemMaxPoints($problem_id)
    {
        $select = DB::table('contest_problem')
            ->select('max_points')
            ->where('problem_id', '=', $problem_id)
            ->where('contest_id', '=', $this->id)
            ->first();
        if ($select) {
            return $select->max_points;
        }
        return null;
    }

    public function getProblemData()
    {
        $problems = [];
        foreach ($this->problems as $problem) {
            $problems[$problem->id]['name'] = $problem->name;
            $problems[$problem->id]['link'] = route('frontend::contests::problem', ['contest_id' => $this->id, 'problem_id' => $problem->id]);
            $solution = $problem->getContestDisplaySolution($this);
            $problems[$problem->id]['difficulty'] = $problem->difficulty;
            if ($solution) {
                if (Auth::user()->hasRole(User::ROLE_TEACHER) || Auth::user()->id == $solution->user_id) {
                    $problems[$problem->id]['solution_link'] = route('frontend::contests::solution', ['id' => $solution->id]);
                }
                $problems[$problem->id]['points'] = $solution->success_percentage / 100 * $this->getProblemMaxPoints($problem->id);
            }
        }
        return $problems;
    }

    protected function fillScore() {
        if(empty($this->standings_score)) {
            $this->standings_score = $this->solutions()
                ->join('contest_problem', 'solutions.problem_id', '=', 'contest_problem.problem_id')
                ->select(\DB::raw('SUM(success_percentage / 100 * contest_problem.max_points) as total, user_id'))
                ->groupBy('user_id')
                ->get();


            $this->standings_score = $this->standings_score->sortByDesc('total');
            $this->standings_score = $this->standings_score->groupBy('total');

            $i = 1;
            $maped_score = [];
            foreach ($this->standings_score as $grouped_score) {
                $users_count = $grouped_score->reduce(function ($carry) {
                    return $carry + 1;
                });
                foreach ($grouped_score as $score) {
                    if($users_count > 1) {
                        $maped_score[$score->user_id] = $i . '-' . ($i + $grouped_score->count() - 1);
                    } else {
                        $maped_score[$score->user_id] = $i;
                    }
                }

                if($grouped_score->count() > 1) {
                    $i = $i + $grouped_score->count();
                } else {
                    $i++;
                }

            }
            $this->standings_score = $maped_score;

            $last_position = $i - 1;
            foreach ($this->users as $user) {
                if(!isset($this->standings_score[$user->id])) {
                    $last_position++;
                }
            }
            foreach ($this->users as $user) {
                if(!isset($this->standings_score[$user->id])) {
                    if($last_position != $i) {
                        $this->standings_score[$user->id] = $i . '-' . $last_position;
                    } else {
                        $this->standings_score[$user->id] = $i;
                    }
                }
            }
        }
    }

    public function getUserPosition(User $user) {

        $this->fillScore();

        return $this->standings_score[$user->id];
    }

    public function getStandingsSolution(User $user, Problem $problem) {
        $solution = null;

        $query = $this->solutions()
            ->where('user_id', $user->id)
            ->where('problem_id', $problem->id);

        if($this->show_max) {
            $solution = $query->orderBy('success_percentage', 'desc')->first();
        } else {
            $solution = $query->orderBy('created_at', 'desc')->first();
        }

        return $solution;
    }

    public function getAVGScore() {
        return $this
            ->solutions()
            ->select(\DB::raw('SUM(success_percentage / 100 * contest_problem.max_points) as total'))
            ->join('contest_problem', 'solutions.problem_id', '=', 'contest_problem.problem_id')
            ->first()->total;
    }

    public function getUsersWhoTryToSolve() {
        return $this
            ->solutions()
            ->count();
    }

    public function getUsersWhoSolved() {
        return $this
            ->solutions()
            ->where('status', Solution::STATUS_OK)
            ->count();
    }
}
