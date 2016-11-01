@extends('layouts.main')

@section('content')
    <div class="container">

        <!-- logo and title -->
        <div class="container">
            <div>
                <a class="navbar-brand" href="{{ action('HomeController@index') }}">
                    <img src="{{ asset('frontend-bundle/media/dots.png') }}">
                </a>
            </div>
            <div>
                <h4>
                    <p>
                        С 16 февраля 2016 тестирующая система DOTS доступна для преподавателей информатики Харькова
                        и Харьковской области. Теперь все, кто преподаёт программирование, сможет зарегистрировать в
                        системе своих учеников, объединять их в группы и проводить практикумы по программированию с
                        использованием тестирующей системы. </p>
                </h4>
            </div>
        </div>

        <!-- description -->
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">Что такое dots?</div>
                    <div class="card-block">
                        <p class="text-justify">
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
            </div>
        </div>

        <!-- news -->
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">News</div>
                    <div class="card-block">
                        <div>
                            <p>Текст последней новости...</p>
                        </div>
                    </div>
                    <hr>

                    <div class="card-block">
                        <div>
                            <p>Текст последней новости...</p>
                        </div>
                    </div>
                    <hr>

                    <div class="card-block">
                        <div>
                            <p>Текст последней новости...</p>
                        </div>
                    </div>
                    <hr>
                    <div class="card-block">

                        <a href="#" class="btn btn-success pull-right">Last news</a>
                    </div>

                </div>

            </div>
        </div>

        <hr class="hidden-border">
        <!-- news -->
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">Практикум по программированию</div>

                    @foreach(\App\Subdomain::get() as $subdomain)
                        <div class="card-block">
                            <div class="row">
                                <div class="col-sm-4">
                                    <a href="{{ $subdomain->getUrl() }}"><img src="{{ $subdomain->image }}" alt="sponsor-logo" class="sponsor-logo" /></a>
                                </div>
                                <div class="col-sm-4">
                                    <a href="{{ $subdomain->getUrl() }}">{{ $subdomain->title }}</a>
                                </div>
                                <div class="col-sm-4">
                                    {{ $subdomain->description }}
                                </div>
                            </div>
                        </div>
                        <hr>
                    @endforeach

                    <div class="card-block">
                        <a href="#" class="btn btn-success pull-right">All subdomains</a>
                    </div>
                </div>

            </div>
        </div>

        <hr class="hidden-border">
        <!-- news -->
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">Project was supported by</div>

                    @foreach(\App\Sponsor::main()->get() as $sponsor)
                        <div class="card-block">
                            <div class="row">
                                <div class="col-sm-4">
                                    <a href="{{ $sponsor->link }}"><img src="{{ $sponsor->image }}" alt="sponsor-logo" class="sponsor-logo" /></a>
                                </div>
                                <div class="col-sm-4">
                                    <a href="{{ $sponsor->link }}">{{ $sponsor->name }}</a>
                                </div>
                                <div class="col-sm-4">
                                    {{ $sponsor->description }}
                                </div>
                            </div>
                        </div>
                        <hr>
                    @endforeach

                    <div class="card-block">
                        <a href="#" class="btn btn-success pull-right">All sponsors</a>
                    </div>
                </div>

            </div>
        </div>


        <hr class="hidden-border">
        <!-- news -->
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">Subdomain's teachers and mentors</div>
                    <div class="card-block">
                        <div class="row">
                            <div class="col-sm-4">
                                <a href="#"><img src="{{ asset('frontend-bundle/media/teacher.jpg') }}" alt="sponsor-logo" class="sponsor-logo" /></a>
                            </div>
                            <div class="col-sm-4">
                                <a href="#">Название</a>
                            </div>
                            <div class="col-sm-4">
                                Описание
                            </div>
                        </div>
                    </div>
                    <hr>

                    <div class="card-block">
                        <div class="row">
                            <div class="col-sm-4">
                                <a href="#"><img src="{{ asset('frontend-bundle/media/teacher.jpg') }}" alt="sponsor-logo" class="sponsor-logo" /></a>
                            </div>
                            <div class="col-sm-4">
                                <a href="#">Название</a>
                            </div>
                            <div class="col-sm-4">
                                Описание
                            </div>
                        </div>
                    </div>
                    <hr>

                    <div class="card-block">
                        <div class="row">
                            <div class="col-sm-4">
                                <a href="#"><img src="{{ asset('frontend-bundle/media/teacher.jpg') }}" alt="sponsor-logo" class="sponsor-logo" /></a>
                            </div>
                            <div class="col-sm-4">
                                <a href="#">Название</a>
                            </div>
                            <div class="col-sm-4">
                                Описание
                            </div>
                        </div>
                    </div>
                    <hr>

                    <div class="card-block">
                        <a href="#" class="btn btn-success pull-right">All teachers and mentors</a>
                    </div>
                </div>

            </div>
        </div>

    </div>
@endsection
