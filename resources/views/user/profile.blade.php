@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-body">
                        @if($user->role != \App\User::ROLE_LOW_USER)
                            <div><span>Avatar</span></div>
                        @endif
                        <div><span>nick: </span><span>{{ $user->nickname }}</span></div>
                        <div><span>name: </span><span>{{ $user->name }}</span></div>
                        @if($user->role == \App\User::ROLE_LOW_USER && $thisUser)
                            <span>Upgrades are cool, verify your email for an upgrade!</span>
                            <a href="{{ action('UserController@upgrade', ['id' => $user->id]) }}">Upgrade!!</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
