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
            $user = User::whereEmail($providerUser->getEmail())->first();
            if(!$user) {
                $user = User::create([
                    'email' => $providerUser->getEmail(),
                    'name'  => $providerUser->getName(),
                    'role'  => User::ROLE_USER,
                ]);
            }
            $account->user()->associate($user);
            $account->save();
            return $user;
        }

    }
}
