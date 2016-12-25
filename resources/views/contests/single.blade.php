@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <span style="vertical-align: sub;">
                    {{ $contest->name }}
                    <i class="tag tag-{{ $contest->is_active? 'success' : 'danger' }}">{{ $contest->is_active? 'Active' : 'Disabled' }}</i>
                </span>
                @if($contest->user_id == Auth::id())
                    <a class="btn btn-secondary float-xs-right" title="Edit"
                       href="{{ action('ContestController@edit',['id'=> $contest->id]) }}">
                        <i class="fa fa-pencil" aria-hidden="true"></i>
                    </a>
                @endif
            </div>
            <div class="card-block">
                <table class="table">
                    <tr>
                        <td class="col-sm-4">@lang('contest.started_at')</td>
                        <td>{{ $contest->start_date }}</td>
                    </tr>
                    <tr>
                        <td>@lang('contest.finished_at')</td>
                        <td>{{ $contest->end_date }}</td>
                    </tr>
                    <tr>
                        <td>@lang('contest.time_left')</td>
                        <td>{{ $contest->isEnded() ? $contest->end_date->diffForHumans() : trans('layout.ended') }}</td>
                    </tr>
                    <tr>
                        <td>@lang('menu.programming_languages')</td>
                        <td>
                            {{
                            implode(', ', $contest->programming_languages->map(function ($el) {
                                return $el->name;
                            })->toArray())
                            }}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            {{ $contest->description }}
                        </td>
                    </tr>
                </table>
            </div>
            <div class="card-block">
                <div class="row pull-right">
                    <div class="col-md-12 btn-group">
                        @if($contest->user_id == Auth::id() || $contest->is_standings_active)
                            <a class="btn btn-success" href="{{ route('frontend::contests::standings', ['id' => $contest->id]) }}"><i class="fa fa-trophy" aria-hidden="true"></i> @lang('contest.standings')</a>
                        @endif
                        <a class="btn btn-primary" href="{{ route('frontend::contests::solutions',['id' => $contest->id]) }}"><i class="fa fa-code" aria-hidden="true"></i> @lang('contest.solutions')</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">@lang('menu.problems')</div>
            <div class="card-block">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-sm">
                        <thead>
                        <tr>
                            <th>@lang('layout.id')</th>
                            <th>@lang('layout.name')</th>
                            <th>@lang('contest.difficulty')</th>
                            <th>{{ $contest->show_max?'Best':'Latest' }} @lang('contest._points')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($contest->getProblemData() as $id => $problem)
                            <tr>
                                <td>{{ $id }}</td>
                                <td class="no-wrap">
                                    <a href="{{ $problem['link'] }}">{{ $problem['name'] }}</a>
                                </td>
                                <td>{{ $problem['difficulty'] }}</td>
                                <td>
                                    @if(isset($problem['points']))
                                        @if(isset($problem['solution_link']))
                                            <a href="{{ $problem['solution_link'] }}">{{ $problem['points'] }}</a>
                                        @else
                                            {{ $problem['points'] }}
                                        @endif
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
