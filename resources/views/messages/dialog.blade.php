@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row">
            <div class="col-xs-12">
                <a class="btn btn-primary" href="{{ route('frontend::messages::list') }}" role="button">Back to dialogs</a>
            </div>
        </div>
        <hr class="hidden-border">
        <div class="card">
            <div class="card-header">Dialog with {{ $dialog_partner->name }}</div>
            @foreach($messages->reverse() as $message)
                <div class="card-block">
                    <div class="row">
                        <div class="col-xs-12">
                            <div><a href="dialog.blade.php">{{ $message->getSenderName() }}</a> <span class="text-muted">{{ $message->created_at }}</span></div>
                        </div>
                        <div class="col-xs-12">
                            <div class="breaking-word text-justify">{{ $message->text }}</div>
                        </div>
                    </div>
                </div>
            @endforeach
            <div class="align-center"> {{ $messages->links() }}</div>

            <hr class="hidden-border">
            <hr class="hidden-border">

            @if(Auth::user()->canWriteTo($dialog_partner->id))
                <div class="card-block">
                    <form method="post" id="send-message">
                        {{ csrf_field() }}

                        <div class="form-group {{ $errors->has('text') ? ' has-danger' : '' }}">
                            <textarea class="form-control" rows="5" name="text" placeholder="Enter your message">{{ old('text') }}</textarea>
                            @if ($errors->has('text'))
                                <span class="form-control-feedback">
                                    <strong>{{ $errors->first('text') }}</strong>
                                </span>
                            @endif
                        </div>

                        <hr class="hidden-border">
                        <button type="submit" class="btn btn-success">Send</button>
                    </form>
                </div>
            @endif
        </div>
    </div>
@endsection
