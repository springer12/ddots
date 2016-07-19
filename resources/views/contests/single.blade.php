@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-6">
                Name:
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6">
                {{ $contest->name }}
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-6">
                Description:
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6">
                {{ $contest->description }}
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-6">
                Start date:
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6">
                {{ $contest->start_date }}
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-6">
                End date:
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6">
                {{ $contest->end_date }}
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-6">
                Active:
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6">
                {{ $contest->is_active }}
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-6">
                @if($contest->is_standings_active )
                    <a href="{{ route('frontend::contests::standings', ['id' => $contest->id]) }}">standings</a>
                @endif
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-6">
                <a href="{{ route('frontend::contests::solutions',['id' => $contest->id]) }}">all solutions</a>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6">
            </div>
        </div>


        <h3>Programming languages</h3>
        <ul>
            @foreach($contest->programming_languages as $programming_language)
                <li>{{ $programming_language->name }}</li>
            @endforeach
        </ul>

        <h3>Problems</h3>
        <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Difficulty</th>
                <th>{{ $contest->show_max?'Best':'Latest' }} points</th>
            </tr>
            </thead>
            <tbody>
            @foreach($contest->problems as $problem)
                <tr>
                    <td>{{ $problem->id }}</td>
                    <td>
                        <a href="{{ action('ProblemController@contestProblem',['contest_id' => $contest->id, 'problem_id' => $problem->id]) }}">{{$problem->name}}</a>
                    </td>
                    <td>{{ $problem->difficulty }}</td>
                    <td>
                        @if(Auth::user()->hasRole(\App\User::ROLE_TEACHER))
                            <a href="{{ route('frontend::contests::solution', ['id' => $problem->getContestDisplaySolution($contest)->id]) }}">
                        @endif

                        {{ $problem->getContestDisplaySolutionPoints($contest) }}</td>
                    @if(Auth::user()->hasRole(\App\User::ROLE_TEACHER))
                    </a>
                    @endif
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
