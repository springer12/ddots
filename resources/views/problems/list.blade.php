@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">@lang('menu.problems')</div>
            <div class="card-block">
                <div class="col-md-8 col-sm-8 col-xs-12">
                    @include('helpers.grid-search', ['action' => action('ProblemController@index')])
                </div>
            </div>
            <div class="card-block">
                @include('partial.problems_list')
            </div>
        </div>
    </div>
@endsection

