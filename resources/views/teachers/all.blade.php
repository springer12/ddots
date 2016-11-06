@extends('layouts.main')

@section('content')
    <div class="container">
        <div class="row">
            @foreach($teachers as $teacher)
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="card text-xs-center">
                        <a href="{{ route('frontend::user::profile', ['id' => $teacher->id]) }}"><img
                                    class="card-img-top teacher-avatar" src="{{ $teacher->avatar }}"
                                    alt="Card image cap"></a>
                        <div class="card-block">
                            <h4>
                                <a href="{{ $teacher->subdomains()->first()->getUrl('user/' . $teacher->id) }}">{{ $teacher->name }}</a>
                            </h4>
                        </div>
                    </div>
                </div>
            @endforeach
            <div class="col-md-12 align-center">{{ $teachers->links() }}</div>
        </div>
    </div>
@endsection
