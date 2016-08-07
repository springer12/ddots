<?php

namespace App\Http\Controllers;

use App\Message;
use App\User;
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
        return view('messages.dialog')->with(['messages' => Auth::user()->getMessagesWith($id)]);
    }

    public function send(Request $request, $id = null)
    {
        $this->validate($request, Message::getValidationRules());
        $id = $id?$id:$request->get('user_id');
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
    }

    public function newDialog(Request $request)
    {
        if(Auth::user()->hasRole(User::ROLE_TEACHER)) {
            $users = Auth::user()->getNoDialogStudents();
        } else {
            $users = Auth::user()->getNoDialogTeachers();
        }
        return view('messages.new')->with(['users' => $users]);
    }
}
