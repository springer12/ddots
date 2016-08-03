@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="card">
                    <div class="header">
                        <h4 class="title">{{ $title }}</h4>
                    </div>
                    <div class="content">
                        <form method="post" class="form-horizontal form-label-left">
                            {!! csrf_field() !!}
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">

                                <div class="col-md-6 col-md-offset-3">
                                    <label for="name">Name <span class="required">*</span></label>
                                    <input type="text" name="name" class="form-control border-input" value="{{ old('name') ?: $group->name }}" required="required">
                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('students') ? ' has-error' : '' }}">
                                <div class="col-md-6 col-md-offset-3">
                                    <label for="students">Students</label>
                                    <select name="students[]"
                                            class="form-control border-input"
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
                                        <span class="help-block">
                                        <strong>{{ $errors->first('students') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">

                                <div class="col-md-6 col-md-offset-3">
                                    <label for="description">Description</label>
                                    <textarea name="description" class="form-control border-input" rows="5">{{ old('description') ?: $group->description }}</textarea>
                                    @if ($errors->has('description'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-3">
                                    <a class="btn btn-primary"
                                       href=""
                                       data-toggle="confirmation"
                                       data-message="Are you sure you want to leave the page? The changes won't be saved."
                                       data-btn-ok-href="{{ route('teacherOnly::groups::list') }}"
                                       data-btn-ok-label="Leave the page">Cancel</a>

                                    <button type="submit" class="btn btn-success">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
