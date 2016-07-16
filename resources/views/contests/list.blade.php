@extends('layouts.app')

@section('content')
    <div class="container">
        @if(Auth::check() && Auth::user()->hasRole(\App\User::ROLE_TEACHER))
            <div class="row">
                <div class="col-md-2 col-sm-2 col-xs-2">
                    <a class="btn btn-primary" href="{{ route('teacherOnly::contests::add') }}" role="button">Add
                        Contest</a>
                </div>
            </div>
        @endif
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Contests</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table class="table">
                            <thead>
                            <tr>
                                @if(!Auth::check() || Auth::user()->hasRole([\App\User::ROLE_USER, \App\User::ROLE_LOW_USER]))
                                    <th>Author</th>
                                @endif
                                <th>@include('helpers.grid-header', ['name' => 'Name',  'order' => 'name'])</th>
                                <th>@include('helpers.grid-header', ['name' => 'Start date', 'order' => 'start_date'])</th>
                                <th>@include('helpers.grid-header', ['name' => 'End date', 'order' => 'end_date'])</th>
                                <th>Description</th>
                                @if(Auth::check() && Auth::user()->hasRole(\App\User::ROLE_TEACHER))
                                    <th>Actions</th>
                                @endif
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($contests as $contest)
                                <tr>
                                    @if(!Auth::check() || Auth::user()->hasRole([\App\User::ROLE_USER, \App\User::ROLE_LOW_USER]))
                                        <td>
                                            <a href="{{ route('frontend::user::profile', ['id' => $contest->owner->id]) }}">{{ $contest->owner->name }}</a>
                                        </td>
                                    @endif

                                    <td class="wrap-text"><a href="{{ action('ContestController@single', ['id' => $contest->id]) }}">{{ $contest->name }}</a></td>
                                    <td>{{ $contest->start_date }}</td>
                                    <td>{{ $contest->end_date }}</td>
                                    <td>{{ $contest->description }}</td>
                                    <td>
                                        @if(Auth::check() && Auth::user()->hasRole(\App\User::ROLE_TEACHER))
                                            <a title="Edit"
                                               href="{{ action('ContestController@edit',['id'=> $contest->id]) }}"><span
                                                        class="glyphicon glyphicon-pencil"></span></a>
                                            @if($contest->is_active == true)
                                                <a title="Hide"
                                                   href="{{ action('ContestController@hide',['id'=> $contest->id]) }}"><span
                                                            class="glyphicon glyphicon-pencil"></span></a>
                                            @endif
                                        @endif
                                    </td>
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
    </div>
@endsection

