@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-6">
                name:
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6">
                {{ $problem->name }}
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-6">
                description:
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6">
                {{ $problem->description }}
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-6">
                difficulty:
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6">
                {{ $problem->difficulty }}
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-6">
                Points:
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6">
                //
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-6">
                <a href="{{ route('contests::single', ['id' => $contest_id]) }}">Contest</a>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6">
            </div>
        </div>
        {{-- @todo upload solution form --}}
        <h3>Solutions</h3>
        <div class="x_content">
            <table class="table">
                <thead>
                <tr>
                    <th>Date</th>
                    <th>Points</th>
                    @if(Auth::check() && Auth::user()->hasRole(\App\User::ROLE_TEACHER))
                        <th>author</th>
                    @endif
                    <th>Source code</th>
                </tr>
                </thead>
                <tbody>
                @foreach($solutions as $solution)
                    <td>{{ $solution->created_at }}</td>
                    <td>//</td>
                    @if(Auth::check() && Auth::user()->hasRole(\App\User::ROLE_TEACHER))
                        <td>
                            @if(Auth::user()->isTeacherOf($solution->owner->id))
                                <a href="{{ route('frontend::user::profile', ['id' => $solution->owner->id]) }}">{{ $solution->owner->name }}</a>
                            @endif
                        </td>
                    @endif
                    <td></td>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
