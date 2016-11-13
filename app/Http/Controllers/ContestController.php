<?php

namespace App\Http\Controllers;

use App\Contest;
use App\Problem;
use Carbon\Carbon;
use Illuminate\Http\Request;

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

        if ($orderBy == 'owner') {
            $contests = Contest::join('users', 'users.id', '=', 'user_id')
                ->groupBy('contests.id')
                ->orderBy('users.name', $orderDir)
                ->select('contests.*');
        } else {
            $contests = Contest::orderBy($orderBy, $orderDir);
        }

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
        $participants = collect();
        $students = Auth::user()->students()->where('confirmed', 1)->get();
        if ($id) {
            $title = 'Edit Contest';
            if (Session::get('errors')) {
                foreach ($students as $student) {
                    if (in_array($student->id, (array)old('participants'))) {
                        $participants->push($student);
                    }
                }
                $included_problems = Problem::orderBy('name', 'desc')->whereIn('id', (array)old('problems'))->get();
            } else {
                $participants = $contest->users()->user()->get();
                $included_problems = $contest->problems()->withPivot('max_points')->get();
            }
            $students = $students->diff($participants);
        } else {
            $title = 'Create Contest';
            $included_problems = collect();
        }

        return view('contests.form')->with([
            'contest' => $contest,
            'title' => $title,
            'students' => $students,
            'participants' => $participants,
            'programming_languages' => ProgrammingLanguage::orderBy('name', 'desc')->get(),
            'included_problems' => $included_problems,
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
            'user_id' => Auth::user()->id,
            'is_active' => $request->get('is_active'),
            'is_standings_active' => $request->get('is_standings_active'),
            'show_max' => $request->get('show_max'),
        ];

        $this->validate($request, Contest::getValidationRules(), ['programming_languages.required' => 'At least one language must be selected.']);


        if ($id) {
            $contest->fill($fillData);
        } else {
            $contest = Contest::create($fillData);
        }

        $contest->programming_languages()->sync($request->get('programming_languages') ? $request->get('programming_languages') : []);

        $contest->problems()->sync($request->get('problems') ? array_combine($request->get('problems'), array_map(function ($a) {
            return ['max_points' => $a];
        }, $request->get('points'))) : []);

        $contest->users()->sync((array)$request->get('participants'));

        $contest->save();

        \Session::flash('alert-success', 'The contest was successfully saved');
        return redirect()->route('frontend::contests::list');
    }

    public function hide(Request $request, $id)
    {
        $contest = Contest::findOrFail($id);
        $contest->hide();
        $contest->save();
        return redirect()->route('frontend::contests::list');
    }

    public function show(Request $request, $id)
    {
        $contest = Contest::findOrFail($id);
        $contest->show();
        $contest->save();
        return redirect()->route('frontend::contests::list');
    }

    public function single(Request $request, $id)
    {
        $contest = Contest::findOrFail($id);
        return View('contests.single')->with(['contest' => $contest]);
    }

    //@todo:1 min results array cache could be temporary solution
    public function standings(Request $request, $id) //@todo add results cache, invalidate cache when new solutions are comming
    {
        $contest = Contest::findOrFail($id);

        $totals   = [];
        $problems = $contest->problems;
        $results  = [];

        foreach ($contest->users as $user) {
            $result = [
                'total'    => $contest->getUserTotalResult($user),
                'user'     => $user,
                'last_standings_solution_at' => Carbon::createFromTimestamp(0),
            ];

            foreach ($problems as $problem) {
                if($user->haveSolutions($contest, $problem)) {
                    $solution = $contest->getStandingsSolution($user, $problem);
                    $result['last_standings_solution_at'] = $result['last_standings_solution_at'] > $solution->created_at ?: $solution->created_at;
                    $result['solutions'][$problem->id] = $solution;
                } else {
                    $result['solutions'][$problem->id] = null;
                }
            }

            $results[] = $result;
        }
        usort($results, function($a, $b) {
            if($a['total'] != $b['total']) {
                return $a['total'] == $b['total'] ? 0 : ($a['total'] > $b['total'] ? -1 : 1);
            }

            if($a['last_standings_solution_at'] != $b['last_standings_solution_at']) {
                return $a['last_standings_solution_at'] == $b['last_standings_  solution_at'] ? 0 : ($a['last_standings_solution_at'] > $b['last_standings_solution_at'] ? -1 : 1);
            }

            return $a['user']->name > $b['user']->name ? 1 : -1;
        });

        $totals = $this->getStandingsTotals($contest, $results);

        return View('contests.standings')->with([
            'contest'  => $contest,
            'results'  => $results,
            'problems' => $problems,
            'totals'   => $totals,
        ]);

    }

    protected function getStandingsTotals(Contest $contest, $results) {
        $totals = [];

        if(count($results)) {
            $totals['total_avg'] = 0;
            foreach ($results as $result) {
                $totals['total_avg'] += $result['total'];
            }
            $totals['total_avg'] /= count($results);


            $totals['avg_by_problems'] = [];
            foreach ($contest->problems as $problem) {
                $totals['avg_by_problems'][$problem->id] = [
                    'total' => 0,
                    'count' => 0,
                ];
            }

            foreach ($results as $result) {
                foreach ($result['solutions'] as $solution) {
                    if(!$solution) {
                        continue;
                    }

                    $totals['avg_by_problems'][$solution->problem_id]['total'] += $solution->success_percentage * $contest->getProblemMaxPoints($solution->problem_id) / 100;
                    $totals['avg_by_problems'][$solution->problem_id]['count']++;
                }
            }
            $mapped_avgs = [];
            foreach ($totals['avg_by_problems'] as $problem_id => $avg_by_problem) {
                $mapped_avgs[$problem_id] = $avg_by_problem['total'] /= $avg_by_problem['count'];
            }
            $totals['avg_by_problems'] = $mapped_avgs;
        }

        return $totals;
    }
}
