<?php

namespace App\Http\Controllers;

use App\Discipline;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DisciplineController extends Controller
{
    public function index(Request $request)
    {
        $orderBySession = \Session::get('orderBy', 'created_at');
        $orderBy = $request->input('order', $orderBySession);

        $orderDirSession = \Session::get('orderDir', 'desc');
        $orderDir = $request->input('dir', $orderDirSession);

        $page = $request->input('page');
        $query = $request->input('query', '');


        if (!in_array($orderBy, Discipline::sortable())) {
            $orderBy = 'id';
        }

        if (!in_array($orderDir, ['asc', 'ASC', 'desc', 'DESC'])) {
            $orderDir = 'desc';
        }

        \Session::put('orderBy', $orderBy);
        \Session::put('orderDir', $orderDir);

        $disciplines = Discipline::orderBy($orderBy, $orderDir);

        $disciplines = $disciplines->paginate(10);

        return view('disciplines.list')->with([
            'disciplines' => $disciplines,
            'order_field' => $orderBy,
            'dir' => $orderDir,
            'page' => $page,
            'query' => $query
        ]);
    }

    public function edit(Request $request, $id = null)
    {
        $discipline = (!$id ?: Discipline::findOrFail($id));

        $this->validate($request, Discipline::getValidationRules());

        if ($id) {
            $discipline->fill($request->all());
        } else {
            $discipline = new Discipline($request->all());
        }

        $discipline->user()->associate(Auth::user());

        $discipline->save();

        \Session::flash('alert-success', 'The discipline was successfully saved');//todo
        return redirect()->route('teacherOnly::disciplines::list');
    }

    public function delete(Request $request, $id)
    {
        $discipline = Discipline::findOrFail($id);
        $discipline->delete();
        return redirect()->route('teacherOnly::disciplines::list')->with('alert-success', 'The discipline was successfully deleted');//todo
    }

    public function showForm(Request $request, $id = null)
    {
        $discipline = ($id ? Discipline::findOrFail($id) : new Discipline());
        if ($id) {
            $title = trans('discipline.edit');
        } else {
            $title = trans('discipline.create');
        }

        return view('disciplines.form')->with([
            'discipline' => $discipline,
            'title' => $title,
            'participants' => $discipline->students,
            'students' => Auth::user()->students,
            'included_problems' => $discipline->problems
        ]);
    }
}