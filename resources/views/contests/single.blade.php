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
                Active standings:
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6">
                {{ $contest->is_standings_active }}
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-6">
                <a href="{{ route('contests::solutions',['id' => $contest->id]) }}">all solutions</a>
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
                <th>id</th>
                <th>name</th>
                <th>difficulty</th>
                <th>points</th>
            </tr>
            </thead>
            <tbody>
            @foreach($contest->problems as $problem)
                <tr>
                    <td>{{$problem->id}}</td>
                    <td><a href="{{ action('ProblemController@contestProblem',['contest_id' => $contest->id, 'problem_id' => $problem->id]) }}">{{$problem->name}}</a></td>
                    <td>{{$problem->difficulty}}</td>
                    <td>//</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
