<?php

namespace App\Http\Controllers\Backend;


use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\ProgrammingLanguage;

class ProgrammingLanguageController extends Controller
{
    public function index(Request $request)
    {
        $orderBySession = \Session::get('orderBy', 'updated_at');
        $orderBy = $request->input('order', $orderBySession);

        $orderDirSession = \Session::get('orderDir', 'desc');
        $orderDir = $request->input('dir', $orderDirSession);

        $page = $request->input('page');
        $query = $request->input('query', '');

        if (!in_array($orderBy, ProgrammingLanguage::sortable())) {
            $orderBy = 'id';
        }

        if (!in_array($orderDir, ['asc', 'ASC', 'desc', 'DESC'])) {
            $orderDir = 'desc';
        }

        \Session::put('orderBy', $orderBy);
        \Session::put('orderDir', $orderDir);

        $programming_languages = $this->findQuery();

        if ($query) {
            $programming_languages = $programming_languages->where(function ($query_s) use ($query) {
                $query_s->orwhere('id', 'like', "%$query%")
                    ->orwhere('name', 'like', "%$query%")
                    ->orwhere('nickname', 'like', "%$query%")
                    ->orwhere('email', 'like', "%$query%");
            });
        }

        $programming_languages = $programming_languages->orderBy($orderBy, $orderDir)
            ->paginate(10);

        return view('backend.programming_languages.list')->with([
            'programming_languages' => $programming_languages,
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
        $programming_language = ($id ? $this->findOrFail($id) : new ProgrammingLanguage());
        if ($id) {
            $title = 'Edit Programming Language';
        } else {
            $title = 'Create Programming Language';
        }

        return view('backend.programming_languages.form')->with([
            'programming_language' => $programming_language,
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
        $programming_language = (!$id ?: $this->findOrFail($id));

        $fillData = [
            'name' => $request->get('name'),
            'ace_mode' => $request->get('ace_mode'),
            'compiler_image' => $request->get('compiler_image'),
            'executor_image' => $request->get('executor_image'),
        ];

        $this->validate($request, ProgrammingLanguage::getValidationRules());

        if ($id) {
            $programming_language->fill($fillData);
        } else {
            $programming_language = ProgrammingLanguage::create($fillData);
        }

        $programming_language->save();

        \Session::flash('alert-success', 'The programming language was successfully saved');
        return redirect()->route('backend::programming_languages::list');
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
        $programming_language = $this->findOrFail($id);
        $programming_language->delete();
        return redirect()->route('backend::programming_languages::list')->with('alert-success', 'The programming language was successfully deleted');
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
        $programming_language = $this->findOrFail($id);
        $programming_language->restore();
        return redirect()->route('backend::programming_languages::list')->with('alert-success', 'The programming language was successfully restored');
    }

    /**
     * @return \Illuminate\Database\Query\Builder
     */
    protected function findQuery()
    {
        return ProgrammingLanguage::withTrashed();
    }

    protected function findOrFail($id)
    {
        return $this->findQuery()->findOrFail($id);
    }

}
