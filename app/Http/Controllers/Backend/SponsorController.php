<?php

namespace App\Http\Controllers\Backend;


use App\Sponsor;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class SponsorController extends Controller
{
    public function index(Request $request)
    {
        $orderBySession = \Session::get('orderBy', 'updated_at');
        $orderBy = $request->input('order', $orderBySession);

        $orderDirSession = \Session::get('orderDir', 'desc');
        $orderDir = $request->input('dir', $orderDirSession);

        $page = $request->input('page');
        $query = $request->input('query', '');

        if (!in_array($orderBy, Sponsor::sortable())) {
            $orderBy = 'id';
        }

        if (!in_array($orderDir, ['asc', 'ASC', 'desc', 'DESC'])) {
            $orderDir = 'desc';
        }

        \Session::put('orderBy', $orderBy);
        \Session::put('orderDir', $orderDir);

        $sponsors = $this->findQuery();

        if ($query) {
            $sponsors = $sponsors->where(function ($query_s) use ($query) {
                $query_s->orwhere('id', 'like', "%$query%")
                    ->orwhere('name', 'like', "%$query%");
            });
        }

        $sponsors = $sponsors->orderBy($orderBy, $orderDir)
            ->paginate(10);

        return view('backend.sponsors.list')->with([
            'sponsors' => $sponsors,
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
        $sponsor = ($id ? $this->findOrFail($id) : new Sponsor());
        if ($id) {
            $title = 'Edit Sponsor';
        } else {
            $title = 'Create Sponsor';
        }

        return view('backend.sponsors.form')->with([
            'sponsor' => $sponsor,
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
        $sponsor = !$id ?: $this->findOrFail($id);
        $fillData = [
            'name' => $request->get('name'),
            'description' => $request->get('description'),
            'show_on_main' => $request->get('show_on_main'),
        ];

        $rules = Sponsor::getValidationRules();
        if (!$id) {
            $rules['image'] .= '|required';
        }
        $this->validate($request, $rules);

        if ($id) {
            $sponsor->fill($fillData);
        } else {
            $sponsor = Sponsor::create($fillData);
        }

        $sponsor->subdomains()->sync((array)$request->get('subdomains'));

        if (Input::hasFile('image')) {
            $sponsor->setImage('image');
        }
        $sponsor->save();

        \Session::flash('alert-success', 'The sponsor was successfully saved');
        return redirect()->route('backend::sponsors::list');
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
        $sponsor = $this->findOrFail($id);
        $sponsor->delete();
        return redirect()->route('backend::sponsors::list')->with('alert-success', 'The sponsor was successfully deleted');
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
        $sponsor = $this->findOrFail($id);
        $sponsor->restore();
        return redirect()->route('backend::sponsors::list')->with('alert-success', 'The sponsor was successfully restored');
    }

    /**
     * @return \Illuminate\Database\Query\Builder
     */
    protected function findQuery()
    {
        return Sponsor::withTrashed();
    }

    protected function findOrFail($id)
    {
        return $this->findQuery()->findOrFail($id);
    }

}
