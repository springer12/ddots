<?php

namespace App\Http\Controllers\Backend;

use App\News;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $orderBySession = \Session::get('orderBy', 'updated_at');
        $orderBy = $request->input('order', $orderBySession);

        $orderDirSession = \Session::get('orderDir', 'desc');
        $orderDir = $request->input('dir', $orderDirSession);

        $page = $request->input('page');
        $query = $request->input('query', '');

        if (!in_array($orderBy, News::sortable())) {
            $orderBy = 'id';
        }

        if (!in_array($orderDir, ['asc', 'ASC', 'desc', 'DESC'])) {
            $orderDir = 'desc';
        }

        \Session::put('orderBy', $orderBy);
        \Session::put('orderDir', $orderDir);

        $news = $this->findQuery();

        if ($query) {
            $news = $news->where(function ($query_s) use ($query) {
                $query_s->orwhere('id', 'like', "%$query%")
                    ->orwhere('name', 'like', "%$query%");
            });
        }
        $subdomain_id = $request->get('subdomain_id');
        if ($subdomain_id) {
            $news = $news->where('subdomain_id', $subdomain_id);
        }

        $news = $news->orderBy($orderBy, $orderDir)
            ->paginate(10);

        return view('backend.news.list')->with([
            'news' => $news,
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
        $news = ($id ? $this->findOrFail($id) : new News());
        if ($id) {
            $title = 'Edit News';
        } else {
            $title = 'Create News';
        }

        return view('backend.news.form')->with([
            'news' => $news,
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
        $news = (!$id ?: $this->findOrFail($id));
        $rules = News::getValidationRules();

        $this->validate($request, $rules);

        //dd($request->all());

        if ($id) {
            $news->fill($request->all());
        } else {
            $news = new News($request->all());
        }
        $news->show_on_main = (bool)$request->get('show_on_main');
        $news->save();

        \Session::flash('alert-success', 'The news was successfully saved');
        return redirect()->route('backend::news::list');
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
        $news = $this->findOrFail($id);
        $news->delete();
        return redirect()->route('backend::news::list')->with('alert-success', 'The news was successfully deleted');
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
        $news = $this->findOrFail($id);
        $news->restore();
        return redirect()->route('backend::news::list')->with('alert-success', 'The news was successfully restored');
    }

    /**
     * @return \Illuminate\Database\Query\Builder
     */
    protected function findQuery()
    {
        return News::withTrashed();
    }

    protected function findOrFail($id)
    {
        return $this->findQuery()->findOrFail($id);
    }

}
