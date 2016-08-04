<?php

namespace App\Http\Controllers\Backend;


use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Input;
use App\ProgrammingLanguage;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $orderBySession = \Session::get('orderBy', 'updated_at');
        $orderBy = $request->input('order', $orderBySession);

        $orderDirSession = \Session::get('orderDir', 'desc');
        $orderDir = $request->input('dir', $orderDirSession);

        $page = $request->input('page');
        $query = $request->input('query', '');

        if (!in_array($orderBy, User::sortable())) {
            $orderBy = 'id';
        }

        if (!in_array($orderDir, ['asc', 'ASC', 'desc', 'DESC'])) {
            $orderDir = 'desc';
        }

        \Session::put('orderBy', $orderBy);
        \Session::put('orderDir', $orderDir);

        $users = $this->findQuery();

        if ($query) {
            $users = $users->where(function ($query_s) use ($query) {
                $query_s->orwhere('id', 'like', "%$query%")
                    ->orwhere('name', 'like', "%$query%")
                    ->orwhere('nickname', 'like', "%$query%")
                    ->orwhere('email', 'like', "%$query%");
            });
        }

        $users = $users->orderBy($orderBy, $orderDir)
            ->paginate(10);

        return view('backend.users.list')->with([
            'users' => $users,
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
        $user = ($id ? $this->findOrFail($id) : new User());
        if ($id) {
            $title = 'Edit User';
        } else {
            $title = 'Create User';
        }

        return view('backend.users.form')->with([
            'user' => $user,
            'title' => $title,
            'passwordRequired' => is_null($id),
            'programming_languages' => ProgrammingLanguage::orderBy('name', 'desc')->get()
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
        $user = (!$id ?: $this->findOrFail($id));

        $fillData = [
            'name' => $request->get('name'),
            'nickname' => $request->get('nickname'),
            'email' => $request->get('email'),
            'role' => $request->get('role'),
            'date_of_birth' => $request->get('date_of_birth'),
            'profession' => $request->get('profession'),
            'programming_language' => $request->get('programming_language'),
            'place_of_study' => $request->get('place_of_study'),
            'vk_link' => $request->get('vk_link'),
            'fb_link' => $request->get('fb_link'),
        ];

        if ($id) {
            $rules = array_merge(User::getValidationRules((bool)$request->get('programming_language')), [
                'email' => 'required|email|unique:users,email,' . $id,
                'nickname' => 'required|max:255|english_alpha_dash|unique:users,nickname,' . $user->id]);
            if ($request->get('password') != '') {
                $rules = array_merge($rules, ['password' => 'required|min:6|confirmed']);
                $fillData = array_merge($fillData, ['password' => $request->get('password')]);
            }
        } else {
            $rules = array_merge(User::getValidationRules((bool)$request->get('programming_language')), [
                'password' => 'required|min:6|confirmed',
                'email' => 'required|email|unique:users',
                'nickname' => 'required|max:255|english_alpha_dash|unique:users,nickname,']);
            $fillData = array_merge($fillData, ['password' => $request->get('password')]);
        }

        $this->validate($request, $rules);

        if ($id) {
            $user->fill($fillData);
        } else {
            $user = User::create($fillData);
        }

        if (Input::hasFile('avatar')) {
            $user->setAvatar('avatar');
        }

        if ($user->hasRole(User::ROLE_TEACHER) && $request->get('subdomain')) {
            $user->subdomains()->sync([$request->get('subdomain')]);
        }

        $user->save();

        \Session::flash('alert-success', 'The user was successfully saved');
        return redirect()->route('backend::users::list');
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
        $user = $this->findOrFail($id);
        $user->delete();
        return redirect()->route('backend::users::list')->with('alert-success', 'The user was successfully deleted');
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
        $user = $this->findOrFail($id);
        $user->restore();
        return redirect()->route('backend::users::list')->with('alert-success', 'The user was successfully restored');
    }

    /**
     * @return \Illuminate\Database\Query\Builder
     */
    protected function findQuery()
    {
        return User::withTrashed()->where('role', '<>', User::ROLE_ADMIN);
    }

    protected function findOrFail($id)
    {
        return $this->findQuery()->findOrFail($id);
    }

}
