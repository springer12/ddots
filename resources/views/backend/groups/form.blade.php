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
                        <div class="form-group row{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label class="form-control-label col-md-3 col-sm-3 col-xs-12" for="name">Name <span
                                        class="required">*</span></label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="name" value="{{ old('name') ?: $group->name }}"
                                       required="required" class="form-control col-md-7 col-xs-12">
                                @if ($errors->has('name'))
                                    <span class="form-text">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row{{ $errors->has('description') ? ' has-error' : '' }}">
                            <label class="form-control-label col-md-3 col-sm-3 col-xs-12"
                                   for="description">Description</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <textarea class="form-control col-md-7 col-xs-12"
                                          name="description">{{ old('description') ?: $group->description }}</textarea>
                                @if ($errors->has('description'))
                                    <span class="form-text">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row{{ $errors->has('owner') ? ' has-error' : '' }}">
                            <label class="form-control-label col-md-3 col-sm-3 col-xs-12"
                                   for="participants">Owner</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select name="owner" data-select-owner
                                        data-teacher-search-url="{{ route('backend::ajax::searchTeachers') }}"
                                        class="form-control col-md-7 col-xs-12">
                                    @if($owner)
                                        <option value="{{ $owner->id }}" selected>{{ $owner->name }}</option>
                                    @endif
                                </select>
                                @if ($errors->has('owner'))
                                    <span class="form-text">
                                        <strong>{{ $errors->first('owner') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row{{ $errors->has('students') ? ' has-error' : '' }}">
                            <label class="form-control-label col-md-3 col-sm-3 col-xs-12"
                                   for="students">Students</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select name="students[]" data-select-students
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
                                    <span class="form-text">
                                        <strong>{{ $errors->first('students') }}</strong>
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
                                   data-btn-ok-href="{{ route('backend::groups::list') }}"
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
