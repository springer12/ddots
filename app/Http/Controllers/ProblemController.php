<?php

namespace App\Http\Controllers;

use App\Contest;
use App\Problem;
use App\Solution;
use Illuminate\Http\Request;

use App\Http\Requests;

class ProblemController extends Controller
{
    public function contestProblem(Request $request, $contest_id, $problem_id)
    {
        $problem = Problem::findOrFail($problem_id);
        $contest = Contest::findOrFail($contest_id);
        //$points_string = $problem->getPointsString($contest);
        $solutions = Solution::whereHas('problem', function ($query) use ($problem_id) {
            $query->where('problem_id', '=', $problem_id);
        })
            ->join('contest_solution', 'solution_id', '=', 'id')
            ->where('contest_id', $contest_id)
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return View('contests.problem')->with([
            'problem' => $problem,
            'solutions' => $solutions,
            'contest' => $contest,
            /*'points' => $points_string*/
        ]);
    }

    public function index(Request $request)
    {
        $orderBySession = \Session::get('orderBy', 'updated_at');
        $orderBy = $request->input('order', $orderBySession);

        $orderDirSession = \Session::get('orderDir', 'desc');
        $orderDir = $request->input('dir', $orderDirSession);

        $page = $request->input('page');
        $query = $request->input('query', '');

        if (!in_array($orderBy, Problem::sortable())) {
            $orderBy = 'id';
        }

        if (!in_array($orderDir, ['asc', 'ASC', 'desc', 'DESC'])) {
            $orderDir = 'desc';
        }

        \Session::put('orderBy', $orderBy);
        \Session::put('orderDir', $orderDir);

        $problems = Problem::query();

        if ($query) {
            $problems = $problems->where(function ($query_s) use ($query) {
                $query_s->orwhere('id', 'like', "%$query%")
                    ->orwhere('name', 'like', "%$query%");
            });
        }

        $problems = $problems->orderBy($orderBy, $orderDir)
            ->paginate(10);

        return view('problems.list')->with([
            'problems' => $problems,
            'order_field' => $orderBy,
            'dir' => $orderDir,
            'page' => $page,
            'query' => $query
        ]);
    }

    public function single(Request $request, $id)
    {
        return view('problems.single', ['problem' => Problem::findOrFail($id)]);
    }
}
