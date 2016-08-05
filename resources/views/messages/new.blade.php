@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <a href="{{ route('frontend::messages::list') }}">Back to dialogs</a>
                        <div class="clearfix"></div>
                    </div>

                    <form method="post">
                        <select name="user_id">
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                        {{ csrf_field() }}
                        <textarea name="text"></textarea>
                        <input type="submit">
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
