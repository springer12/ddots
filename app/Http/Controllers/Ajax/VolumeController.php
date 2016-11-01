<?php

namespace app\Http\Controllers\Ajax;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Volume;

class VolumeController extends Controller
{
    public function search(Request $request)
    {
        return Volume::search($request->get('term'), $request->get('page'));
    }
}