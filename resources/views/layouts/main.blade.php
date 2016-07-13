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

<div class="wrapper dots-domain-wrap">


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
                    <a class="navbar-brand" href="#">Домены</a>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">

                        <li>
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="ti-file"></i>
                                <p>Инструкция</p>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="ti-id-badge"></i>
                                <p>Регистрация</p>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="ti-user"></i>
                                <p>Вход</p>
                            </a>
                        </li>

                    </ul>

                </div>
            </div>
        </nav>

        @include('helpers.flash')
        @yield('content')

        <footer class="footer">
            <div class="container-fluid">
                <div class="align-center copyright">
                    Copyright © 2005-2016, Молодёжное научное общество "Q-BIT" <br>
                    тех. поддержка: Н.А. Арзубов <br>
                    При использовании материалов сайта ссылка на dots.org.ua обязательна.
                </div>
            </div>
        </footer>

    </div>
</div>

</body>
<script src="{{ asset('frontend-bundle/js/bundle' . (config('app.assets.minified', false) ? '.min' : '') . '.js') }}"></script>
</body>
</html>
