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
            $myTeachers = Auth::user()
                ->teachers()
                ->orderBy('name', 'asc')->get();

            foreach($myTeachers as $k=>$teacher) {
                if(!$teacher->pivot->confirmed) {
                    unset($myTeachers[$k]);
                }
            }
            $allTeachers = $allTeachers->whereNotIn('teacher_id', $myTeachers->map(function ($item) {
                return $item->id;
            }))
                ->leftJoin('teacher_student', 'teacher_id', '=', 'id');
        }

        $allTeachers = $allTeachers->orderBy('name', 'asc')
            ->groupBy('id')
            ->paginate(1);
       // dd(DB::getQueryLog());
        return view('teacher_list.index')->with(['allTeachers' => $allTeachers, 'myTeachers' => $myTeachers]);
    }
}
