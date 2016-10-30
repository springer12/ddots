<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ App\Subdomain::currentSubdomain()->title }}</title>

    <link href="{{ asset('frontend-bundle/css/bundle' . (config('app.assets.minified', false) ? '.min' : '') . '.css') }}"
          rel='stylesheet' type='text/css'>
</head>

<body>
<div class="wrapper">
    @include('partial.navbar')
    <div class="content">
        @yield('content')
    </div>
    <footer class="footer">
        <div class="container">
            <p class="text-justify text-muted">
                Copyright © 2005-2016, Молодёжное научное общество "Q-BIT" <br>
                тех. поддержка: Н.А. Арзубов <br>
                При использовании материалов сайта ссылка на dots.org.ua обязательна.
            </p>
        </div>
    </footer>
    @yield('scripts')
</div>
<script src="{{ asset('frontend-bundle/js/bundle' . (config('app.assets.minified', false) ? '.min' : '') . '.js') }}"></script>
</body>
</html>
