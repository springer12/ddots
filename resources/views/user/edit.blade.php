@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2">


                <div class="card">
                    <div class="header">
                        <h4 class="title">{{ $user->hasRole(\App\User::ROLE_LOW_USER) ? 'Upgrade' : 'Update' }} Profile</h4>
                    </div>
                    <div class="content">
                        <form role="form" method="POST"
                              action="{{ $user->hasRole(\App\User::ROLE_LOW_USER) ? action('UserController@upgrade') : action('UserController@edit') }}"
                              enctype="multipart/form-data">
                            {{ csrf_field() }}

                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                        <label for="name">Full Name</label>
                                        <input id="name" name="name" type="text" class="form-control border-input" placeholder="Full Name" value="{{ old('name') ? old('name') : $user->name }}">

                                        @if ($errors->has('name'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group{{ $errors->has('nickname') ? ' has-error' : '' }}">
                                        <label for="nickname">Nickname</label>
                                        <input id="nickname" name="nickname" type="text" class="form-control border-input" placeholder="Nickname" value="{{ old('nickname') ? old('nickname') : $user->nickname }}">

                                        @if ($errors->has('nickname'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('nickname') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group{{ $errors->has('date_of_birth') ? ' has-error' : '' }}">
                                        <label for="date_of_birth">Birthday</label>
                                        <input data-datepicker id="date_of_birth" name="date_of_birth" type="date" class="form-control border-input" placeholder="Birthday" value="{{ old('date_of_birth') ? old('date_of_birth') : $user->date_of_birth }}">

                                        @if ($errors->has('date_of_birth'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('date_of_birth') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">

                                <div class="col-md-4">
                                    <div class="form-group{{ $errors->has('profession') ? ' has-error' : '' }}">
                                        <label for="profession">Profession</label>
                                        <input id="profession" name="profession" type="text" class="form-control border-input" placeholder="Profession" value="{{ old('profession') ? old('profession') : $user->profession }}">
                                        @if ($errors->has('profession'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('profession') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group{{ $errors->has('place_of_study') ? ' has-error' : '' }}">
                                        <label for="place_of_study">Place Of Study</label>
                                        <input id="place_of_study" name="place_of_study" type="text" class="form-control border-input" placeholder="Place Of Study" value="{{ old('place_of_study') ? old('place_of_study') : $user->place_of_study }}">
                                        @if ($errors->has('place_of_study'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('place_of_study') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-5">
                                    <div class="form-group{{ $errors->has('programming_language') ? ' has-error' : '' }}">
                                        <label for="programming_language">Programming Language</label>
                                        <select name="programming_language" class="form-control border-input">
                                            @foreach($programming_languages as $programming_language)
                                                <option value="{{ $programming_language->id }}"
                                                        {{ old('programming_language') == $programming_language->id ? 'selected' : ($user->programming_language == $programming_language->id ? 'selected' : '') }}>
                                                    {{ $programming_language->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('programming_language'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('programming_language') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('vk_link') ? ' has-error' : '' }}">
                                        <label for="vk_link">VK</label>
                                        <input id="vk_link" name="vk_link" type="text" class="form-control border-input" placeholder="Link to vk profile" value="{{ old('vk_link') ? old('vk_link') : $user->vk_link }}">
                                        @if ($errors->has('vk_link'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('vk_link') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('fb_link') ? ' has-error' : '' }}">
                                        <label for="fb_link">Facebook</label>
                                        <input id="fb_link" name="fb_link" type="text" class="form-control border-input" placeholder="Link to facebook profile" value="{{ old('fb_link') ? old('fb_link') : $user->fb_link }}">
                                        @if ($errors->has('fb_link'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('fb_link') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            @if($user->hasRole(\App\User::ROLE_LOW_USER))
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                            You will be sent a verification email.
                                            <label for="email">Email *</label>
                                            <input id="email" name="email" type="text" class="form-control border-input" placeholder="Link to vk profile" value="{{ old('email') ? old('email') : $user->email }}">
                                            @if ($errors->has('email'))
                                                <span class="help-block">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                            @endif

                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if(!$user->hasRole(\App\User::ROLE_LOW_USER))
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                            <label for="avatar">Avatar</label>
                                            <input id="avatar" type="file" name="avatar" accept="image/*">
                                            @if ($errors->has('avatar'))
                                                <span class="help-block">
                                                <strong>{{ $errors->first('avatar') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="text-center">
                                <button type="submit" class="btn btn-info btn-fill btn-wd">{{ $user->hasRole(\App\User::ROLE_LOW_USER) ? 'Upgrade' : 'Update' }} Profile</button>
                            </div>
                            <div class="clearfix"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
