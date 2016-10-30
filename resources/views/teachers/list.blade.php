@extends('layouts.app')

@section('content')

    <div class="container">

        @if($myTeachers && !$myTeachers->isEmpty())
            <h2>My teachers</h2>
            <div class="row">
                @foreach($myTeachers as $teacher)
                    <div class="col-lg-4 col-md-5">
                        <div class="card text-xs-center">
                            <a href="{{ route('frontend::user::profile', ['id' => $teacher->id]) }}"><img class="card-img-top teacher-avatar" src="{{ $teacher->avatar }}" alt="Card image cap"></a>
                            <div class="card-block">
                                <h4>
                                    <a href="{{ route('frontend::user::profile', ['id' => $teacher->id]) }}">{{ $teacher->name }}</a>
                                </h4>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <hr class="hidden-border">
        @endif
        <h2>All teachers</h2>
        <div class="row" {{ $allowedRequests ?: 'data-requests-forbidden' }}>
            @foreach($allTeachers as $teacher)

                <div class="col-lg-4 col-md-5">
                    <div class="card text-xs-center">
                        <a href="{{ route('frontend::user::profile', ['id' => $teacher->id]) }}"><img class="card-img-top teacher-avatar" src="{{ $teacher->avatar }}" alt="Card image cap"></a>
                        <div class="card-block">
                            <h4>
                                <a href="{{ route('frontend::user::profile', ['id' => $teacher->id]) }}">{{ $teacher->name }}</a>
                            </h4>
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
