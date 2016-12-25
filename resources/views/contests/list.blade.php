@extends('layouts.app')

@section('content')
    <div class="container">
        @if(Auth::user()->hasRole(\App\User::ROLE_TEACHER))
            <div class="row">
                <div class="col-xs-12">
                    <a class="btn btn-primary" href="{{ route('teacherOnly::contests::add') }}"
                       role="button">@lang('contest.add_contest')</a>
                </div>
            </div>
            <hr class="hidden-border">
        @endif
        <hr class="hidden-border">
        <div class="card">
            <div class="card-header">@lang('menu.contests')</div>
            <div class="card-block">
                @include('partial.contests_list')
            </div>
        </div>
    </div>
@endsection

