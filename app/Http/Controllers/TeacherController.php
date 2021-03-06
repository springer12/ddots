<?php

namespace App\Http\Controllers;

use App\Subdomain;
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
        $allTeachers = Subdomain::currentSubdomain()->users()->teacher()->orderBy('name', 'asc')->paginate(9);
        if (Auth::check() && Auth::user()->hasRole(User::ROLE_USER)) {
            $myTeachers = Auth::user()->getConfirmedTeachersQuery()->orderBy('name', 'asc')->get();
            $allTeachers = Auth::user()->markRelated($allTeachers);
            $allowedRequests = Auth::user()->allowedToRequestTeacher();
        }

        return view('teachers.list')->with([
            'allTeachers' => $allTeachers,
            'myTeachers' => $myTeachers,
            'allowedRequests' => $allowedRequests
        ]);
    }

    public function main()
    {
        return view('teachers.all', ['teachers' => User::teacher()->paginate(9)]);
    }
}
