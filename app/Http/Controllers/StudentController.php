<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $orderBySession = \Session::get('orderBy', 'updated_at');
        $orderBy = $request->input('order', $orderBySession);

        $orderDirSession = \Session::get('orderDir', 'desc');
        $orderDir = $request->input('dir', $orderDirSession);

        $page = $request->input('page');


        if (!in_array($orderBy, User::sortable())) {
            $orderBy = 'id';
        }

        if (!in_array($orderDir, ['asc', 'ASC', 'desc', 'DESC'])) {
            $orderDir = 'desc';
        }

        \Session::put('orderBy', $orderBy);
        \Session::put('orderDir', $orderDir);

        $students = $this->findQuery();

        $students = $students->orderBy($orderBy, $orderDir)
            ->paginate(10);

        return view('students.list')->with([
            'students' => $students,
            'order_field' => $orderBy,
            'dir' => $orderDir,
            'page' => $page,

        ]);
    }

    /**
     * Show the form.
     *
     * @param \Illuminate\Http\Request $request
     * @param int|null $id
     *
     * @return \Illuminate\Http\Response
     */
    public function showForm(Request $request, $id)
    {


        return view('students.form')->with([
            'student' => User::findOrFail($id),
            'groups' => Auth::user()->groups()->whereNotIn('id', function ($query) use ($id) {
                $query->select('group_id')->from('group_user')->where('user_id', $id);
            })->get()
        ]);
    }

    /**
     * Handle a add/edit request
     *
     * @param \Illuminate\Http\Request $request
     * @param int|null $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {

        $this->validate($request, ['group' => 'required|exists:groups,id|unique:group_user,group_id,NULL,group_id,user_id,' . $id]);
        $user = User::findOrFail($id);
        $user->groups()->attach($request->get('group'));
        $user->save();
        \Session::flash('alert-success', 'The student was successfully saved');
        return redirect()->route('students::list');
    }

    /**
     * @return \Illuminate\Database\Query\Builder
     */
    protected function findQuery()
    {
        return Auth::user()->students()->withPivot('confirmed');
    }

    protected function findOrFail($id)
    {
        return $this->findQuery()->findOrFail($id);
    }
}
