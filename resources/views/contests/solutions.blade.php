@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <a href="{{ route('frontend::contests::single', ['id' => $contest->id]) }}">{{ $contest->name }}</a>
                <i class="fa fa-angle-double-right" aria-hidden="true"></i>
                @lang('contest.all_solutions')</div>
            <div class="card-block">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-sm">
                        <thead>
                        <tr>
                            <th>@lang('layout.date')</th>
                            <th>@lang('contest.result')</th>
                            <th>@lang('contest.points')</th>
                            <th>@lang('contest.problem')</th>
                            @if(Auth::check() && Auth::user()->hasRole(\App\User::ROLE_TEACHER))
                                <th>@lang('contest.author')</th>
                            @endif
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($solutions as $solution)
                            <tr>
                                <td>{{ $solution->created_at }}</td>
                                <td>{{ $solution->status }}</td>
                                <td>
                                    <a href="{{ route('frontend::contests::solution', ['id' => $solution->id]) }}">{{ $solution->getPoints() }}</a>
                                </td>
                                <td>
                                    <a href="{{ route('frontend::contests::problem', ['contest_id' => $solution->getContest()->id, 'problem_id' => $solution->problem->id]) }}">{{ $solution->problem->name }}</a>
                                </td>
                                @if(Auth::user()->hasRole(\App\User::ROLE_TEACHER))
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
                </div>
            </div>
            {{ $solutions->links() }}
        </div>
    </div>
@endsection
