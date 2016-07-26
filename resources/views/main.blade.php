@extends('layouts.main')

@section('content')
    <div class="content dots-domain-content">
        <div class="container-fluid">

            <!-- logo and title -->
            <div class="row">
                <div class="col-lg-3 col-sm-6">
                    <div class="dots-logo">
                        <a href="http://dots.org.ua/dots/"></a>
                    </div>
                </div>
                <div class="col-lg-9 col-sm-6 dots-tagline">
                    <h1 class="title">
                        <p>
                            С 16 февраля 2016 тестирующая система DOTS доступна для преподавателей информатики Харькова
                            и Харьковской области. Теперь все, кто преподаёт программирование, сможет зарегистрировать в
                            системе своих учеников, объединять их в группы и проводить практикумы по программированию с
                            использованием тестирующей системы. </p>
                    </h1>
                </div>
            </div>

            <!-- description -->
            <div class="row">
                <div class="col-lg-12 col-sm-12 dots-wrap-content">
                    <h2>Что такое dots?</h2>
                    <p class="dots-card" style="text-align: justify;">
                        <b>Dots</b> - это тестирующая система для dots.org.ua, написаная на Python, sh и C и интенсивно
                        использующая все возможности Docker контейнеров и Cgroup подсистемы ядра, запуская компиляторы и
                        тестируя пользовательские решения в отдельных Docker контейнерах. Такой подход делает DDots
                        максимально гибкой и модульной системой. <br> <br>

                        Один DDots обрабатывает одно решение в единицу времени и предзагружает два решения в очередь для
                        уменьшения задержек, связанных с сетью. Таким образом, для нагрузки нескольких ядер
                        рекомендуется запускать N контейнеров DDots (это делается автоматически, Makefile автоматически
                        определяет количество доступных ядер и использует все возможности). <br><br>
                    </p>
                </div>
            </div>

            <!-- news -->
            <div class="row">
                <div class="col-lg-12 col-sm-12 dots-wrap-content">
                    <h2>Новости</h2>
                    <div class="dots-card">

                        <div class="dots-news-wrap">
                            <p>Текст последней новости</p>
                            <a href="#">Подробнее</a>
                        </div>

                        <a href="#" class="dots-full-content-link"><i class="ti-arrow-circle-down"></i>Все
                            новости</a>
                    </div>
                </div>
            </div>

            <!-- practical -->
            <div class="row">
                <div class="col-lg-12 col-sm-12 dots-wrap-content">
                    <h2>Практикум по программированию</h2>
                    <div class="dots-card">
                        <div class="content table-responsive table-full-width">
                            <table class="table">
                                <tbody>
                                @foreach(\App\Subdomain::get() as $subdomain)
                                    <tr>
                                        <td class="dots-tb-cont-logo"><a href="{{ $subdomain->getUrl() }}"><img
                                                        src="{{ $subdomain->image }}"
                                                        alt="subdomain-logo"/></a></td>
                                        <td class="dots-tb-cont-name"><a href="{{ $subdomain->getUrl() }}">{{ $subdomain->title }}</a></td>
                                        <td class="dots-tb-cont-description">{{ $subdomain->description }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        <a href="#" class="dots-full-content-link"><i class="ti-arrow-circle-down"></i>Все
                            практикумы</a>
                    </div>
                </div>
            </div>

            <!-- sponsors -->
            <div class="row">
                <div class="col-lg-12 col-sm-12 dots-wrap-content">
                    <h2>Проект поддержали</h2>
                    <div class="dots-card">
                        <div class="content table-responsive table-full-width">
                            <table class="table">
                                <tbody>
                                @foreach(\App\Sponsor::main()->get() as $sponsor)
                                    <tr>
                                        <td class="dots-tb-cont-logo"><a href="{{ $sponsor->link }}"><img
                                                        src="{{ $sponsor->image }}" alt="sponsor-logo"/></a></td>
                                        <td class="dots-tb-cont-name"><a
                                                    href="{{ $sponsor->link }}">{{ $sponsor->name }}</a></td>
                                        <td class="dots-tb-cont-description">{{ $sponsor->description }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        <a href="#" class="dots-full-content-link"><i class="ti-arrow-circle-down"></i>Все спонсоры</a>
                    </div>
                </div>
            </div>

            <!-- teachers -->
            <div class="row">
                <div class="col-lg-12 col-sm-12 dots-wrap-content">
                    <h2>Преподаватели и менторы</h2>
                    <div class="dots-card">
                        <div class="content table-responsive table-full-width">
                            <table class="table">
                                <tbody>
                                <tr>
                                    <td class="dots-tb-cont-logo"><img
                                                src="{{ asset('frontend-bundle/media/teacher.jpg') }}"
                                                alt="sponsor-logo"/></td>
                                    <td class="dots-tb-cont-name">Название</td>
                                    <td class="dots-tb-cont-description">Описание</td>
                                </tr>
                                <tr>
                                    <td class="dots-tb-cont-logo"><img
                                                src="{{ asset('frontend-bundle/media/teacher.jpg') }}"
                                                alt="sponsor-logo"/></td>
                                    <td class="dots-tb-cont-name">Название</td>
                                    <td class="dots-tb-cont-description">Описание</td>
                                </tr>
                                <tr>
                                    <td class="dots-tb-cont-logo"><img
                                                src="{{ asset('frontend-bundle/media/teacher.jpg') }}"
                                                alt="sponsor-logo"/></td>
                                    <td class="dots-tb-cont-name">Название</td>
                                    <td class="dots-tb-cont-description">Описание</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                        <a href="#" class="dots-full-content-link"><i class="ti-arrow-circle-down"></i>Все
                            преподаватели и менторы</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
