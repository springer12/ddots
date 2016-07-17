@extends('layouts.app')

@section('content')

    <table class="table">
        <thead>
        <tr>
            <th>Date</th>
            <th>Result</th>
            <th>Points</th>
            <th>Problem</th>
            @if(Auth::check() && Auth::user()->hasRole(\App\User::ROLE_TEACHER))
                <th>Author</th>
            @endif
        </tr>
        </thead>
        <tbody>
        @foreach($solutions as $solution)
            <tr>
                <td>{{ $solution->created_at }}</td>
                <td>{{ $solution->status }}</td>
                <td>points</td>
                <td>
                    <a href="{{ route('contests::problem', ['contest_id' => $solution->getContest()->id, 'problem_id' => $solution->problem->id]) }}">{{ $solution->problem->name }}</a>
                </td>
                @if(Auth::check() && Auth::user()->hasRole(\App\User::ROLE_TEACHER))
                    <td>
                        @if(Auth::user()->isTeacherOf($solution->owner->id))
                            <a href="{{ route('frontend::user::profile', ['id' => $solution->owner->id]) }}">{{ $solution->owner->name }}</a>
                        @endif
                    </td>
                @endif

            </tr>
        @endforeach
        </tbody>

    </table>
    {{ $solutions->links() }}
@endsection
