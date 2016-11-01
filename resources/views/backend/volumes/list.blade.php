@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-2 col-sm-2 col-xs-2">
                <a class="btn btn-primary" href="{{ route('backend::volumes::add') }}" role="button">Add Volumes</a>
            </div>
            <div class="col-md-8 col-sm-8 col-xs-12">
                @include('helpers.grid-search', ['action' => action('Backend\VolumeController@index')])
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Volumes</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>@include('helpers.grid-header', ['name' => 'ID',           'order' => 'id'])</th>
                                <th>@include('helpers.grid-header', ['name' => 'Name',  'order' => 'name'])</th>
                                <th>@include('helpers.grid-header', ['name' => 'Created Date', 'order' => 'created_at'])</th>
                                <th>@include('helpers.grid-header', ['name' => 'Updated Date', 'order' => 'updated_at'])</th>
                                <th>@include('helpers.grid-header', ['name' => 'Deleted Date', 'order' => 'deleted_at'])</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($volumes as $volume)
                                <tr>
                                    <td>{{ $volume->id }}</td>
                                    <td class="wrap-text">{{ $volume->name }}</td>
                                    <td>{{ $volume->created_at }}</td>
                                    <td>{{ $volume->updated_at }}</td>
                                    <td>{{ $volume->deleted_at }}</td>
                                    <td>

                                        <a title="Edit"
                                           href="{{ action('Backend\VolumeController@edit',['id'=> $volume->id]) }}">
                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                        </a>
                                        @if (!$volume->deleted_at)
                                            <a title="Delete" href="" data-toggle="confirmation"
                                               data-message="Are you sure you want to delete this volume from the system?"
                                               data-btn-ok-href="{{ action('Backend\VolumeController@delete', ['id'=> $volume->id]) }}"
                                               data-btn-ok-label="Delete">
                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                            </a>
                                        @else
                                            <a title="Restore" href="" data-toggle="confirmation"
                                               data-message="Are you sure you want to restore this volume?"
                                               data-btn-ok-href="{{ action('Backend\VolumeController@restore', ['id'=> $volume->id]) }}"
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
                            {{ $volumes->appends(\Illuminate\Support\Facades\Input::except('page'))->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
