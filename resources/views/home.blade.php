@extends('layouts.app')

@section('content')
    <div class="content">
        <div class="container-fluid">
            <!-- logo and title -->
            <div class="row">
                <div class="col-lg-3 col-sm-6">
                    <div class="dots-logo dots-sub-logo">
                        <img src="media/subdomain_logo.png" alt="sub-logo" />
                    </div>
                </div>
                <div class="col-lg-9 col-sm-6 dots-tagline">
                    <h1 class="title">
                        <p>Академическая гимназия №45</p>
                        <p>Практикум по програмированию</p>
                    </h1>
                </div>
            </div>

            <!-- description -->
            @if(!Auth::check())
                <div class="row">
                    <div class="col-lg-12 col-sm-12 dots-wrap-content">
                        <h2>Login form</h2>
                        <div class="dots-card">
                            <form class="form-inline" role="form" method="POST" action="{{ url('/login') }}">
                                {{ csrf_field() }}
                                <div class="form-group{{ $errors->has('nickname') ? ' has-error' : '' }}">
                                    <label class="sr-only" for="exampleInputEmail2">Email</label>
                                    <input type="text" class="form-control border-input" id="exampleInputEmail2" placeholder="Enter email" name="nickname">
                                    @if ($errors->has('nickname'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('nickname') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <label class="sr-only" for="exampleInputPassword2">Password</label>
                                    <input type="password" class="form-control border-input" id="exampleInputPassword2" placeholder="Password" name="password">
                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <button type="submit" class="btn btn-primary btn-wd">Login</button>
                                <div class="dots-social-enter">
                                    <span>Or login via:</span>
                                    <ul class="dots-social-icons">
                                        <li><a href="{{ route('social::redirect', ['provider' => 'vkontakte']) }}"><i class="dots-vk-icons"></i></a></li>
                                        <li><a href="{{ route('social::redirect', ['provider' => 'google']) }}"><i class="dots-google-icons"></i></a></li>
                                        <li><a href="{{ route('social::redirect', ['provider' => 'facebook']) }}"><i class="dots-facebook-icons"></i></a></li>
                                    </ul>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
        @endif
        <!-- news -->
            <div class="row">
                <div class="col-lg-12 col-sm-12 dots-wrap-content">
                    <h2>News</h2>
                    <div class="dots-card">

                        <div class="dots-news-wrap">
                            <p>Текст последней новости</p>
                            <a href="#">More</a>
                        </div>

                        <a href="#" class="dots-full-content-link"><i class="ti-arrow-circle-down"></i>All news</a>
                    </div>
                </div>
            </div>

            <!-- sponsors -->
            <div class="row">
                <div class="col-lg-12 col-sm-12 dots-wrap-content">
                    <h2>Project was supported by</h2>
                    <div class="dots-card">
                        <div class="content table-responsive table-full-width">
                            <table class="table">
                                <tbody>
                                @foreach($subdomain->sponsors as $sponsor)
                                <tr>
                                    <td class="dots-tb-cont-logo"><img src="{{ $sponsor->image }}" alt="sponsor-logo" /></td>
                                    <td class="dots-tb-cont-name">{{ $sponsor->name }}</td>
                                    <td class="dots-tb-cont-description">{{ $sponsor->description }}</td>
                                </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <a href="#" class="dots-full-content-link"><i class="ti-arrow-circle-down"></i>All sponsors</a>
                    </div>
                </div>
            </div>

            <!-- teachers -->
            <div class="row">
                <div class="col-lg-12 col-sm-12 dots-wrap-content">
                    <h2>Subdomain's teachers and mentors</h2>
                    <div class="dots-card">
                        <div class="content table-responsive table-full-width">
                            <table class="table">
                                <tbody>
                                <tr>
                                    <td class="dots-tb-cont-logo">lOGO</td>
                                    <td class="dots-tb-cont-name">Название</td>
                                    <td class="dots-tb-cont-description">Описание</td>
                                </tr>
                                <tr>
                                    <td class="dots-tb-cont-logo">lOGO</td>
                                    <td class="dots-tb-cont-name">Название</td>
                                    <td class="dots-tb-cont-description">Описание</td>
                                </tr>
                                <tr>
                                    <td class="dots-tb-cont-logo">lOGO</td>
                                    <td class="dots-tb-cont-name">Название</td>
                                    <td class="dots-tb-cont-description">Описание</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                        <a href="#" class="dots-full-content-link"><i class="ti-arrow-circle-down"></i>All teachers and mentors</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
