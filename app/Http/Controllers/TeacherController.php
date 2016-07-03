<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use Auth;


class TeacherController extends Controller
{
    public function index(Request $request)
    {
        $myTeachers = null;
        $allowedRequests = false;
        if(Auth::check() && Auth::user()->hasRole(User::ROLE_USER)) {
            $allTeachers = Auth::user()->getUnrelatedOrUnconfirmedTeachersQuery()->orderBy('name', 'asc')->paginate(10);
            $myTeachers = Auth::user()->getConfirmedTeachersQuery()->orderBy('name', 'asc')->get();
            Auth::user()->markRelated($allTeachers);
            $allowedRequests = Auth::user()->allowedToRequestTeacher();
        } else {
            $allTeachers = User::teacher()->orderBy('name', 'asc')->paginate(10);
        }

        return view('teachers.list')->with([
            'allTeachers'     => $allTeachers,
            'myTeachers'      => $myTeachers,
            'allowedRequests' => $allowedRequests
        ]);
    }
}
