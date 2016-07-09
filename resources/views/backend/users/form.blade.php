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
                    <form method="post" class="form-horizontal form-label-left" enctype="multipart/form-data">
                        {!! csrf_field() !!}
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Name <span
                                        class="required">*</span></label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="name" value="{{ old('name') ?: $user->name }}"
                                       required="required" class="form-control col-md-7 col-xs-12">
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('avatar') ? ' has-error' : '' }}">
                            <div><img width="100" height="100" src="{{ $user->avatar }}" alt="avatar"></div>
                            <input type="file" name="avatar" id="avatar">
                        </div>
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="password">Password{!! !$passwordRequired?'':' <span
                                            class="required">*</span>' !!}</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="password" name="password" value="{{ old('password') }}"
                                       {!! !$passwordRequired?:'required="required"' !!}
                                       class="form-control col-md-7 col-xs-12">
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="password_confirmation">Confirm
                                password{!! !$passwordRequired?'':' <span
                                            class="required">*</span>' !!}</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="password" name="password_confirmation"
                                       value="{{ old('password_confirmation') }}"
                                       {!! !$passwordRequired?:'required="required"' !!}
                                       class="form-control col-md-7 col-xs-12">
                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">E-mail <span
                                        class="required">*</span></label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="email" value="{{ old('email') ?: $user->email }}"
                                       required="required"
                                       class="form-control col-md-7 col-xs-12">
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group{{ $errors->has('role') ? ' has-error' : '' }}">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="role">Role <span
                                        class="required">*</span></label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select name="role" required="required" class="form-control col-md-7 col-xs-12">
                                    @foreach(App\User::SETTABLE_ROLES as $role => $name)
                                        <option value="{{ $role }}" {{ !$user->hasRole($role)?:'selected' }}>{{ $name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('role'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('role') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group{{ $errors->has('nickname') ? ' has-error' : '' }}">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nickname">Nickname <span
                                        class="required">*</span></label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="nickname" value="{{ old('nickname') ?: $user->nickname }}"
                                       required="required" class="form-control col-md-7 col-xs-12">
                                @if ($errors->has('nickname'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('nickname') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group{{ $errors->has('date_of_birth') ? ' has-error' : '' }}">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="date_of_birth">Date of
                                birth</label>

                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input data-datepicker id="date_of_birth" class="form-control col-md-7 col-xs-12"
                                       name="date_of_birth"
                                       value="{{ old('date_of_birth')?old('date_of_birth'):$user->date_of_birth }}">
                                @if ($errors->has('date_of_birth'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('date_of_birth') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group{{ $errors->has('place_of_study') ? ' has-error' : '' }}">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="place_of_study">Place of
                                study </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="place_of_study"
                                       value="{{ old('place_of_study') ?: $user->place_of_study }}"
                                       class="form-control col-md-7 col-xs-12">
                                @if ($errors->has('place_of_study'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('place_of_study') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="programming_language" class="col-md-4 control-label">primary programming
                                language</label>

                            <div class="col-md-6">
                                <button data-language-selector-button class="btn btn-primary dropdown-toggle"
                                        type="button"
                                        data-toggle="dropdown">@if($user->programmingLanguage)
                                        {{ $user->programmingLanguage->name }}
                                    @else
                                        Not Selected
                                    @endif
                                </button>
                                <ul class="dropdown-menu">
                                    @foreach($programming_languages as $programming_language)
                                        <li role="presentation"><a data-language-selector
                                                                   data-id="{{ $programming_language->id }}">{{ $programming_language->name }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                                <input type="hidden" name="programming_language"
                                       @if($user->programmingLanguage)
                                       value="{{ $user->programmingLanguage->id }}
                                       @endif
                                               "/>
                                @if ($errors->has('programming_language'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('programming_language') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('vk_link') ? ' has-error' : '' }}">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="vk_link">VK link</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="vk_link" value="{{ old('vk_link') ?: $user->vk_link }}"
                                       class="form-control col-md-7 col-xs-12">
                                @if ($errors->has('vk_link'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('vk_link') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('fb_link') ? ' has-error' : '' }}">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="fb_link">FB link</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="fb_link" value="{{ old('fb_link') ?: $user->fb_link }}"
                                       class="form-control col-md-7 col-xs-12">
                                @if ($errors->has('fb_link'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('fb_link') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="ln_solid"></div>
                        <div class="form-group">
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
