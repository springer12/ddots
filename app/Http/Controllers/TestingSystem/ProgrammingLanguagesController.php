<?php

namespace App\Http\Controllers\TestingSystem;

use App\ProgrammingLanguage;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ProgrammingLanguagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $languages = ProgrammingLanguage::all();

        $response = [];

        foreach ($languages as $language) {
            $response[] = [
                'id'             => $language->id,
                'title'          => $language->name,
                'compiler_image' => $language->compiler_image,
                'executor_image' => $language->executor_image,
            ];
        }

        return $response;
    }
}
