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
@include('partial.navbar')

@yield('content')

@yield('scripts')
<script src="{{ asset('frontend-bundle/js/bundle' . (config('app.assets.minified', false) ? '.min' : '') . '.js') }}"></script>
</body>
</html>
