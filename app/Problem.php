<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;

/**
 * Class Problem
 * @package App
 */
class Problem extends Model
{
    use SoftDeletes;

    public $fillable = [
        'name', 'description', 'difficulty', 'archive'
    ];

    /**
     * The columns that grid can be sorted.
     *
     * @var bool
     *
     * @return string|array
     */
    public static function sortable($list = false)
    {
        $columns = [
            'id', 'name', 'created_at', 'updated_at', 'deleted_at', 'difficulty',
        ];

        return ($list ? implode(',', $columns) : $columns);
    }

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
            if ($this->archive) {
                File::delete(storage_path('app/problems/' . $this->id) . $this->archive);
            }
            $this->archive = Input::file($name)->getClientOriginalName();
            Input::file($name)->move(storage_path('app/problems/' . $this->id), $this->archive);
        }
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
        return $query->orderBy('success_percentage', 'desc')
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

    public function getContestUserDisplaySolution(Contest $contest, $user_id) {

        $solution = $this->getContestSolutionQuery($contest->id)->where('user_id', $user_id);
        if ($contest->show_max) {
            $solution = $this->getMaxPointsSolution($solution);
        } else {
            $solution = $this->getLatestSolution($solution);
        }

        return $solution;
    }
    
    public function getPointsString(Contest $contest) {
        $display_solution = $this->getContestDisplaySolution($contest);
        if($display_solution) {
            $points_string = $display_solution->success_percentage / 100 * $contest->getProblemMaxPoints($this->id);
        } else {
            $points_string = '-';
        }
        $points_string .= ' / ' . $contest->getProblemMaxPoints($this->id);
        return $points_string;
    }
}
