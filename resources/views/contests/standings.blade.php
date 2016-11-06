@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <a href="{{ route('frontend::contests::single', ['id' => $contest->id]) }}">{{ $contest->name }}</a>
                <i class="fa fa-angle-double-right" aria-hidden="true"></i>
                Standings
            </div>
            <div class="card-block">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-sm">
                        <thead>
                        <tr>
                            <th>Position</th>
                            <th>User</th>
                            @foreach($problems as $problem)
                                <th>
                                    <a href="{{ $problem->getLink($contest) }}">{{ $problem->name }}</a>
                                </th>
                            @endforeach
                            <th>Total</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($results as $result)
                            <?php $total = 0 ?>
                            <tr>
                                <td>
                                    {{ $result['position'] }}
                                </td>
                                <td>
                                    @if(Auth::user()->hasRole(\App\User::ROLE_TEACHER) && Auth::user()->isTeacherOf($result['user']->id) || Auth::user()->id == $result['user']->id)
                                        <a href="{{ route('frontend::user::profile', ['id' => $result['user']->id]) }}">
                                            {{ $result['user']->name }}
                                        </a>
                                    @else
                                        {{ $result['user']->name }}
                                    @endif
                                </td>
                                @foreach($result['solutions'] as $solution)
                                    <td>
                                        @if($solution)
                                            @if(Auth::user()->hasRole(\App\User::ROLE_TEACHER))
                                                <a href="{{ route('frontend::contests::solution', ['id' => $problem['solution_id']]) }}">
                                                    {{ $solution->success_percentage / 100 * $contest->getProblemMaxPoints($solution->problem_id) }}
                                                </a>
                                            @else
                                                {{ $solution->success_percentage / 100 * $contest->getProblemMaxPoints($solution->problem_id) }}
                                            @endif
                                            <?php $total += $solution->success_percentage / 100 * $contest->getProblemMaxPoints($solution->problem_id) ?>
                                        @else
                                            -
                                        @endif
                                    </td>
                                @endforeach
                                <td>
                                    {{ $total }}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <th colspan="2">Average points</th>
                            @foreach($contest->problems as $problem)
                                <td>{{ $problem->getAVGScore($contest) }}</td>
                            @endforeach
                            <th>{{ $contest->getAVGScore() }}</th>
                        </tr>
                        <tr>
                            <th colspan="2">Attempts</th>
                            @foreach($contest->problems as $problem)
                                <td>{{ $problem->getUsersWhoTryToSolve($contest) }}</td>
                            @endforeach
                            <th>{{ $contest->getUsersWhoTryToSolve() }}</th>
                        </tr>
                        <tr>
                            <th colspan="2">Solutions</th>
                            @foreach($contest->problems as $problem)
                                <td>{{ $problem->getUsersWhoSolved($contest) }}</td>
                            @endforeach
                            <th>{{ $contest->getUsersWhoSolved() }}</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
