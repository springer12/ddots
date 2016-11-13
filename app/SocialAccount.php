<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Socialite\Contracts\Provider;

/**
 * App\SocialAccount
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $provider_user_id
 * @property string $provider
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Query\Builder|\App\SocialAccount whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SocialAccount whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SocialAccount whereProviderUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SocialAccount whereProvider($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SocialAccount whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SocialAccount whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SocialAccount extends Model
{
    protected $fillable = ['user_id', 'provider_user_id', 'provider'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function createOrGetUser(Provider $provider, $providerName) {
        $providerUser = $provider->user();
        $account = SocialAccount::whereProvider($providerName)->whereProviderUserId($providerUser->getId())->first();
        if($account) {
            return $account->user;
        } else {
            $account = new SocialAccount([
                'provider_user_id' => $providerUser->getId(),
                'provider' => $providerName,
            ]);
            $email = $providerUser->getEmail();
            if($email) {
                $role = User::ROLE_USER;
                $user = User::whereEmail($email)->first();
            } else {
                $role = User::ROLE_LOW_USER;
                $user = null;
            }
            if(!$user) {
                $user = User::create([
                    'name'     => $providerUser->getName(),
                    'nickname' => str_slug($providerUser->getName(), '_') . '_' . base_convert(time() - env('START_OF_TIME', 1466603612),10,36),
                    'email'    => $email,
                    'role'     => $role,
                ]);
            }
            $account->user()->associate($user);
            $account->save();
            return $user;
        }

    }
}
