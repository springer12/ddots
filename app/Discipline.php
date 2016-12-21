<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Discipline extends Model
{
    use SoftDeletes;
    use Sortable;

    protected static $sortable_columns = ['id', 'name', 'created_at', 'updated_at', 'deleted_at'];

    public function students()
    {
        return $this->belongsToMany(User::class);
    }

    public function owner()
    {
        return $this->belongsTo(User::class);
    }

}
