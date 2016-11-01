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
                    <p>Практикум по програмированию</p>
                </h3>
            </div>
        </div>

        <!-- description -->
        @if(!Auth::check())

            <hr class="hidden-border">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card" id="login">
                        <div class="card-header">Login</div>
                        <div class="card-block">
                            <form role="form" method="POST" action="{{ url('/login') }}">
                                {{ csrf_field() }}
                                <div class="form-group row {{ $errors->has('nickname') ? ' has-danger' : '' }}">
                                    <label class="col-md-4 col-form-label">Email / nickname</label>

                                    <div class="col-md-6">
                                        <input class="form-control" type="text" placeholder="Enter email" name="nickname">
                                        @if ($errors->has('nickname'))
                                            <span class="form-control-feedback">
                                                <strong>{{ $errors->first('nickname') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row {{ $errors->has('password') ? ' has-danger' : '' }}">
                                    <label class="col-md-4 col-form-label">Password</label>
                                    <div class="col-md-6">
                                        <input class="form-control" type="password" placeholder="Password" name="password">
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
                                                <input type="checkbox" name="remember"> Remember Me
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row ">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa fa-btn fa-sign-in"></i> Login
                                        </button>

                                        <a class="btn btn-link" href="{{ url('/password/reset') }}">Forgot Your Password?</a>
                                    </div>
                                </div>
                                <div class="form-group row ">
                                    <div class="col-md-6 offset-md-4">
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
        @endif
        <hr class="hidden-border">
        <!-- news -->
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">News</div>
                    <div class="card-block">
                        <div>
                            <p>Текст последней новости...</p>
                        </div>
                    </div>
                    <hr>

                    <div class="card-block">
                        <div>
                            <p>Текст последней новости...</p>
                        </div>
                    </div>
                    <hr>

                    <div class="card-block">
                        <div>
                            <p>Текст последней новости...</p>
                        </div>
                    </div>
                    <hr>
                    <div class="card-block">

                        <a href="#" class="btn btn-success pull-right">Last news</a>
                    </div>

                </div>

            </div>
        </div>


        <hr class="hidden-border">
        <!-- news -->
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">Project was supported by</div>

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
                        <a href="#" class="btn btn-success pull-right">All sponsors</a>
                    </div>
                </div>

            </div>
        </div>

        <hr class="hidden-border">
        <!-- news -->
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">Subdomain's teachers and mentors</div>
                    <div class="card-block">
                        <div class="row">
                            <div class="col-sm-4">
                                <a href="#"><img src="#" alt="sponsor-logo" class="sponsor-logo" /></a>
                            </div>
                            <div class="col-sm-4">
                                <a href="#">Название</a>
                            </div>
                            <div class="col-sm-4">
                                Описание
                            </div>
                        </div>
                    </div>
                    <hr>

                    <div class="card-block">
                        <div class="row">
                            <div class="col-sm-4">
                                <a href="#"><img src="#" alt="sponsor-logo" class="sponsor-logo" /></a>
                            </div>
                            <div class="col-sm-4">
                                <a href="#">Название</a>
                            </div>
                            <div class="col-sm-4">
                                Описание
                            </div>
                        </div>
                    </div>
                    <hr>

                    <div class="card-block">
                        <div class="row">
                            <div class="col-sm-4">
                                <a href="#"><img src="#" alt="sponsor-logo" class="sponsor-logo" /></a>
                            </div>
                            <div class="col-sm-4">
                                <a href="#">Название</a>
                            </div>
                            <div class="col-sm-4">
                                Описание
                            </div>
                        </div>
                    </div>
                    <hr>

                    <div class="card-block">
                        <a href="#" class="btn btn-success pull-right">All teachers and mentors</a>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
