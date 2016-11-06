<?php

namespace App\Http\Controllers;

use App\Sponsor;
use App\Subdomain;
use Illuminate\Http\Request;

class SponsorController extends Controller
{
    public function all(Request $request)
    {
        return view('sponsors.all', ['sponsors' => Sponsor::main()->paginate(6)]);
    }

    public function index(Request $request)
    {
        return view('sponsors.domain', ['sponsors' => Subdomain::currentSubdomain()->sponsors()->paginate(6)]);
    }
}
