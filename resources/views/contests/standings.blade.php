@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <a href="{{ route('frontend::contests::single', ['id' => $contest->id]) }}">{{ $contest->name }}</a>
                <i class="fa fa-angle-double-right" aria-hidden="true"></i>
                Standings</div>
            <div class="card-block scrollable-width">
                <table class="table table-striped table-bordered table-sm">
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
                    <tfoot>
                    <tr>
                        <th>Average points</th>
                        @foreach($contest->problems as $problem)
                            <td>12</td>
                        @endforeach
                        <th>12</th>
                    </tr>
                    <tr>
                        <th>Attempts</th>
                        @foreach($contest->problems as $problem)
                            <td>12</td>
                        @endforeach
                        <th>{{ 12* $contest->problems->count() }}</th>
                    </tr>
                    <tr>
                        <th>Solutions</th>
                        @foreach($contest->problems as $problem)
                            <td>12</td>
                        @endforeach
                        <th>{{ 12* $contest->problems->count() }}</th>
                    </tr>
                    </tfoot>
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
            </div>
        </div>
    </div>
@endsection
