@extends('layouts.app')

@section('content')
    <div class="container">
        <!-- logo and title -->
        <div class="row">
            <div class="col-sm-2">
                <img src="{{ $subdomain->image }}" alt="sub-logo" class="subdomain-logo"/>
            </div>
            <div class="col-sm-10">
                <h3>
                    <p>{{ $subdomain->description }}</p>
                    <p>@lang('layout.description_2')</p>
                </h3>
            </div>
        </div>

        <!-- description -->
        @if(!Auth::check())

            <hr class="hidden-border">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card" id="login">
                        <div class="card-header">@lang('menu.login')</div>
                        <div class="card-block">
                            <form role="form" method="POST" action="{{ url('/login') }}">
                                {{ csrf_field() }}
                                <div class="form-group row {{ $errors->has('nickname') ? ' has-danger' : '' }}">
                                    <label class="col-md-4 col-form-label">@lang('layout.email_nickname')</label>

                                    <div class="col-md-6">
                                        <input class="form-control" type="text" placeholder="@lang('layout.enter_email')"
                                               name="nickname">
                                        @if ($errors->has('nickname'))
                                            <span class="form-control-feedback">
                                                <strong>{{ $errors->first('nickname') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row {{ $errors->has('password') ? ' has-danger' : '' }}">
                                    <label class="col-md-4 col-form-label">@lang('layout.password')</label>
                                    <div class="col-md-6">
                                        <input class="form-control" type="password" placeholder="@lang('layout.password')"
                                               name="password">
                                        @if ($errors->has('password'))
                                            <span class="form-control-feedback">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-6 offset-md-4">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="remember"> @lang('layout.remember_me')
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-6 offset-md-4">
                                        <a class="btn btn-social-icon btn-vk"       href="{{ route('social::redirect', ['provider' => 'vkontakte']) }}"><span class="fa fa-vk"></span></a>
                                        <a class="btn btn-social-icon btn-google"   href="{{ route('social::redirect', ['provider' => 'google']) }}"><span class="fa fa-google"></span></a>
                                        <a class="btn btn-social-icon btn-facebook" href="{{ route('social::redirect', ['provider' => 'facebook']) }}"><span class="fa fa-facebook"></span></a>
                                    </div>
                                </div>
                                <div class="form-group row ">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa fa-btn fa-sign-in"></i> @lang('menu.login')
                                        </button>

                                        <a class="btn btn-link" href="{{ url('/password/reset') }}">@lang('layout.forgot_password')</a>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>

                </div>
            </div>
        @endif
        <hr class="hidden-border">
        <!-- news -->
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">@lang('menu.news')</div>
                    @each('partial.news_item', $subdomain->news()->orderBy('created_at', 'desc')->take(3)->get(), 'news_item')
                    <div class="card-block">
                        <a href="{{ url('news') }}" class="btn btn-success pull-right">@lang('layout.latest_news')</a>
                    </div>
                </div>

            </div>
        </div>


        <hr class="hidden-border">
        <!-- news -->
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">@lang('layout.supported_by')</div>

                    @foreach($subdomain->sponsors as $sponsor)
                        <div class="card-block">
                            <div class="row">
                                <div class="col-sm-4">
                                    <a href="{{ $sponsor->link }}"><img src="{{ $sponsor->image }}" alt="sponsor-logo" class="sponsor-logo" /></a>
                                </div>
                                <div class="col-sm-4">
                                    <a href="{{ $sponsor->link }}">{{ $sponsor->name }}</a>
                                </div>
                                <div class="col-sm-4">
                                    {{ $sponsor->description }}
                                </div>
                            </div>
                        </div>
                        <hr>
                    @endforeach

                    <div class="card-block">
                        <a href="{{ url('sponsors') }}" class="btn btn-success pull-right">@lang('layout.all_sponsors')</a>
                    </div>
                </div>

            </div>
        </div>

        <hr class="hidden-border">
        <!-- news -->
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">@lang('layout.sub_teachers_mentors')</div>
                    @foreach($subdomain->users()->teacher()->inRandomOrder()->take(3)->get() as $teacher)
                        <div class="card-block">
                            <div class="row">
                                <div class="col-sm-4">
                                    <a href="{{ url('user', ['id' => $teacher->id]) }}"><img src="{{ $teacher->avatar }}" alt="sponsor-logo" class="sponsor-logo" /></a>
                                </div>
                                <div class="col-sm-4">
                                    <a href="{{ url('user', ['id' => $teacher->id]) }}">{{ $teacher->name }}</a>
                                </div>
                                <div class="col-sm-4 breaking-word">
                                    {{ $teacher->description }}
                                </div>
                            </div>
                        </div>
                        <hr>
                    @endforeach
                    <div class="card-block">
                        <a href="{{ url('teachers') }}" class="btn btn-success pull-right">@lang('layout.all_teachers_mentors')</a>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
