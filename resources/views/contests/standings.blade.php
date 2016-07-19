@extends('layouts.app')

@section('content')
    Standings
    <table class="table">
        <thead>
        <tr>
            <th>User</th>
            @foreach($contest->problems as $problem)
                <th>
                    <a href="{{ route('frontend::contests::problem', ['contest_id' => $contest->id, 'problem_id' => $problem->id]) }}">{{ $problem->name }}</a>
                </th>
            @endforeach
            <th>Total</th>
        </tr>
        </thead>
        <tbody>

        @foreach($users as $user_id => $user)
            <tr>
                <td>
                    @if(Auth::user()->hasRole(\App\User::ROLE_TEACHER) && Auth::user()->isTeacherOf($user_id) || Auth::user()->id == $user_id)
                        <a href="{{ route('frontend::user::profile', ['id' => $user_id]) }}">
                            {{ $user['name'] }}
                        </a>
                    @else
                        {{ $user['name'] }}
                    @endif

                </td>
                @foreach($user['problems'] as $problem_id => $problem)
                    <td>
                        @if($problem['points'])
                            @if(Auth::user()->hasRole(\App\User::ROLE_TEACHER))
                                <a href="{{ route('frontend::contests::solution', ['id' => $problem['solution_id']]) }}">
                                    {{ $problem['points'] }}
                                </a>
                            @else
                                {{ $problem['points'] }}
                            @endif
                        @else
                            -
                        @endif
                    </td>
                @endforeach
                <td>
                    {{ $user['points'] }}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
