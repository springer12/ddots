@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                {{ $problem->name }}
                <span class="float-xs-right">
                    @for($i = 0; $i < $problem->difficulty; $i++)
                        <i class="fa fa-star" aria-hidden="true"></i>
                    @endfor
                </span>
            </div>
            <div class="card-block">
                @lang('layout.volumes'):<h4>
                    @foreach($problem->volumes as $volume)
                        <span class="tag tag-default">{{ $volume->name }}</span>
                        <span class="tag tag-default">{{ $volume->name }}</span>
                        <span class="tag tag-default">{{ $volume->name }}</span>
                    @endforeach
                </h4>
            </div>
            <div class="card-block">
                <p>
                    {{ $problem->description }}
                </p>
                <div class="align-center form-group">
                    <img src="{{ $problem->image }}" style="max-width: 100%">{{-- @todo remove inline --}}
                </div>
            </div>
        </div>
    </div>
@endsection

