<?php

namespace App\Http\Controllers\TestingSystem;

use App\Problem;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class ProblemController extends Controller
{
    /**
     * Returns a problem's archive
     * 
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function getArchive(Request $request, $id)
    {
        return Problem::findOrFail($id)->archive;
    }
}
 