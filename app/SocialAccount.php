<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Socialite\Contracts\Provider;

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
