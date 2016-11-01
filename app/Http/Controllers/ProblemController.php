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
        })->join('contest_solution', 'solution_id', '=', 'id')->where('contest_id', $contest_id)->get();
        return View('contests.problem')->with([
            'problem' => $problem,
            'solutions' => $solutions,
            'contest' => $contest,
            /*'points' => $points_string*/
        ]);
    }
}
