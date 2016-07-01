@extends('layouts.app')

@section('content')
    @if(isset($myTeachers))
        <h2>My teachers</h2>
        @foreach($myTeachers as $teacher)
            <div><img src="{{$teacher->avatar()}}" width="15"/> <a href="{{route('frontend::user::profile', ['id' => $teacher->id])}}">{{ $teacher->name }}</a></div>
        @endforeach
    @endif
    <br/>
    <br/>
    <br/>
    <br/>
    <div class="container">
<h2>All teachers</h2>
        <input type="hidden" value="{{route('frontend::addTeacher')}}" data-post-url/>
        <input type="hidden" value="{{ csrf_token() }}" data-x-csrf {{$allowedRequests?'':'data-requests-forbidden'}}/>

    @foreach($allTeachers as $teacher)

        <div class="row">
        <div class="col-md-6"><img src="{{$teacher->avatar}}" width="15"/><a href="{{route('frontend::user::profile', ['id' => $teacher->id])}}">{{ $teacher->name }}</a></div>
            @if(\Auth::check() && \Auth::user()->hasRole(App\User::ROLE_USER))
                @if($teacher->relation_exists)
                    <div class="col-md-6">unconfirmed</div>
                @else
                    <div class="col-md-6"><input type="button" data-teacher-id="{{ $teacher->id }}" value="My teacher" {{$allowedRequests?'':'disabled'}}/><span class="display-none">unconfirmed</span></div>

                @endif
            @endif


        </div>
    @endforeach
        <div class="row"><div class="col-md-6 text-center">{{ $allTeachers->links() }}</div></div>
    </div>
@endsection