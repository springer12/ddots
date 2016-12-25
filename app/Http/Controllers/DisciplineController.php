<?php

namespace App\Http\Controllers;

use App\Contest;
use App\Discipline;
use App\Problem;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

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
        $discipline->problems()->sync((array)$request->get('problems'));
        $discipline->students()->sync((array)$request->get('participants'));
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
        $discipline = ($id ? Discipline::find($id) : new Discipline());
        if ($id) {
            $title = trans('discipline.edit');
        } else {
            $title = trans('discipline.create');
        }

        $participants = collect();
        $students = Auth::user()->students()->where('confirmed', 1)->get();
        if (Session::get('errors')) {
            foreach ($students as $student) {
                if (in_array($student->id, (array)old('participants'))) {
                    $participants->push($student);
                }
            }
            $included_problems = Problem::orderBy('name', 'desc')->whereIn('id', (array)old('problems'))->get();
        } else {
            $included_problems = $discipline->problems;
            $participants = $discipline->students;
        }

        return view('disciplines.form')->with([
            'discipline' => $discipline,
            'title' => $title,
            'participants' => $participants,
            'students' => Auth::user()->students->diff($participants),
            'included_problems' => $included_problems
        ]);
    }

    public function single(Request $request, $id)
    {

        $discipline = Discipline::findOrFail($id);
        $orderBySession = \Session::get('orderByStudents', 'updated_at');
        $orderByStudents = $request->input('order_students', $orderBySession);

        $orderDirSession = \Session::get('orderDirStudents', 'desc');
        $orderDirStudents = $request->input('dir_students', $orderDirSession);

        if (!in_array($orderByStudents, User::sortable())) {
            $orderByStudents = 'id';
        }

        if (!in_array($orderDirStudents, ['asc', 'ASC', 'desc', 'DESC'])) {
            $orderDirStudents = 'desc';
        }

        \Session::put('orderByStudents', $orderByStudents);
        \Session::put('orderDirStudents', $orderDirStudents);

        $students = $discipline->students()->orderBy($orderByStudents, $orderDirStudents)
            ->paginate(3, ['*'], 'page_students');

        $orderBySession = \Session::get('orderByProblems', 'updated_at');
        $orderByProblems = $request->input('order_problems', $orderBySession);

        $orderDirSession = \Session::get('orderDirProblems', 'desc');
        $orderDirProblems = $request->input('dir_problems', $orderDirSession);

        if (!in_array($orderByProblems, Problem::sortable())) {
            $orderByProblems = 'id';
        }

        if (!in_array($orderDirProblems, ['asc', 'ASC', 'desc', 'DESC'])) {
            $orderDirProblems = 'desc';
        }

        \Session::put('orderByProblems', $orderByProblems);
        \Session::put('orderDirProblems', $orderDirProblems);

        $problems = $discipline->problems()->orderBy($orderByProblems, $orderDirProblems)
            ->paginate(3, ['*'], 'page_problems');

        $orderBySession = \Session::get('orderByContests', 'updated_at');
        $orderByContests = $request->input('order_contests', $orderBySession);

        $orderDirSession = \Session::get('orderDirContests', 'desc');
        $orderDirContests = $request->input('dir_contests', $orderDirSession);

        if (!in_array($orderByContests, Contest::sortable())) {
            $orderByContests = 'id';
        }

        if (!in_array($orderDirContests, ['asc', 'ASC', 'desc', 'DESC'])) {
            $orderDirContests = 'desc';
        }

        \Session::put('orderByContests', $orderByContests);
        \Session::put('orderDirContests', $orderDirContests);

        $contests = $discipline->contests()->orderBy($orderByContests, $orderDirContests)
            ->paginate(3, ['*'], 'page_contests');

        return view('disciplines.single')->with([
            'discipline' => $discipline,
            'students' => $students,
            'order_field_students' => $orderByStudents,
            'dir_students' => $orderDirStudents,
            'contests' => $contests,
            'order_field_contests' => $orderByContests,
            'dir_contests' => $orderDirContests,
            'problems' => $problems,
            'order_field_problems' => $orderByProblems,
            'dir_problems' => $orderDirProblems,
        ]);
    }
}