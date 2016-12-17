@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <a class="btn btn-primary" href="{{ route('teacherOnly::groups::add') }}"
                   role="button">@lang('layout.add_group')</a>
            </div>
        </div>
        <hr class="hidden-border">
        <div class="card">
            <div class="card-header">@lang('menu.groups')</div>
            <div class="card-block">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-sm">
                        <thead>
                        <tr>
                            <th>@include('helpers.grid-header', ['name' => trans('layout.id'),           'order' => 'id'])</th>
                            <th>@include('helpers.grid-header', ['name' => trans('layout.name'),         'order' => 'name'])</th>
                            <th>@include('helpers.grid-header', ['name' => trans('layout.created_date'), 'order' => 'created_at'])</th>
                            <th>@include('helpers.grid-header', ['name' => trans('layout.updated_date'), 'order' => 'updated_at'])</th>
                            <th>@include('helpers.grid-header', ['name' => trans('layout.deleted_date'), 'order' => 'deleted_at'])</th>
                            <th>@lang('layout.actions')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($groups as $group)
                            <tr>
                                <td>{{ $group->id }}</td>
                                <td class="no-wrap">{{ $group->name }}</td>
                                <td>{{ $group->created_at }}</td>
                                <td>{{ $group->updated_at }}</td>
                                <td>{{ $group->deleted_at }}</td>
                                <td class="actions-menu btn-group">
                                    <a class="btn btn-secondary" title="@lang('layout.edit')"
                                       href="{{ action('GroupController@edit',['id'=> $group->id]) }}">
                                        <i class="fa fa-pencil" aria-hidden="true"></i>
                                    </a>
                                    @if (!$group->deleted_at)
                                        <a class="btn btn-danger" title="@lang('layout.delete')" href=""
                                           data-toggle="confirmation"
                                           data-message="Are you sure you want to delete this group from the system?"
                                           data-btn-ok-href="{{ action('GroupController@delete', ['id'=> $group->id]) }}"
                                           data-btn-ok-label="@lang('layout.delete')">
                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                        </a>
                                    @else
                                        <a class="btn btn-secondary" title="@lang('layout.restore')" href=""
                                           data-toggle="confirmation"
                                           data-message="Are you sure you want to restore this group?"
                                           data-btn-ok-href="{{ action('GroupController@restore', ['id'=> $group->id]) }}"
                                           data-btn-ok-label="@lang('layout.restore')">
                                            <i class="fa fa-repeat" aria-hidden="true"></i>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="custom-pager">
                        {{ $groups->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
