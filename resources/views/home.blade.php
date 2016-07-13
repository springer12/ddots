@extends('layouts.app')

@section('content')
    <div class="content">
        <div class="container-fluid">

            <!-- logo and title -->
            <div class="row">
                <div class="col-lg-3 col-sm-6">
                    <div class="dots-logo dots-sub-logo">
                        <img src="media/subdomain_logo.png" alt="sub-logo" />
                    </div>
                </div>
                <div class="col-lg-9 col-sm-6 dots-tagline">
                    <h1 class="title">
                        <p>Академическая гимназия №45</p>
                        <p>Практикум по програмированию</p>
                    </h1>
                </div>
            </div>

            <!-- description -->
            <div class="row">
                <div class="col-lg-12 col-sm-12 dots-wrap-content">
                    <h2>Форма входа</h2>
                    <div class="dots-card">
                        <form class="form-inline" role="form">
                            <div class="form-group">
                                <label class="sr-only" for="exampleInputEmail2">Email</label>
                                <input type="email" class="form-control border-input" id="exampleInputEmail2" placeholder="Enter email">
                            </div>
                            <div class="form-group has-error">
                                <label class="sr-only" for="exampleInputPassword2">Пароль</label>
                                <input type="password" class="form-control border-input" id="exampleInputPassword2" placeholder="Password">
                        <span class="help-block">
                          <strong>Неверный пароль</strong>
                        </span>
                            </div>
                            <button type="submit" class="btn btn-primary btn-wd">Войти</button>
                            <div class="dots-social-enter">
                                <span>Или войдите через:</span>
                                <ul class="dots-social-icons">
                                    <li><a href="#"><i class="dots-vk-icons"></i></a></li>
                                    <li><a href="#"><i class="dots-google-icons"></i></a></li>
                                    <li><a href="#"><i class="dots-faceboock-icons"></i></a></li>
                                </ul>
                            </div>
                        </form>
                    </div>
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

                        <a href="#" class="dots-full-content-link"><i class="ti-arrow-circle-down"></i>Все новости</a>
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
                                    <td class="dots-tb-cont-logo"><img src="media/sponsor1.png" alt="sponsor-logo" /></td>
                                    <td class="dots-tb-cont-name">Название</td>
                                    <td class="dots-tb-cont-description">Описание</td>
                                </tr>
                                <tr>
                                    <td class="dots-tb-cont-logo"><img src="media/sponsor2.png" alt="sponsor-logo" /></td>
                                    <td class="dots-tb-cont-name">Название</td>
                                    <td class="dots-tb-cont-description">Описание</td>
                                </tr>
                                <tr>
                                    <td class="dots-tb-cont-logo"><img src="media/sponsor3.png" alt="sponsor-logo" /></td>
                                    <td class="dots-tb-cont-name">Название</td>
                                    <td class="dots-tb-cont-description">Описание</td>
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
                    <h2>Преподаватели и менторы поддомена</h2>
                    <div class="dots-card">
                        <div class="content table-responsive table-full-width">
                            <table class="table">
                                <tbody>
                                <tr>
                                    <td class="dots-tb-cont-logo">lOGO</td>
                                    <td class="dots-tb-cont-name">Название</td>
                                    <td class="dots-tb-cont-description">Описание</td>
                                </tr>
                                <tr>
                                    <td class="dots-tb-cont-logo">lOGO</td>
                                    <td class="dots-tb-cont-name">Название</td>
                                    <td class="dots-tb-cont-description">Описание</td>
                                </tr>
                                <tr>
                                    <td class="dots-tb-cont-logo">lOGO</td>
                                    <td class="dots-tb-cont-name">Название</td>
                                    <td class="dots-tb-cont-description">Описание</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                        <a href="#" class="dots-full-content-link"><i class="ti-arrow-circle-down"></i>Все преподаватели и менторы</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
