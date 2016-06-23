<?php

namespace App\Http\Controllers\TestingSystem;

use App\Solution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class SolutionController extends Controller
{
    public function latest_new(Request $request) {
        $solution = Solution::oldestNew();
        $solution->state = Solution::STATE_RESERVED;
        $solution->save();
        return $solution->id;
    }

    public function show(Request $request, $id) {
return 'show';
    }

    public function show_source_code(Request $request) {
        return ' ';

    }

    public function update(Request $request, $id) {
        return ' ';

    }

    public function store_report(Request $request, $id) {
        return ' ';

    }

}
 