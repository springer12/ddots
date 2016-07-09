@extends('layouts.app')

@section('content')

    <div class="container">
        @if($myTeachers && !$myTeachers->isEmpty())
            <h2>My teachers</h2>
            @foreach($myTeachers as $teacher)
                <div class="col-lg-4 col-md-5">
                    <div class="card card-user">
                        <div class="content">
                            <div class="author">
                                <a href="{{ route('frontend::user::profile', ['id' => $teacher->id]) }}"><img
                                            class="avatar border-white" src="{{ $teacher->avatar }}" alt="..."></a>
                                <h4 class="title">
                                    <a href="{{ route('frontend::user::profile', ['id' => $teacher->id]) }}">{{ $teacher->name }}</a>
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif

        <h2>All teachers</h2>
        <div class="row" {{ $allowedRequests ?: 'data-requests-forbidden' }}>
            @foreach($allTeachers as $teacher)

                <div class="col-lg-4 col-md-5">
                    <div class="card card-user">
                        <div class="content">
                            <div class="author">
                                <a href="{{ route('frontend::user::profile', ['id' => $teacher->id]) }}"><img
                                            class="avatar border-white" src="{{ $teacher->avatar }}" alt="..."></a>
                                <h4 class="title">
                                    <a href="{{ route('frontend::user::profile', ['id' => $teacher->id]) }}">{{ $teacher->name }}</a>
                                </h4>
                            </div>
                            <div class="text-center description">
                                @if(\Auth::check() && \Auth::user()->hasRole(App\User::ROLE_USER))
                                    <button type="button"
                                            data-teacher-id="{{ $teacher->id }}"
                                            data-add-teacher-button
                                            data-add-teacher-url="{{ route('frontend::ajax::addTeacher', ['id' =>$teacher->id]) }}"
                                            class="btn btn-info btn-fill btn-wd"
                                            style="display: {{ $teacher->relation_exists ? 'none' : 'inline-block' }}"
                                            {{ $allowedRequests ? '' : 'disabled' }}>
                                        My teacher
                                    </button>
                                    <button id="teacher_{{ $teacher->id }}" type="button"
                                            class="btn btn-success btn-fill btn-wd"
                                            style="display: {{ $teacher->relation_exists ? 'inline-block' : 'none' }}"
                                            disabled>request is sent
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
@endsection
