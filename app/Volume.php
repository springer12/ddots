<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Volume extends Model
{
    use SoftDeletes;
    use Sortable;

    const RESULTS_PER_PAGE = 20;

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

    public static function search($term, $page)
    {
        $problems = static::select(['id', 'name'])
            ->where('name', 'LIKE', '%' . $term . '%');

        $count = $problems->count();
        $problems = $problems->skip(($page - 1) * static::RESULTS_PER_PAGE)
            ->take(static::RESULTS_PER_PAGE)
            ->get();
        return ['results' => $problems, 'total_count' => $count];
    }
}
