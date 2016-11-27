@extends('layouts.app')
@section('scripts')
    <script src="{{ asset('ace-bundle/js/ace/ace.js') }}"></script>
@endsection
@section('content')
    <div class="container">
        <div class="card">
            @if($contest)
                <div class="card-header">
                    <a href="{{ route('frontend::contests::single', ['id' => $contest->id]) }}">{{ $contest->name }}</a>
                    <i class="fa fa-angle-double-right" aria-hidden="true"></i>
                    <a href="{{ route('frontend::contests::contest_problem', ['contest_id' => $contest->id, 'problem_id' => $solution->problem->id ]) }}">{{ $solution->problem->name }}</a>
                    <i class="fa fa-angle-double-right" aria-hidden="true"></i>
                    solution
                </div>
            @endif
            <div class="card-block">

                <table class="table">
                    <tr>
                        <td>Date</td>
                        <td>{{ $solution->created_at }}</td>
                    </tr>
                    <tr>
                        <td>Programming language</td>
                        <td>{{ $solution->programming_language->name }}</td>
                    </tr>
                    <tr>
                        <td>Points</td>
                        <td>
                            @if($solution->owner->hasRole(\App\User::ROLE_TEACHER))
                                @if($solution->success_percentage)
                                    {{ $solution->success_percentage }} %
                                @else
                                    -
                                @endif
                            @else
                                {{ $solution->points }}
                            @endif

                            @if($solution->status !== App\Solution::STATUS_ZR && Auth::user()->isTeacherOf($solution->owner->id))
                                <a data-btn-ok-href="{{ route('teacherOnly::solutions::annul', ['id' => $solution->id]) }}"
                                   href=""
                                   class="btn btn-danger btn-sm"
                                   data-btn-ok-label="Annul"
                                   data-toggle="confirmation"
                                   data-message="Are you sure you want to annul this solution?"
                                >Annul</a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Result</td>
                        <td>
                            {{ $solution->status?: 'in proccess' }}
                        </td>
                    </tr>
                    <tr>
                        <td>Max memory usag</td>
                        <td>{{ $solution->max_memory }}</td>
                    </tr>
                    <tr>
                        <td>Max time</td>
                        <td>{{ $solution->max_time }}</td>
                    </tr>
                </table>

                @if(Auth::user()->hasRole(\App\User::ROLE_TEACHER) && Auth::user()->isTeacherOf($solution->owner->id))
                    @if($solution->reviewed === null)
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <a class="btn btn-success"
                                   href="{{ route('teacherOnly::solutions::approve', ['id' => $solution->id]) }}">Approve</a>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <a class="btn btn-danger"
                                   href="{{ route('teacherOnly::solutions::decline', ['id' => $solution->id]) }}">Decline</a>
                            </div>
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            Author:
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <a href="{{ route('frontend::user::profile', ['id' => $solution->owner->id]) }}">{{ $solution->owner->name }}</a>
                        </div>
                    </div>
                @endif
                <div data-solution data-ace-mode="{{ $solution->programming_language->ace_mode }}" class="ace-editor"
                     id="editor">{{ $solution->status === App\Solution::STATUS_ZR?'Solution annulled':$solution->getCode() }}</div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">Reports</div>
            <div class="card-block">
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
                        <tr>
                            <td>{{ $solution->successful_reports? $solution->points / $solution->successful_reports: '-' }}</td>
                            <td>{{ $report->execution_time }}</td>
                            <td>
                                <span class="tag tag-{{ $report->status == App\SolutionReport::STATUS_OK? 'success' : 'danger' }}">{{ $report->status }}</span>
                            </td>
                            <td>{{ $report->memory_peak }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
