@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-body">
                        {{-- @if(!$user->hasRole(\App\User::ROLE_LOW_USER)) --}}
                        <div><img width="100" height="100" src="{{ $user->getAvatar() }}" alt="avatar"></div>
                        {{-- @endif --}}
                        <div><span>nick: </span><span>{{ $user->nickname }}</span></div>
                        <div><span>name: </span><span>{{ $user->name }}</span></div>
                        @if($user->hasRole(\App\User::ROLE_USER) && $user->date_of_birth)
                            <div><span>age: </span><span>{{ $user->getAge() }}</span></div>
                        @endif
                        @if($user->hasRole([\App\User::ROLE_USER, \App\User::ROLE_TEACHER]))
                            <div><span>date of registration: </span><span>{{ $user->getRegistrationDate() }}</span>
                            </div>
                        @endif
                        @if($user->hasRole([\App\User::ROLE_USER, \App\User::ROLE_TEACHER]) && $user->profession)
                            <div><span>profession: </span><span>{{ $user->profession }}</span></div>
                        @endif
                        @if($user->hasRole(\App\User::ROLE_USER) && $user->place_of_study)
                            <div><span>place_of_study: </span><span>{{ $user->place_of_study }}</span></div>
                        @endif
                        @if($user->hasRole([\App\User::ROLE_USER, \App\User::ROLE_TEACHER]) && $user->programmingLanguage)
                            <div>
                                <span>primary programming language: </span><span>{{ $user->programmingLanguage->name }}</span>
                            </div>
                        @endif
                        @if($user->hasRole([\App\User::ROLE_USER, \App\User::ROLE_TEACHER]) && $user->vk_link)
                            <div><span>vk: </span><a href="{{$user->vk_link}}">VK</a></div>
                        @endif
                        @if($user->hasRole([\App\User::ROLE_USER, \App\User::ROLE_TEACHER]) && $user->fb_link)
                            <div><span>fb: </span><a href="{{$user->fb_link}}">FB</a></div>
                        @endif
                        @if(\Illuminate\Support\Facades\Auth::user()->id == $user->id && $user->hasRole(\App\User::ROLE_USER))
                            <form method="post" action="{{ action('UserController@addTeacher') }}">
                                {{ csrf_field() }}
                                <input type="text" name="id"/>
                                <button type="submit" class="btn btn-lg btn-primary btn-block">Add</button>
                            </form>
                        @endif
                        @if($user->hasRole(\App\User::ROLE_USER) && $user->teachers)
                            teachers:
                            @foreach($user->teachers as $teacher)
                                <a href="{{ action('UserController@index', ['id' => $teacher->id]) }}">{{ $teacher->name }}</a>
                            @endforeach
                        @endif
                        @if($user->hasRole(\App\User::ROLE_TEACHER) && $user->students)
                            students:
                            @foreach($user->students as $student)
                                <a href="{{ action('UserController@index', ['id' => $student->id]) }}">{{ $student->name }}</a>
                            @endforeach
                        @endif
                        @if(\Illuminate\Support\Facades\Auth::user()->id == $user->id)
                            <a href="{{ route('frontend::user::edit') }}" class="btn btn-lg btn-primary btn-block">
                                @if($user->hasRole(\App\User::ROLE_LOW_USER))
                                    Upgrade
                                @else
                                    Edit Profile
                                @endif
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
