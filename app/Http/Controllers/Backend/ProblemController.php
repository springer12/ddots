<?php

namespace App\Http\Controllers\Backend;

use App\Problem;
use App\Volume;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ProblemController extends Controller
{
    public function index(Request $request)
    {
        $orderBySession = \Session::get('orderBy', 'updated_at');
        $orderBy = $request->input('order', $orderBySession);

        $orderDirSession = \Session::get('orderDir', 'desc');
        $orderDir = $request->input('dir', $orderDirSession);

        $page = $request->input('page');
        $query = $request->input('query', '');

        if (!in_array($orderBy, Problem::sortable())) {
            $orderBy = 'id';
        }

        if (!in_array($orderDir, ['asc', 'ASC', 'desc', 'DESC'])) {
            $orderDir = 'desc';
        }

        \Session::put('orderBy', $orderBy);
        \Session::put('orderDir', $orderDir);

        $problems = $this->findQuery();

        if ($query) {
            $problems = $problems->where(function($query_s) use ($query) {
                $query_s->orwhere('id', 'like', "%$query%")
                    ->orwhere('name', 'like', "%$query%");
            });
        }

        $problems = $problems->orderBy($orderBy, $orderDir)
            ->paginate(10);

        return view('backend.problems.list')->with([
            'problems'    => $problems,
            'order_field' => $orderBy,
            'dir'         => $orderDir,
            'page'        => $page,
            'query'       => $query
        ]);
    }

    /**
     * Show the form.
     *
     * @param \Illuminate\Http\Request $request
     * @param int|null                 $id
     *
     * @return \Illuminate\Http\Response
     */
    public function showForm(Request $request, $id = null) {
        $problem = ($id ? $this->findOrFail($id) : new Problem());
        if ($id) {
            $title = 'Edit Problem';
        } else {
            $title = 'Create Problem';
        }

        return view('backend.problems.form')->with([
            'problem' => $problem,
            'title'   => $title
        ]);
    }

    /**
     * Handle a add/edit request
     *
     * @param \Illuminate\Http\Request $request
     * @param int|null                 $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id = null) {
        $problem = (!$id ?: $this->findOrFail($id));

        $this->validate($request, [
            'name'      => 'required|string|max:255', //@todo:to model
            'archive'   => 'required',
            'volumes'   => 'array'
        ]);


        if ($id) {
            $problem->fill(['name' => $request->get('name')]);
        } else {
            $problem = new Problem(['name' => $request->get('name')]);
        }
        $problem->save();

        $new_volumes = [];
        foreach ($request->get('volumes') as $key => $volume) {
            if(!is_numeric($volume)) {
                $new_volumes[] = Volume::create(['name' => $volume])->id;
            } else {
                $new_volumes[] = $volume;
            }
        }

        $problem->volumes()->sync($new_volumes);

        \Session::flash('alert-success', 'The problem was successfully saved');
        return redirect()->route('backend::problems::list');
    }

    /**
     * Handle a delete request
     *
     * @param int|null                 $id
     *
     * @return \Illuminate\Http\Response
     */
    public function delete($id) {
        $problem = $this->findOrFail($id);
        $problem->delete();
        return redirect()->route('backend::problems::list')->with('alert-success', 'The problem was successfully deleted');
    }

    /**
     * Handle a restore request
     *
     * @param int|null                 $id
     *
     * @return \Illuminate\Http\Response
     */
    public function restore($id) {
        $problem = $this->findOrFail($id);
        $problem->restore();
        return redirect()->route('backend::problems::list')->with('alert-success', 'The problem was successfully restored');
    }

    /**
     * @return \Illuminate\Database\Query\Builder
     */
    protected function findQuery() {
        return Problem::withTrashed();
    }

    protected function findOrFail($id) {
        return $this->findQuery()->findOrFail($id);
    }

}
