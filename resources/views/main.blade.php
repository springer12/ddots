@extends('layouts.main')

@section('content')
    <div class="content dots-domain-content">
        <div class="container-fluid">

            <!-- logo and title -->
            <div class="row">
                <div class="col-lg-3 col-sm-6">
                    <div class="dots-logo">
                        <a href=""></a>
                    </div>
                </div>
                <div class="col-lg-9 col-sm-6 dots-tagline">
                    <h1 class="title">
                        <p>
                            С 16 февраля 2016 тестирующая система DOTS доступна для преподавателей информатики Харькова и Харьковской области. Теперь все, кто преподаёт программирование, сможет зарегистрировать в системе своих учеников, объединять их в группы и проводить практикумы по программированию с использованием тестирующей системы. </p>
                    </h1>
                </div>
            </div>

            <!-- description -->
            <div class="row">
                <div class="col-lg-12 col-sm-12 dots-wrap-content">
                    <h2>Что такое dots?</h2>
                    <p class="dots-card" style="text-align: justify;">
                        <b>Dots</b> - это тестирующая система для dots.org.ua, написаная на Python, sh и C и интенсивно использующая все возможности Docker контейнеров и Cgroup подсистемы ядра, запуская компиляторы и тестируя пользовательские решения в отдельных Docker контейнерах. Такой подход делает DDots максимально гибкой и модульной системой. <br> <br>

                        Один DDots обрабатывает одно решение в единицу времени и предзагружает два решения в очередь для уменьшения задержек, связанных с сетью. Таким образом, для нагрузки нескольких ядер рекомендуется запускать N контейнеров DDots (это делается автоматически, Makefile автоматически определяет количество доступных ядер и использует все возможности). <br><br>
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
                                <tr>
                                    <td class="dots-tb-cont-logo"><a href="http://hneu.dots.org.ua"><img src="{{ asset('frontend-bundle/media/subdomain_logo.png') }}" alt="sponsor-logo"/></a></td>
                                    <td class="dots-tb-cont-name"><a href="http://hneu.dots.org.ua">ХНЕУ</a></td>
                                    <td class="dots-tb-cont-description">Кафедра информационных систем, ХНЕУ</td>
                                </tr>
                                <tr>
                                    <td class="dots-tb-cont-logo"><a href="http://ag45.dots.org.ua"><img src="{{ asset('frontend-bundle/media/ag45.png') }}" alt="sponsor-logo"/></a></td>
                                    <td class="dots-tb-cont-name"><a href="http://ag45.dots.org.ua">АГ45</a></td>
                                    <td class="dots-tb-cont-description">Харьковский УВК №45 "Академическая гимназия"</td>
                                </tr>
                                <tr>
                                    <td class="dots-tb-cont-logo"><a href="http://pml27.dots.org.ua"><img src="{{ asset('frontend-bundle/media/pml27.png') }}" alt="sponsor-logo"/></a></td>
                                    <td class="dots-tb-cont-name"><a href="http://pml27.dots.org.ua">Л27</a></td>
                                    <td class="dots-tb-cont-description">Харьковский физико-математический лицей №27</td>
                                </tr>
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
                                <tr>
                                    <td class="dots-tb-cont-logo"><a href="http://www.insart.com/"><img src="{{ asset('frontend-bundle/media/insart_logo.png') }}" alt="sponsor-logo"/></a></td>
                                    <td class="dots-tb-cont-name"><a href="http://www.insart.com/">INSART Ltd.</a></td>
                                    <td class="dots-tb-cont-description">Software Engineering and R&D</td>
                                </tr>
                                <tr>
                                    <td class="dots-tb-cont-logo"><a href="http://coderivium.com/"><img src="{{ asset('frontend-bundle/media/coderivium.png') }}" alt="sponsor-logo"/></a></td>
                                    <td class="dots-tb-cont-name"><a href="http://coderivium.com/">Coderivium</a></td>
                                    <td class="dots-tb-cont-description">Mobile App Design & Development Agency</td>
                                </tr>
                                <tr>
                                    <td class="dots-tb-cont-logo"><a href="https://www.facebook.com/groups/763425083707475/"><img src="{{ asset('frontend-bundle/media/itcluster.png') }}" alt="sponsor-logo"/></a></td>
                                    <td class="dots-tb-cont-name"><a href="https://www.facebook.com/groups/763425083707475/">Kharkiv IT cluster</a></td>
                                    <td class="dots-tb-cont-description">Key goal of this group is to unite all the initiatves to promote and develop Kharkiv as a world class IT destination.</td>
                                </tr>
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
                                    <td class="dots-tb-cont-logo"><img src="{{ asset('frontend-bundle/media/teacher.jpg') }}" alt="sponsor-logo"/></td>
                                    <td class="dots-tb-cont-name">Название</td>
                                    <td class="dots-tb-cont-description">Описание</td>
                                </tr>
                                <tr>
                                    <td class="dots-tb-cont-logo"><img src="{{ asset('frontend-bundle/media/teacher.jpg') }}" alt="sponsor-logo"/></td>
                                    <td class="dots-tb-cont-name">Название</td>
                                    <td class="dots-tb-cont-description">Описание</td>
                                </tr>
                                <tr>
                                    <td class="dots-tb-cont-logo"><img src="{{ asset('frontend-bundle/media/teacher.jpg') }}" alt="sponsor-logo"/></td>
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
