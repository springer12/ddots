<?php

namespace App\Http\Controllers\Admin;

use App\TestingServer;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class TestingServersController extends Controller
{
    public function index()
    {
        return view('admin.testing_servers.list')->with(['servers' => TestingServer::paginate(10)]);
    }
}
