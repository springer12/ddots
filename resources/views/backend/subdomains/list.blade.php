@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-2 col-sm-2 col-xs-2">
                <a class="btn btn-primary" href="{{ route('backend::subdomains::add') }}" role="button">Add
                    Subdomain</a>
            </div>
            <div class="col-md-8 col-sm-8 col-xs-12">
                @include('helpers.grid-search', ['action' => action('Backend\SubdomainController@index')])
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Subdomains</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>@include('helpers.grid-header', ['name' => 'ID',           'order' => 'id'])</th>
                                <th>@include('helpers.grid-header', ['name' => 'Name',  'order' => 'name'])</th>
                                <th>@include('helpers.grid-header', ['name' => 'Full name',  'order' => 'fullname'])</th>
                                <th>@include('helpers.grid-header', ['name' => 'Title',  'order' => 'title'])</th>
                                <th>@include('helpers.grid-header', ['name' => 'Created Date', 'order' => 'created_at'])</th>
                                <th>@include('helpers.grid-header', ['name' => 'Updated Date', 'order' => 'updated_at'])</th>
                                <th>@include('helpers.grid-header', ['name' => 'Deleted Date', 'order' => 'deleted_at'])</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($subdomains as $subdomain)
                                <tr>
                                    <td>{{ $subdomain->id }}</td>
                                    <td class="wrap-text">{{ $subdomain->name }}</td>
                                    <td>{{ $subdomain->fullname }}</td>
                                    <td>{{ $subdomain->title }}</td>
                                    <td>{{ $subdomain->created_at }}</td>
                                    <td>{{ $subdomain->updated_at }}</td>
                                    <td>{{ $subdomain->deleted_at }}</td>
                                    <td>
                                        <a title="Edit"
                                           href="{{ action('Backend\SubdomainController@edit',['id'=> $subdomain->id]) }}">
                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                        </a>
                                        @if (!$subdomain->deleted_at)
                                            <a title="Delete" href="" data-toggle="confirmation"
                                               data-message="Are you sure you want to delete this subdomain from the system?"
                                               data-btn-ok-href="{{ action('Backend\SubdomainController@delete', ['id'=> $subdomain->id]) }}"
                                               data-btn-ok-label="Delete">
                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                            </a>
                                        @else
                                            <a title="Restore" href="" data-toggle="confirmation"
                                               data-message="Are you sure you want to restore this subdomain?"
                                               data-btn-ok-href="{{ action('Backend\SubdomainController@restore', ['id'=> $subdomain->id]) }}"
                                               data-btn-ok-label="Restore">
                                                <i class="fa fa-repeat" aria-hidden="true"></i>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="custom-pager">
                            {{ $subdomains->appends(\Illuminate\Support\Facades\Input::except('page'))->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
