<?php

namespace App\Http\Controllers;

use App\Contest;
use App\Problem;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use App\ProgrammingLanguage;
use App\User;

class ContestController extends Controller
{
    public function index(Request $request)
    {
        $orderBySession = \Session::get('orderBy', 'updated_at');
        $orderBy = $request->input('order', $orderBySession);

        $orderDirSession = \Session::get('orderDir', 'desc');
        $orderDir = $request->input('dir', $orderDirSession);

        $page = $request->input('page');
        $query = $request->input('query', '');


        if (!in_array($orderBy, Contest::sortable())) {
            $orderBy = 'id';
        }

        if (!in_array($orderDir, ['asc', 'ASC', 'desc', 'DESC'])) {
            $orderDir = 'desc';
        }

        \Session::put('orderBy', $orderBy);
        \Session::put('orderDir', $orderDir);

        $contests = Contest::orderBy($orderBy, $orderDir);
        if (Auth::check() && Auth::user()->hasRole(User::ROLE_TEACHER)) {
            $contests = $contests->where('user_id', Auth::user()->id);
        } elseif (Auth::check() && Auth::user()->hasRole(User::ROLE_USER)) {
            $contests = $contests->whereHas('users', function ($query) {
                $query->where('user_id', Auth::user()->id);
            })->where('is_active', true)->orWhere('labs', true);
        } elseif (!Auth::check() || Auth::user()->hasRole(User::ROLE_LOW_USER)) {
            $contests = $contests->where('labs', true)->where('is_active', true);
        }
        $contests = $contests->paginate(10);

        return view('contests.list')->with([
            'contests' => $contests,
            'order_field' => $orderBy,
            'dir' => $orderDir,
            'page' => $page,
            'query' => $query
        ]);
    }

    public function showForm(Request $request, $id = null)
    {
        $contest = ($id ? Contest::findOrFail($id) : new Contest());
        if ($id && $contest->currentUserAllowedEdit() || !$id) {
            if ($id) {
                $title = 'Edit Contest';
                $participants = $contest->users()->user()->get();
            } else {
                $title = 'Create Contest';
                $participants = collect();
            }

            $students = Auth::user()->students()->get()->diff($participants);

            return view('contests.form')->with([
                'contest' => $contest,
                'title' => $title,
                'students' => $students,
                'participants' => $participants,
                'programming_languages' => ProgrammingLanguage::orderBy('name', 'desc')->get(),
                'problems' => Problem::orderBy('name', 'desc')->get()->diff($contest->problems),
            ]);
        }
        return redirect()->route('contests::list');
    }

    /**
     * Handle a add/edit request
     *
     * @param \Illuminate\Http\Request $request
     * @param int|null $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id = null)
    {
        $contest = (!$id ?: Contest::findOrFail($id));
        if ($id && $contest->currentUserAllowedEdit() || !$id) {
            $fillData = [
                'name' => $request->get('name'),
                'description' => $request->get('description'),
                'start_date' => $request->get('start_date'),
                'end_date' => $request->get('end_date'),
                'user_id' => Auth::user()->id,
                'is_active' => $request->get('is_active'),
                'is_standings_active' => $request->get('is_standings_active'),
                'show_max' => $request->get('show_max'),
                'labs' => $request->get('labs'),
            ];

            $this->validate($request, Contest::getValidationRules());


            if ($id) {
                $contest->fill($fillData);
            } else {
                $contest = Contest::create($fillData);
            }

            $contest->programming_languages()->sync($request->get('programming_languages'));

            $contest->problems()->sync($request->get('problems') ? $request->get('problems') : []);

            $contest->users()->sync($request->get('participants') ? $request->get('participants') : []);

            $contest->save();

            \Session::flash('alert-success', 'The contest was successfully saved');
        }
        return redirect()->route('contests::list');
    }

    public function hide(Request $request, $id)
    {

        $contest = Contest::findOrFail($id);
        if ($contest->currentUserAllowedEdit()) {
            $contest->hide();
            $contest->save();
        }
        return redirect()->route('contests::list');
    }

    public function single(Request $request, $id)
    {
        return View('contests.single')->with(['contest' => Contest::findOrFail($id)]);
    }
}
