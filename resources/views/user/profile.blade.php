@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2">
                <div class="card card-user">
                    <div class="content">
                        <div class="author">
                            <img class="avatar border-white" src="{{ $user->avatar }}" alt="...">
                            <h4 class="title">{{ $user->name }}<br>
                                <a href="{{ route('frontend::user::profile', ['id' => $user->id]) }}"><small>{{ $user->nickname }}</small></a>
                            </h4>
                        </div>
                        <div class="row">
                            <div class="col-md-12 align-center">
                                @if($user->hasRole([\App\User::ROLE_USER, \App\User::ROLE_TEACHER]) && $user->vk_link)
                                    <a href="{{ $user->vk_link }}"><i class="dots-vk-icon"></i></a>
                                @endif

                                @if($user->hasRole([\App\User::ROLE_USER, \App\User::ROLE_TEACHER]) && $user->fb_link)
                                    <a href="{{ $user->fb_link }}"><i class="dots-facebook-icon"></i></a>
                                @endif
                            </div>
                        </div>
                        @if(Auth::check() && Auth::user()->id == $user->id)
                            <div class="row">
                                <div class="col-xs-10 col-xs-offset-1 col-sm-4 col-sm-offset-4 col-md-4 col-md-offset-4">
                                    <a href="{{ route('frontend::user::edit') }}" class="btn btn-lg btn-primary btn-block">
                                        @if($user->hasRole(\App\User::ROLE_LOW_USER))
                                            Upgrade
                                        @else
                                            Edit Profile
                                        @endif
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                    <hr>
                    <div class="text-center">
                        <div class="row">
                            <div class="col-md-3 col-md-offset-1">
                                @if($user->hasRole(\App\User::ROLE_USER) && $user->date_of_birth)
                                    <h5>{{ $user->getAge() }}<br><small>Years old</small></h5>
                                @endif
                            </div>
                            <div class="col-md-4">
                                @if($user->hasRole([\App\User::ROLE_USER, \App\User::ROLE_TEACHER]))
                                    <h5>{{ $user->created_at->diffInDays(Carbon\Carbon::now()) }}<br><small>{{ str_plural('Day', $user->created_at->diffInDays(Carbon\Carbon::now())) }} with us</small></h5>
                                @endif
                            </div>
                            <div class="col-md-3">
                                @if($user->hasRole([\App\User::ROLE_USER, \App\User::ROLE_TEACHER]) && $user->profession)
                                    <h5>{{ $user->profession }}<br><small>Profession</small></h5>
                                @endif
                            </div>


                            <div class="col-md-3 col-md-offset-1">
                                @if($user->hasRole(\App\User::ROLE_USER) && $user->place_of_study)
                                    <h5>{{ $user->place_of_study }}<br><small>Place of study</small></h5>
                                @endif
                            </div>
                            <div class="col-md-4">
                                @if($user->hasRole([\App\User::ROLE_USER, \App\User::ROLE_TEACHER]) && $user->programmingLanguage)
                                    <h5>{{ $user->programmingLanguage->name }}<br><small>Primary language</small></h5>
                                @endif
                            </div>
                            <div class="col-md-3"></div>
                        </div>
                    </div>
                </div>


                @if($user->hasRole(\App\User::ROLE_USER) && $user->teachers()->count())
                    <div class="card">
                        <div class="header">
                            <h4 class="title">Teachers</h4>
                        </div>
                        <div class="content">
                            <ul class="list-unstyled team-members">

                                @foreach($user->teachers as $teacher)
                                    <li>
                                        <div class="row">
                                            <div class="col-xs-3">
                                                <a href="{{ action('UserController@index', ['id' => $teacher->id]) }}">
                                                    <div class="avatar">
                                                        <img src="{{ $teacher->avatar }}" alt="Circle Image" class="img-circle img-no-padding img-responsive">
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="col-xs-6">

                                                <a href="{{ action('UserController@index', ['id' => $teacher->id]) }}">
                                                    {{ $teacher->name }}
                                                    <br>
                                                    <span class="text-muted"><small>{{ $teacher->nickname }}</small></span>
                                                </a>
                                            </div>

                                            <div class="col-xs-3 text-right">
                                                @if($teacher->vk_link)
                                                    <a href="{{ $teacher->vk_link }}"><i class="dots-vk-icon"></i></a>
                                                @endif
                                                @if($teacher->fb_link)
                                                    <a href="{{ $teacher->fb_link }}"><i class="dots-facebook-icon"></i></a>
                                                @endif
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                @endif
            </div>
        </div>
    </div>
@endsection
