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
                            <ul class="nav nav-pills" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" href="#contest-settings" role="tab"
                                       data-toggle="tab">@lang('contest.general')</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#participants" role="tab"
                                       data-toggle="tab">@lang('contest.participants')</a>
                                </li>
                                <li class="nav-item {{ $contest->type != \App\Contest::TYPE_EXAM ?: 'invisible' }}"
                                    data-contest-problems-tab>
                                    <a class="nav-link" href="#problems" role="tab"
                                       data-toggle="tab">@lang('menu.problems')</a>
                                </li>
                                <li class="nav-item float-md-right">
                                    <button type="submit" class="btn btn-success" data-contest-save-input
                                            disabled="disabled">@lang('layout.save')
                                    </button>
                                </li>
                                <li class="nav-item float-md-right">
                                    <a class="btn btn-warning"
                                       href=""
                                       data-toggle="confirmation"
                                       data-message="@lang('layout.cancel_warn')"
                                       data-btn-ok-href="{{ route('frontend::contests::list') }}"
                                       data-btn-ok-label="Leave the page">@lang('layout.save')</a>
                                </li>
                            </ul>
                            <hr class="invisible"/>
                            @if($errors->has('problems'))
                                <div class="alert alert-danger">{{ $errors->first('problems') }}</div>
                            @endif
                            @if($errors->has('participants'))
                                <div class="alert alert-danger">{{ $errors->first('participants') }}</div>
                            @endif
                            @if($errors->has('programming_languages'))
                                <div class="alert alert-danger">{{ $errors->first('programming_languages') }}</div>
                            @endif
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="contest-settings">
                                    <div class="form-group row {{ $errors->has('name') ? ' has-danger' : '' }}">
                                        <label class="control-label col-md-4" for="name">@lang('layout.name') <span
                                                    class="required">*</span></label>
                                        <div class="col-md-8">
                                            <input type="text" id="name" name="name"
                                                   value="{{ old('name') ?: $contest->name }}"
                                                   required="required" class="form-control">
                                            @if ($errors->has('name'))
                                                <span class="form-control-feedback">
                                                    <strong>{{ $errors->first('name') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row {{ $errors->has('description') ? ' has-danger' : '' }}">
                                        <label class="control-label col-md-4"
                                               for="description">@lang('layout.description')<span
                                                    class="required">*</span></label>
                                        <div class="col-md-8">
                                    <textarea name="description" id="description" required="required"
                                              class="form-control">{{ old('description') ?: $contest->description }}</textarea>
                                            @if ($errors->has('description'))
                                                <span class="form-control-feedback">
                                                    <strong>{{ $errors->first('description') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row {{ $errors->has('start_date') ? ' has-danger' : '' }}">
                                        <label class="control-label col-md-4"
                                               for="start_date">@lang('contest.start_date')<span
                                                    class="required">*</span></label>
                                        <div class="col-md-8">
                                            <input type="datetime" id="start_date" name="start_date"
                                                   data-start-datepicker
                                                   value="{{ old('start_date') ?: $contest->start_date }}"
                                                   required="required"
                                                   class="form-control">
                                            @if ($errors->has('start_date'))
                                                <span class="form-control-feedback">
                                                    <strong>{{ $errors->first('start_date') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row {{ $errors->has('end_date') ? ' has-danger' : '' }}">
                                        <label class="control-label col-md-4" for="end_date">@lang('contest.end_date')
                                            <span
                                                    class="required">*</span></label>
                                        <div class="col-md-8">
                                            <input type="datetime" id="end_date" name="end_date" data-end-datepicker
                                                   value="{{ old('end_date') ?: $contest->end_date }}"
                                                   required="required"
                                                   class="form-control">
                                            @if ($errors->has('end_date'))
                                                <span class="form-control-feedback">
                                                    <strong>{{ $errors->first('end_date') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="control-label col-md-4"
                                               for="programming_language">@lang('menu.programming_languages')</label>
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
                                        <label class="control-label col-md-4"
                                               for="is_active">@lang('contest.active')</label>
                                        <div class="col-md-8">
                                            <input type="checkbox" id="is_active" name="is_active"
                                                   class="form-control" {{ $errors->has() ? (!old('is_active')?:'checked') : (!$contest->is_active?:'checked') }}>
                                            @if ($errors->has('is_active'))
                                                <span class="form-control-feedback">
                                                    <strong>{{ $errors->first('is_active') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="control-label col-md-4"
                                               for="is_exam">@lang('contest.is_exam')</label>
                                        <div class="col-md-8">
                                            <input type="checkbox" id="is_exam" name="is_exam" data-exam-input
                                                   {{ !old('is_exam') && $contest->type != \App\Contest::TYPE_EXAM ?:'checked="checked"' }}
                                                   class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-md-4"
                                               for="is_acm">@lang('contest.is_acm')</label>
                                        <div class="col-md-8">
                                            <input type="checkbox" id="is_acm" name="is_acm" data-acm-input
                                                   {{ !old('is_acm') && !$contest->is_acm ?:'checked="checked"' }}
                                                   {{ !old('is_exam') && $contest->type != \App\Contest::TYPE_EXAM ?: 'disabled="disabled"'}}
                                                   class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-md-4"
                                               for="is_standings_active">@lang('contest.active_standings')</label>
                                        <div class="col-md-8">
                                            <input type="checkbox" id="is_standings_active" name="is_standings_active"
                                                   data-standings-input
                                                   {{ !old('is_exam') && $contest->type != \App\Contest::TYPE_EXAM ?: 'disabled="disabled"'}}
                                                   class="form-control" {{ $errors->has() ? (!old('is_standings_active')?:'checked') : (!$contest->is_standings_active?:'checked') }}>
                                        </div>
                                    </div>
                                    <div class="form-group row {{ $errors->has('show_max') ? ' has-danger' : '' }}">
                                        <label class="control-label col-md-4"
                                               for="show_max">@lang('contest.show_max')</label>
                                        <div class="col-md-8">
                                            <input type="checkbox" id="show_max" name="show_max"
                                                   class="form-control"
                                                   {{ $errors->has() ? (old('show_max') ?: 'checked') : (!$contest->show_max ?:'checked') }} {{ !(old('is_acm') || $contest->is_acm) ?: 'disabled' }} data-show-max-input>
                                            @if ($errors->has('show_max'))
                                                <span class="form-control-feedback">
                                                    <strong>{{ $errors->first('show_max') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" role="tabpanel" id="participants"> {{-- @todo --}}
                                    <div class="card-block">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <select class="form-control" data-participant-select>
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
                                    <hr class="invisible">
                                    <table class="table table-striped table-bordered table-sm" data-participants
                                           @foreach($participants as $participant)
                                           data-{{ $participant->id }}="{{ $participant->name }}"
                                            @endforeach
                                    >
                                        <thead>
                                        <tr>
                                            <th>@lang('layout.name')</th>
                                            <th>@lang('contest.action')</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>

                                <div role="tabpanel" class="tab-pane fade" id="problems">
                                    <div class="card-block">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <select data-problem-select
                                                        data-get-problems-url="{{ route('privileged::ajax::searchProblems') }}"
                                                        class="form-control col-md-7 col-xs-12">
                                                    <option></option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <select data-volume-select
                                                        data-get-volumes-url="{{ route('privileged::ajax::searchVolumes') }}"
                                                        class="form-control col-md-7 col-xs-12">
                                                    <option></option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="invisible">
                                    <table class="table table-striped table-bordered table-sm" data-problems
                                           @if($contest->type == \App\Contest::TYPE_EXAM || old('is_exam'))

                                           data-all-user-problems='{{ $included_problems }}'
                                           @else
                                           @foreach($included_problems as $problem)
                                           data-{{ $problem->id }}="{{ $problem->name }}"
                                           data-{{ $problem->id }}-points="{{ isset($problem->pivot)?$problem->pivot->max_points:$problem->max_points }}"
                                           data-{{ $problem->id }}-review="{{ isset($problem->pivot)?$problem->pivot->review_required:$problem->review_required  }}"
                                           data-{{ $problem->id }}-time-penalty="{{ isset($problem->pivot)?$problem->pivot->time_penalty:$problem->time_penalty }}"
                                            @endforeach
                                            @endif
                                    >
                                        <thead>
                                        <tr>
                                            <th>@lang('layout.name')</th>
                                            <th>@lang('contest.points')</th>
                                            <th>@lang('contest.review')</th>
                                            <th>@lang('contest.time_penalty')</th>
                                            <th>@lang('contest.action')</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" data-contest-user-modal>{{-- @todo --}}
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <select data-problem-select
                                    data-get-problems-url="{{ route('privileged::ajax::searchProblems') }}"
                                    class="form-control col-md-7 col-xs-12">
                                <option></option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <select data-volume-select
                                    data-get-volumes-url="{{ route('privileged::ajax::searchVolumes') }}"
                                    class="form-control col-md-7 col-xs-12">
                                <option></option>
                            </select>
                        </div>
                    </div>
                    <table class="table table-striped table-bordered table-sm">
                        <thead>
                        <tr>
                            <th>@lang('layout.name')</th>
                            <th>@lang('contest.points')</th>
                            <th>@lang('contest.review')</th>
                            <th>@lang('contest.time_penalty')</th>
                            <th>@lang('contest.action')</th>
                        </tr>
                        </thead>
                        <tbody data-user-problems></tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('layout.cancel')</button>
                    <button type="button" class="btn btn-primary" data-save-user-problems>@lang('layout.save')</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <script data-element-block type="x-tmpl-mustache">
    <tr data-@{{ element }}-block-id=@{{ id }} data-@{{ element }}-@{{ id }}-name="@{{ name }}" data-user-problems-id="@{{ id }}">
        <td>
            @{{ name }}
        </td>
        @{{ #type_problem }}
        <td>
            <input name="points[@{{ id }}]" type="number" class="form-control" value="@{{ points }}"/>
        </td>
        <td>
            <input name="review_required[@{{ id }}]" type="checkbox" class="form-control"
                   @{{ #review }}
                   checked
                    @{{ /review }}
            />
        </td>
        <td>
            <input name="time_penalty[@{{ id }}]" type="number" class="form-control" value="@{{ time_penalty }}"/>
        </td>
        @{{ /type_problem}}
        <td class="actions-menu">
            <a data-remove-@{{ element }}-id="@{{ id }}" data-remove-@{{ element }}-name="@{{ name }}"
               href="javascript:void(0);">
                <span class="tag tag-danger"><i class="fa fa-remove"></i></span>
            </a>
            @{{ ^type_problem }}
            <a data-edit-@{{ element }}-id="@{{ id }}"
               class="{{ old('is_exam') || $contest->type == \App\Contest::TYPE_EXAM ?: 'invisible' }}"
               href="javascript:void(0);">
                <span class=""><i class="fa fa-pencil"></i></span>
            </a>
            @{{ /type_problem }}
        </td>
        <input type="hidden" name="@{{ element }}s[]" value="@{{ id }}">
    </tr>
    </script>
@endsection