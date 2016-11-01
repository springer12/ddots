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
                    <form method="post" class=" form-label-left" enctype="multipart/form-data">
                        {!! csrf_field() !!}

                        <div class="form-group row{{ $errors->has('name') ? ' has-danger' : '' }}">
                            <label class="form-control-label col-md-3 col-sm-3 col-xs-12" for="name">Name <span
                                        class="required">*</span></label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="name" value="{{ old('name') ?: $programming_language->name }}"
                                       required="required" class="form-control col-md-7 col-xs-12">
                                @if ($errors->has('name'))
                                    <span class="form-text">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row{{ $errors->has('ace_mode') ? ' has-danger' : '' }}">
                            <label class="form-control-label col-md-3 col-sm-3 col-xs-12" for="ace_mode">Ace editor mode</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="ace_mode" value="{{ old('ace_mode') ?: $programming_language->ace_mode }}"
                                       required="required" class="form-control col-md-7 col-xs-12">
                                @if ($errors->has('ace_mode'))
                                    <span class="form-text">
                                        <strong>{{ $errors->first('ace_mode') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row{{ $errors->has('compiler_image') ? ' has-danger' : '' }}">
                            <label class="form-control-label col-md-3 col-sm-3 col-xs-12" for="compiler_image">Compiler image</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="compiler_image" value="{{ old('compiler_image') ?: $programming_language->compiler_image }}"
                                       required="required" class="form-control col-md-7 col-xs-12">
                                @if ($errors->has('compiler_image'))
                                    <span class="form-text">
                                        <strong>{{ $errors->first('compiler_image') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row{{ $errors->has('executor_image') ? ' has-danger' : '' }}">
                            <label class="form-control-label col-md-3 col-sm-3 col-xs-12" for="executor_image">Executor image</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="executor_image" value="{{ old('executor_image') ?: $programming_language->executor_image }}"
                                       required="required" class="form-control col-md-7 col-xs-12">
                                @if ($errors->has('executor_image'))
                                    <span class="form-text">
                                        <strong>{{ $errors->first('executor_image') }}</strong>
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
                                   data-btn-ok-href="{{ route('backend::programming_languages::list') }}"
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
