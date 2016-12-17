@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <a class="btn btn-primary" href="{{ route('frontend::messages::list') }}"
                   role="button">@lang('messaging.back_to_dialogs')</a>
            </div>
        </div>
        <hr class="hidden-border">
        <div class="card">
            <div class="card-header">@lang('messaging.new_dialog')</div>
            <div class="card-block">
                <form method="post">
                    {{ csrf_field() }}
                    <div class="form-group row {{ $errors->has('user_id') ? ' has-danger' : '' }}">
                        <label for="user_id" class="col-md-2 col-form-label">@lang('messaging.to')</label>
                        <div class="col-md-8">
                            <select name="user_id" id="user_id" class="form-control">
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('user_id'))
                                <span class="form-control-feedback">
                                    <strong>{{ $errors->first('user_id') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row {{ $errors->has('text') ? ' has-danger' : '' }}">
                        <label for="text" class="col-md-2 col-form-label">@lang('messaging.message')</label>
                        <div class="col-md-8">
                            <textarea name="text" id="text" class="form-control" rows="3"></textarea>
                            @if ($errors->has('text'))
                                <span class="form-control-feedback">
                                    <strong>{{ $errors->first('text') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row ">
                        <div class="col-md-8 offset-md-2">
                            <button type="submit" class="btn btn-success">@lang('messaging.send')</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
