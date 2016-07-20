@extends('layouts.app')
@section('scripts')
    <script src="{{ asset('ace-bundle/js/ace.js') }}"></script>
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-6">
                Date:
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6">
                {{ $solution->created_at }}
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-6">
                programming language:
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6">
                {{ $solution->programming_language->name }}
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-6">
                Points:
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6">
                {{ $solution->points }}
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-6">
                Result:
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6">
                {{ $solution->status }}
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-6">
                Max memory usage:
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6">
                {{ $solution->max_memory }}
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-6">
                Max time:
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6">
                {{ $solution->max_time }}
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-6">
                Problem:
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6">
                <a href="{{ route('frontend::contests::problem', ['contest_id' => $solution->getContest()->id, 'problem_id' => $solution->problem->id]) }}">{{ $solution->problem->name }}</a>
            </div>
        </div>

        @if(Auth::check() && Auth::user()->hasRole(\App\User::ROLE_TEACHER) && Auth::user()->isTeacherOf($solution->owner->id))
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-6">
                Author:
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6">
                <a href="{{ route('frontend::user::profile', ['id' => $solution->owner->id]) }}">{{ $solution->owner->name }}</a>
            </div>
        </div>
        @endif

        <div id="editor">{{ $solution->getCode() }}</div>
        <h3>Reports</h3>
        <div class="x_content">
            <table class="table">
                <thead>
                <tr>
                    <th>Points out of total</th>
                    <th>Execution time</th>
                    <th>Result</th>
                    <th>Peak memory usage</th>
                </tr>
                </thead>
                <tbody>
                @foreach($solution->reports as $report)
                    <td>{{ $solution->successful_reports? $solution->points / $solution->successful_reports: '-' }}</td>
                    <td>{{ $report->execution_time }}</td>
                    <td>{{ $report->status }}</td>
                    <td>{{ $report->memory_peak }}</td>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
