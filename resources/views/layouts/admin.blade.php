<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>DOTS</title>

    <link href="{{ asset('backend-bundle/css/bundle' . (config('app.assets.minified', false) ? '.min' : '') . '.css') }}"
          rel='stylesheet' type='text/css'>

</head>
<body class="nav-md">
<div class="container body">
    <div class="main_container">
        <div class="col-md-3 left_col">
            <div class="left_col scroll-view">
                <div class="navbar nav_title" style="border: 0;">
                    <a href="{{ action('Backend\DashboardController@index') }}" class="site_title"><i
                                class="fa fa-paw"></i> <span>DOTS ROOT</span></a>
                </div>

                <div class="clearfix"></div>

                <!-- menu profile quick info -->
                <div class="profile">
                    <div class="profile_pic">
                        <img src="{{ Auth::user()->avatar }}" alt="..." class="img-circle profile_img">
                    </div>
                    <div class="profile_info">
                        <span>Welcome,</span>
                        <h2>{{ Auth::user()->name }}</h2>
                    </div>
                </div>
                <!-- /menu profile quick info -->

                <br>

                <!-- sidebar menu -->
                <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                    <div class="menu_section active">
                        <h3>General</h3>
                        <ul class="nav side-menu" style="">
                            <li class="active"><a><i class="fa fa-home"></i> Home <span
                                            class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu" style="display: block;">
                                    <li class="{{ !Request::is(action('Backend\DashboardController@index')) ?: 'current-page' }}">
                                        <a href="{{ action('Backend\DashboardController@index') }}">Dashboard</a></li>
                                    <li class="{{ !Request::is(action('Backend\TestingServersController@index')) ?: 'current-page' }}">
                                        <a href="{{ action('Backend\TestingServersController@index') }}">Testing
                                            servers</a></li>
                                    <li class="{{ !Request::is(action('Backend\UserController@index')) ?: 'current-page' }}">
                                        <a href="{{ action('Backend\UserController@index') }}">Users</a></li>
                                    <li class="{{ !Request::is(action('Backend\NewsController@index')) ?: 'current-page' }}">
                                        <a href="{{ action('Backend\NewsController@index') }}">News</a></li>
                                    <li class="{{ !Request::is(action('Backend\ProblemController@index')) ?: 'current-page' }}">
                                        <a href="{{ action('Backend\ProblemController@index') }}">Problems</a></li>
                                    <li class="{{ !Request::is(action('Backend\VolumeController@index')) ?: 'current-page' }}">
                                        <a href="{{ action('Backend\VolumeController@index') }}">Volumes</a></li>
                                    <li class="{{ !Request::is(action('Backend\SponsorController@index')) ?: 'current-page' }}">
                                        <a href="{{ action('Backend\SponsorController@index') }}">Sponsors</a></li>
                                    <li class="{{ !Request::is(action('Backend\SubdomainController@index')) ?: 'current-page' }}">
                                        <a href="{{ action('Backend\SubdomainController@index') }}">Subdomains</a></li>
                                    <li class="{{ !Request::is(action('Backend\ContestController@index')) ?: 'current-page' }}">
                                        <a href="{{ action('Backend\ContestController@index') }}">Contests</a></li>
                                    <li class="{{ !Request::is(action('Backend\GroupController@index')) ?: 'current-page' }}">
                                        <a href="{{ action('Backend\GroupController@index') }}">Groups</a></li>
                                    <li class="{{ !Request::is(action('Backend\ProgrammingLanguageController@index')) ?: 'current-page' }}">
                                        <a href="{{ action('Backend\ProgrammingLanguageController@index') }}">Programming
                                            languages</a></li>
                                    <li class="{{ !Request::is(action('Backend\MessageController@index')) ?: 'current-page' }}">
                                        <a href="{{ action('Backend\MessageController@index') }}">Dialogs</a></li>
                                    <li class="{{ !Request::is(action('Backend\TesterController@index')) ?: 'current-page' }}">
                                        <a href="{{ action('Backend\TesterController@index') }}">Fake tester</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- /sidebar menu -->

            </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
            <div class="nav_menu">
                <nav class="" role="navigation">
                    <div class="nav toggle">
                        <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                    </div>

                    <ul class="nav navbar-nav navbar-right">
                        <li class="">
                            <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown"
                               aria-expanded="false">
                                <img src="{{ Auth::user()->avatar }}" alt="">{{ Auth::user()->name }}
                            </a>
                            <div class="dropdown-menu pull-right">
                                <a class="dropdown-item" href="{{ url('/logout') }}"><i
                                            class="fa fa-sign-out pull-right"></i> Log Out</a>
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
        <!-- /top navigation -->
    </div>
    <!-- /page content -->
    <div class="right_col" role="main">
        @include('helpers.flash')
        @yield('content')
    </div>
    <footer>
        <div class="pull-right"></div>
        <div class="clearfix"></div>
    </footer>
</div>


</body>

{{--@yield('content')--}}

<script src="{{ asset('backend-bundle/js/bundle' . (config('app.assets.minified', false) ? '.min' : '') . '.js') }}"></script>
<script src="//cdn.ckeditor.com/4.5.11/standard/ckeditor.js"></script>
</body>
</html>
