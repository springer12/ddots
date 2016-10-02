<?php

namespace App\Http\Controllers\Backend;

use App\Message;
use App\User;
use Illuminate\Contracts\Validation\ValidationException;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class MessageController extends Controller
{
    public function index(Request $request)
    {
        return view('backend.messages.list')->with(['dialog_users' => Auth::user()->getDialogUsers()]);
    }

    public function dialog(Request $request, $id)
    {
        return view('backend.messages.dialog')->with(['messages' => Auth::user()->getMessagesWith($id)]);
    }

    public function send(Request $request, $id = null)
    {
        $id = $id ? $id : $request->get('user_id');
        $this->validate($request, Message::getValidationRules());
        $message = new Message();
        $message->text = e($request->get('text'));
        $message->sender()->associate(Auth::user()->id);
        $message->receiver()->associate($id);
        $message->owner()->associate(Auth::user()->id);
        $message->save();
        $message = $message->replicate();
        $message->owner()->associate($id);
        $message->save();
        return redirect(route('backend::messages::dialog', ['id' => $id]));
    }
}
