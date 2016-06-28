<?php

namespace App\Http\Controllers;

use App\ActivationRepository;
use App\ProgrammingLanguage;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use App\ActivationService;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $user = User::findOrFail($request->id);
        return view('user.profile')->with(['user' => $user]);
    }

    public function upgrade(Request $request)
    {
        $activationService = new ActivationService(new ActivationRepository());
        $rules = array_merge(Auth::user()->getValidationRules(), [
            'email' => 'required|email|unique:users,email,' . Auth::user()->id
        ]);
        $this->validate($request, $rules);
        Auth::user()->fill($request->all());
        $activationService->sendActivationMail(Auth::user());
        Auth::user()->save();
        \Session::flash('alert-success', 'An verification email has been sent');
        return redirect(action('UserController@index', ['id' => Auth::user()->id]));
    }

    public function edit(Request $request)
    {
        return view('user.edit')->with(['user' => Auth::user(), 'programming_languages' => ProgrammingLanguage::orderBy('name', 'desc')->get()]);
    }

    public function saveEdit(Request $request)
    {

        $this->validate($request, Auth::user()->getValidationRules());
        if(Input::hasFile('avatar')) {
            Auth::user()->setAvatar('avatar');
        }
        Auth::user()->fill($request->all());
        Auth::user()->save();
        return redirect(route('frontend::user::profile', ['id' => Auth::user()->id]));
    }

    public function addTeacher(Request $request) {
        $this->validate($request, ['id' => 'exists:users']);
        $teacher = User::where('id',$request->id)->where('role', User::ROLE_TEACHER)->firstOrFail();
        Auth::user()->teachers()->attach($teacher);
        return redirect(route('frontend::user::profile', ['id' => Auth::user()->id]));
    }
    public function verify(Request $request, $token)
    {
        $activationService = new ActivationService(new ActivationRepository());
        if ($user = $activationService->activateUser($token)) {
            auth()->login($user);
            \Session::flash('alert-success', 'Email verified!');
            return redirect(route('frontend::user::profile', ['id' => $user->id]));
        }
        abort(404);
    }
}
