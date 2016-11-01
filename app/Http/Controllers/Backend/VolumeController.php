<?php

namespace App\Http\Controllers\Backend;

use App\Volume;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VolumeController extends Controller
{
    public function index(Request $request)
    {
        $orderBySession = \Session::get('orderBy', 'updated_at');
        $orderBy = $request->input('order', $orderBySession);

        $orderDirSession = \Session::get('orderDir', 'desc');
        $orderDir = $request->input('dir', $orderDirSession);

        $page = $request->input('page');
        $query = $request->input('query', '');

        if (!in_array($orderBy, Volume::sortable())) {
            $orderBy = 'id';
        }


        if (!in_array($orderDir, ['asc', 'ASC', 'desc', 'DESC'])) {
            $orderDir = 'desc';
        }

        \Session::put('orderBy', $orderBy);
        \Session::put('orderDir', $orderDir);

        $volumes = $this->findQuery();

        if ($query) {
            $volumes = $volumes->where(function ($query_s) use ($query) {
                $query_s->orwhere('id', 'like', "%$query%")
                    ->orwhere('name', 'like', "%$query%");
            });
        }

        $volumes = $volumes->paginate(10);

        return view('backend.volumes.list')->with([
            'volumes' => $volumes,
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
        $volume = ($id ? $this->findOrFail($id) : new Volume());
        if ($id) {
            $title = 'Edit Volume';
        } else {
            $title = 'Create Volume';
        }

        return view('backend.volumes.form')->with([
            'volume' => $volume,
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
        $volume = (!$id ?: $this->findOrFail($id));

        $rules = Volume::getValidationRules();

        $this->validate($request, $rules);

        if ($id) {
            $volume->fill($request->all());
        } else {
            $volume = Volume::create($request->all());
        }

        $volume->problems()->sync($request->get('problems', []));
        $volume->save();

        \Session::flash('alert-success', 'The volume was successfully saved');
        return redirect()->route('backend::volumes::list');
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
        $volume = $this->findOrFail($id);
        $volume->delete();
        return redirect()->route('backend::volumes::list')->with('alert-success', 'The volume was successfully deleted');
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
        $volume = $this->findOrFail($id);
        $volume->restore();
        return redirect()->route('backend::volumes::list')->with('alert-success', 'The volume was successfully restored');
    }

    /**
     * @return \Illuminate\Database\Query\Builder
     */
    protected function findQuery()
    {
        return Volume::withTrashed();
    }

    protected function findOrFail($id)
    {
        return $this->findQuery()->findOrFail($id);
    }

}
