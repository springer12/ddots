<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(Request $request, $id) {
        $user = User::findOrFail($id);
        $thisUser = Auth::User();
        //if($user->role == User::ROLE_TEACHER){
        return view('user.profile')->with(['user' => $user, 'thisUser' => ($thisUser ? $user->id == $thisUser->id : false)]);
        //}
    }
    public function upgrade(Request $request, $id) {
        $user = Auth::user();
        if($user->id == $id) {
            $user->upgrade();
        }
        return redirect(action('UserController@index', ['id' => $user->id]));
    }
}
