@extends('layouts.app')
@section('scripts')
    <script src="{{ asset('ace-bundle/js/ace/ace.js') }}"></script>
    <script src="{{ asset('ace-bundle/js/ace/ext-language_tools.js') }}"></script>
@endsection
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <a href="{{ route('frontend::contests::single', ['id' => $contest->id]) }}">{{ $contest->name }}</a>
                <i class="fa fa-angle-double-right" aria-hidden="true"></i>
                {{ $problem->name }}
                <span class="float-xs-right">
                    @for($i = 0; $i < $problem->difficulty; $i++)
                        <i class="fa fa-star" aria-hidden="true"></i>
                    @endfor
                </span>
            </div>
            <div class="card-block">

                <div class="align-center form-group">
                    <img src="{{ $problem->image }}"  style="max-width: 100%">
                </div>

            </div>
        </div>
        <div class="card">
            <div class="card-header">
                New Solution
            </div>
            <div class="card-block">
                <form data-submit-solution method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}


                    <div class="form-group row {{ $errors->has('programming_language') ? ' has-danger' : '' }}">
                        <label class="col-md-4 col-form-label" for="programming_language">Programming language</label>
                        <div class="col-md-8">
                            <select data-programming-languages name="programming_language"
                                    class="form-control border-input">
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
                    </div>

                    <div class="form-group">
                        <div class="ace-editor" id="editor"></div>
                    </div>

                    <div class="form-group row{{ $errors->has('solution_code_file') ? ' has-danger' : '' }}">
                        <label class="form-control-label col-md-4" for="solution_code_file">Or upload file</label>
                        <div class="col-md-8">
                            <input type="file" name="solution_code_file"/>
                            @if ($errors->has('solution_code_file'))
                                <span class="form-control-feedback">
                                    <strong>{{ $errors->first('solution_code_file') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>


                    <input type="hidden" name="solution_code"/>
                    <hr class="hidden-border">
                    <div class="form-group">
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-header">Solutions</div>
            <div class="card-block">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-sm">
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
                    <div class="col-md-12 align-center">{{ $solutions->links() }}</div>
                </div>
            </div>
        </div>
    </div>
@endsection
