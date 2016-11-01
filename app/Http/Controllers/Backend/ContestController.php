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

        if($orderBy == 'owner') {
            $contests = Contest::join('users', 'users.id', '=', 'user_id')
                ->groupBy('contests.id')
                ->orderBy('users.name', $orderDir)
                ->select('contests.*');
        } else {
            $contests = Contest::orderBy($orderBy, $orderDir);
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
        //@todo ajax problems
        $contest = ($id ? Contest::findOrFail($id) : new Contest());
        $old_owner = null;
        if ($id) {
            $title = 'Edit Contest';
            if (Session::get('errors')) {

                $old_owner = User::find(old('owner'));
                $participants = User::user()->whereIn('id', old('participants'))->get();
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
        } else {
            $title = 'Create Contest';
            $participants = collect();
            $unincluded_problems = Problem::orderBy('name', 'desc')->get();
            $included_problems = collect();
        }


        return view('backend.contests.form')->with([
            'contest' => $contest,
            'title' => $title,
            'participants' => $participants,
            'old_owner' => $old_owner,
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
