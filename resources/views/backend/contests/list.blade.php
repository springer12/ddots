@extends('layouts.admin')

@section('content')
    <div class="container">
            <div class="row">
                <div class="col-md-2 col-sm-2 col-xs-2">
                    <a class="btn btn-primary" href="{{ route('backend::contests::add') }}" role="button">Add
                        Contest</a>
                </div>
            </div>
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
                                <th>@include('helpers.grid-header', ['name' => 'Author',  'order' => 'owner.name'])</th>
                                <th>@include('helpers.grid-header', ['name' => 'Name',  'order' => 'name'])</th>
                                <th>@include('helpers.grid-header', ['name' => 'Start date', 'order' => 'start_date'])</th>
                                <th>@include('helpers.grid-header', ['name' => 'End date', 'order' => 'end_date'])</th>
                                <th>@include('helpers.grid-header', ['name' => 'Created at', 'order' => 'created_at'])</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($contests as $contest)
                                <tr>
                                    <td>
                                        {{ $contest->owner->name }}
                                    </td>
                                    <td class="wrap-text">
                                        {{ $contest->name }}
                                    </td>
                                    <td>{{ $contest->start_date }}</td>
                                    <td>{{ $contest->end_date }}</td>
                                    <td>{{ $contest->created_at }}</td>
                                    <td>{{ $contest->description }}</td>
                                    <td>
                                        <a title="Edit"
                                           href="{{ action('Backend\ContestController@edit',['id'=> $contest->id]) }}"><span
                                                    class="glyphicon glyphicon-pencil"></span></a>
                                        @if($contest->is_active == true)
                                            <a title="Hide"
                                               href="{{ action('Backend\ContestController@hide',['id'=> $contest->id]) }}"><span
                                                        class="glyphicon glyphicon-pencil"></span></a>
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

