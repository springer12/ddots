<?php

namespace App\Http\Controllers;

use App\Contest;
use App\ContestProblemUser;
use App\Problem;
use App\Solution;
use Carbon\Carbon;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\ProgrammingLanguage;
use App\User;
use Psy\Util\Json;

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
                if ($contest->type != Contest::TYPE_EXAM && !old('is_exam')) {
                    $max_points = (array)old('points');
                    $time_penalty = (array)old('time_penalty');
                    $review = (array)old('review_required');
                    $included_problems = Problem::orderBy('name', 'desc')->whereIn('id', (array)old('problems'))->get();
                    foreach ($included_problems as $problem) {
                        $problem->max_points = $max_points[$problem->id];
                        $problem->time_penalty = $time_penalty[$problem->id];
                        $problem->review_required = isset($review[$problem->id]);
                    }
                } else {
                    $included_problems = [];
                    foreach (old('user_problems') as $key => $user_item) {
                        $included_problems[$key] = json_decode($user_item, true);
                    }
                    $included_problems = Json::encode($included_problems);
                }
            } else {
                $participants = $contest->users()->user()->get();
                if ($contest->type != Contest::TYPE_EXAM && !old('is_exam')) {
                    $included_problems = $contest->problems()->withPivot('max_points', 'review_required', 'time_penalty')->get();
                } else {
                    $included_problems = [];
                    foreach ($contest->problemUsers as $cpu) {
                        $included_problems[$cpu->user_id][$cpu->problem_id] = [
                            'max_points' => $cpu->max_points,
                            'review_required' => $cpu->review_required,
                            'time_penalty' => $cpu->time_penalty,
                            'name' => $cpu->problem->name,
                        ];
                    }
                    $included_problems = Json::encode($included_problems);
                }
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

        $this->validate($request, Contest::getValidationRules($request->has('is_exam')), ['programming_languages.required' => 'At least one language must be selected.']);

        if ($id) {
            $contest->fill($request->except('labs'));
        } else {
            $contest = Contest::create($request->except('labs') + ['user_id' => Auth::user()->id]);
        }

        if ($request->has('is_exam')) {
            $contest->type = Contest::TYPE_EXAM;
            $contest->is_acm = false;
        } else {
            $contest->is_acm = $request->has('is_acm');
        }

        $contest->is_active = $request->has('is_active');
        $contest->is_standings_active = $request->has('is_standings_active');
        if ($contest->is_acm) {
            $contest->show_max = false;
        } else {
            $contest->show_max = $request->has('show_max');
        }

        $contest->programming_languages()->sync($request->get('programming_languages') ? $request->get('programming_languages') : []);

        if ($contest->type != Contest::TYPE_EXAM) {
            $contest_problems = [];
            $reviews = $request->get('review_required');
            $points = $request->get('points');
            $time_penalties = $request->get('time_penalty');
            foreach ($request->get('problems', []) as $problem) {
                $contest_problems[$problem] = [
                    'max_points' => $points[$problem],
                    'review_required' => isset($reviews[$problem]),
                    'time_penalty' => $time_penalties[$problem],
                ];
            }

            $contest->problems()->sync($contest_problems);
            $contest->users()->sync((array)$request->get('participants'));
        } else {
            $contest->users()->sync($request->get('participants', []));
            $contest->problems()->sync([]);
            $user_problems = $request->get('user_problems', []);
            ContestProblemUser::where('contest_id', $contest->id)->delete();
            foreach ($request->get('participants', []) as $user) {
                if (isset($user_problems[$user])) {
                    $user_problem = json_decode($user_problems[$user], true);
                    foreach ($user_problem as $problem_id => $problem) {
                        ContestProblemUser::create([
                            'user_id' => $user,
                            'problem_id' => $problem_id,
                            'contest_id' => $contest->id,
                            'max_points' => $problem['max_points'],
                            'time_penalty' => $problem['time_penalty'],
                            'review_required' => $problem['review_required'],
                        ]);
                    }
                }
            }
        }

        $contest->save();

        \Session::flash('alert-success', 'The contest was successfully saved');
        return redirect()->route('frontend::contests::single', ['id' => $contest->id]);
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
        $problems = $contest->problems;
        $results = [];
        if (!$contest->is_acm) {
            foreach ($contest->users as $user) {
                $result = [
                    'total' => $contest->getUserTotalResult($user),
                    'user' => $user,
                    'last_standings_solution_at' => Carbon::createFromTimestamp(0),
                ];

                foreach ($problems as $problem) {
                    if ($user->haveSolutions($contest, $problem)) {
                        $solution = $contest->getStandingsSolution($user, $problem);
                        $result['last_standings_solution_at'] = $result['last_standings_solution_at'] > $solution->created_at ?: $solution->created_at;
                        $result['solutions'][$problem->id] = $solution;
                    } else {
                        $result['solutions'][$problem->id] = null;
                    }
                }

                $results[] = $result;
            }
            usort($results, function ($a, $b) {
                if ($a['total'] != $b['total']) {
                    return $a['total'] == $b['total'] ? 0 : ($a['total'] > $b['total'] ? -1 : 1);
                }

                if ($a['last_standings_solution_at'] != $b['last_standings_solution_at']) {
                    return $a['last_standings_solution_at'] == $b['last_standings_solution_at'] ? 0 : ($a['last_standings_solution_at'] > $b['last_standings_solution_at'] ? -1 : 1);
                }

                return $a['user']->name > $b['user']->name ? 1 : -1;
            });

            $totals = $this->getStandingsTotals($contest, $results);
        } else {

            $template = ['users_attempted' => 0, 'attempts' => 0, 'correct_solutions' => 0];
            foreach (Solution::getStatuses() as $status) {
                $template['statuses'][$status]['count'] = 0;
            }
            $totals = $template;
            foreach ($contest->problems()->withPivot('time_penalty')->get() as $problem) {
                $totals[$problem->id] = $template;
            }
            foreach ($contest->users as $user) {
                $total_solutions = 0;
                $correct_solutions = 0;
                $result = [
                    'user' => $user,
                    'total' => 0,
                    'time' => 0,
                ];
                foreach ($contest->problems as $problem) {
                    $final_solution = false;
                    $solutions = $contest->solutions()->where('user_id', $user->id)->where('problem_id', $problem->id)->orderBy('created_at')->get();
                    if (!$solutions->isEmpty()) {
                        $totals[$problem->id]['users_attempted']++;
                    }
                    $result[$problem->id]['solved'] = false;
                    $result[$problem->id]['attempts'] = 0;
                    foreach ($solutions as $index => $solution) {
                        $totals[$problem->id]['statuses'][$solution->status]['count']++;
                        $result[$problem->id]['attempts']++;
                        $total_solutions++;
                        $totals[$problem->id]['attempts']++;
                        $final_solution = $solution;
                        if ($solution->status === Solution::STATUS_OK) {
                            $totals[$problem->id]['correct_solutions']++;
                            $result[$problem->id]['solution_id'] = $solution->id;
                            $correct_solutions++;
                            $result[$problem->id]['solved'] = true;
                            break;
                        }
                    }
                    if ($final_solution) {
                        $result[$problem->id]['time'] = ($result[$problem->id]['attempts'] > 1 ? ($result[$problem->id]['attempts'] - 1) * $problem->pivot->time_penalty : 0) + (int)(($final_solution->created_at->getTImeStamp() - $contest->start_date->getTimestamp()) / 60);
                        $result['time'] += $result[$problem->id]['time'];
                        if ($result[$problem->id]['solved']) {
                            $result['total']++;
                        }
                    } else {
                        $result[$problem->id]['time'] = 0;
                    }
                }

                if ($total_solutions) {
                    $result['error_percentage'] = ($total_solutions - $correct_solutions) / $total_solutions * 100;
                } else {
                    $result['error_percentage'] = 0;
                }
                $results[] = $result;
            }

            foreach ($contest->problems as $problem) {
                $totals['attempts'] += $totals[$problem->id]['attempts'];
                $totals['users_attempted'] += $totals[$problem->id]['users_attempted'];
                $totals['correct_solutions'] += $totals[$problem->id]['correct_solutions'];
                foreach (Solution::getStatuses() as $status) {
                    $totals['statuses'][$status]['count'] += $totals[$problem->id]['statuses'][$status]['count'];

                    $totals[$problem->id]['statuses'][$status]['percentage'] = $totals[$problem->id]['statuses'][$status]['count'] / ($totals[$problem->id]['attempts'] ?: 1) * 100;
                }
            }

            /*foreach ($contest->problems as $problem) {
                foreach (Solution::getStatuses() as $status => $description) {
                    $totals[$problem->id]['statuses']['percentage'] = $totals[$problem->id]['statuses'][$status]['count'] / $totals['attempts'] * 100;
                }
            }*/

            foreach (Solution::getStatuses() as $status) {
                $totals['statuses'][$status]['percentage'] =
                    $totals['statuses'][$status]['count']
                    / $totals['attempts'] * 100;
            }

            usort($results, function ($a, $b) {
                if ($a['total'] < $b['total']) {
                    return 1;
                } elseif ($a['total'] > $b['total']) {
                    return -1;
                } elseif ($a['time'] < $b['time']) {
                    return 1;
                } elseif ($a['time'] > $b['time']) {
                    return -1;
                } elseif ($a['error_percentage'] < $b['error_percentage']) {
                    return 1;
                } elseif ($a['error_percentage'] > $b['error_percentage']) {
                    return -1;
                } else {
                    return 0;
                }
            });
        }

        return View('contests.standings')->with([
            'contest' => $contest,
            'results' => $results,
            'problems' => $problems,
            'totals' => $totals,
        ]);

    }

    protected function getStandingsTotals(Contest $contest, $results)
    {
        $totals = [];

        if (count($results)) {
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
                    if (!$solution) {
                        continue;
                    }

                    $totals['avg_by_problems'][$solution->problem_id]['total'] += $solution->success_percentage * $contest->getProblemMaxPoints($solution->problem_id) / 100;
                    $totals['avg_by_problems'][$solution->problem_id]['count']++;
                }
            }
            $mapped_avgs = [];
            foreach ($totals['avg_by_problems'] as $problem_id => $avg_by_problem) {
                $mapped_avgs[$problem_id] = $avg_by_problem['count'] ? $avg_by_problem['total'] /= $avg_by_problem['count'] : 0;
            }
            $totals['avg_by_problems'] = $mapped_avgs;
        }

        return $totals;
    }
}
