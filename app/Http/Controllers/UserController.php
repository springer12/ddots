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
        $rules = Auth::user()->getValidationRules();
        $rules['email'] = 'required|email|unique:users,email,' . Auth::user()->id;
        $this->validate($request, $rules);
        Auth::user()->fill($request->except('date_of_birth'));
        Auth::user()->date_of_birth = $request->date_of_birth ? Carbon::parse($request->date_of_birth) : null;
        Auth::user()->sendVerificationMail();
        Auth::user()->save();
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

        $this->validate($request, Auth::user()->getValidationRules());
        if(Input::hasFile('avatar_file')) {
            Auth::user()->setAvatar();
        }
        Auth::user()->fill($request->except('date_of_birth'));
        Auth::user()->date_of_birth = $request->date_of_birth ? Carbon::parse($request->date_of_birth) : null;
        Auth::user()->save();
        return redirect(route('user::profile', ['id' => Auth::user()->id]));
    }

    public function addTeacher(Request $request) {
        $this->validate($request, ['id' => 'exists:users']);
        $teacher = User::where('id',$request->id)->where('role', User::ROLE_TEACHER)->firstOrFail();
        Auth::user()->teachers()->attach($teacher);
        return redirect(route('user::profile', ['id' => Auth::user()->id]));
    }

}
