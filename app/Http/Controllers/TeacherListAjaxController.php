<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use \Auth;

class TeacherListAjaxController extends Controller
{
    public function addTeacher(Request $request)
    {

        if(Auth::check() && Auth::user()->hasRole(User::ROLE_USER)) {
            $remainingRequests = Auth::user()->getRemainingRequests();
            if($remainingRequests > 0) {
                $teacher = User::where('role', User::ROLE_TEACHER)->find($request->input('id'));
                Auth::user()->teachers()->attach($teacher->id);
            }
            return $remainingRequests - 1;
        } else {
            return -1;
        }
    }
}
