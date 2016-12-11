<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;

class TesterController extends Controller
{
    public function index(Request $request) {
        return view('backend.tester.form');
    }

    public function test(Request $request) {
        try {
            \Session::flash('alert-success', 'Tester response: ' . Artisan::call('tester', ['--login' => $request->get('login'), '--password' => $request->get('password'), '--count' => $request->get('count')]));
        } catch (\Exception $e) {
            \Session::flash('alert-danger', $e->getMessage());
        }
        return view('backend.tester.form');
    }
}
