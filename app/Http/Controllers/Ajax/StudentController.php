<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Requests;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use \Auth;

class StudentController extends Controller
{
    public function confirm(Request $request, $id)
    {
        if (Auth::check() && Auth::user()->hasRole(User::ROLE_TEACHER)) {
            User::findOrFail($id)->teachers()->updateExistingPivot(Auth::user()->id,['confirmed' => true]);
            $response['error'] = false;
        } else {
            $response['error'] = true;
        }
        return $response;
    }

    public function decline(Request $request, $id) {
        if (Auth::check() && Auth::user()->hasRole(User::ROLE_TEACHER)) {
            User::findOrFail($id)->teachers()->detach(Auth::user()->id);
            $response['error'] = false;
        } else {
            $response['error'] = true;
        }
        return $response;
    }
}

