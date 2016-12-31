<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * App\Contest
 *
 * @property integer $id
 * @property string $name
 * @property integer $user_id
 * @property string $deleted_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $description
 * @property \Carbon\Carbon $start_date
 * @property \Carbon\Carbon $end_date
 * @property boolean $is_active
 * @property boolean $is_standings_active
 * @property boolean $labs
 * @property string $type
 * @property boolean $show_max
 * @property boolean $is_acm
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\ProgrammingLanguage[] $programming_languages
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Problem[] $problems
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $users
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Solution[] $solutions
 * @property-read \App\User $owner
 * @method static \Illuminate\Database\Query\Builder|\App\Contest whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Contest whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Contest whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Contest whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Contest whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Contest whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Contest whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Contest whereStartDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Contest whereEndDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Contest whereIsActive($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Contest whereIsStandingsActive($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Contest whereLabs($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Contest whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Contest whereShowMax($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Contest whereIsAcm($value)
 * @mixin \Eloquent
 */
class Contest extends Model
{
    use Sortable;
    use SoftDeletes;

    protected static $sortable_columns = [
        'id', 'name', 'start_date', 'end_date', 'created_at', 'owner',
    ];

    const TYPE_TOURNAMENT = 'tournament';
    const TYPE_EXAM = 'exam';

    protected $fillable = [
        'name', 'description', 'user_id', 'start_date', 'end_date', 'is_active', 'is_standings_active', 'labs', 'is_acm',
    ];

    protected $dates = [
        'start_date',
        'end_date',
        'created_at',
    ];

    public static function getValidationRules($is_exam)
    {
        $arr = [
            'name' => 'required|max:255',
            'description' => 'required|max:3000',
            'start_date' => 'required|date_format:Y-m-d H:i:s',
            'end_date' => 'required|date_format:Y-m-d H:i:s|after:start_date',
            'participants' => 'required',
            'programming_languages.*' => 'exists:programming_languages,id',
            'problems.*' => 'exists:problems,id',
            'problem_points.*' => 'required|integer|between:1,100',
        ];
        return $arr + ($is_exam ? [] : ['problems' => 'required']);
    }

    public function programming_languages()
    {
        return $this->belongsToMany(ProgrammingLanguage::class, 'contest_programming_language', 'contest_id', 'programming_language_id');
    }

    public function problemUsers()
    {
        return $this->hasMany(ContestProblemUser::class);
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

    public function discipline()
    {
        return $this->belongsTo(Discipline::class);
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

    public function isEnded() {

        if(Carbon::now()->gt($this->end_date)) {
            return true;
        }
        return false;
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


    public function getProblemReviewRequired($problem_id)
    {
        $select = DB::table('contest_problem')
            ->select('review_required')
            ->where('problem_id', '=', $problem_id)
            ->where('contest_id', '=', $this->id)
            ->first();
        if ($select) {
            return $select->review_required;
        }
        return null;
    }

    public function getProblemData()
    {
        $problems = [];
        if ($this->type == static::TYPE_EXAM) {
            if (Auth::user()->hasRole(User::ROLE_TEACHER)) {
                $all_problems = $this->problemUsers()->groupBy('problem_id')->get();
            } else {
                $all_problems = $this->problemUsers()->where('user_id', Auth::user()->id)->get();
            }
            foreach ($all_problems as $cpu) {
                $problems[$cpu->problem->id]['name'] = $cpu->problem->name;
                $problems[$cpu->problem->id]['link'] = route('frontend::contests::problem', ['contest_id' => $this->id, 'problem_id' => $cpu->problem->id]);
                $problems[$cpu->problem->id]['difficulty'] = $cpu->problem->difficulty;
                $solution = null; //@todo
            }
        } else {
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
        }
        return $problems;
    }

    public function getUserTotalResult(User $user)
    {
        $total = 0;

        $solutions = $this->solutions()
            ->where('user_id', $user->id)
            ->get();

        $solutions = $solutions->groupBy('problem_id');

        foreach ($solutions as $problem_id => $grouped_solutions) {
            if ($grouped_solutions) {
                if ($this->show_max) {
                    $solution = $grouped_solutions->where('reviewed', 1)->sortByDesc('success_percentage')->first();
                } else {
                    $solution = $grouped_solutions->where('reviewed', 1)->sortByDesc('created_at')->first();
                }

                if ($solution) {

                    $total += $solution->success_percentage * $this->getProblemMaxPoints($problem_id) / 100;
                }
            }
        }
        return $total;
    }

    public function getStandingsSolution(User $user, Problem $problem)
    {
        $solution = null;

        $query = $this->solutions()
            ->where('user_id', $user->id)
            ->where('problem_id', $problem->id);

        if ($this->show_max) {
            $solution = $query->orderBy('success_percentage', 'desc')->first();
        } else {
            $solution = $query->orderBy('created_at', 'desc')->first();
        }

        return $solution;
    }

    public function getAVGScore()
    {
        return $this
            ->solutions()
            ->select(\DB::raw('AVG(success_percentage / 100 * contest_problem.max_points) as avg_score'))
            ->join('contest_problem', 'solutions.problem_id', '=', 'contest_problem.problem_id')
            ->first()->avg_score;
    }

    public function getUsersWhoTryToSolve()
    {
        return $this
            ->solutions()
            ->select(DB::raw('count(*) as item'))
            ->groupBy('user_id', 'problem_id')
            ->get()
            ->count();
    }

    public function getUsersWhoSolved()
    {
        return $this
            ->solutions()
            ->select(DB::raw('count(*) as item'))
            ->where('status', Solution::STATUS_OK)
            ->groupBy('user_id', 'problem_id')
            ->get()
            ->count();
    }
}
