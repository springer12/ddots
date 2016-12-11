<?php

namespace App\Http\Controllers\TestingSystem;

use App\TestingServer;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class TestingServerController extends Controller
{
    /**
     * Gets the api token for a testing server
     *
     * @param Request $request
     * @return array
     */
    public function getToken(Request $request)
    {
        $server = TestingServer::where('login', $request->get('login'))->first();
        if(!$server->isTokenValid()) {
            $server->api_token = TestingServer::generateApiToken();
            $server->save();
        }
        return ['api_token' => $server->api_token];
    }
}
 