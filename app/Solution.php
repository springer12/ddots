<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Solution extends Model
{

    const STATE_NEW = 'new';
    const STATE_RECEIVED = 'received';
    const STATE_REJECTED = 'rejected';
    const STATE_RESERVED = 'reserved';
    const STATE_TESTED = 'tested';

    /*
     * разбиваем дату создания на год, месяц, день
     *
     * и сохраняем по такому пути solutions_source_code/год/месяц/день/id
     * @todo: make path creation more beauty
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

}