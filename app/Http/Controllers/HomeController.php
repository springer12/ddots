<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Subdomain;
use Illuminate\Http\Request;
use Auth;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $nickname = '';
        if(Auth::check()) {
            $nickname = Auth::user()->nickname;
        }
        return view('home')->with(['nickname' => $nickname, 'subdomain' => Subdomain::currentSubdomain()]);
    }
}
