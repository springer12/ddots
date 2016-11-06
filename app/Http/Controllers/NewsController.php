<?php

namespace App\Http\Controllers;

use App\News;
use App\Subdomain;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function main(Request $request)
    {
        return view('news.all', ['news' => News::main()->paginate(6)]);
    }

    public function index(Request $request)
    {
        return view('news.domain', ['news' => Subdomain::currentSubdomain()->news()->paginate(6)]);
    }

    public function mainSingle(Request $request, $id) {
        return view('news.main_single', ['news_item' => News::findOrFail($id)]);
    }

    public function domainSingle(Request $request, $id) {
        return view('news.domain_single', ['news_item' => News::findOrFail($id)]);
    }
}
