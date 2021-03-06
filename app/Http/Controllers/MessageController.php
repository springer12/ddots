<?php

namespace App\Http\Controllers;

use App\Message;
use App\User;
use Illuminate\Contracts\Validation\ValidationException;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index(Request $request)
    {
        return view('messages.list')->with(['dialog_users' => Auth::user()->getDialogUsers()]);
    }

    public function dialog(Request $request, $id)
    {
        $messages = Auth::user()->getMessagesWithQuery($id)->orderBy('created_at', 'desc')->paginate(20);

        return view('messages.dialog')->with([
            'messages' => $messages,
            'dialog_partner' => User::find($id),
        ]);
    }

    public function send(Request $request, $id = null)
    {
        $id = $id ? $id : $request->get('user_id');
        if (Auth::user()->canWriteTo($id)) {
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
            return redirect(route('frontend::messages::dialog', ['id' => $id]));
        } else {
            abort(403);
        }
    }

    public function newDialog(Request $request)
    {

        $users = Auth::user()->getNoDialogUsers();
        if (Auth::user()->hasRole(User::ROLE_TEACHER)) {
            $users->push(User::admin()->first()); //@todo add logic for selecting an admin
            $users->last()->name = 'admin';
        }

        return view('messages.new')->with(['users' => $users]);
    }
}
