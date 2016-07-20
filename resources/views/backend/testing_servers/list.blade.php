@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-2 col-sm-2 col-xs-2">
                <a class="btn btn-primary" href="{{ route('backend::testing_servers::add') }}" role="button">Add Server</a>
            </div>
            <div class="col-md-8 col-sm-8 col-xs-12">
                @include('helpers.grid-search', ['action' => action('Backend\TestingServersController@index')])
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Testing Servers</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>@include('helpers.grid-header', ['name' => 'ID',           'order' => 'id'])</th>
                                <th>@include('helpers.grid-header', ['name' => 'Server name',  'order' => 'name'])</th>
                                <th>@include('helpers.grid-header', ['name' => 'Created Date', 'order' => 'created_at'])</th>
                                <th>@include('helpers.grid-header', ['name' => 'Updated Date', 'order' => 'updated_at'])</th>
                                <th>@include('helpers.grid-header', ['name' => 'Deleted Date', 'order' => 'deleted_at'])</th>
                                <th>Token</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($servers as $server)
                                <tr>
                                    <td>{{ $server->id }}</td>
                                    <td class="wrap-text">{{ $server->name }}</td>
                                    <td>{{ $server->created_at }}</td>
                                    <td>{{ $server->updated_at }}</td>
                                    <td>{{ $server->deleted_at }}</td>
                                    <td class="wrap-text">{{ $server->api_token }}</td>
                                    <td>
                                        <a title="Edit" href="{{ action('Backend\TestingServersController@edit',['id'=> $server->id]) }}"><span class="glyphicon glyphicon-pencil"></span></a>
                                        @if (!$server->deleted_at)
                                            <a title="Delete" href="" data-toggle="confirmation" data-message="Are you sure you want to delete this server from the system?" data-btn-ok-href="{{ action('Backend\TestingServersController@delete', ['id'=> $server->id]) }}" data-btn-ok-label="Delete"><span class="glyphicon glyphicon-trash"></span></a>
                                        @else
                                            <a title="Restore" href="" data-toggle="confirmation" data-message="Are you sure you want to restore this server?" data-btn-ok-href="{{ action('Backend\TestingServersController@restore', ['id'=> $server->id]) }}" data-btn-ok-label="Restore"><span class="glyphicon glyphicon-repeat"></span></a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="custom-pager">
                            {{ $servers->appends(\Illuminate\Support\Facades\Input::except('page'))->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
