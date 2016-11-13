<?php

namespace App\Http\Controllers;

use App\Contest;
use App\Solution;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class SolutionController extends Controller
{
    public function contestSolution(Request $request, $id)
    {
        $solution = Solution::findOrFail($id);
        $solution->fillData();
        return View('contests.solution')->with([
            'solution' => $solution,
            'contest' => $solution->getContest(),
        ]);
    }

    public function contestSolutions(Request $request, $id)
    {
        $solutions = Solution::join('contest_solution', 'solutions.id', '=', 'solution_id')->where('contest_id', $id);
        if (!Auth::user()->hasRole(User::ROLE_TEACHER)) {
            $solutions = $solutions->where('user_id', Auth::user()->id);
        }
        return View('contests.solutions')->with([
            'solutions' => $solutions->paginate(10),
            'contest' => Contest::findOrFail($id),
        ]);
    }

    public function submit(Request $request, $contest_id, $problem_id)//@todo:refactor that shit!
    {
        $this->validate($request, Solution::getValidationRules($contest_id));

        $solution = new Solution(['state' => Solution::STATE_NEW]);
        $solution->owner()->associate(Auth::user()->id);
        $solution->problem()->associate($problem_id);
        $solution->programming_language()->associate($request->get('programming_language'));
        $solution->save();
        if (!Auth::user()->hasRole(User::ROLE_TEACHER)) {
            DB::table('contest_solution')->insert(['contest_id' => $contest_id, 'solution_id' => $solution->id]); //@todo:refactor that shit!
        }
        if ($request->hasFile('solution_code_file')) {
            $solution->saveCodeFile('solution_code_file');
        } else {
            File::put($solution->sourceCodeFilePath(), $request->get('solution_code'));
        }

        return redirect()->action('SolutionController@contestSolution', ['id' => $solution->id]);
    }

    public function annul(Request $request, $id)
    {
        $solution = Solution::findOrFail($id);
        if (Auth::user()->isTeacherOf($solution->user_id)) {
            $solution->annul();
        }
        $solution->save();
        return redirect()->action('SolutionController@contestSolution', ['id' => $solution->id]);
    }
}
