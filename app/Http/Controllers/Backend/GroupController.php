<?php

namespace App\Http\Controllers\Backend;


use App\Group;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\User;
use App\Http\Controllers\Controller;

class GroupController extends Controller
{
    public function index(Request $request)
    {
        $orderBySession = \Session::get('orderBy', 'updated_at');
        $orderBy = $request->input('order', $orderBySession);

        $orderDirSession = \Session::get('orderDir', 'desc');
        $orderDir = $request->input('dir', $orderDirSession);

        $page = $request->input('page');
        $query = $request->input('query', '');

        if (!in_array($orderBy, Group::sortable())) {
            $orderBy = 'id';
        }


        if (!in_array($orderDir, ['asc', 'ASC', 'desc', 'DESC'])) {
            $orderDir = 'desc';
        }

        \Session::put('orderBy', $orderBy);
        \Session::put('orderDir', $orderDir);

        $groups = $this->findQuery();

        if ($query) {
            $groups = $groups->where(function ($query_s) use ($query) {
                $query_s->orwhere('id', 'like', "%$query%")
                    ->orwhere('name', 'like', "%$query%")
                    ->orwhere('nickname', 'like', "%$query%")
                    ->orwhere('email', 'like', "%$query%");
            });
        }

/*            */
        if($orderBy == 'owner') {
            $groups = $groups->join('group_user', 'group_id', '=', 'groups.id')
                ->join('users', 'user_id', '=', 'users.id')
                ->where('role', User::ROLE_TEACHER)
                ->groupBy('groups.id')
                ->orderBy('users.name', $orderDir)
                ->select('groups.*');
        } else {
            $groups = $groups->orderBy($orderBy, $orderDir);
        }

            $groups = $groups->paginate(10);

        return view('backend.groups.list')->with([
            'groups' => $groups,
            'order_field' => $orderBy,
            'dir' => $orderDir,
            'page' => $page,
            'query' => $query
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
    public function showForm(Request $request, $id = null)
    {
        $group = ($id ? $this->findOrFail($id) : new Group());
        if ($id) {
            $title = 'Edit Group';
        } else {
            $title = 'Create Group';
        }
        $students = $group->getStudents();

        return view('backend.groups.form')->with([
            'group' => $group,
            'owner' => $group->getOwner(),
            'students' => $group->getStudents(),
            'unincludedStudents' => $group->getOwner()->students->diff($students),
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
        $users[] = $request->get('owner');

        $group->users()->sync($users);
        

        $group->save();

        \Session::flash('alert-success', 'The group was successfully saved');
        return redirect()->route('backend::groups::list');
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
        return redirect()->route('backend::groups::list')->with('alert-success', 'The group was successfully deleted');
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
        return redirect()->route('backend::groups::list')->with('alert-success', 'The group was successfully restored');
    }

    /**
     * @return \Illuminate\Database\Query\Builder
     */
    protected function findQuery()
    {
        return Group::withTrashed();
    }

    protected function findOrFail($id)
    {
        return $this->findQuery()->findOrFail($id);
    }

}
