@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">Register</div>
                    <div class="card-block">
                        <form class="form" role="form" method="POST" action="{{ url('/register') }}">
                            {{ csrf_field() }}

                            <div class="form-group row {{ $errors->has('name') ? ' has-danger' : '' }}">

                                <label for="name" class="col-md-4 control-label">Name*</label>

                                <div class="col-md-8">
                                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}">
                                    @if ($errors->has('name'))
                                        <span class="form-control-feedback">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('nickname') ? ' has-danger' : '' }}">

                                <label for="nickname" class="col-md-4 control-label">Nickname*</label>

                                <div class="col-md-8">
                                    <input id="nickname" type="text" class="form-control" name="nickname" value="{{ old('nickname') }}">

                                    @if ($errors->has('nickname'))
                                        <span class="form-control-feedback">
                                            <strong>{{ $errors->first('nickname') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>


                            <div class="form-group row {{ $errors->has('password') ? ' has-danger' : '' }}">

                                <label for="password" class="col-md-4 control-label">Password*</label>

                                <div class="col-md-8">
                                    <input id="password" type="password" class="form-control" name="password" value="{{ old('password') }}">

                                    @if ($errors->has('password'))
                                        <span class="form-control-feedback">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('password_confirmation') ? ' has-danger' : '' }}">

                                <label for="password_confirmation" class="col-md-4 control-label">Confirm Password*</label>

                                <div class="col-md-8">
                                    <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" value="{{ old('password_confirmation') }}">

                                    @if ($errors->has('password_confirmation'))
                                        <span class="form-control-feedback">
                                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row ">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-btn fa-user"></i> Register
                                    </button>
                                    <a class="btn btn-social-icon btn-vk"       href="{{ route('social::redirect', ['provider' => 'vkontakte']) }}"><span class="fa fa-vk"></span></a>
                                    <a class="btn btn-social-icon btn-google"   href="{{ route('social::redirect', ['provider' => 'google']) }}"><span class="fa fa-google"></span></a>
                                    <a class="btn btn-social-icon btn-facebook" href="{{ route('social::redirect', ['provider' => 'facebook']) }}"><span class="fa fa-facebook"></span></a>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>

    </div>


@endsection
