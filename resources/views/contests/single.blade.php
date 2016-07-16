@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-6">
                name:
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6">
                {{ $contest->name }}
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-6">
                description:
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6">
                {{ $contest->description }}
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-6">
                start_date:
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6">
                {{ $contest->start_date }}
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-6">
                end_date:
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6">
                {{ $contest->end_date }}
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-6">
                is_active:
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6">
                {{ $contest->is_active }}
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-6">
                is_standings_active:
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6">
                {{ $contest->is_standings_active }}
            </div>
        </div>


        <h3>Programming languages</h3>
        <ul>
            @foreach($contest->programming_languages as $programming_language)
                <li>{{ $programming_language->name }}</li>
            @endforeach
        </ul>

        <h3>Problems</h3>
        <ul>
            @foreach($contest->problems as $problem)
                <li>{{ $problem->name }}</li>
            @endforeach
        </ul>
    </div>
@endsection
