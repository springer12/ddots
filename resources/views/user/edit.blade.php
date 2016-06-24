@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST"
                              action="{{ action('UserController@edit') }}">
                            {{ csrf_field() }}
                            {{ method_field('PATCH') }}
                            <div><span>name: </span><span>{{ $user->name }}</span></div>

                            <div><img src="" alt="avatar"></div>

                            <div class="form-group{{ $errors->has('nickname') ? ' has-error' : '' }}">
                                <label for="nickname" class="col-md-4 control-label">Nickname</label>

                                <div class="col-md-6">
                                    <input id="nickname" class="form-control" name="nickname"
                                           value="{{ old('nickname')?old('nickname'):$user->nickname }}">

                                    @if ($errors->has('nickname'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('nickname') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('date_of_birth') ? ' has-error' : '' }}">
                                <label for="date_of_birth" class="col-md-4 control-label">birthday</label>

                                <div class="col-md-6">
                                    <input id="date_of_birth" class="form-control" name="date_of_birth"
                                           value="{{ old('date_of_birth')?old('date_of_birth'):$user->getDateOfBirth() }}">

                                    @if ($errors->has('date_of_birth'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('date_of_birth') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('profession') ? ' has-error' : '' }}">
                                <label for="profession" class="col-md-4 control-label">profession</label>

                                <div class="col-md-6">
                                    <input id="date_of_birth" class="form-control" name="profession"
                                           value="{{ old('profession')?old('profession'):$user->profession }}">

                                    @if ($errors->has('profession'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('profession') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            @if($user->hasRole(\App\User::ROLE_USER))
                                <div class="form-group{{ $errors->has('place_of_study') ? ' has-error' : '' }}">
                                    <label for="place_of_study" class="col-md-4 control-label">place of study</label>

                                    <div class="col-md-6">
                                        <input id="place_of_study" class="form-control" name="place_of_study"
                                               value="{{ old('place_of_study')?old('place_of_study'):$user->place_of_study }}">

                                        @if ($errors->has('place_of_study'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('place_of_study') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            <div class="form-group">
                                <label for="programming_language" class="col-md-4 control-label">primary programming
                                    language</label>

                                <div class="col-md-6">
                                    <button data-language-selector-button class="btn btn-primary dropdown-toggle" type="button"
                                            data-toggle="dropdown">{{ $user->programmingLanguage->name }}</button>
                                    <ul class="dropdown-menu">
                                        @foreach($langs as $lang)
                                            <li role="presentation"><a data-language-selector data-id="{{ $lang->id }}">{{ $lang->name }}</a></li>
                                        @endforeach
                                    </ul>
                                    <input type="hidden" name="programming_language"
                                           value="{{ $user->programmingLanguage->id }}"/>
                                    @if ($errors->has('programming_language'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('programming_language') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('vk_link') ? ' has-error' : '' }}">
                                <label for="vk_link" class="col-md-4 control-label">vk link</label>

                                <div class="col-md-6">
                                    <input id="vk_link" class="form-control" name="vk_link"
                                           value="{{ old('vk_link')?old('vk_link'):$user->vk_link }}">

                                    @if ($errors->has('vk_link'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('vk_link') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('fb_link') ? ' has-error' : '' }}">
                                <label for="fb_link" class="col-md-4 control-label">fb link</label>

                                <div class="col-md-6">
                                    <input id="fb_link" class="form-control" name="fb_link"
                                           value="{{ old('fb_link')?old('fb_link'):$user->fb_link }}">

                                    @if ($errors->has('fb_link'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('fb_link') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <input type="submit" value="save" class="btn btn-lg btn-primary btn-block"/>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
