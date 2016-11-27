<?php

namespace App\Http\Controllers\TestingSystem;

use App\Solution;
use App\SolutionReport;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\File;

class SolutionController extends Controller
{
    /**
     * Gets the latest unreserved unprocessed solution
     *
     * @param Request $request
     * @return array
     */
    public function latest_new(Request $request) {
        $solution = Solution::oldestNew();
        $solution->state = Solution::STATE_RESERVED;
        $solution->save();
        return ['id' => $solution->id];
    }

    /**
     * Gets a solution
     *
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function show(Request $request, $id) {
        $solution = Solution::select('problem_id', 'programming_language_id', 'testing_mode')
            ->where('id', $id)
            ->firstOrFail();

        return $solution;
    }

    /**
     * Gets a solution's source code
     *
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function show_source_code(Request $request, $id) {
        return File::get(Solution::where('id', $id)->firstOrFail()->sourceCodeFilePath());
    }

    /**
     * Updates a solution
     *
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function update(Request $request, $id) {
        $this->validate($request, [
            'state' => 'required|in:' . implode(',', Solution::getStates())
        ]);

        $solution = Solution::where('id', $id)->firstOrFail();
        $solution->state = $request->get('state');
        $solution->save();

        return Response::make();
    }

    /**
     * Stores a report to a solution
     *
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function store_report(Request $request, $id) {
        $this->validate($request, [
            'status'                 => 'required|in:' . implode(',', array_flip(Solution::getStatuses())),
            'message'                => 'string|max:255',
            'tests.*.status'         => 'required|in:' . implode(',', SolutionReport::getStatuses()),
            'tests.*.execution_time' => 'required|numeric',
            'tests.*.memory_peak'    => 'required|numeric',
        ]);

        $solution_reports = $request->get('tests');
        $reports = [];
        $succeeded = 0;

        foreach ($solution_reports as $report) {
            $reports[] = new SolutionReport([
                'status'         => $report['status'],
                'execution_time' => $report['execution_time'],
                'memory_peak'    => $report['memory_peak'],
            ]);

            if($report['status'] == 'OK') {
                $succeeded++;
            }
        }

        $solution = Solution::where('id', $id)->firstOrFail();

        $solution->success_percentage = $succeeded * 100 / count($solution_reports);

        $solution->status  = $request->get('status');
        $solution->message = $request->get('message');
        $solution->reports()->saveMany($reports);
        $solution->save();

        return Response::make();
    }

}
 