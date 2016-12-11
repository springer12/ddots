<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Carbon\Carbon;

/**
 * App\TestingServer
 *
 * @property integer $id
 * @property string $name
 * @property string $api_token
 * @property string $deleted_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $token_created_at
 * @property string $login
 * @property string $password
 * @method static \Illuminate\Database\Query\Builder|\App\TestingServer whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TestingServer whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TestingServer whereApiToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TestingServer whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TestingServer whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TestingServer whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TestingServer whereTokenCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TestingServer whereLogin($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TestingServer wherePassword($value)
 * @mixin \Eloquent
 */
class TestingServer extends Authenticatable
{
    use SoftDeletes;
    use Sortable;
    
    protected static $sortable_columns = [
        'id', 'name', 'login', 'token_created_at', 'deleted_at'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'login', 'password', 'token_created_at'
    ];

    const TOKEN_TTL = 60 * 60; //seconds

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
