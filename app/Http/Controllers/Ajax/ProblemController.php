<?php

namespace App\Http\Controllers\Ajax;

use App\Problem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use \Auth;

class ProblemController extends Controller
{
    public function search(Request $request)
    {
        $volume_id = $request->get('volume_id');
        if ($request->get('volume_id')) {
            return Problem::select('id', 'name')
                ->whereHas('volumes', function ($q) use ($volume_id) {
                    $q->where('volumes.id', $volume_id);
                })
                ->get();
        }
        return Problem::search($request->get('term'), $request->get('page'));
    }
}

