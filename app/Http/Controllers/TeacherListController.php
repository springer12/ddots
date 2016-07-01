<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use Auth;
use Illuminate\Support\Facades\DB;

class TeacherListController extends Controller
{
    public function index(Request $request)
    {
        DB::enableQueryLog();
        $myTeachers = null;
        $allTeachers = User::teacher();
        if(Auth::check() && Auth::user()->hasRole(User::ROLE_USER)) {
            $myTeachers = Auth::user()->whereIn('id', function ($query) {
                $query->select('teacher_id')
                    ->from('teacher_student')
                    ->where('student_id', Auth::user()->id)
                    ->where('confirmed', '=', true);
            })->teacher()->groupBy('id')
                ->orderBy('name', 'asc')
                ->get();
            $allTeachers = $allTeachers->whereNotIn('id', function ($query) {
                $query->select('teacher_id')
                    ->from('teacher_student')
                    ->where('student_id', Auth::user()->id)
                    ->where('confirmed', '=', true);
            })->groupBy('id');
        }

        $allTeachers = $allTeachers->orderBy('name', 'asc')
            ->paginate(10);
        if(Auth::check()) {
            foreach($allTeachers as $teacher) {
                $teacher['relation_exists'] = $teacher->students()->get()->contains(Auth::user()->id);
            }
        }

        return view('teacher_list.index')->with(['allTeachers' => $allTeachers, 'myTeachers' => $myTeachers]);
    }
}
