<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContestProblemUser extends Model
{
    public $timestamps = false;
    protected $table = 'contest_problem_user';
    protected $guarded  = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function contest()
    {
        return $this->belongsTo(Contest::class);
    }

    public function problem()
    {
        return $this->belongsTo(Problem::class);
    }
}
