@extends('layouts.app')

@section('content')
@if(isset($myTeachers))
    @foreach($myTeachers as $teacher)
        <div><a href="{{route('frontend::user::profile', ['id' => $teacher->id])}}">{{ $teacher->name }}</a></div>
    @endforeach
    @endif
<br/>
<br/>
<br/>
<br/>

    @foreach($allTeachers as $teacher)
        <div class="asd"><a href="{{route('frontend::user::profile', ['id' => $teacher->id])}}">{{ $teacher->name }}</a>
            @if(\Illuminate\Support\Facades\Auth::user()->hasRole(App\User::ROLE_USER))
                {{ $teacher->pivot->confirmed }}
                @endif

        </div>
    @endforeach
    {{ $allTeachers->links() }}
    @endsection