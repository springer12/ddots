<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <link href="{{ asset('frontend-bundle/css/bundle' . (config('app.assets.minified', false) ? '.min' : '') . '.css') }}" rel='stylesheet' type='text/css'>

</head>


<body>
<header class="navbar navbar-dark bg-inverse navbar-static-top bd-navbar">
    <div class="container">
        <nav>
            <button class="navbar-toggler float-xs-right hidden-sm-up" type="button" data-toggle="collapse" data-target="#bd-main-nav" aria-controls="bd-main-nav" aria-expanded="false" aria-label="Toggle navigation"></button>

            <div class="collapse navbar-toggleable-xs" id="bd-main-nav">
                <a class="navbar-brand" href="{{ action('HomeController@index') }}">
                    DOTS
                </a>
                <ul class="nav navbar-nav ">
                    <li class="nav-item {{ Request::is('teachers') ? 'active' : '' }}"><a class="nav-item nav-link" href="{{ route('allTeachers') }}">Teachers</a></li>
                </ul>
                <ul class="nav navbar-nav  float-md-right">
                    <li class="nav-item"><a class="nav-item nav-link" href="{{ url('/register') }}"><i class="fa fa-file-o" aria-hidden="true"></i> Instructions</a></li>{{-- @todo --}}
                    <li class="nav-item"><a class="nav-item nav-link" href="{{ url('/register') }}"><i class="fa fa-sign-in" aria-hidden="true"></i> Register</a></li>
                </ul>
            </div>
        </nav>
    </div>
</header>

@include('helpers.flash')
@yield('content')

<footer class="footer">
    <div class="container">
        <p class="text-justify text-muted text-xs-center">
            Copyright © 2005-2016, Молодёжное научное общество "Q-BIT" <br>
            тех. поддержка: Н.А. Арзубов <br>
            При использовании материалов сайта ссылка на dots.org.ua обязательна.
        </p>
    </div>
</footer>


</body>
<script src="{{ asset('frontend-bundle/js/bundle' . (config('app.assets.minified', false) ? '.min' : '') . '.js') }}"></script>
<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-86644916-1', 'auto');
    ga('send', 'pageview');

</script>
</body>
</html>
