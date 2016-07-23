@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-2 col-sm-2 col-xs-2">
                <a class="btn btn-primary" href="{{ route('backend::sponsors::add') }}" role="button">Add Sponsor</a>
            </div>
            <div class="col-md-8 col-sm-8 col-xs-12">
                @include('helpers.grid-search', ['action' => action('Backend\SponsorController@index')])
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Sponsors</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>@include('helpers.grid-header', ['name' => 'ID',           'order' => 'id'])</th>
                                <th>@include('helpers.grid-header', ['name' => 'Created Date', 'order' => 'created_at'])</th>
                                <th>@include('helpers.grid-header', ['name' => 'Updated Date', 'order' => 'updated_at'])</th>
                                <th>@include('helpers.grid-header', ['name' => 'Deleted Date', 'order' => 'deleted_at'])</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($sponsors as $sponsor)
                                <tr>
                                    <td>{{ $sponsor->name }}</td>
                                    <td>{{ $sponsor->created_at }}</td>
                                    <td>{{ $sponsor->updated_at }}</td>
                                    <td>{{ $sponsor->deleted_at }}</td>
                                    <td>
                                        <a title="Edit"
                                           href="{{ action('Backend\SponsorController@edit',['id'=> $sponsor->id]) }}"><span
                                                    class="glyphicon glyphicon-pencil"></span></a>
                                        @if (!$sponsor->deleted_at)
                                            <a title="Delete" href="" data-toggle="confirmation"
                                               data-message="Are you sure you want to delete this sponsor from the system?"
                                               data-btn-ok-href="{{ action('Backend\SponsorController@delete', ['id'=> $sponsor->id]) }}"
                                               data-btn-ok-label="Delete"><span
                                                        class="glyphicon glyphicon-trash"></span></a>
                                        @else
                                            <a title="Restore" href="" data-toggle="confirmation"
                                               data-message="Are you sure you want to restore this sponsor?"
                                               data-btn-ok-href="{{ action('Backend\SponsorController@restore', ['id'=> $sponsor->id]) }}"
                                               data-btn-ok-label="Restore"><span
                                                        class="glyphicon glyphicon-repeat"></span></a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="custom-pager">
                            {{ $sponsors->appends(\Illuminate\Support\Facades\Input::except('page'))->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
