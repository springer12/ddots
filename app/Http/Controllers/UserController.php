<?php

namespace App\Http\Controllers;

use App\ProgrammingLanguage;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class UserController extends Controller
{
    public function index(Request $request, $id = null) {
        if($id) {
            $user = User::findOrFail($id);
            $thisUser = $user->id == Auth::user()->id ? true : false;
        } else {
            $user = Auth::User();
            $thisUser = true;
        }

        //if($user->role == User::ROLE_TEACHER){
        return view('user.profile')->with(['user' => $user, 'thisUser' => $thisUser]);
        //}
    }

    public function upgrade(Request $request) {
        $user = Auth::user();
        $user->upgrade();
        return redirect(action('UserController@index', ['id' => $user->id]));
    }

    public function edit(Request $request) {
        return view('user.edit')->with(['user' => Auth::user(), 'langs' => ProgrammingLanguage::orderBy('name', 'desc')->get()]);
    }

    public function saveEdit(Request $request) {
        $user = Auth::user();
        $this->validate($request, [
            'nickname' => 'required|max:255|english_alpha_dash|unique:users,nickname,' . $user->id,
            'date_of_birth' => 'date',
            'profession' => 'max:255|alpha_dash',
            'place_of_study' => 'max:255|alpha_dash',
            'programming_language' => 'exists:programming_languages,id',
            'vk_link' => 'url_domain:vk.com,new.vk.com,www.vk.com,www.new.vk.com',
            'fb_link' => 'url_domain:facebook.com,www.facebook.com',
        ]);
        $user->nickname = $request->nickname;
        $user->date_of_birth = Carbon::parse($request->date_of_birth);
        $user->profession = $request->profession;
        $user->programming_language = $request->programming_language;
        $user->place_of_study = $request->place_of_study;
        $user->vk_link = $request->vk_link;
        $user->fb_link = $request->fb_link;
        $user->save();
        return redirect(route('user::profile'));
    }
}
