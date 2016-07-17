<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Solution extends Model
{

    const STATE_NEW      = 'new';
    const STATE_RECEIVED = 'received';
    const STATE_REJECTED = 'rejected';
    const STATE_RESERVED = 'reserved';
    const STATE_TESTED   = 'tested';

    const STATUS_CE = 'CE';
    const STATUS_FF = 'FF';
    const STATUS_NC = 'NC';
    const STATUS_CC = 'CC';
    const STATUS_CT = 'CT';
    const STATUS_UE = 'UE';

    public function reports() {
        return $this->hasMany('App\SolutionReport');
    }

    public function problem(){
        return $this->belongsTo(Problem::class, 'problem_id');
    }
    
    public function owner() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function programming_language(){
    return $this->belongsTo(ProgrammingLanguage::class, 'programming_language_id');
}
    /*
     * разбиваем дату создания на год, месяц, день
     *
     * и сохраняем по такому пути solutions_source_code/год/месяц/день/id
     * @todo: make path creation more beautiful
     */
    public function sourceCodePath()
    {
        return 'solutions_source_code/' .
        $this->created_at->year   . '/' .
        $this->created_at->month  . '/' .
        $this->created_at->day    . '/' . $this->id;
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

    public static function getStates() {
        return [
            self::STATE_NEW,
            self::STATE_RECEIVED,
            self::STATE_REJECTED,
            self::STATE_RESERVED,
            self::STATE_TESTED,
        ];
    }

    public function getMaxTime(){
        $max = 0;
        foreach($this->reports as $report) {
            if($report->execution_time > $max) {
                $max = $report->execution_time;
            }
        }
        return $max;
    }

    public function getMaxMemory(){
        $max = 0;
        foreach($this->reports as $report) {
            if($report->memory_peak > $max) {
                $max = $report->memory_peak;
            }
        }
        return $max;
    }

    public function getContest(){
       return Contest::join('contest_solution', 'id', '=', 'contest_id')->where('solution_id', $this->attributes['id'])->first();
    }

    public static function getStatuses() {
        return [
            self::STATUS_CE,
            self::STATUS_FF,
            self::STATUS_NC,
            self::STATUS_CC,
            self::STATUS_CT,
            self::STATUS_UE,
        ];
    }

}