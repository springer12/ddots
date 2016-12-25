<?php

namespace App\Http\Controllers\Ajax;

use App\Discipline;
use App\Problem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use \Auth;

class ProblemController extends Controller
{
    public function search(Request $request)
    {
        $volume_id = $request->get('volume_id');
        $discipline_id = $request->get('discipline_id');
        if($discipline_id) {
            $query = Discipline::findOrFail($discipline_id)->problems();
        } else {
            $query = Problem::query();
        }
        if ($request->get('volume_id')) {
            return $query->select('id', 'name')
                ->whereHas('volumes', function ($q) use ($volume_id) {
                    $q->where('volumes.id', $volume_id);
                })
                ->get();
        }
        return Problem::search($request->get('term'), $request->get('page'), $query);
    }
}

