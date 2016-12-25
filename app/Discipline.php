<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Discipline extends Model
{
    use SoftDeletes;
    use Sortable;

    protected static $sortable_columns = ['id', 'name', 'created_at', 'updated_at', 'deleted_at'];

    protected $fillable = ['name', 'description'];

    public function students()
    {
        return $this->belongsToMany(User::class);
    }

    public function problems()
    {
        return $this->belongsToMany(Problem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function getValidationRules()
    {
        return [
            'name' => 'required|max:255|any_lang_name',
            'description' => 'max:255',
        ];
    }
}
