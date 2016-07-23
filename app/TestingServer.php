<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TestingServer extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];


    /**
     * The columns that grid can be sorted.
     *
     * @var array
     */
    public static function sortable($list = false) {
        $columns = [
            'id', 'name', 'created_at', 'updated_at', 'deleted_at'
        ];

        return ($list ? implode(',', $columns) : $columns);
    }

    public static function generateApiToken() {
        return str_random(60);
    }
}
