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
                    <form method="post" class="form-horizontal form-label-left">
                        {!! csrf_field() !!}
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Name <span
                                        class="required">*</span></label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="name" value="{{ old('name') ?: $contest->name }}"
                                       required="required" class="form-control col-md-7 col-xs-12">
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="description">Description<span
                                        class="required">*</span></label></label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <textarea name="description" required="required"
                                          class="form-control col-md-7 col-xs-12"
                                >{{ old('description') ?: $contest->description }}</textarea>
                                @if ($errors->has('description'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('start_date') ? ' has-error' : '' }}">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="start_date">Start date<span
                                        class="required">*</span></label></label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="datetime" name="start_date" data-start-datepicker
                                       value="{{ old('start_date') ?: $contest->start_date }}"
                                       required="required" class="form-control col-md-7 col-xs-12">
                                @if ($errors->has('start_date'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('start_date') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('end_date') ? ' has-error' : '' }}">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="end_date">End date<span
                                        class="required">*</span></label></label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="datetime" name="end_date" data-end-datepicker
                                       value="{{ old('end_date') ?: $contest->end_date }}"
                                       required="required" class="form-control col-md-7 col-xs-12">
                                @if ($errors->has('end_date'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('end_date') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('owner') ? ' has-error' : '' }}">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="owner">Owner <span
                                        class="required">*</span></label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select name="owner" required="required" class="form-control col-md-7 col-xs-12">
                                    @if(!$contest->owner)
                                        <option value="">Select a teacher</option>
                                    @endif
                                    @foreach($teachers as $teacher)
                                        <option value="{{ $teacher->id }}"
                                        @if(old('owner'))
                                            {{ !(old('owner') == $teacher->id)?:'selected' }}
                                                @elseif($contest->owner)
                                            {{ !$contest->owner->id == $teacher->id?:'selected' }}
                                                @endif
                                        >{{ $teacher->name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('owner'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('owner') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('is_active') ? ' has-error' : '' }}">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12"
                                   for="is_active">Active</label></label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="checkbox" name="is_active"
                                       class="form-control col-md-7 col-xs-12"
                                @if($errors->has())
                                    {{ !old('is_active')?:'checked' }}
                                        @else
                                    {{ !$contest->is_active?:'checked' }}
                                        @endif
                                >
                                @if ($errors->has('is_active'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('is_active') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('is_standings_active') ? ' has-error' : '' }}">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="is_standings_active">Active
                                standings</label></label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="checkbox" name="is_standings_active"

                                       class="form-control col-md-7 col-xs-12"
                                @if($errors->has())
                                    {{ !old('is_standings_active')?:'checked' }}
                                        @else
                                    {{ !$contest->is_standings_active?:'checked' }}
                                        @endif>
                                @if ($errors->has('is_standings_active'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('is_standings_active') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

<div class="col-md-12 text-center"><h2>Programming languages</h2></div>
                        @if(old('programming_languages'))
                            @foreach($programming_languages as $programming_language)
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12"
                                           for="programming_language">{{ $programming_language->name }}</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">

                                        <input id="programming_language" type="checkbox" name="programming_languages[]"
                                               class="form-control col-md-7 col-xs-12"
                                               value="{{ $programming_language->id }}" {{ !in_array($programming_language->id, old('programming_languages'))?:'checked' }}>
                                    </div>
                                </div>
                            @endforeach
                        @elseif($errors->has('programming_languages'))
                            {{ $errors->first('programming_languages') }}
                            @foreach($programming_languages as $programming_language)
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12"
                                           for="programming_language">{{ $programming_language->name }}</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input id="programming_language" type="checkbox" name="programming_languages[]"
                                               class="form-control col-md-7 col-xs-12"
                                               value="{{ $programming_language->id }}">
                                    </div>
                                </div>
                            @endforeach
                        @else
                            @foreach($programming_languages as $programming_language)
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12"
                                           for="programming_language">{{ $programming_language->name }}</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">

                                        <input id="programming_language" type="checkbox" name="programming_languages[]"
                                               class="form-control col-md-7 col-xs-12"
                                               value="{{ $programming_language->id }}" {{ !$contest->programming_languages->contains($programming_language->id)?:'checked' }}>
                                    </div>
                                </div>
                            @endforeach
                        @endif


                        <div class="form-group{{ $errors->has('participants') ? ' has-error' : '' }}">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12"
                                   for="participants">Participants</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select name="participants[]" data-select-participants data-student-search-url="{{ route('backend::ajax::searchStudents') }}"
                                        class="form-control col-md-7 col-xs-12"
                                        multiple>
                                    @foreach($participants as $participant)
                                        <option value="{{ $participant->id }}"
                                                selected>{{ $participant->name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('participants'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('participants') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div>
                            <div>
                                <h2>Included problems</h2>
                                <ul data-included-problems>
                                    @foreach($included_problems as $problem)
                                        <li>
                                            <a data-included-problem
                                               data-problem-id="{{ $problem->id }}">{{ $problem->name }}</a>
                                            <input type="hidden" name="problems[]" value="{{ $problem->id }}"/>
                                            <input type="number" name="problem_points[{{ $problem->id }}]"
                                                   value="{{ $contest->getProblemMaxPoints($problem->id) }}"/>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <br/>
                            <h2>All problems</h2>
                            <a data-toggle="dropdown">Add problem</a>
                            <ul class="dropdown-menu" data-unincluded-problems>
                                @foreach($unincluded_problems as $problem)
                                    <li role="presentation">
                                        <a data-unincluded-problem
                                           data-problem-id="{{ $problem->id }}">{{ $problem->name }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <label for="show_max">Show maximum points for problems</label>
                        <input id="show_max" type="checkbox" name="show_max"
                        @if($errors->has())
                            {{ !old('show_max')?:'checked' }}
                                @else
                            {{ !$contest->show_max?:'checked' }}
                                @endif
                        >

                        <label for="labs">Is a labs contest</label>
                        <input id="labs" type="checkbox" name="labs"
                        @if($errors->has())
                            {{ !old('labs')?:'checked' }}
                                @else
                            {{ !$contest->labs?:'checked' }}
                                @endif
                        >

                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                <a class="btn btn-primary"
                                   href=""
                                   data-toggle="confirmation"
                                   data-message="Are you sure you want to leave the page? The changes won't be saved."
                                   data-btn-ok-href="{{ route('backend::contests::list') }}"
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
