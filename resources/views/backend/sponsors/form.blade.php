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
                                <input type="text" name="name" value="{{ old('name') ?: $sponsor->name }}"
                                       required="required" class="form-control col-md-7 col-xs-12">
                                @if ($errors->has('name'))
                                    <span class="form-text">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row{{ $errors->has('image') ? ' has-error' : '' }}">
                            @if($sponsor->image)
                                <div><img width="100" height="100" src="{{ $sponsor->image }}" alt="image"></div>
                            @endif
                            <input type="file" name="image" id="image">
                            {{ $errors->first('image') }}
                        </div>

                        <div class="form-group row{{ $errors->has('link') ? ' has-error' : '' }}">
                            <label class="form-control-label col-md-3 col-sm-3 col-xs-12" for="name">Link <span
                                        class="required">*</span></label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="link" value="{{ old('link') ?: $sponsor->link }}"
                                       required="required" class="form-control col-md-7 col-xs-12">
                                @if ($errors->has('link'))
                                    <span class="form-text">
                                        <strong>{{ $errors->first('link') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row{{ $errors->has('description') ? ' has-error' : '' }}">
                            <label class="form-control-label col-md-3 col-sm-3 col-xs-12" for="description">Description <span
                                        class="required">*</span></label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <textarea type="text" name="description" required="required"
                                          class="form-control col-md-7 col-xs-12">{{ old('description') ?old('description'): $sponsor->description }}</textarea>
                                @if ($errors->has('description'))
                                    <span class="form-text">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <label for="show_on_main">Show this sponsor on the main page</label>
                        <input type="checkbox" name="show_on_main" id="show_on_main"
                        @if($errors->has())
                            {{ !old('show_on_main')?:'checked' }}
                                @else
                            {{ !$sponsor->show_on_main?:'checked' }}
                                @endif
                        >
                        <div class="form-group row{{ $errors->has('volumes') ? ' has-error' : '' }}">

                            <label class="form-control-label col-md-3 col-sm-3 col-xs-12" for="volumes">Subdomains</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select name="subdomains[]" data-select-subdomain
                                        class="form-control col-md-7 col-xs-12"
                                        multiple>
                                    @foreach(\App\Subdomain::all() as $subdomain)
                                        <option value="{{ $subdomain->id }}"
                                        @if($errors->has())
                                            {{ !in_array($subdomain->id, (array)old('subdomains'))?'':'selected' }}
                                                @else
                                            {{ $sponsor->subdomains()->find($subdomain->id) ? 'selected' : '' }}
                                                @endif
                                        >
                                            {{ $subdomain->name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('subdomains'))
                                    <span class="form-text">
                                        <strong>{{ $errors->first('subdomains') }}</strong>
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
                                   data-btn-ok-href="{{ route('backend::sponsors::list') }}"
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
