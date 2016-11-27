<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;

/**
 * App\Solution
 *
 * @property integer $id
 * @property string $state
 * @property string $status
 * @property string $testing_mode
 * @property string $message
 * @property integer $problem_id
 * @property integer $programming_language_id
 * @property integer $user_id
 * @property integer $testing_server_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property boolean $success_percentage
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\SolutionReport[] $reports
 * @property-read \App\Problem $problem
 * @property-read \App\User $owner
 * @property-read \App\ProgrammingLanguage $programming_language
 * @method static \Illuminate\Database\Query\Builder|\App\Solution whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Solution whereState($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Solution whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Solution whereTestingMode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Solution whereMessage($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Solution whereProblemId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Solution whereProgrammingLanguageId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Solution whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Solution whereTestingServerId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Solution whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Solution whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Solution whereSuccessPercentage($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Solution oldestNew()
 * @mixin \Eloquent
 */
class Solution extends Model
{

    public function fillData()
    {
        $this->points = $this->getPoints();
        $this->getPoints();
        foreach ($this->reports as $report) {
            if ($report->execution_time > $this->max_time) {
                $this->max_time = $report->execution_time;
            }
            if ($report->memory_peak > $this->max_memory) {
                $this->max_memory = $report->memory_peak;
            }
            if ($report->status == SolutionReport::STATUS_OK) { //@todo set correct status for success
                $this->successful_reports++;
            }
        }
    }


    public $max_time = 0, $max_memory = 0, $successful_reports = 0, $points = 0;

    const STATE_NEW = 'new';
    const STATE_RECEIVED = 'received';
    const STATE_REJECTED = 'rejected';
    const STATE_RESERVED = 'reserved';
    const STATE_TESTED = 'tested';

    const STATUS_OK = 'OK';
    const STATUS_CE = 'CE';
    const STATUS_FF = 'FF';
    const STATUS_NC = 'NC';
    const STATUS_CC = 'CC';
    const STATUS_CT = 'CT';
    const STATUS_UE = 'UE';

    const STATUS_ZR = 'ZR'; //annuled solution

    protected $fillable = ['state'];

    public function reports()
    {
        return $this->hasMany('App\SolutionReport');
    }

    public function problem()
    {
        return $this->belongsTo(Problem::class, 'problem_id');
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function programming_language()
    {
        return $this->belongsTo(ProgrammingLanguage::class, 'programming_language_id');
    }

    public static function getValidationRules($contest_id)
    {
        return [
            'programming_language' => 'required|exists:contest_programming_language,programming_language_id,contest_id,' . $contest_id,
            'solution_code' => 'required_without:solution_code_file',
            'solution_code_file' => 'required_without:solution_code|mimetypes:text/plain',
        ];
    }

    /*
     * разбиваем дату создания на год, месяц, день
     *
     * и сохраняем по такому пути solutions_source_code/год/месяц/день/id
     * @todo: make path creation more beautiful
     */
    public function sourceCodePath()
    {
        $dir = 'solutions_source_code/' .
            $this->created_at->year . '/' .
            $this->created_at->month . '/' .
            $this->created_at->day . '/';
        $dir = storage_path($dir);

        if (!File::exists($dir)) {
            File::makeDirectory($dir, 0755, true);
        }
        return $dir;
    }

    public function sourceCodeFilePath()
    {
        return $this->sourceCodePath() . $this->id;
    }

    /**
     * Scope a query to only include oldest new solution.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOldestNew($query)
    {
        return $query->where('state', self::STATE_NEW)
            ->orderBy('created_at', 'asc')
            ->firstOrFail();
    }

    public static function getStates()
    {
        return [
            self::STATE_NEW,
            self::STATE_RECEIVED,
            self::STATE_REJECTED,
            self::STATE_RESERVED,
            self::STATE_TESTED,
        ];
    }

    public function getContest()
    {
        return Contest::join('contest_solution', 'id', '=', 'contest_id')->where('solution_id', $this->attributes['id'])->first();
    }

    public function getPoints()
    {
        $select = DB::table('contest_problem')
            ->join('contest_solution', 'contest_problem.contest_id', '=', 'contest_solution.contest_id')
            ->join('solutions', function ($join) {
                $join->on('solutions.problem_id', '=', 'contest_problem.problem_id')
                    ->on('contest_solution.solution_id', '=', 'solutions.id');
            })
            ->where('solution_id', $this->attributes['id'])
            ->select('max_points')->first();
        if ($select) {
            return $this->attributes['success_percentage'] / 100 * $select->max_points;
        }
        return null;
    }

    public static function getStatuses()
    {
        return [
            self::STATUS_OK => 'All cool',
            self::STATUS_CE => 'Compilation error',
            self::STATUS_FF => 'Final fantasy',
            self::STATUS_NC => 'Not cool',
            self::STATUS_CC => 'Not cool',
            self::STATUS_CT => 'Not cool',
            self::STATUS_UE => 'Not cool',
            self::STATUS_ZR => 'Annulled',
        ];
    }

    public function saveCodeFile($file)
    {
        if (Input::file($file)->isValid()) {
            Input::file($file)->move($this->sourceCodePath(), $this->id);
        }
    }

    public function getCode()
    {
        try {
            return File::get($this->sourceCodeFilePath());
        } catch (\Exception $e) {
            return "";
        }
    }

    public function annul()
    {
        $this->status = static::STATUS_ZR;
        $this->success_percentage = 0;
    }

    public function approve()
    {
        $this->reviewed = true;
    }

    public function decline()
    {
        $this->reviewed = false;
    }
}
