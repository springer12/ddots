<header class="navbar navbar-dark bg-inverse navbar-static-top bd-navbar">
    <div class="container">
        <nav>
            <button class="navbar-toggler float-xs-right hidden-sm-up" type="button" data-toggle="collapse"
                    data-target="#bd-main-nav" aria-controls="bd-main-nav" aria-expanded="false"
                    aria-label="Toggle navigation"></button>
            <div class="collapse navbar-toggleable-xs" id="bd-main-nav">
                <a class="navbar-brand" href="{{ action('HomeController@index') }}">
                    {{ App\Subdomain::currentSubdomain()->fullname }}
                </a>
                <ul class="nav navbar-nav ">
                    <li class="nav-item {{ Request::is('teachers') ? 'active' : '' }}">
                        <a class="nav-item nav-link" href="{{ url('/teachers') }}">@lang('menu.teachers')</a>
                    </li>
                    @if (Auth::check())
                        <li class="nav-item {{ Request::fullUrl() == route('frontend::user::profile', ['id' => Auth::user()->id]) ? 'active' : '' }}">
                            <a class="nav-item nav-link"
                               href="{{ route('frontend::user::profile', ['id' => Auth::user()->id]) }}">@lang('menu.profile')</a>
                        </li>
                    @endif

                    @if (Auth::check() && Auth::user()->hasRole(App\User::ROLE_TEACHER))
                        <li class="nav-item {{ Request::is('groups') ? 'active' : '' }}">
                            <a class="nav-item nav-link" href="{{ url('/groups') }}">@lang('menu.groups')</a>
                        </li>
                        <li class="nav-item {{ Request::is('students') ? 'active' : '' }}">
                            <a class="nav-item nav-link" href="{{ url('/students') }}">@lang('menu.students')</a>
                        </li>
                        <li class="nav-item {{ Request::is('problems') ? 'active' : '' }}">
                            <a class="nav-item nav-link" href="{{ url('/problems') }}">@lang('menu.problems')</a>
                        </li>
                    @endif
                    @if(Auth::check())
                        <li class="nav-item {{ Request::is('contests') ? 'active' : '' }}">
                            <a class="nav-item nav-link" href="{{ url('/contests') }}">@lang('menu.contests')</a>
                        </li>
                        <li class="nav-item {{ Request::is('messaging') ? 'active' : '' }}">
                            <a class="nav-item nav-link" href="{{ url('/messaging') }}">@lang('menu.messaging')</a>
                        </li>
                    @endif

                    @if (Auth::check())
                        <li class="nav-item float-md-right">
                            <a class="nav-item nav-link" href="{{ url('/logout') }}">
                                <i class="fa fa-sign-out" aria-hidden="true"></i>
                                @lang('menu.logout')
                            </a>
                        </li>
                    @endif
                    @if (!Auth::check())
                        <li class="nav-item float-md-right">
                            <a class="nav-item nav-link"
                               href="{{ url('/register') }}">
                                <i class="fa fa-sign-in" aria-hidden="true"></i>
                                @lang('menu.register')
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
        </nav>
    </div>
</header>