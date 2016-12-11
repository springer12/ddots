<?php

namespace App\Http\Controllers\Backend;

use App\TestingServer;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class TestingServersController extends Controller
{
    public function index(Request $request)
    {
        $orderBySession = \Session::get('orderBy', 'updated_at');
        $orderBy = $request->input('order', $orderBySession);

        $orderDirSession = \Session::get('orderDir', 'desc');
        $orderDir = $request->input('dir', $orderDirSession);

        $page = $request->input('page');
        $query = $request->input('query', '');

        if (!in_array($orderBy, TestingServer::sortable())) {
            $orderBy = 'id';
        }

        if (!in_array($orderDir, ['asc', 'ASC', 'desc', 'DESC'])) {
            $orderDir = 'desc';
        }

        \Session::put('orderBy', $orderBy);
        \Session::put('orderDir', $orderDir);

        $testing_servers = $this->findQuery();

        if ($query) {
            $testing_servers = $testing_servers->where(function ($query_s) use ($query) {
                $query_s->orwhere('id', 'like', "%$query%")
                    ->orwhere('name', 'like', "%$query%");
            });
        }

        $testing_servers = $testing_servers->orderBy($orderBy, $orderDir)
            ->paginate(10);

        return view('backend.testing_servers.list')->with([
            'servers' => $testing_servers,
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
        $testing_server = ($id ? $this->findOrFail($id) : new TestingServer());
        if ($id) {
            $title = 'Edit Serever';
        } else {
            $title = 'Create Server';
        }

        return view('backend.testing_servers.form')->with([
            'server' => $testing_server,
            'title' => $title,
            'passwordRequired' => is_null($id),
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
        $testing_server = (!$id ?: $this->findOrFail($id));
        $rules = TestingServer::getValidationRules();
        $fillData = ['name' => $request->get('name'), 'login' => $request->get('login')];
        if (!$id || $request->get('password') != '') {
            $rules = array_merge($rules, ['password' => 'required|min:6|confirmed']);
            $fillData = array_merge($fillData, ['password' => $request->get('password')]);
        }
        
        if($id) {
            $rules = array_merge($rules,['login' => 'required|string|max:255|alpha_dash|unique:testing_servers,login,' . $id]);
        } else {
            $rules = array_merge($rules,['login' => 'required|string|max:255|alpha_dash|unique:testing_servers,login,']);
        }
        
        $this->validate($request, $rules);


        if ($id) {
            $testing_server->fill($fillData);
        } else {
            $testing_server = new TestingServer($fillData);
        }
        $testing_server->save();

        \Session::flash('alert-success', 'The server was successfully saved');
        return redirect()->route('backend::testing_servers::list');
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
        $server = $this->findOrFail($id);
        $server->delete();
        return redirect()->route('backend::testing_servers::list')->with('alert-success', 'The server was successfully deleted');
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
        $server = $this->findOrFail($id);
        $server->restore();
        return redirect()->route('backend::testing_servers::list')->with('alert-success', 'The server was successfully restored');
    }

    /**
     * @return \Illuminate\Database\Query\Builder
     */
    protected function findQuery()
    {
        return TestingServer::withTrashed();
    }

    protected function findOrFail($id)
    {
        return $this->findQuery()->findOrFail($id);
    }

}
