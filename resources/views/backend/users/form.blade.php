@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>{{ $title }}</h2>

                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <br>
                    <form method="post" class="form-label-left" enctype="multipart/form-data">
                        {!! csrf_field() !!}
                        <div class="form-group row{{ $errors->has('name') ? ' has-danger' : '' }}">
                            <label class="form-control-label col-md-3 col-sm-3 col-xs-12" for="name">Name <span
                                        class="required">*</span></label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="name" value="{{ old('name') ?: $user->name }}"
                                       required="required" class="form-control col-md-7 col-xs-12">
                                @if ($errors->has('name'))
                                    <span class="form-text">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row{{ $errors->has('avatar') ? ' has-danger' : '' }}">
                            <label class="form-control-label col-md-3 col-sm-3 col-xs-12" for="avatar">Avatar</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div><img width="100" height="100" src="{{ $user->avatar }}" alt="avatar"></div>
                                <input type="file" name="avatar" id="avatar">

                            </div>
                        </div>
                        <div class="form-group row{{ $errors->has('password') ? ' has-danger' : '' }}">
                            <label class="form-control-label col-md-3 col-sm-3 col-xs-12" for="password">Password{!! !$passwordRequired?'':' <span
                                            class="required">*</span>' !!}</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="password" name="password" value="{{ old('password') }}"
                                       {!! !$passwordRequired?:'required="required"' !!}
                                       class="form-control col-md-7 col-xs-12">
                                @if ($errors->has('password'))
                                    <span class="form-text">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row{{ $errors->has('password_confirmation') ? ' has-danger' : '' }}">
                            <label class="form-control-label col-md-3 col-sm-3 col-xs-12" for="password_confirmation">Confirm
                                password{!! !$passwordRequired?'':' <span
                                            class="required">*</span>' !!}</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="password" name="password_confirmation"
                                       value="{{ old('password_confirmation') }}"
                                       {!! !$passwordRequired?:'required="required"' !!}
                                       class="form-control col-md-7 col-xs-12">
                                @if ($errors->has('password_confirmation'))
                                    <span class="form-text">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row{{ $errors->has('email') ? ' has-danger' : '' }}">
                            <label class="form-control-label col-md-3 col-sm-3 col-xs-12" for="email">E-mail <span
                                        class="required">*</span></label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="email" value="{{ old('email') ?: $user->email }}"
                                       required="required"
                                       class="form-control col-md-7 col-xs-12">
                                @if ($errors->has('email'))
                                    <span class="form-text">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group row{{ $errors->has('role') ? ' has-danger' : '' }}">
                            <label class="form-control-label col-md-3 col-sm-3 col-xs-12" for="role">Role <span
                                        class="required">*</span></label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select name="role" required="required" class="form-control col-md-7 col-xs-12"
                                        data-role-select>
                                    @foreach(App\User::SETTABLE_ROLES as $role => $name)
                                        <option value="{{ $role }}" {{ !$user->hasRole($role)?:'selected' }} {{ !($role == App\User::ROLE_TEACHER)?:'data-teacher-option' }}>{{ $name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('role'))
                                    <span class="form-text">
                                        <strong>{{ $errors->first('role') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group row{{ $errors->has('nickname') ? ' has-danger' : '' }}">
                            <label class="form-control-label col-md-3 col-sm-3 col-xs-12" for="nickname">Nickname <span
                                        class="required">*</span></label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="nickname" value="{{ old('nickname') ?: $user->nickname }}"
                                       required="required" class="form-control col-md-7 col-xs-12">
                                @if ($errors->has('nickname'))
                                    <span class="form-text">
                                        <strong>{{ $errors->first('nickname') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row{{ $errors->has('date_of_birth') ? ' has-danger' : '' }}">
                            <label class="form-control-label col-md-3 col-sm-3 col-xs-12" for="date_of_birth">Date of
                                birth</label>

                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input data-datepicker id="date_of_birth" class="form-control col-md-7 col-xs-12"
                                       type="date"
                                       name="date_of_birth"
                                       value="{{ old('date_of_birth')?old('date_of_birth'):$user->date_of_birth }}">
                                @if ($errors->has('date_of_birth'))
                                    <span class="form-text">
                                        <strong>{{ $errors->first('date_of_birth') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group row{{ $errors->has('place_of_study') ? ' has-danger' : '' }}">
                            <label class="form-control-label col-md-3 col-sm-3 col-xs-12" for="place_of_study">Place of
                                study </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="place_of_study"
                                       value="{{ old('place_of_study') ?: $user->place_of_study }}"
                                       class="form-control col-md-7 col-xs-12">
                                @if ($errors->has('place_of_study'))
                                    <span class="form-text">
                                        <strong>{{ $errors->first('place_of_study') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div data-subdomain-select class="form-group row{{ $errors->has('subdomain') ? ' has-danger' : '' }}"
                             style="display: {{ $user->hasRole(\App\User::ROLE_TEACHER)?'block':'none' }}">
                            <label class="form-control-label col-md-3 col-sm-3 col-xs-12" for="role">Subdomain</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select name="subdomain" class="form-control col-md-7 col-xs-12">
                                    @if($user->subdomains->isEmpty())
                                        <option value="" selected>Select a subdomain</option>
                                    @endif
                                    @foreach(\App\Subdomain::get() as $subdomain)
                                        <option value="{{ $subdomain->id }}" {{ !$user->subdomains->contains($subdomain->id)?:'selected' }}>{{ $subdomain->name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('subdomain'))
                                    <span class="form-text">
                                        <strong>{{ $errors->first('subdomain') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row{{ $errors->has('programming_language') ? ' has-danger' : '' }}">
                            <label class="form-control-label col-md-3 col-sm-3 col-xs-12" for="programming_language">Programming
                                language</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select name="programming_language" class="form-control col-md-7 col-xs-12">
                                    <option value="">Not selected</option>
                                    @foreach($programming_languages as $programming_language)
                                        <option value="{{ $programming_language->id }}"
                                                {{ $user->programming_language != $programming_language->id?:'selected' }}
                                        >{{ $programming_language->name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('programming_language'))
                                    <span class="form-text">
                                        <strong>{{ $errors->first('programming_language') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row{{ $errors->has('vk_link') ? ' has-danger' : '' }}">
                            <label class="form-control-label col-md-3 col-sm-3 col-xs-12" for="vk_link">VK link</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="vk_link" value="{{ old('vk_link') ?: $user->vk_link }}"
                                       class="form-control col-md-7 col-xs-12">
                                @if ($errors->has('vk_link'))
                                    <span class="form-text">
                                        <strong>{{ $errors->first('vk_link') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row{{ $errors->has('fb_link') ? ' has-danger' : '' }}">
                            <label class="form-control-label col-md-3 col-sm-3 col-xs-12" for="fb_link">FB link</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="fb_link" value="{{ old('fb_link') ?: $user->fb_link }}"
                                       class="form-control col-md-7 col-xs-12">
                                @if ($errors->has('fb_link'))
                                    <span class="form-text">
                                        <strong>{{ $errors->first('fb_link') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="ln_solid"></div>
                        <div class="form-group row">
                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                <a class="btn btn-primary"
                                   href=""
                                   data-toggle="confirmation"
                                   data-message="Are you sure you want to leave the page? The changes won't be saved."
                                   data-btn-ok-href="{{ route('backend::users::list') }}"
                                   data-btn-ok-label="Leave the page">Cancel</a>

                                <button type="submit" class="btn btn-success">Save</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
