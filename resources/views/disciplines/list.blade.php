@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <a class="btn btn-primary" href="{{ route('teacherOnly::disciplines::add') }}"
                   role="button">@lang('discipline.add')</a>
            </div>
        </div>
        <hr class="hidden-border">
        <div class="card">
            <div class="card-header">@lang('menu.disciplines')</div>
            <div class="card-block">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-sm">
                        <thead>
                        <tr>
                            <th>@include('helpers.grid-header', ['name' => trans('layout.id'),  'order' => 'id'])</th>
                            <th>@include('helpers.grid-header', ['name' => trans('layout.name'),  'order' => 'name'])</th>
                            <th>@lang('menu.students')</th>
                            <th>@lang('menu.contests')</th>
                            <th>@include('helpers.grid-header', ['name' => trans('layout.created_date'),  'order' => 'created_at'])</th>
                            <th>@lang('layout.actions')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($disciplines as $discipline)
                            <tr>
                                <td>{{ $discipline->id }}</td>
                                <td class="wrap-text"><a
                                            href="{{ action('DisciplineController@showForm', ['id' => $discipline->id]) }}">{{ $discipline->name }}</a>
                                </td>
                                <td>//todo</td>
                                <td>//todo</td>
                                <td class="no-wrap">{{ $discipline->created_at }}</td>
                                <td class="actions-menu btn-group">
                                    <a class="btn btn-secondary" title="@lang('layout.edit')"
                                       href="{{ action('DisciplineController@showForm',['id'=> $discipline->id]) }}">
                                        <i class="fa fa-pencil" aria-hidden="true"></i>
                                    </a>
                                    <a class="btn btn-secondary btn-danger" title="@lang('layout.delete')"
                                       href="{{ action('DisciplineController@delete',['id'=> $discipline->id]) }}">
                                        <i class="fa fa-ban" aria-hidden="true"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="custom-pager">
                        {{ $disciplines->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

