<?php

namespace App\Http\Controllers\TestingSystem;

use App\Solution;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

class SolutionController extends Controller
{
    public function latest_new(Request $request) {
        $solution = Solution::oldestNew();
        $solution->state = Solution::STATE_RESERVED;
        $solution->save();
        return $solution->id;
    }

    public function show(Request $request, $id) {
        $solution = Solution::select('problem_id', 'programming_language_id', 'testing_mode')
            ->where('id', $id)
            ->firstOrFail();
        return $solution;
    }

    public function show_source_code(Request $request, $id) {
        return Storage::get(Solution::where('id', $id)->firstOrFail()->sourceCodePath());
    }

    public function update(Request $request, $id) {
        $this->validate($request, [
            'state' => 'required|in:' . implode(',', Solution::getStates())
        ]);

        $solution = Solution::where('id', $id)->firstOrFail();
        $solution->state = $request->get('state');
        $solution->save();
        //@todo test this
        return Response::make();
    }

    public function store_report(Request $request, $id) {
        //@todo: add implementation
    }

}
 