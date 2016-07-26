<?php

namespace App\Http\Controllers\Backend;


use App\Subdomain;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Input;
use App\ProgrammingLanguage;

class SubdomainController extends Controller
{
    public function index(Request $request)
    {
        $orderBySession = \Session::get('orderBy', 'updated_at');
        $orderBy = $request->input('order', $orderBySession);

        $orderDirSession = \Session::get('orderDir', 'desc');
        $orderDir = $request->input('dir', $orderDirSession);

        $page = $request->input('page');
        $query = $request->input('query', '');

        if (!in_array($orderBy, Subdomain::sortable())) {
            $orderBy = 'id';
        }

        if (!in_array($orderDir, ['asc', 'ASC', 'desc', 'DESC'])) {
            $orderDir = 'desc';
        }

        \Session::put('orderBy', $orderBy);
        \Session::put('orderDir', $orderDir);

        $subdomains = $this->findQuery();

        if ($query) {
            $subdomains = $subdomains->where(function ($query_s) use ($query) {
                $query_s->orwhere('id', 'like', "%$query%")
                    ->orwhere('name', 'like', "%$query%")
                    ->orwhere('nickname', 'like', "%$query%")
                    ->orwhere('email', 'like', "%$query%");
            });
        }

        $subdomains = $subdomains->orderBy($orderBy, $orderDir)
            ->paginate(10);

        return view('backend.subdomains.list')->with([
            'subdomains' => $subdomains,
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
        $subdomain = ($id ? $this->findOrFail($id) : new Subdomain());
        if ($id) {
            $title = 'Edit Subdomain';
        } else {
            $title = 'Create Subdomain';
        }

        return view('backend.subdomains.form')->with([
            'subdomain' => $subdomain,
            'title' => $title,
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
        $subdomain = (!$id ?: $this->findOrFail($id));

        $fillData = [
            'name' => $request->get('name'),
            'fullname' => $request->get('fullname'),
            'title' => $request->get('title'),
            'description' => $request->get('description'),
        ];

        $rules = Subdomain::getValidationRules();
        if (!$id) {
            $rules['image'] .= '|required';
        }

        $this->validate($request, $rules);

        if ($id) {
            $subdomain->fill($fillData);
        } else {
            $subdomain = Subdomain::create($fillData);
        }

        if (Input::hasFile('image')) {
            $subdomain->setImage('image');
        }


        $subdomain->save();

        \Session::flash('alert-success', 'The subdomain was successfully saved');
        return redirect()->route('backend::subdomains::list');
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
        $subdomain = $this->findOrFail($id);
        $subdomain->delete();
        return redirect()->route('backend::subdomains::list')->with('alert-success', 'The subdomain was successfully deleted');
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
        $subdomain = $this->findOrFail($id);
        $subdomain->restore();
        return redirect()->route('backend::subdomains::list')->with('alert-success', 'The subdomain was successfully restored');
    }

    /**
     * @return \Illuminate\Database\Query\Builder
     */
    protected function findQuery()
    {
        return Subdomain::withTrashed();
    }

    protected function findOrFail($id)
    {
        return $this->findQuery()->findOrFail($id);
    }

}
