<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\ProgrammingLanguage
 *
 * @property integer $id
 * @property string $name
 * @property string $deleted_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $ace_mode
 * @property string $compiler_image
 * @property string $executor_image
 * @method static \Illuminate\Database\Query\Builder|\App\ProgrammingLanguage whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ProgrammingLanguage whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ProgrammingLanguage whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ProgrammingLanguage whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ProgrammingLanguage whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ProgrammingLanguage whereAceMode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ProgrammingLanguage whereCompilerImage($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ProgrammingLanguage whereExecutorImage($value)
 * @mixin \Eloquent
 */
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
