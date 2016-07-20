@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-2 col-sm-2 col-xs-2">
                <a class="btn btn-primary" href="{{ route('backend::users::add') }}" role="button">Add User</a>
            </div>
            <div class="col-md-8 col-sm-8 col-xs-12">
                @include('helpers.grid-search', ['action' => action('Backend\UserController@index')])
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Users</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>@include('helpers.grid-header', ['name' => 'ID',           'order' => 'id'])</th>
                                <th>@include('helpers.grid-header', ['name' => 'Name',  'order' => 'name'])</th>
                                <th>@include('helpers.grid-header', ['name' => 'E-mail',  'order' => 'email'])</th>
                                <th>@include('helpers.grid-header', ['name' => 'Role',  'order' => 'role'])</th>
                                <th>@include('helpers.grid-header', ['name' => 'Nickname',  'order' => 'nickname'])</th>
                                <th>@include('helpers.grid-header', ['name' => 'Date of birth',  'order' => 'date_of_birth'])</th>
                                <th>@include('helpers.grid-header', ['name' => 'Place of study',  'order' => 'place_of_study'])</th>
                                <th>@include('helpers.grid-header', ['name' => 'Programming language',  'order' => 'programming_language'])</th>
                                <th>@include('helpers.grid-header', ['name' => 'VK link',  'order' => 'vk_link'])</th>
                                <th>@include('helpers.grid-header', ['name' => 'FB link',  'order' => 'fb_link'])</th>
                                <th>@include('helpers.grid-header', ['name' => 'Created Date', 'order' => 'created_at'])</th>
                                <th>@include('helpers.grid-header', ['name' => 'Updated Date', 'order' => 'updated_at'])</th>
                                <th>@include('helpers.grid-header', ['name' => 'Deleted Date', 'order' => 'deleted_at'])</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td class="wrap-text">{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->role }}</td>
                                    <td>{{ $user->nickname }}</td>
                                    <td>{{ $user->date_of_birth }}</td>
                                    <td>{{ $user->place_of_study }}</td>
                                    <td>{{ $user->programmingLanguage['name'] }}</td>
                                    <td>{{ $user->vk_link }}</td>
                                    <td>{{ $user->fb_link }}</td>
                                    <td>{{ $user->created_at }}</td>
                                    <td>{{ $user->updated_at }}</td>
                                    <td>{{ $user->deleted_at }}</td>
                                    <td>
                                        <a title="Edit"
                                           href="{{ action('Backend\UserController@edit',['id'=> $user->id]) }}"><span
                                                    class="glyphicon glyphicon-pencil"></span></a>
                                        @if (!$user->deleted_at)
                                            <a title="Delete" href="" data-toggle="confirmation"
                                               data-message="Are you sure you want to delete this user from the system?"
                                               data-btn-ok-href="{{ action('Backend\UserController@delete', ['id'=> $user->id]) }}"
                                               data-btn-ok-label="Delete"><span
                                                        class="glyphicon glyphicon-trash"></span></a>
                                        @else
                                            <a title="Restore" href="" data-toggle="confirmation"
                                               data-message="Are you sure you want to restore this user?"
                                               data-btn-ok-href="{{ action('Backend\UserController@restore', ['id'=> $user->id]) }}"
                                               data-btn-ok-label="Restore"><span
                                                        class="glyphicon glyphicon-repeat"></span></a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="custom-pager">
                            {{ $users->appends(\Illuminate\Support\Facades\Input::except('page'))->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
