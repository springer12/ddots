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
                                <input type="text" name="name" value="{{ old('name') ?: $volume->name }}"
                                       required="required" class="form-control col-md-7 col-xs-12">
                                @if ($errors->has('name'))
                                    <span class="form-text">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row{{ $errors->has('problems') ? ' has-error' : '' }}">
                            <label class="form-control-label col-md-3 col-sm-3 col-xs-12"
                                   for="problems">Problems</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select name="problems[]" data-select-problem-volume
                                        data-get-problems-url="{{ route('privileged::ajax::searchProblems') }}"
                                        class="form-control col-md-7 col-xs-12"
                                        multiple>
                                    @foreach($volume->problems as $problem)
                                        <option value="{{ $problem->id }}"
                                                selected>{{ $problem->name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('problems'))
                                    <span class="form-text">
                                        <strong>{{ $errors->first('problems') }}</strong>
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
                                   data-btn-ok-href="{{ route('backend::volumes::list') }}"
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
