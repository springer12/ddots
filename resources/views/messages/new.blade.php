@extends('layouts.app')

@section('content')


    <a href="{{ route('frontend::messages::list') }}">Back to dialogs</a>
    <div class="card">
        <form method="post">
            <select name="user_id" class="form-control border-input">
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
            <br>
            {{ csrf_field() }}
            <textarea name="text" class="form-control border-input" rows="3"></textarea>
            @if($errors->has('text'))
                <span><strong>{{ $errors->first('text') }}</strong></span>
            @endif
            <button type="submit" class="btn btn-default">Send</button>
        </form>
    </div>







@endsection
