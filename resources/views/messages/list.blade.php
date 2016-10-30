@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <a class="btn btn-primary" href="{{ route('frontend::messages::new') }}" role="button">New dialog</a>
            </div>
        </div>
        <hr class="hidden-border">
        <div class="row">
            <div class="col-xs-12">
                @if(!$dialog_users->isEmpty())
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Username</th>
                            <th>Last message</th>
                            <th>Date</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($dialog_users as $user)
                        <tr>
                            <td class="no-wrap">{{ $user->hasRole(\App\User::ROLE_ADMIN)?'admin':$user->name }}</td>
                            <td>
                                <a class="breaking-word" href="{{ route('frontend::messages::dialog', ['id' => $user->id]) }}#send-message">
                                    {{ $user->getLastMessageWith(Auth::user()->id)->getSenderName() }}: {{ $user->getLastMessageWith(Auth::user()->id)->text }}
                                </a>
                            </td>
                            <td class="no-wrap">{{ $user->getLastMessageWith(Auth::user()->id)->created_at }}</td>
                        </tr>

                        @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
@endsection
