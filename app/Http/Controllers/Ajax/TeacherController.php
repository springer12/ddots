<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Requests;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use \Auth;

class TeacherController extends Controller
{
    public function addTeacher(Request $request, $id)
    {
        if (Auth::check() && Auth::user()->hasRole(User::ROLE_USER)) {
            $remainingRequests = Auth::user()->getRemainingRequests();
            if ($remainingRequests > 0) {
                $teacher = User::where('role', User::ROLE_TEACHER)->find($id);
                Auth::user()->teachers()->attach($teacher->id);
            }
            $response['remainingRequests'] = $remainingRequests - 1;
            $response['error'] = false;
        } else {
            $response['error'] = true;
        }
        return $response;
    }
}
