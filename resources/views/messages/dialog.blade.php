@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 card">
                <div class="x_panel">
                    <div class="x_title">
                        <a href="{{ route('frontend::messages::list') }}">Back to dialogs</a>
                        <br>
                        <p>{{ $dialog_partner->name }}</p>
                        <br>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content row ">
                        @foreach($messages as $message)
                            <div class="col-xs-12 col-sm-6 col-md-8">
                                <div><span>{{ $message->getSenderName() }} :</span> {{ $message->text }}</div>
                            </div>
                            <div class="col-xs-6 col-md-4">
                                <div class="pull-right">{{ $message->created_at }}</div>
                            </div>

                        @endforeach
                    </div>

                    @if(Auth::user()->canWriteTo($dialog_partner->id))
                        <form method="post">
                            {{ csrf_field() }}
                            <textarea class="form-control border-input  " rows="3" name="text"></textarea>
                            @if($errors->has('text'))
                                <span><strong>{{ $errors->first('text') }}</strong></span>
                            @endif
                            <button type="submit" class="btn btn-default">Send</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
