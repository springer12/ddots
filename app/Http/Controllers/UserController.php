<?php

namespace App\Http\Controllers;

use App\ProgrammingLanguage;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $user = User::findOrFail($request->id);
        return view('user.profile')->with(['user' => $user]);
    }

    public function upgrade(Request $request)
    {
        $user = Auth::user();
        $rules = $user->getValidationRules();
        $rules['email'] = 'required|email|unique:users,email,' . $user->id;
        $this->validate($request, $rules);
        $user->fill($request->except('date_of_birth'));
        $user->date_of_birth = $request->date_of_birth ? Carbon::parse($request->date_of_birth) : null;
        $user->sendVerificationMail();
        $user->save();
        return redirect(action('UserController@index'));
    }

    public function verify(Request $request, $code)
    {
        $user = User::where('email_verification_code', $code)->firstOrFail();
        $user->upgrade();
        $user->email_verification_code = null;
        $user->save();
        return redirect(route('user::profile', ['id' => $user->id]));
    }

    public function edit(Request $request)
    {
        return view('user.edit')->with(['user' => Auth::user(), 'programming_languages' => ProgrammingLanguage::orderBy('name', 'desc')->get()]);
    }

    public function saveEdit(Request $request)
    {
        $user = Auth::user();
        $this->validate($request, $user->getValidationRules());
        if(Input::hasFile('avatar_file')) {
            $user->setAvatar();
        }
        $user->fill($request->except('date_of_birth'));
        $user->date_of_birth = $request->date_of_birth ? Carbon::parse($request->date_of_birth) : null;
        $user->save();
        return redirect(route('user::profile', ['id' => $user->id]));
    }
}
