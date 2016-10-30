<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

/**
 * Class Problem
 * @package App
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
            if ($this->attributes['archive']) {
                File::delete($this->getFilePath() . $this->attributes['archive']);
            }
            $this->attributes['archive'] = Input::file($name)->getClientOriginalName();
            Input::file($name)->move($this->getFilePath(), $this->attributes['archive']);
        }
    }

    public function getArchiveAttribute($value)
    {
        return File::get($this->getFilePath() . $value);
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
