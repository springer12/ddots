<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Carbon\Carbon;

class TestingServer extends Authenticatable
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'login', 'password'
    ];

    const TOKEN_TTL = 60 * 60; //seconds

    /**
     * The columns that grid can be sorted.
     *
     * @var array
     */
    public static function sortable($list = false)
    {
        $columns = [
            'id', 'name', 'created_at', 'updated_at', 'deleted_at'
        ];

        return ($list ? implode(',', $columns) : $columns);
    }

    public function isTokenValid()
    {
        if ($this->api_token && Carbon::parse($this->attributes['token_created_at'])->diffInSeconds(Carbon::now()) < self::TOKEN_TTL) {
            return true;
        }
        return false;
    }

    public static function getValidationRules()
    {
        return [
            'name' => 'required|string|max:255',
        ];
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);

        return $this;
    }

    public function setApiTokenAttribute($value)
    {
        $this->attributes['api_token'] = $value;
        $this->token_created_at = Carbon::now();
    }

    public static function generateApiToken()
    {
        return str_random(60);
    }
}
