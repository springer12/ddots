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
    public function index(Request $request, $id = null) {
        if($id) {
            $user = User::findOrFail($id);
        } else {
            $user = Auth::User();
        }
        return view('user.profile')->with(['user' => $user]);
    }

    public function upgrade(Request $request) {
        $user = Auth::user();
        $rules = $user->getValidationRules();
        $rules['email'] = 'required|email|unique:users,email,' . $user->id;
        $this->validate($request,$rules);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->nickname = $request->nickname;
        $user->date_of_birth = $request->date_of_birth?Carbon::parse($request->date_of_birth):null;
        $user->profession = $request->profession;
        $user->programming_language = $request->programming_language;
        $user->place_of_study = $request->place_of_study;
        $user->vk_link = $request->vk_link;
        $user->fb_link = $request->fb_link;
        $user->sendVerificationMail($request->email);
        $user->save();
        return redirect(action('UserController@index'));
    }

    public function verify(Request $request, $code) {
        $user = User::where('email_verification_code', $code)->firstOrFail();
        $user->upgrade();
        $user->email_verification_code = null;
        $user->save();
        return redirect(action('UserController@index'));
    }

    public function edit(Request $request) {
        return view('user.edit')->with(['user' => Auth::user(), 'programming_languages' => ProgrammingLanguage::orderBy('name', 'desc')->get()]);
    }

    public function saveEdit(Request $request) {
        $user = Auth::user();
        $this->validate($request, $user->getValidationRules());
        if(Input::hasFile('avatar_file')){
            $user->setAvatar();
        }
        $user->name = $request->name;
        $user->nickname = $request->nickname;
        $user->date_of_birth = $request->date_of_birth?Carbon::parse($request->date_of_birth):null;
        $user->profession = $request->profession;
        $user->programming_language = $request->programming_language;
        $user->place_of_study = $request->place_of_study;
        $user->vk_link = $request->vk_link;
        $user->fb_link = $request->fb_link;
        $user->save();
        return redirect(route('user::profile'));
    }
}
