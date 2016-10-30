<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Volume extends Model
{
    use SoftDeletes;
    use Sortable;

    protected static $sortable_columns = [
        'id', 'name',
    ];

    public $fillable = [
        'name'
    ];

    public function problems()
    {
        return $this->belongsToMany(Problem::class);
    }

    public static function getValidationRules()
    {
        return [
            'name' => 'required|max:255|any_lang_name',
            ];
    }
}
