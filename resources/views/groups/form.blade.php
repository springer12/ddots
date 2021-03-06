@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">{{ $title }}</div>
                    <div class="card-block">
                        <form method="post">
                            {!! csrf_field() !!}
                            <div class="form-group row{{ $errors->has('name') ? ' has-danger' : '' }}">
                                <label class="form-control-label col-md-4" for="name">@lang('layout.name') <span
                                            class="required">*</span></label>
                                <div class="col-md-8">
                                    <input type="text" name="name" class="form-control border-input"
                                           value="{{ old('name') ?: $group->name }}" required="required">
                                    @if ($errors->has('name'))
                                        <span class="form-control-feedback">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row{{ $errors->has('students') ? ' has-danger' : '' }}">
                                <label class="form-control-label col-md-4" for="students">@lang('menu.students')</label>
                                <div class="col-md-8">
                                    <select name="students[]"
                                            data-select-students
                                            data-get-students-url="{{ route('backend::ajax::getStudents') }}"
                                            class="form-control col-md-7 col-xs-12"
                                            multiple>
                                        @foreach($students as $student)
                                            <option value="{{ $student->id }}"
                                                    selected>{{ $student->name }}</option>
                                        @endforeach
                                        @foreach($unincludedStudents as $student)
                                            <option value="{{ $student->id }}">{{ $student->name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('students'))
                                        <span class="form-control-feedback">
                                        <strong>{{ $errors->first('students') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row{{ $errors->has('description') ? ' has-danger' : '' }}">
                                <label class="form-control-label col-md-4"
                                       for="description">@lang('layout.description')</label>
                                <div class="col-md-8">
                                    <textarea name="description" class="form-control border-input"
                                              rows="5">{{ old('description') ?: $group->description }}</textarea>
                                    @if ($errors->has('description'))
                                        <span class="form-control-feedback">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <hr class="hidden-border">
                            <div class="form-group">
                                <div class="col-md-8 offset-md-3">
                                    <a class="btn btn-primary"
                                       href=""
                                       data-toggle="confirmation"
                                       data-message="@lang('layout.cancel_warn')"
                                       data-btn-ok-href="{{ route('teacherOnly::groups::list') }}"
                                       data-btn-cancel-label="@lang('layout.cancel')"
                                       data-btn-ok-label="@lang('layout.leave_page')">@lang('layout.cancel')</a>

                                    <button type="submit" class="btn btn-success">@lang('layout.save')</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
