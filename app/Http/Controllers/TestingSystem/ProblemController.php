<?php

namespace App\Http\Controllers\TestingSystem;

use App\Problem;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class ProblemController extends Controller
{
    public function getArchive(Request $request, $id)
    {
        return Problem::findOrFail($id)->archive;
    }
}
 