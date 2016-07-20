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
                    <button type="button" class="navbar-toggle">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar bar1"></span>
                        <span class="icon-bar bar2"></span>
                        <span class="icon-bar bar3"></span>
                    </button>
                    <a class="navbar-brand" href="{{ action('HomeController@index') }}">{{ App\Subdomain::currentSubdomain()->fullname }}</a>
                </div>

                <div class="collapse navbar-collapse">
                    @include('partial.navbar')
                </div>
                {{--@todo: contest menu--}}
            </div>
        </nav>

        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    @include('helpers.flash')
                    @yield('content')
                </div>
            </div>
        </div>
        @include('partial.footer')
    </div>
</div>

@yield('scripts')
<script src="{{ asset('frontend-bundle/js/bundle' . (config('app.assets.minified', false) ? '.min' : '') . '.js') }}"></script>
</body>
</html>
