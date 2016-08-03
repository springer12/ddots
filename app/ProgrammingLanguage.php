<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProgrammingLanguage extends Model
{
    use SoftDeletes;
    use Sortable;

    protected $fillable = [
        'name', 'ace_mode','compiler_image', 'executor_image',
    ];

    protected static $sortable_columns = [
        'id', 'name', 'created_at', 'deleted_at', 'updated_at'
    ];

    public static function getValidationRules(){
        return [
            'name' => 'required|max:255|alpha_dash_spaces',
            'ace_mode' => 'max:255|alpha_dash',
        ];
    }
}
