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
                    <form method="post" class=" form-label-left">
                        {!! csrf_field() !!}
                        <div class="form-group row{{ $errors->has('name') ? ' has-danger' : '' }}">
                            <label class="form-control-label col-md-3 col-sm-3 col-xs-12" for="name">Title <span
                                        class="required">*</span></label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="name" value="{{ old('name') ?: $news->name }}"
                                       required="required" class="form-control col-md-7 col-xs-12">
                                @if ($errors->has('name'))
                                    <span class="form-text">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <label for="show_on_main">Show this sponsor on the main page</label>
                        <input type="checkbox" name="show_on_main" id="show_on_main"
                        @if($errors->has())
                            {{ !old('show_on_main')?:'checked' }}
                                @else
                            {{ !$news->show_on_main?:'checked' }}
                                @endif
                        >


                        <div data-subdomain-select
                             class="form-group row{{ $errors->has('subdomain_id') ? ' has-danger' : '' }}">
                            <label class="form-control-label col-md-3 col-sm-3 col-xs-12" for="role">Subdomain</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select name="subdomain_id" class="form-control col-md-7 col-xs-12">
                                    <option value="">No subdomain</option>
                                    @foreach(\App\Subdomain::get() as $subdomain)
                                        <option value="{{ $subdomain->id }}" {{ $news->subdomain != $subdomain?:'selected' }}>{{ $subdomain->name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('subdomain_id'))
                                    <span class="form-text">
                                        <strong>{{ $errors->first('subdomain_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row{{ $errors->has('content') ? ' has-danger' : '' }}">
                            <label class="form-control-label col-md-3 col-sm-3 col-xs-12" for="name">Content <span
                                        class="required">*</span></label>
                            <div class="col-md-6 col-sm-6 col-xs-12">

                                <textarea name="content" data-wysiwyg>{{ old('content')?old('content'):$news->content }}</textarea>
                                @if ($errors->has('content'))
                                    <span class="form-text">
                                        <strong>{{ $errors->first('content') }}</strong>
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
                                   data-btn-ok-href="{{ route('backend::news::list') }}"
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
