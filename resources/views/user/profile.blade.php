@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 offset-md-1 col-lg-8 offset-lg-2">
                <div class="card text-xs-center">
                    <div class="card-header text-xs-left">Profile</div>
                    <div class="card-block">
                        <a href="{{ route('frontend::user::profile', ['id' => $user->id]) }}"><img class="card-img-top teacher-avatar" src="{{ $user->avatar }}" alt="Card image cap"></a>
                        <h4>{{ $user->name }}<br>
                            <a href="{{ route('frontend::user::profile', ['id' => $user->id]) }}"><small>{{ $user->nickname }}</small></a>
                        </h4>
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
                            <div class="text-center">
                                <a href="{{ route('frontend::user::edit') }}" class="btn btn-success">
                                    @if($user->hasRole(\App\User::ROLE_LOW_USER))
                                        Upgrade
                                    @else
                                        Update
                                    @endif
                                </a>
                            </div>
                        @endif
                    </div>
                    <hr>
                    <div>
                        <div class="row">
                            @if($user->hasRole(\App\User::ROLE_USER) && $user->date_of_birth)
                                <div class="col-md-4">
                                    <h5>{{ $user->getAge() }}<br><small>Years old</small></h5>
                                </div>
                            @endif
                            @if($user->hasRole([\App\User::ROLE_USER, \App\User::ROLE_TEACHER]))
                                <div class="col-md-4">
                                    <h5>{{ $user->created_at->diffInDays(Carbon\Carbon::now()) }}<br><small>{{ str_plural('Day', $user->created_at->diffInDays(Carbon\Carbon::now())) }} with us</small></h5>
                                </div>
                            @endif
                            @if($user->hasRole([\App\User::ROLE_USER, \App\User::ROLE_TEACHER]) && $user->profession)
                                <div class="col-md-4">
                                    <h5>{{ $user->profession }}<br><small>Profession</small></h5>
                                </div>
                            @endif


                            @if($user->hasRole(\App\User::ROLE_USER) && $user->place_of_study)
                                <div class="col-md-4">
                                    <h5>{{ $user->place_of_study }}<br><small>Place of study</small></h5>
                                </div>
                            @endif
                            @if($user->hasRole([\App\User::ROLE_USER, \App\User::ROLE_TEACHER]) && $user->programmingLanguage)
                                <div class="col-md-4">
                                    <h5>{{ $user->programmingLanguage->name }}<br><small>Primary language</small></h5>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>


                @if($user->hasRole(\App\User::ROLE_USER) && $user->teachers()->count())
                    <div class="card">
                        <div class="card-header">Teachers</div>
                        <div class="card-block">
                            <div class="row">
                                @foreach($user->teachers as $teacher)
                                    <div class="col-md-4">
                                        <div class="card text-xs-center">
                                            <a href="{{ action('UserController@index', ['id' => $teacher->id]) }}">
                                                <img class="card-img-top teacher-avatar" src="{{ $teacher->avatar }}" alt="Card image cap">
                                            </a>
                                            <div class="card-block">
                                                <a href="{{ action('UserController@index', ['id' => $teacher->id]) }}">
                                                    <h4 class="card-title">{{ $teacher->name }}</h4>
                                                    <p class="card-text"><small class="text-muted">{{ $teacher->nickname }}</small></p>
                                                </a>
                                                <div class="card-text">
                                                    @if($teacher->vk_link)
                                                        <a class="btn btn-social-icon btn-vk" href="{{ $teacher->vk_link }}"><span class="fa fa-vk"></span></a>
                                                    @endif
                                                    @if($teacher->fb_link)
                                                        <a class="btn btn-social-icon btn-facebook" href="{{ $teacher->fb_link }}"><span class="fa fa-facebook"></span></a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                @endif
            </div>
        </div>
    </div>
@endsection
