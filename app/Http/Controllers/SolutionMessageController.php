<?php

namespace App\Http\Controllers;

use App\SolutionMessage;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class SolutionMessageController extends Controller
{
    public function message(Request $request, $id)
    {
        $this->validate($request, SolutionMessage::getValidationRules());
        $message = new SolutionMessage();
        $message->text = $request->get('text');
        $message->solution_id = $id;
        $message->user_id = Auth::user()->id;
        $message->save();
        return redirect(action('SolutionController@contestSolution', ['id' => $id]));
    }
}
