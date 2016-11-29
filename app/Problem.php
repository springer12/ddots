<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

/**
 * Class Problem
 *
 * @package App
 * @property integer $id
 * @property string $name
 * @property string $deleted_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $archive
 * @property string $description
 * @property boolean $difficulty
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Volume[] $volumes
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Contest[] $contests
 * @method static \Illuminate\Database\Query\Builder|\App\Problem whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Problem whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Problem whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Problem whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Problem whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Problem whereArchive($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Problem whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Problem whereDifficulty($value)
 * @mixin \Eloquent
 */
class Problem extends Model
{
    use SoftDeletes;
    use Sortable;

    const RESULTS_PER_PAGE = 10;
    protected static $sortable_columns = [
        'id', 'name', 'created_at', 'updated_at', 'deleted_at', 'difficulty',
    ];

    public $fillable = [
        'name', 'description', 'difficulty', 'archive'
    ];

    public static function getValidationRules()
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:3000',
            'difficulty' => 'required|integer|between:0,5',
            'archive' => 'mimetypes:application/x-gzip',
            'volumes' => 'array'
        ];
    }

    public function getFilePath()
    {
        $dir = storage_path('app/problems/' . $this->id . '/');
        if (!File::exists($dir)) {
            File::makeDirectory($dir, 0755, true);
        }
        return $dir;
    }

    public static function getAlternateFilePath()
    {
        return base_path('var/test_db/');
    }

    public function volumes()
    {
        return $this->belongsToMany('App\Volume');
    }

    public function contests()
    {
        return $this->belongsToMany(Contest::class, 'contest_problem', 'problem_id', 'contest_id')->withTimestamps();
    }

    public function setArchive($name)
    {
        if (Input::file($name)->isValid()) {
            if (isset($this->attributes['archive'])) {
                File::delete($this->getFilePath() . $this->attributes['archive']);
            }
            $this->attributes['archive'] = Input::file($name)->getClientOriginalName();
            Input::file($name)->move($this->getFilePath(), $this->attributes['archive']);
            File::copy($this->getFilePath() . $this->attributes['archive'], static::getAlternateFilePath() . $this->id . '.tar.gz');
        }
    }

    public function getArchiveAttribute($value)
    {
        return File::get($this->getFilePath() . $value);
    }

    public function getArchivePath() {
        return $this->getFilePath() . $this->attributes['archive'];
    }

    public function getLink(Contest $contest) {
        return route('frontend::contests::problem', ['contest_id' => $contest->id, 'problem_id' => $this->id]);
    }

    public function getSolutions(Contest $contest) {
        return $contest->solutions()->where('problem_id', $this->id)->get();
    }

    public function getAVGScore(Contest $contest) {
        return $contest
            ->solutions()
            ->select(\DB::raw('SUM(success_percentage / 100 * contest_problem.max_points) as total'))
            ->join('contest_problem', 'solutions.problem_id', '=', 'contest_problem.problem_id')
            ->where('solutions.problem_id', $this->id)
            ->first()->total;
    }

    public function getUsersWhoTryToSolve(Contest $contest) {
        return $contest
            ->solutions()
            ->select(DB::raw('count(*) as item'))
            ->where('problem_id', $this->id)
            ->groupBy('user_id', 'problem_id')
            ->get()
            ->count();
    }

    public function getUsersWhoSolved(Contest $contest) {
        if($contest->show_max) {
            return $contest
                ->solutions()
                ->select(DB::raw('count(*) as item'))
                ->where('problem_id', $this->id)
                ->where('status', Solution::STATUS_OK)
                ->groupBy('user_id', 'problem_id')
                ->get()
                ->count();
        }

        return $contest
            ->solutions()
            ->select(DB::raw('count(*) as item'))
            ->where('problem_id', $this->id)
            ->groupBy('user_id', 'created_at')
            ->take(1)
            ->get()
            ->count();
    }


    private function getContestSolutionQuery($contest_id)
    {
        return DB::table('solutions')
            ->join('contest_solution', 'solution_id', '=', 'id')
            ->where('problem_id', '=', $this->attributes['id'])
            ->where('contest_id', '=', $contest_id);
    }

    private function getMaxPointsSolution($query)
    {
        return $query->orderBy('success_percentage', 'desc')
            ->first();
    }

    private function getLatestSolution($query)
    {
        return $query->orderBy('created_at', 'desc')
            ->first();
    }

    public function getContestDisplaySolution(Contest $contest)
    {
        $solution = $this->getContestSolutionQuery($contest->id);
        if ($contest->show_max) {
            $solution = $this->getMaxPointsSolution($solution);
        } else {
            $solution = $this->getLatestSolution($solution);
        }
        return $solution;
    }

    public function getContestUserDisplaySolution(Contest $contest, $user_id)
    {
        $solution = $this->getContestSolutionQuery($contest->id)->where('user_id', $user_id);
        if ($contest->show_max) {
            $solution = $this->getMaxPointsSolution($solution);
        } else {
            $solution = $this->getLatestSolution($solution);
        }

        return $solution;
    }

    public function getPointsString(Contest $contest)
    {
        $display_solution = $this->getContestDisplaySolution($contest);
        if ($display_solution) {
            $points_string = $display_solution->success_percentage / 100 * $contest->getProblemMaxPoints($this->id);
        } else {
            $points_string = '-';
        }
        $points_string .= ' / ' . $contest->getProblemMaxPoints($this->id);
        return $points_string;
    }

    public static function search($term, $page)
    {
        $problems = static::select(['id', 'name'])
            ->where('name', 'LIKE', '%' . $term . '%');

        $count = $problems->count();
        $problems = $problems->skip(($page - 1) * static::RESULTS_PER_PAGE)
            ->take(static::RESULTS_PER_PAGE)
            ->get();
        return ['results' => $problems, 'total_count' => $count];
    }
}
