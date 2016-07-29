<?php

namespace App\Http\Controllers\Backend;

use App\Contest;
use App\Problem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Http\Requests;
use App\ProgrammingLanguage;
use App\User;

class ContestController extends Controller
{
    public function index(Request $request)
    {
        $orderBySession = \Session::get('orderBy', 'created_at');
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

        $contests = Contest::orderBy($orderBy, $orderDir);
        if (Auth::user()->hasRole(User::ROLE_TEACHER)) {
            $contests = $contests->where('user_id', Auth::user()->id);
        } elseif (Auth::user()->hasRole(User::ROLE_USER)) {
            $contests = $contests->whereHas('users', function ($query) {
                $query->where('user_id', Auth::user()->id);
            })->where('is_active', true)->orWhere('labs', true);
        } elseif (Auth::user()->hasRole(User::ROLE_LOW_USER)) {
            $contests = $contests->where('labs', true)->where('is_active', true);
        }
        $contests = $contests->paginate(10);

        return view('backend.contests.list')->with([
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
        $participants = collect();
        $students = User::user()->get();
        if ($id) {
            $title = 'Edit Contest';
            if (Session::get('errors')) {
                foreach ($students as $student) {
                    if (in_array($student->id, (array)old('participants'))) {
                        $participants->push($student);
                    }
                }

                $included_problems = collect();
                $problems = Problem::orderBy('name', 'desc')->get();

                foreach ($problems as $problem) {
                    if (in_array($problem->id, (array)old('problems'))) {
                        $included_problems->push($problem);
                    }
                }
                $unincluded_problems = $problems->diff($included_problems);

            } else {
                $participants = $contest->users()->user()->get();
                $included_problems = $contest->problems;
                $unincluded_problems = Problem::orderBy('name', 'desc')->get()->diff($included_problems);
            }
            $students = $students->diff($participants);
        } else {
            $title = 'Create Contest';
            $unincluded_problems = Problem::orderBy('name', 'desc')->get();
            $included_problems = collect();
        }


        return view('backend.contests.form')->with([
            'contest' => $contest,
            'title' => $title,
            'students' => $students,
            'participants' => $participants,
            'programming_languages' => ProgrammingLanguage::orderBy('name', 'desc')->get(),
            'teachers' => User::teacher()->select(['id', 'name'])->get(),
            'included_problems' => $included_problems,
            'unincluded_problems' => $unincluded_problems
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
            'start_date' => $request->get('start_date'),
            'end_date' => $request->get('end_date'),
            'user_id' => $request->get('owner'),
            'is_active' => $request->get('is_active'),
            'is_standings_active' => $request->get('is_standings_active'),
            'show_max' => $request->get('show_max'),
            'labs' => $request->get('labs'),
        ];

        $rules = Contest::getValidationRules() + ['owner' => 'required|exists:users,id,role,' . User::ROLE_TEACHER];
        $this->validate($request, $rules, ['programming_languages.required' => 'At least one language must be selected.']);

        if ($id) {
            $contest->fill($fillData);
        } else {
            $contest = Contest::create($fillData);
        }

        $contest->programming_languages()->sync($request->get('programming_languages') ? $request->get('programming_languages') : []);

        $contest->problems()->sync($request->get('problems') ? array_combine($request->get('problems'), array_map(function ($a) {
            return ['max_points' => $a];
        }, $request->get('problem_points'))) : []);

        $contest->users()->sync((array)$request->get('participants'));

        $contest->save();

        \Session::flash('alert-success', 'The contest was successfully saved');
        return redirect()->route('backend::contests::list');
    }

    public function hide(Request $request, $id)
    {
        $contest = Contest::findOrFail($id);
        $contest->hide();
        $contest->save();
        return redirect()->route('backend::contests::list');
    }

    public function show(Request $request, $id)
    {
        $contest = Contest::findOrFail($id);
        $contest->show();
        $contest->save();
        return redirect()->route('backend::contests::list');
    }
}
