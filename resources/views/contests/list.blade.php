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
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-sm">
                        <thead>
                        <tr>
                            <th>@include('helpers.grid-header', ['name' => trans('layout.name'),  'order' => 'name'])</th>
                            @if(Auth::user()->hasRole([\App\User::ROLE_USER, \App\User::ROLE_LOW_USER]))
                                <th>@include('helpers.grid-header', ['name' => trans('contest.author'),  'order' => 'owner'])</th>
                            @endif
                            <th>@include('helpers.grid-header', ['name' => trans('contest.start_date'), 'order' => 'start_date'])</th>
                            <th>@include('helpers.grid-header', ['name' => trans('contest.end_date'), 'order' => 'end_date'])</th>
                            <th>@lang('layout.description')</th>
                            @if(Auth::user()->hasRole(\App\User::ROLE_TEACHER))
                                <th>@lang('layout.actions')</th>
                            @endif
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($contests as $contest)
                            <tr>
                                <td class="wrap-text"><a
                                            href="{{ action('ContestController@single', ['id' => $contest->id]) }}">{{ $contest->name }}</a>
                                </td>
                                @if(Auth::user()->hasRole([\App\User::ROLE_USER, \App\User::ROLE_LOW_USER]))
                                    <td>
                                        <a href="{{ route('frontend::user::profile', ['id' => $contest->owner->id]) }}">{{ $contest->owner->name }}</a>
                                    </td>
                                @endif
                                <td class="no-wrap">{{ $contest->start_date }}</td>
                                <td class="no-wrap">{{ $contest->end_date }}</td>
                                <td class="breaking-word">{{ $contest->description }}</td>
                                @if(Auth::user()->hasRole(\App\User::ROLE_TEACHER))
                                    <td class="actions-menu btn-group">
                                        <a class="btn btn-secondary" title="Edit"
                                           href="{{ action('ContestController@edit',['id'=> $contest->id]) }}">
                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                        </a>
                                        @if($contest->is_active == true)
                                            <a class="btn btn-secondary btn-danger" title="Hide"
                                               href="{{ action('ContestController@hide',['id'=> $contest->id]) }}">
                                                <i class="fa fa-ban" aria-hidden="true"></i>
                                            </a>
                                        @else
                                            <a class="btn btn-secondary btn-success" title="Show"
                                               href="{{ action('ContestController@show',['id'=> $contest->id]) }}">
                                                <i class="fa fa-repeat" aria-hidden="true"></i>
                                            </a>
                                        @endif
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="custom-pager">
                        {{ $contests->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

