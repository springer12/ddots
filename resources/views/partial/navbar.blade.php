
{{--<nav class="navbar navbar-dark bg-inverse">--}}
{{--<div class="container">--}}
{{--<div class="navbar-header">--}}

{{--<!-- Collapsed Hamburger -->--}}
{{--<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">--}}
{{--<span class="sr-only">Toggle Navigation</span>--}}
{{--<span class="icon-bar"></span>--}}
{{--<span class="icon-bar"></span>--}}
{{--<span class="icon-bar"></span>--}}
{{--</button>--}}

{{--<!-- Branding Image -->--}}
{{--<a class="navbar-brand" href="{{ action('HomeController@index') }}">--}}
{{--{{ App\Subdomain::currentSubdomain()->fullname }}--}}
{{--</a>--}}
{{--</div>--}}

{{--<div class="collapse navbar-collapse" id="app-navbar-collapse">--}}
{{--<!-- Left Side Of Navbar -->--}}
{{--<ul class="nav navbar-nav">--}}
{{--<li><a href="{{ url('/teachers') }}">Teachers</a></li>--}}
{{--@if (Auth::check())--}}
{{--<li><a href="{{ route('frontend::user::profile', ['id' => Auth::user()->id]) }}">Profile</a></li>--}}
{{--@endif--}}

{{--@if (Auth::check() && Auth::user()->hasRole(App\User::ROLE_TEACHER))--}}
{{--<li><a href="{{ url('/groups') }}">Groups</a></li>--}}
{{--<li><a href="{{ url('/students') }}">Students</a></li>--}}
{{--@endif--}}
{{--@if(Auth::check())--}}
{{--<li><a href="{{ url('/contests') }}">Contests</a></li>--}}
{{--<li><a href="{{ url('/messaging') }}">Messaging</a></li>--}}
{{--@endif--}}
{{--</ul>--}}


{{--<!-- Right Side Of Navbar -->--}}
{{--<ul class="nav navbar-nav navbar-right">--}}
{{--<!-- Authentication Links -->--}}
{{--@if (Auth::guest())--}}
{{--<li><a href="{{ url('/register') }}">Register</a></li>--}}
{{--@else--}}
{{--<li class="dropdown">--}}
{{--<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">--}}
{{--{{ Auth::user()->name }} <span class="caret"></span>--}}
{{--</a>--}}

{{--<ul class="dropdown-menu" role="menu">--}}
{{--<li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>--}}
{{--</ul>--}}
{{--</li>--}}
{{--@endif--}}
{{--</ul>--}}
{{--</div>--}}
{{--</div>--}}
{{--</nav>--}}

{{--<nav class="navbar navbar-dark bg-inverse">--}}
{{--<button class="navbar-toggler hidden-lg-up" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"></button>--}}
{{--<div class="collapse navbar-toggleable-md" id="navbarResponsive">--}}
{{--<a class="navbar-brand" href="{{ action('HomeController@index') }}">{{ App\Subdomain::currentSubdomain()->fullname }}</a>--}}
{{--<ul class="nav navbar-nav">--}}
{{--<li class="nav-item active">--}}
{{--<a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>--}}
{{--</li>--}}
{{--<li class="nav-item">--}}
{{--<a class="nav-link" href="#">Link</a>--}}
{{--</li>--}}
{{--<li class="nav-item">--}}
{{--<a class="nav-link" href="#">Link</a>--}}
{{--</li>--}}
{{--</ul>--}}
{{--<!-- Right Side Of Navbar -->--}}
{{--<ul class="nav navbar-nav navbar-right">--}}
{{--<!-- Authentication Links -->--}}
{{--@if (Auth::guest())--}}
{{--<li><a href="{{ url('/register') }}">Register</a></li>--}}
{{--@else--}}
{{--<li class="dropdown">--}}
{{--<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">--}}
{{--{{ Auth::user()->name }} <span class="caret"></span>--}}
{{--</a>--}}

{{--<ul class="dropdown-menu" role="menu">--}}
{{--<li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>--}}
{{--</ul>--}}
{{--</li>--}}
{{--@endif--}}
{{--</ul>--}}

{{--</div>--}}
{{--</nav>--}}






<header class="navbar navbar-dark bg-inverse navbar-static-top bd-navbar">
    <div class="container">


        <nav>
            <button class="navbar-toggler float-xs-right hidden-sm-up" type="button" data-toggle="collapse" data-target="#bd-main-nav" aria-controls="bd-main-nav" aria-expanded="false" aria-label="Toggle navigation"></button>
            <a class="navbar-brand" href="{{ action('HomeController@index') }}">
                {{ App\Subdomain::currentSubdomain()->fullname }}
            </a>
            <div class="collapse navbar-toggleable-xs" id="bd-main-nav">

                <a class="navbar-brand" href="{{ action('HomeController@index') }}">
                    {{ App\Subdomain::currentSubdomain()->fullname }}
                </a>
                <ul class="nav navbar-nav">
                    <li class="nav-item {{ Request::is('teachers') ? 'active' : '' }}"><a class="nav-item nav-link" href="{{ url('/teachers') }}">Teachers</a></li>

                    @if (Auth::check())
                        <li class="nav-item {{ Request::is(route('frontend::user::profile', ['id' => Auth::user()->id])) ? 'active' : '' }}"><a class="nav-item nav-link" href="{{ route('frontend::user::profile', ['id' => Auth::user()->id]) }}">Profile</a></li>
                    @endif

                    @if (Auth::check() && Auth::user()->hasRole(App\User::ROLE_TEACHER))
                        <li class="nav-item {{ Request::is('groups') ? 'active' : '' }}"><a class="nav-item nav-link" href="{{ url('/groups') }}">Groups</a></li>
                        <li class="nav-item {{ Request::is('students') ? 'active' : '' }}"><a class="nav-item nav-link" href="{{ url('/students') }}">Students</a></li>
                    @endif
                    @if(Auth::check())
                        <li class="nav-item {{ Request::is('contests') ? 'active' : '' }}"><a class="nav-item nav-link" href="{{ url('/contests') }}">Contests</a></li>
                        <li class="nav-item {{ Request::is('messaging') ? 'active' : '' }}"><a class="nav-item nav-link" href="{{ url('/messaging') }}">Messaging</a></li>
                    @endif
                </ul>
            </div>
        </nav>
    </div>
</header>