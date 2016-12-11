@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-2 col-sm-2 col-xs-2">
                <a class="btn btn-primary" href="{{ route('backend::news::add') }}" role="button">Add
                    News</a>
            </div>
            <div class="col-md-8 col-sm-8 col-xs-12">
                @include('helpers.grid-search', ['action' => action('Backend\NewsController@index')])
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>News</h2>
                        <div class="float-xs-right">
                            <select data-subdomain-filter-select>
                                <option value="0">Select a subdomain</option>
                                @foreach(\App\Subdomain::all() as $subdomain)
                                    <option value="{{ $subdomain->id }}" {{ \Illuminate\Support\Facades\Input::get('subdomain_id') != $subdomain->id?:'selected' }}>{{ $subdomain->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>@include('helpers.grid-header', ['name' => 'ID',            'order' => 'id'])</th>
                                <th>@include('helpers.grid-header', ['name' => 'Title',   'order' => 'name'])</th>
                                <th>@include('helpers.grid-header', ['name' => 'Show on main',   'order' => 'show_on_main'])</th>
                                <th>@include('helpers.grid-header', ['name' => 'Subdomain',   'order' => 'subdomain'])</th>
                                <th>@include('helpers.grid-header', ['name' => 'Created Date', 'order' => 'created_at'])</th>
                                <th>@include('helpers.grid-header', ['name' => 'Updated Date', 'order' => 'updated_at'])</th>
                                <th>@include('helpers.grid-header', ['name' => 'Deleted Date',  'order' => 'deleted_at'])</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($news as $news_item)
                                <tr>
                                    <td>{{ $news_item->id }}</td>
                                    <td class="wrap-text">{{ $news_item->name }}</td>
                                    <td>@if($news_item->show_on_main)
                                            <i class="fa fa-check" aria-hidden="true"></i>
                                        @endif</td>
                                    <td>{{ $news_item->subdomain->name }}</td>
                                    <td>{{ $news_item->created_at }}</td>
                                    <td>{{ $news_item->updated_at }}</td>
                                    <td>{{ $news_item->deleted_at }}</td>
                                    <td>
                                        <a title="Edit"
                                           href="{{ action('Backend\NewsController@edit',['id'=> $news_item->id]) }}">
                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                        </a>
                                        @if (!$news_item->deleted_at)
                                            <a title="Delete" href="" data-toggle="confirmation"
                                               data-message="Are you sure you want to delete these news from the system?"
                                               data-btn-ok-href="{{ action('Backend\NewsController@delete', ['id'=> $news_item->id]) }}"
                                               data-btn-ok-label="Delete">
                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                            </a>
                                        @else
                                            <a title="Restore" href="" data-toggle="confirmation"
                                               data-message="Are you sure you want to restore these news?"
                                               data-btn-ok-href="{{ action('Backend\NewsController@restore', ['id'=> $news_item->id]) }}"
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
                            {{ $news->appends(\Illuminate\Support\Facades\Input::except('page'))->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
