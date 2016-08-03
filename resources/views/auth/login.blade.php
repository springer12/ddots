@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="card">
                <div class="header">
                    <h4 class="title">Login</h4>
                </div>
                <div class="content">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('nickname') ? ' has-error' : '' }}">

                            <div class="col-md-6 col-md-offset-3">
                                <label for="nickname">Nickname or Email</label>
                                <input id="nickname" class="form-control border-input" name="nickname" value="{{ old('nickname') }}">

                                @if ($errors->has('nickname'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('nickname') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">

                            <div class="col-md-6 col-md-offset-3">
                                <label for="password">Password</label>
                                <input id="password" type="password" class="form-control border-input" name="password">

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-3">
                                <label for="remember"><input id="remember" type="checkbox" name="remember"> Remember Me</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-3">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-btn fa-sign-in"></i> Login</button>

                                <a class="" href="{{ url('/password/reset') }}">Forgot Your Password?</a>
                            </div>

                        </div>
                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-3">
                                <div class="dots-social-enter">
                                    <ul class="dots-social-icons">
                                        <li><a href="{{ route('social::redirect', ['provider' => 'vkontakte']) }}"><i class="dots-vk-icons"></i></a></li>
                                        <li><a href="{{ route('social::redirect', ['provider' => 'google']) }}"><i class="dots-google-icons"></i></a></li>
                                        <li><a href="{{ route('social::redirect', ['provider' => 'facebook']) }}"><i class="dots-facebook-icons"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
