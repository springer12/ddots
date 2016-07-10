<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Problem
 * @package App
 */
class Problem extends Model
{
    use SoftDeletes;

    public $fillable = [
      'name'
    ];

    /**
     * The columns that grid can be sorted.
     *
     * @var bool
     *
     * @return string|array
     */
    public static function sortable($list = false) {
        $columns = [
            'id', 'name', 'created_at', 'updated_at', 'deleted_at'
        ];

        return ($list ? implode(",", $columns) : $columns);
    }


    public function volumes() {
        return $this->belongsToMany('App\Volume');
    }

    /*
     * @todo: make path creation more beauty
     */
    public function archivePath()
    {
        return 'problems/' . $this->id;
    }

}
