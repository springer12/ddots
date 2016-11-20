@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <a href="{{ route('frontend::contests::single', ['id' => $contest->id]) }}">{{ $contest->name }}</a>
                <i class="fa fa-angle-double-right" aria-hidden="true"></i>
                Standings
            </div>
            @if($contest->is_acm)
                @include('contests.partial._acm_standings')
            @else
                @include('contests.partial._standard_standings')
            @endif
        </div>
    </div>
@endsection
