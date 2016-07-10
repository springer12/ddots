<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;

/**
 * Class Problem
 * @package App
 */
class Problem extends Model
{
    use SoftDeletes;

    public $fillable = [
      'name', 'archive'
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

}
