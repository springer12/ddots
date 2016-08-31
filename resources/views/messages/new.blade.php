@extends('layouts.app')

@section('content')


<a href="{{ route('frontend::messages::list') }}">Back to dialogs</a>
<div class="card">
<form method="post">
    <select name="user_id">
        @foreach($users as $user)
            <option value="{{ $user->id }}">{{ $user->name }}</option>
        @endforeach
    </select>
    {{ csrf_field() }}
    <textarea name="text"></textarea>
    @if($errors->has('text'))
        <span><strong>{{ $errors->first('text') }}</strong></span>
    @endif
    <input type="submit">
</form>
</div>







@endsection
