@extends('layouts.app')
@section('scripts')
    <script src="{{ asset('ace-bundle/js/ace/ace.js') }}"></script>
    <script src="{{ asset('ace-bundle/js/ace/ext-language_tools.js') }}"></script>
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-6">
                name:
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6">
                {{ $problem->name }}
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-6">
                description:
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6">
                {{ $problem->description }}
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-6">
                difficulty:
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6">
                {{ $problem->difficulty }}
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-6">
                {{ $contest->show_max?'Best':'Latest' }} points:
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6">
                {{ $points }}
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-6">
                Contest
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6">
                <a href="{{ route('frontend::contests::single', ['id' => $contest->id]) }}">{{ $contest->name }}</a>
            </div>
        </div>
        <form data-submit-solution method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <h3>Upload solution</h3>
            <div class="ace-editor" id="editor"></div>
            <div class="form-group{{ $errors->has('programming_language') ? ' has-danger' : '' }}">
                <select data-programming-languages name="programming_language">
                    <option value="" selected>Select a language</option>
                    @foreach($contest->programming_languages as $language)
                        <option data-ace-mode="{{ $language->ace_mode }}"
                                value="{{ $language->id }}">{{ $language->name }}</option>
                    @endforeach
                </select>
                @if ($errors->has('programming_language'))
                    <span class="form-control-feedback">
                        <strong>{{ $errors->first('programming_language') }}</strong>
                    </span>
                @endif
            </div>
            <input type="file" name="solution_code_file"/>
            <input type="hidden" name="solution_code"/>
            <input type="submit" value="Submit"/>
        </form>
        <div class="card">
            <div class="card-header">Solutions</div>
            <div class="card-block">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Date</th>
                        <th>Points</th>
                        @if(Auth::check() && Auth::user()->hasRole(\App\User::ROLE_TEACHER))
                            <th>author</th>
                        @endif
                        <th>Source code</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($solutions as $solution)
                        <tr>
                            <td>{{ $solution->created_at }}</td>
                            <td>{{ $solution->getPoints() }}</td>
                            @if(Auth::check() && Auth::user()->hasRole(\App\User::ROLE_TEACHER))
                                <td class="no-wrap">
                                    @if(Auth::user()->isTeacherOf($solution->owner->id))
                                        <a href="{{ route('frontend::user::profile', ['id' => $solution->owner->id]) }}">{{ $solution->owner->name }}</a>
                                    @endif
                                </td>
                            @endif
                            <td>
                                <a href="{{ route('frontend::contests::solution',['id' => $solution->id]) }}">Solution</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
