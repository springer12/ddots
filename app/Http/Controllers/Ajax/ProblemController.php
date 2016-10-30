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
        return Problem::search($request->get('term'), $request->get('page'));
    }
}

