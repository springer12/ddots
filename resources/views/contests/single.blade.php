@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">{{ $contest->name }} <span class="tag tag-{{ $contest->is_active? 'success' : 'danger' }}">{{ $contest->is_active? 'Active' : 'Disabled' }}</span> <span class="float-xs-right">{{ $contest->start_date }} — {{ $contest->end_date }}</span></div>


            <div class="card-block">
                <div class="row">
                    <div class="col-md-4">
                        <h3>
                            @foreach($contest->programming_languages as $programming_language)
                            <span class="tag tag-primary">{{ $programming_language->name }}</span>
                            @endforeach
                        </h3>
                        <h3><span class="tag tag-success">{{ $contest->end_date->diffInDays($contest->start_date) }} d. to finish</span></h3>
                    </div>
                    <div class="col-md-8">
                        <p>{{ $contest->description }}</p>
                    </div>
                </div>
            </div>
            <div class="card-block">
                <div class="row">
                    <div class="col-md-12">
                        @if($contest->is_standings_active )
                            <a class="btn btn-primary" href="{{ route('frontend::contests::standings', ['id' => $contest->id]) }}"><i class="fa fa-trophy" aria-hidden="true"></i> standings</a>
                        @endif
                        <a class="btn btn-primary" href="{{ route('frontend::contests::solutions',['id' => $contest->id]) }}"><i class="fa fa-code" aria-hidden="true"></i> solutions</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <h3 class="card-header">Problems</h3>
            <div class="card-block">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Difficulty</th>
                        <th>{{ $contest->show_max?'Best':'Latest' }} points</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($problems as $id => $problem)
                        <tr>
                            <td>{{ $id }}</td>
                            <td class="no-wrap">
                                <a href="{{ $problem['link'] }}">{{ $problem['name'] }}</a>
                            </td>
                            <td>{{ $problem['difficulty'] }}</td>
                            <td>
                                @if(isset($problem['points']))
                                    @if(isset($problem['solution_link']))
                                        <a href="{{ $problem['solution_link'] }}">{{ $problem['points'] }}</a>
                                    @else
                                        {{ $problem['points'] }}
                                    @endif
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
