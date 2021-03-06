@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <a href="{{ route('backend::messages::list') }}">Back to dialogs</a>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    @foreach($messages as $message)
                        <div><span>{{ $message->getSenderName() }} :</span> {{ $message->text }}</div>
                    @endforeach
                </div>
                <form method="post">
                    {{ csrf_field() }}
                    <textarea name="text"></textarea>
                    @if($errors->has('text'))
                        <span><strong>{{ $errors->first('text') }}</strong></span>
                    @endif
                    <input type="submit">
                </form>
            </div>
        </div>
    </div>
@endsection
