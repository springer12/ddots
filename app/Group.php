<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Requests;

/**
 * App\Group
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $users
 * @method static \Illuminate\Database\Query\Builder|\App\Group whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Group whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Group whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Group whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Group whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Group whereDeletedAt($value)
 * @mixin \Eloquent
 */
class Group extends Model
{
    use SoftDeletes;
    use Sortable;

    protected static $sortable_columns = [
        'id', 'name', 'created_at', 'updated_at', 'deleted_at', 'owner'
    ];

    protected $fillable = ['name', 'description'];

    public static function getValidationRules()
    {
        return [
            'name' => 'required|max:255|any_lang_name',
            'description' => 'max:255',
        ];
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'group_user', 'group_id')->withTimestamps();
    }

    public function getOwner()
    {
        return $this->users()->teacher()->first();
    }

    public function getStudents()
    {
        return $this->users()->user()->get();
    }
}