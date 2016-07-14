<?php

namespace App\Http\Controllers;

use App\Contest;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use App\ProgrammingLanguage;

class ContestController extends Controller
{
    public function index(Request $request) {
        $orderBySession = \Session::get('orderBy', 'updated_at');
        $orderBy = $request->input('order', $orderBySession);

        $orderDirSession = \Session::get('orderDir', 'desc');
        $orderDir = $request->input('dir', $orderDirSession);

        $page = $request->input('page');
        $query = $request->input('query', '');



        if (!in_array($orderBy, Contest::sortable())) {
            $orderBy = 'id';
        }

        if (!in_array($orderDir, ['asc', 'ASC', 'desc', 'DESC'])) {
            $orderDir = 'desc';
        }

        \Session::put('orderBy', $orderBy);
        \Session::put('orderDir', $orderDir);



        $contests = Contest::orderBy($orderBy, $orderDir)
            ->paginate(10);

        return view('contests.list')->with([
            'contests' => $contests,
            'order_field' => $orderBy,
            'dir' => $orderDir,
            'page' => $page,
            'query' => $query
        ]);
    }
    public function showForm(Request $request, $id = null)
    {
        $contest = ($id ? Contest::findOrFail($id) : new Contest());
        if ($id) {
            $title = 'Edit Contest';
            $participants = $contest->users()->user()->get();
        } else {
            $title = 'Create Contest';
            $participants = null;
        }

        $students = Auth::user()->students()->get()->diff($participants);
        
        return view('contests.form')->with([
            'contest' => $contest,
            'title' => $title,
            'students' => $students,
            'participants' => $participants,
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
        $contest = (!$id ?: Contest::findOrFail($id));
        $fillData = [
            'name' => $request->get('name'),
            'description' => $request->get('description'),
            'user_id' => Auth::user()->id,
            'start_date' => $request->get('start_date'),
            'end_date' => $request->get('end_date'),
            'is_active' => $request->get('is_active'),
            'is_standings_active' => $request->get('is_standings_active'),
        ];

        $this->validate($request, Contest::getValidationRules());

        if ($id) {
            $contest->fill($fillData);
        } else {
            $contest = Contest::create($fillData);
        }

        $contest->programming_languages()->detach();
        $contest->programming_languages()->attach($request->get('programming_languages'));



        foreach(Auth::user()->students as $student) {
            $contest->users()->detach($student->id);
        }

        $contest->users()->attach($request->get('participants'));
        
        $contest->save();

        \Session::flash('alert-success', 'The contest was successfully saved');
        return redirect()->route('teacherOnly::contests::list');
    }

}
