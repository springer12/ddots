<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ App\Subdomain::currentSubdomain()->title }}</title>

    <link href="{{ asset('frontend-bundle/css/bundle' . (config('app.assets.minified', false) ? '.min' : '') . '.css') }}" rel='stylesheet' type='text/css'>

</head>

<div class="wrapper">
    <div class="sidebar" data-background-color="white" data-active-color="danger">
        <div class="sidebar-wrapper">
            <div class="logo">
                <a href="{{ action('HomeController@index') }}" class="simple-text">
                    <img href="{{ App\Subdomain::currentSubdomain()->logo() }}" alt="logo">
                </a>
            </div>

            @include('partial.sidebar')
        </div>
    </div>

    <div class="main-panel">
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle toggled">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar bar1"></span>
                        <span class="icon-bar bar2"></span>
                        <span class="icon-bar bar3"></span>
                    </button>
                    <a class="navbar-brand" href="{{ action('HomeController@index') }}">{{ App\Subdomain::currentSubdomain()->fullname }}</a>
                </div>

                {{--<div class="collapse navbar-collapse">--}}
                    {{--<ul class="nav navbar-nav navbar-right">--}}
                        {{--<li>--}}
                            {{--<a href="#" class="dropdown-toggle" data-toggle="dropdown">--}}
                                {{--<i class="ti-panel"></i>--}}
                                {{--<p>Stats</p>--}}
                            {{--</a>--}}
                        {{--</li>--}}
                        {{--<li class="dropdown">--}}
                            {{--<a href="#" class="dropdown-toggle" data-toggle="dropdown">--}}
                                {{--<i class="ti-bell"></i>--}}
                                {{--<p class="notification">5</p>--}}
                                {{--<p>Notifications</p>--}}
                                {{--<b class="caret"></b>--}}
                            {{--</a>--}}
                            {{--<ul class="dropdown-menu">--}}
                                {{--<li><a href="#">Notification 1</a></li>--}}
                                {{--<li><a href="#">Notification 2</a></li>--}}
                                {{--<li><a href="#">Notification 3</a></li>--}}
                                {{--<li><a href="#">Notification 4</a></li>--}}
                                {{--<li><a href="#">Another notification</a></li>--}}
                            {{--</ul>--}}
                        {{--</li>--}}
                        {{--<li>--}}
                            {{--<a href="#">--}}
                                {{--<i class="ti-settings"></i>--}}
                                {{--<p>Settings</p>--}}
                            {{--</a>--}}
                        {{--</li>--}}
                    {{--</ul>--}}
                {{--</div>--}}
                {{--@todo: contest menu--}}
            </div>
        </nav>


        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    @yield('content')
                </div>
            </div>
        </div>
        @include('partial.footer')
    </div>
</div>
<script src="{{ asset('frontend-bundle/js/bundle' . (config('app.assets.minified', false) ? '.min' : '') . '.js') }}"></script>
</body>
</html>
