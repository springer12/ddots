<?php

namespace App\Http\Controllers\Auth;

use App\SocialAccount;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;

use Auth;

class SocialController extends Controller
{

    /**
     * Redirect the user to the provider's authentication page.
     *
     * @return Response
     */
    public function redirectToProvider(Request $request, $provider)
    {
            return Socialite::with($provider)->redirect();
    }

    /**
     * Obtain the user information from the provider.
     *
     * @return Response
     */
    public function handleProviderCallback(Request $request , $provider)
    {
        $user = SocialAccount::createOrGetUser(Socialite::driver($provider), $provider);
        Auth::login($user);
        return redirect('/');
    }
}
