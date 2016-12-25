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
                            <ul class="nav nav-pills" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" href="#general" role="tab"
                                       data-toggle="tab">@lang('contest.general')</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#participants" role="tab"
                                       data-toggle="tab">@lang('contest.participants')</a>
                                </li>
                                <li class="nav-item"
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
                                    <a class="btn btn-primary"
                                       href=""
                                       data-toggle="confirmation"
                                       data-message="@lang('layout.cancel_warn')"
                                       data-btn-ok-href="{{ route('teacherOnly::disciplines::list') }}"
                                       data-btn-cancel-label="@lang('layout.cancel')"
                                       data-btn-ok-label="@lang('layout.leave_page')">@lang('layout.cancel')</a>
                                </li>
                            </ul>
                            <hr class="invisible"/>
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="general">
                                    <div class="form-group row{{ $errors->has('name') ? ' has-danger' : '' }}">
                                        <label class="form-control-label col-md-4" for="name">@lang('layout.name') <span
                                                    class="required">*</span></label>
                                        <div class="col-md-8">
                                            <input type="text" name="name" class="form-control border-input"
                                                   value="{{ old('name') ?: $discipline->name }}" required="required">
                                            @if ($errors->has('name'))
                                                <span class="form-control-feedback">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row{{ $errors->has('description') ? ' has-danger' : '' }}">
                                        <label class="form-control-label col-md-4"
                                               for="description">@lang('layout.description')</label>
                                        <div class="col-md-8">
                                    <textarea name="description" class="form-control border-input"
                                              rows="5">{{ old('description') ?: $discipline->description }}</textarea>
                                            @if ($errors->has('description'))
                                                <span class="form-control-feedback">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @include('partial.add_students')
                                <div role="tabpanel" class="tab-pane fade" id="problems">
                                    @include('partial.add_problems')
                                    <hr class="invisible">
                                    <table class="table table-striped table-bordered table-sm" data-problems
                                           @foreach($included_problems as $problem)
                                           data-{{ $problem->id }}="{{ $problem->name }}"
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
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <script data-element-block type="x-tmpl-mustache">
    <tr data-@{{ element }}-block-id=@{{ id }} data-@{{ element }}-@{{ id }}-name="@{{ name }}
        " data-user-problems-id="@{{ id }}">
        <td>
            @{{ name }}
        </td>
        <td class="actions-menu">
            <a data-remove-@{{ element }}-id="@{{ id }}" data-remove-@{{ element }}-name="@{{ name }}"
               href="javascript:void(0);">
                <span class="tag tag-danger"><i class="fa fa-remove"></i></span>
            </a>
        </td>
        <input type="hidden" name="@{{ element }}s[]" value="@{{ id }}">
    </tr>
    </script>
@endsection
