<?php

namespace App\Http\Controllers;

use App\Solution;
use Illuminate\Http\Request;

use App\Http\Requests;

class SolutionController extends Controller
{
    public function contestSolution(Request $request, $id) {
        return View('contests.solution')->with(['solution' => Solution::findOrFail($id)]);
    }

    public function contestSolutions(Request $request, $id) {
        return View('contests.solutions')->with(['solutions' => Solution::join('contest_solution', 'solutions.id','=', 'solution_id')->where('contest_id', $id)->paginate(10)]);
    }
}
