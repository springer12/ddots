@extends('layouts.app')

@section('content')
    <div class="container">
        @if($myTeachers && !$myTeachers->isEmpty())
            <div class="card">
                <div class="card-header">@lang('layout.my_teachers')</div>
                <div class="card-block">
                    <div class="row">
                        @foreach($myTeachers as $teacher)
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <div class="card text-xs-center">
                                    <a href="{{ route('frontend::user::profile', ['id' => $teacher->id]) }}"><img
                                                class="card-img-top teacher-avatar" src="{{ $teacher->avatar }}"
                                                alt="Card image cap"></a>
                                    <div class="card-block">
                                        <h4>
                                            <a href="{{ route('frontend::user::profile', ['id' => $teacher->id]) }}">{{ $teacher->name }}</a>
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <hr class="hidden-border">
        @endif
        @if(!$allTeachers->isEmpty())
            <div class="card">
                <div class="card-header">@lang('layout.all_teachers')</div>
                <div class="card-block">
                    <div class="row" {{ $allowedRequests ?: 'data-requests-forbidden' }}>
                        @foreach($allTeachers as $teacher)
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <div class="card text-xs-center">
                                    <a class="teacher-avatar-container"
                                       href="{{ route('frontend::user::profile', ['id' => $teacher->id]) }}"><img
                                                class="card-img-top teacher-avatar" src="{{ $teacher->avatar }}"
                                                alt="Card image cap"></a>
                                    <div class="card-block">
                                        <h4 class="teacher-name-container">
                                            <a href="{{ route('frontend::user::profile', ['id' => $teacher->id]) }}">{{ $teacher->name }}</a>
                                        </h4>
                                        <div class="text-center description">
                                            @if(\Auth::check() && \Auth::user()->hasRole(App\User::ROLE_USER))
                                                <button type="button"
                                                        data-teacher-id="{{ $teacher->id }}"
                                                        data-add-teacher-button
                                                        data-add-teacher-url="{{ route('frontend::ajax::addTeacher', ['id' =>$teacher->id]) }}"
                                                        data-error-text="@lang('layout.teacher_requests_expended')"
                                                        class="btn btn-info btn-fill btn-wd"
                                                        style="display: {{ $teacher->relation_exists ? 'none' : 'inline-block' }}"
                                                        {{ $allowedRequests ? '' : 'disabled' }}>
                                                    @lang('layout.my_teacher')
                                                </button>
                                                <button id="teacher_{{ $teacher->id }}" type="button"
                                                        class="btn btn-success btn-fill btn-wd"
                                                        style="display: {{ $teacher->relation_exists && !$teacher->confirmed ? 'inline-block' : 'none' }}"
                                                        disabled>@lang('layout.request_is_sent')
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div class="col-md-12 align-center">{{ $allTeachers->links() }}</div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
