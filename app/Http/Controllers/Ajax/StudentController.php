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
            User::findOrFail($id)->teachers()->updateExistingPivot(Auth::user()->id, ['confirmed' => true]);
            $response['error'] = false;
        } else {
            $response['error'] = true;
        }
        return $response;
    }

    public function decline(Request $request, $id)
    {
        if (Auth::check() && Auth::user()->hasRole(User::ROLE_TEACHER)) {
            User::findOrFail($id)->teachers()->detach(Auth::user()->id);
            $response['error'] = false;
        } else {
            $response['error'] = true;
        }
        return $response;
    }

    public function addToGroup(Request $request)
    {
        if (Auth::check() && Auth::user()->hasRole(User::ROLE_TEACHER)) {
            $this->validate($request, [
                'group_id' => 'required|exists:groups,id|unique:group_user,group_id,NULL,group_id,user_id,' . $request->get('student_id'),
                'student_id' => 'required|exists:users,id'
            ]);
            $user = User::find($request->get('student_id'));
            $user->groups()->attach($request->get('group_id'));
            $user->save();
            $response['error'] = false;
        } else {
            $response['error'] = true;
        }
        return $response;
    }

    public function search(Request $request)
    {
        if(Auth::user()->hasRole(User::ROLE_ADMIN)) {
            $results_per_page = 10;
            $students = User::user()
                ->select(['id', 'name'])
                ->where('name', 'LIKE', '%' . $request->get('term') . '%')
                ->skip(($request->get('page') - 1) * $results_per_page)
                ->take($results_per_page)
                ->get();
            return ['results' => $students, 'total_count' => User::user()
                ->where('name', 'LIKE', '%' . $request->get('term') . '%')
                ->count()
            ];
        }
        return null;
    }
}

