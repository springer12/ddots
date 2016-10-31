@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="card">
                    <div class="card-header">{{ $title }}</div>
                    <div class="card-block">
                        <form method="post">
                            {!! csrf_field() !!}
                            <div class="form-group row {{ $errors->has('name') ? ' has-danger' : '' }}">
                                <label class="control-label col-md-4" for="name">Name <span
                                            class="required">*</span></label>
                                <div class="col-md-8">
                                    <input type="text" name="name" value="{{ old('name') ?: $contest->name }}"
                                           required="required" class="form-control">
                                    @if ($errors->has('name'))
                                        <span class="form-control-feedback">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('description') ? ' has-danger' : '' }}">
                                <label class="control-label col-md-4" for="description">Description<span
                                            class="required">*</span></label>
                                <div class="col-md-8">
                                    <textarea name="description" required="required"
                                              class="form-control">{{ old('description') ?: $contest->description }}</textarea>
                                    @if ($errors->has('description'))
                                        <span class="form-control-feedback">
                                            <strong>{{ $errors->first('description') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('start_date') ? ' has-danger' : '' }}">
                                <label class="control-label col-md-4" for="start_date">Start date<span class="required">*</span></label>
                                <div class="col-md-8">
                                    <input type="datetime" name="start_date" data-start-datepicker
                                           value="{{ old('start_date') ?: $contest->start_date }}" required="required"
                                           class="form-control">
                                    @if ($errors->has('start_date'))
                                        <span class="form-control-feedback">
                                        <strong>{{ $errors->first('start_date') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('end_date') ? ' has-danger' : '' }}">
                                <label class="control-label col-md-4" for="end_date">End date<span
                                            class="required">*</span></label>
                                <div class="col-md-8">
                                    <input type="datetime" name="end_date" data-end-datepicker
                                           value="{{ old('end_date') ?: $contest->end_date }}" required="required"
                                           class="form-control">
                                    @if ($errors->has('end_date'))
                                        <span class="form-control-feedback">
                                            <strong>{{ $errors->first('end_date') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label col-md-4" for="programming_language">Programming
                                    languages</label>
                                <div class="col-md-8">
                                    <select id="programming_language" name="programming_languages[]"
                                            data-select-programming-languages class="form-control" multiple>
                                        @if(old('programming_languages'))
                                            @foreach($programming_languages as $programming_language)
                                                <option value="{{ $programming_language->id }}" {{ !in_array($programming_language->id, old('programming_languages'))?:'selected' }}>{{ $programming_language->name }}</option>
                                            @endforeach
                                        @elseif($errors->has('programming_languages'))
                                            @foreach($programming_languages as $programming_language)
                                                <option value="{{ $programming_language->id }}">{{ $programming_language->name }}</option>
                                            @endforeach
                                        @else
                                            @foreach($programming_languages as $programming_language)
                                                <option value="{{ $programming_language->id }}" {{ !$contest->programming_languages->contains($programming_language->id)?:'selected' }}>{{ $programming_language->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @if ($errors->has('programming_languages'))
                                        <span class="form-control-feedback">
                                            <strong>{{ $errors->first('programming_languages') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('is_active') ? ' has-danger' : '' }}">
                                <label class="control-label col-md-4" for="is_active">Active</label>
                                <div class="col-md-8">
                                    <input type="checkbox" name="is_active"
                                           class="form-control" {{ $errors->has() ? (!old('is_active')?:'checked') : (!$contest->is_active?:'checked') }}>
                                    @if ($errors->has('is_active'))
                                        <span class="form-control-feedback">
                                            <strong>{{ $errors->first('is_active') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('is_standings_active') ? ' has-danger' : '' }}">
                                <label class="control-label col-md-4" for="is_standings_active">Active standings</label>
                                <div class="col-md-8">
                                    <input type="checkbox" name="is_standings_active"
                                           class="form-control" {{ $errors->has() ? (!old('is_standings_active')?:'checked') : (!$contest->is_standings_active?:'checked') }}>
                                    @if ($errors->has('is_standings_active'))
                                        <span class="form-control-feedback">
                                            <strong>{{ $errors->first('is_standings_active') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('show_max') ? ' has-danger' : '' }}">
                                <label class="control-label col-md-4" for="show_max">Show maximum points in
                                    results</label>
                                <div class="col-md-8">
                                    <input type="checkbox" name="show_max"
                                           class="form-control" {{ $errors->has() ? (!old('show_max')?:'checked') : (!$contest->show_max?:'checked') }}>
                                    @if ($errors->has('show_max'))
                                        <span class="form-control-feedback">
                                            <strong>{{ $errors->first('show_max') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>


                            <div class="card">{{-- @todo --}}
                                <div class="card-header">Participants</div>
                                <div data-participants
                                     @foreach($participants as $participant)
                                     data-{{ $participant->id }}="{{ $participant->name }}"
                                        @endforeach
                                >


                                </div>

                                <hr class="hidden-border">
                                <div class="card-block">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <select name="asd" class="form-control" data-participant-select>
                                                <option></option>
                                                @foreach($students as $student)
                                                    <option value="{{ $student->id }}">{{ $student->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <select class="form-control" data-group-select>
                                                <option></option>
                                                @foreach(Auth::user()->groups as $group)
                                                    <option data-user-ids="{{ $group->users->pluck('id')->toJson() }}"
                                                            value="{{ $group->id }}">{{ $group->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card">{{-- @todo --}}
                                <div class="card-header">Problems</div>
                                <div data-problems>
                                    @foreach($included_problems as $problem)
                                        <div class="card-block">
                                            {{ $problem->name }}
                                        </div>
                                    @endforeach

                                </div>

                                <hr class="hidden-border">
                                <div class="card-block">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <select></select>
                                            <button class="btn btn-success">Add problem</button>
                                        </div>
                                        <div class="col-md-6">
                                            <select></select>
                                            <button class="btn btn-success">Add volume</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr class="hidden-border">
                            <div class="form-group">
                                <div class="col-md-8 col-md-offset-3">
                                    <a class="btn btn-primary"
                                       href=""
                                       data-toggle="confirmation"
                                       data-message="Are you sure you want to leave the page? The changes won't be saved."
                                       data-btn-ok-href="{{ route('frontend::contests::list') }}"
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
    <script id="participant_block" type="x-tmpl-mustache">
    <div data-participant-block-id=@{{ id }} class="card-block">
        <div class="col-xs-1">
            <a data-remove-participant-id="@{{ id }}"  data-remove-participant-name="@{{ name }}" href="javascript:void(0);">
                <span class="tag tag-danger"><i class="fa fa-remove"></i></span>
            </a>
        </div>
        <div class="col-xs-11">
            @{{ name }}
        </div>
        <input type="hidden" name="participants[]" value="@{{ id }}">
    </div>
    </script>
@endsection
