<?php

namespace App\Http\Controllers;

use App\Group;
use Illuminate\Http\Request;
use App\User;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class GroupController extends Controller
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

        $groups = $this->findQuery();

        $groups = $groups->orderBy($orderBy, $orderDir)
            ->paginate(10);

        return view('groups.list')->with([
            'groups' => $groups,
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
     * @return View
     */
    public function showForm(Request $request, $id = null)
    {
        $group = ($id ? $this->findOrFail($id) : new Group());
        if ($id) {
            $title = trans('layout.group.edit');
        } else {
            $title = trans('layout.group.create');
        }

        $students = $group->getStudents();

        return view('groups.form')->with([
            'group' => $group,
            'students' => $students,
            'unincludedStudents' => Auth::user()->students->diff($students),
            'title' => $title,
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
    public function edit(Request $request, $id = null)
    {
        $group = (!$id ?: $this->findOrFail($id));

        $fillData = [
            'name' => $request->get('name'),
            'description' => $request->get('description'),
        ];

        $rules = Group::getValidationRules();

        $this->validate($request, $rules);

        if ($id) {
            $group->fill($fillData);
        } else {
            $group = Group::create($fillData);
        }

        $users = $request->get('students');
        $users[] = Auth::user()->id;

        $group->users()->sync($users);

        $group->save();

        \Session::flash('alert-success', 'The group was successfully saved');//todo
        return redirect()->route('teacherOnly::groups::list');
    }

    /**
     * Handle a delete request
     *
     * @param int|null $id
     *
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $group = $this->findOrFail($id);
        $group->delete();
        return redirect()->route('teacherOnly::groups::list')->with('alert-success', 'The group was successfully deleted');//todo
    }

    /**
     * Handle a restore request
     *
     * @param int|null $id
     *
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $group = $this->findOrFail($id);
        $group->restore();
        return redirect()->route('teacherOnly::groups::list')->with('alert-success', 'The group was successfully restored');//todo
    }

    /**
     * @return \Illuminate\Database\Query\Builder
     */
    protected function findQuery()
    {
        return Group::withTrashed()->whereHas('users', function($query){
            $query->where('user_id', Auth::user()->id);
        });
    }

    protected function findOrFail($id)
    {
        return $this->findQuery()->findOrFail($id);
    }

}
